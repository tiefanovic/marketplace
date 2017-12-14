<?php

namespace AWstreams\Marketplace\Controller\Seller;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
use Magento\Catalog\Model\ResourceModel\Product\Collection AS Product;
use Magento\Sales\Model\Order\Email\Sender\InvoiceSender;
use Magento\Framework\Controller\ResultFactory;
use Magento\Sales\Model\Order\ShipmentFactory;
use Magento\Sales\Model\Order\Email\Sender\ShipmentSender;


class SaveShip extends Action
{
    protected $customerSession;
    protected $currentCustomer;
    protected  $productCollection ;
    protected $_orderRepository;
    protected $_invoiceService;
    protected $_transaction;
    protected $_resultFactory;
    protected $shipmentFactory;
    protected $shipmentSender;

    public function __construct(Context $context,
                                \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
                                \Magento\Sales\Model\Service\InvoiceService $invoiceService,
                                \Magento\Framework\DB\Transaction $transaction,
                                InvoiceSender $invoiceSender,
                                Product $product ,
                                ShipmentFactory $shipmentFactory,
                                ShipmentSender $shipmentSender,
                                Session $customerSession

    ) {
        $this->_orderRepository = $orderRepository;
        $this->_invoiceService = $invoiceService;
        $this->_transaction = $transaction;
        $this->customerSession = $customerSession;
        $this->productCollection = $product;
        $this->invoiceSender = $invoiceSender;
        $this->shipmentFactory = $shipmentFactory;
        $this->shipmentSender = $shipmentSender;
        $this->currentCustomer =$this->customerSession->getCustomer();
        $this->_resultFactory = $context->getResultFactory();

        parent::__construct($context);
    }
    protected function _prepareShipment($invoice)
    {
        $invoiceData = $this->getRequest()->getParam('invoice');

        $shipment = $this->shipmentFactory->create(
            $invoice->getOrder(),
            isset($invoiceData['items']) ? $invoiceData['items'] : [],
            $this->getRequest()->getPost('tracking')
        );

        if (!$shipment->getTotalQty()) {
            return false;
        }

        return $shipment->register();
    }

    public function execute()
    {

        $parameter = $this->getRequest()->getParams();
        $orderId = $parameter['id'];
        $order1 = $this->getSpcificOrder($orderId);
        $orderData = $order1->getData();

        $ids =$this->getProductCollection();
        $orderProducts = $this->getAllItems($orderId,$ids );

        $total = $orderProducts['total'];
        unset($orderProducts['total']);
        $itemsArray = array();


        foreach ($orderProducts as $product){
            $itemsArray[] = $product['id'];
        }

        $order = $this->_objectManager->create('Magento\Sales\Model\Order')->load($orderId);

        $convertOrder = $this->_objectManager->create('Magento\Sales\Model\Convert\Order');
        $shipment = $convertOrder->toShipment($order);

        foreach ($order->getAllItems() AS $orderItem) {

            if ( in_array($orderItem->getProductID(),$itemsArray)) {
                echo $orderItem->getQtyToShip() .'--';
                $qtyShipped = $orderItem->getQtyToShip();
                // Create shipment item with qty
                $shipmentItem = $convertOrder->itemToShipmentItem($orderItem)->setQty($qtyShipped);
                // Add shipment item to shipment
                $shipment->addItem($shipmentItem);
            }else{
                unset($orderItem);
            }
        }

        $shipment->register();

        $shipment->getOrder()->setIsInProcess(true);

        try {
            $shipment->save();
            $shipment->getOrder()->save();

            // Send email
            $this->_objectManager->create('Magento\Shipping\Model\ShipmentNotifier')
                ->notify($shipment);

            $shipment->save();
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __($e->getMessage())
            );
        }

        //to set qty for qty_shipped
        $orderItems = $order->getAllItems();
        foreach ($orderItems as $item) {
            if(in_array($item['product_id'],$ids)) {

                $item->setQtyShipped($item['qty_ordered']);
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