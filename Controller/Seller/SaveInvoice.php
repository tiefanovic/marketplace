<?php

namespace AWstreams\Marketplace\Controller\Seller;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
use Magento\Catalog\Model\ResourceModel\Product\Collection AS Product;
use Magento\Sales\Model\Order\Email\Sender\InvoiceSender;
use Magento\Framework\Controller\ResultFactory;

class SaveInvoice extends Action
{
    protected $customerSession;
    protected $currentCustomer;
    protected  $productCollection ;
    protected $_orderRepository;
    protected $_invoiceService;
    protected $_transaction;
    protected $_resultFactory;


    public function __construct(Context $context,
                                \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
                                \Magento\Sales\Model\Service\InvoiceService $invoiceService,
                                \Magento\Framework\DB\Transaction $transaction,
                                InvoiceSender $invoiceSender,
                                Product $product ,
                                Session $customerSession

    ) {
        $this->_orderRepository = $orderRepository;
        $this->_invoiceService = $invoiceService;
        $this->_transaction = $transaction;
        $this->customerSession = $customerSession;
        $this->productCollection = $product;
        $this->invoiceSender = $invoiceSender;
        $this->currentCustomer =$this->customerSession->getCustomer();
        $this->_resultFactory = $context->getResultFactory();

        parent::__construct($context);
    }
    /**
     * Marketplace order invoice controller.
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {

        $parmater= $this->getRequest()->getParams() ;
        $orderId = $parmater['id'];
        $order1 = $this->getSpcificOrder($orderId);
        $orderData = $order1->getData();
        $ids =$this->getProductCollection();
        $orderProducts = $this->getAllItems($orderId,$ids);

        $total = $orderProducts['total'];
        unset($orderProducts['total']);
        $itemsArray =array();

        foreach ($orderProducts as $product){
            $itemsArray[$product['item_id']] = floor($product['quantity']);
        }


        $order = $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderId);


        $shippingAmount = $orderData['shipping_amount'];

        $subTotal =$total;
        $baseSubtotal = $total;
        $grandTotal = $shippingAmount + $subTotal ;
        $baseGrandTotal = $shippingAmount + $subTotal ;

        $invoice = $this->_invoiceService->prepareInvoice($order, $itemsArray);
        $invoice->setShippingAmount($shippingAmount);

        $invoice->setSubtotal($subTotal);
        $invoice->setBaseSubtotal($baseSubtotal);
        $invoice->setGrandTotal($grandTotal);
        $invoice->setBaseGrandTotal($baseGrandTotal);

        $invoice->register();
        $transactionSave = $this->_objectManager->create(
            'Magento\Framework\DB\Transaction'
        )->addObject(
            $invoice
        )->addObject(
            $invoice->getOrder()
        );

        $transactionSave->save();

        $this->invoiceSender->send($invoice);
        //send notification code
        $order->addStatusHistoryComment(
            __(' ', $invoice->getId())
        )
            ->setIsCustomerNotified(true)
            ->save();


        //to set qty for qty_invoiced
        $orderItems = $order->getAllItems();
        foreach ($orderItems as $item) {
            if(in_array($item['product_id'],$ids)) {

                $item->setQtyInvoiced($item['qty_ordered']);
                $item->save();
            }
        }

        // Redirect to your form page (or anywhere you want...)
        $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());

        return $resultRedirect;

    }

    public function getSpcificOrder($id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->get('Magento\Sales\Model\Order')->load($id);
        return   $order;
    }

    public function getProductCollection(){

        $customer_id =$this->currentCustomer->getId();
        $vendor = $this->productCollection->getAllAttributeValues('vendor_id');

        $productIds = array() ;
        foreach ($vendor as $k =>$v){
            foreach ($v as $kk => $vv){
                if($vv == $customer_id)
                    array_push($productIds,$k);
            }
        }

        return   $productIds;
    }

    public function getAllItems($id,$ids)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('Magento\Sales\Model\Order')->load($id);//loadByIncrementId(000000001);
        $orderItems = $order->getAllItems();
        $itemQty = array();
        $total =0 ;
        echo "<pre>";
        foreach ($orderItems as $item) {
            $item = $item->getData();
            if(in_array($item['product_id'],$ids)){
                $total += $item['qty_ordered'] * $item['price'] ;
                $itemQty[]=array('item_id'=> $item['item_id'],'id'=>$item['product_id'],'sku'=>$item['sku'],'quantity'=>$item['qty_ordered'],'description'=>$item['description'],'name'=>$item['name'],'price'=>$item['price']);
            }
            $itemQty['total']= $total;
        }

        return $itemQty;
    }

}