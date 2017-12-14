<?php
namespace AWstreams\Marketplace\Block\Frontend\Seller;

use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;
use \Magento\Sales\Model\Order;
use \Magento\Framework\App\ObjectManager;
use \Magento\Sales\Model\ResourceModel\Order\CollectionFactoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\Collection AS Product;


class Orders extends Template
{
    protected $currentCustomer;
    protected $_session;
    protected $orders;
    protected $_orderCollectionFactory;
    protected  $productCollection ;
    protected $_countryFactory;


    public function __construct(Template\Context $context, array $data = [],
                                Session $session,
                                Product $product ,
                                \Magento\Directory\Model\CountryFactory $countryFactory,
                                \Magento\Sales\Model\Order $orderCollectionFactory1
    )
    {
        $this->_orderCollectionFactory = $orderCollectionFactory1;
        $this->productCollection = $product;
        $this->_countryFactory = $countryFactory;
        $this->_session = $session;
        $this->currentCustomer = $this->_session->getCustomer();
        parent::__construct($context, $data);
    }


    public function getSalesOrderCollection(){
        $order= $this->_orderCollectionFactory->getCollection()->getData();
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
        $objectManager = ObjectManager::getInstance();
        $order = $objectManager->create('Magento\Sales\Model\Order')->load($id);//loadByIncrementId(000000001);
        $orderItems = $order->getAllItems();
        $itemQty = array();
        $total =0 ;
        foreach ($orderItems as $item) {
            $item = $item->getData();
            if(in_array($item['product_id'],$ids)){
                $total += $item['qty_ordered'] * $item['price'] ;
                $itemQty[]=array('qtyCancel'=> $item['qty_canceled'],
                                'qtyShipped'=> $item['qty_shipped'],
                                'qtyInvoiced'=> $item['qty_invoiced'],
                                'qtyShip'=>$item['qty_shipped'],
                                'item_id'=> $item['item_id'],
                                'id'=>$item['product_id'],
                                'sku'=>$item['sku'],
                                'quantity'=>$item['qty_ordered'],
                                'description'=>$item['description'],
                                'name'=>$item['name'],
                                'price'=>$item['price']
                );

            }
            $itemQty['total']= $total;
        }

        return $itemQty;
    }

    public function getSpcificOrder($id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->get('Magento\Sales\Model\Order')->load($id);
        return   $order;
    }

    public function test(){
        return $this->getRequest()->getParams();
    }

    public function getCountryname($countryCode){
        $country = $this->_countryFactory->create()->loadByCode($countryCode);
        return $country->getName();
    }


    public function getInvoice($id)
    {

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $invoice = $objectManager->get('Magento\Sales\Model\Order\Invoice')->load($id);
        return   $invoice;
    }

    public function getStatus($orderProdcuts)
    {
        unset($orderProdcuts['total']);

        foreach ($orderProdcuts as $product){
            if($product['qtyCancel'] == $product['quantity'])
                return 'cancel';
        elseif($product['qtyShipped'] == $product['quantity'])
                return 'complete';
            elseif($product['qtyInvoiced'] == $product['quantity'])
                return 'processing';
        }
        return 'pending';

    }



}