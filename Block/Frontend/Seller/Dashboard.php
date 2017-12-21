<?php
/**
 * Created by PhpStorm.
 * User: noh
 * Date: 12/17/17
 * Time: 5:02 PM
 */

namespace AWstreams\Marketplace\Block\Frontend\Seller;

use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;
use \Magento\Framework\App\ObjectManager;
use Magento\Catalog\Model\ResourceModel\Product\Collection AS Product;
use AWstreams\Marketplace\Model\ResourceModel\Profile\Collection AS Profile;
use AWstreams\Marketplace\Model\ResourceModel\Rating\Collection AS Rate;


class Dashboard extends Template
{
    protected $currentCustomer;
    protected $_session;
    protected $orders;
    protected $_orderCollectionFactory;
    protected  $productCollection ;
    protected $_countryFactory;
    protected $rateCollection ;
    protected $_total;


    public function __construct(Template\Context $context, array $data = [],
                                Session $session,
                                Product $product ,
                                Profile $profileCollection,
                                \Magento\Directory\Model\CountryFactory $countryFactory,
                                \Magento\Sales\Model\Order $orderCollectionFactory1,
                                Rate $rateCollection

    )
    {
        $this->_orderCollectionFactory = $orderCollectionFactory1;
        $this->productCollection = $product;
        $this->_countryFactory = $countryFactory;
        $this->_session = $session;
        $this->rateCollection = $rateCollection;
        $this->profileCollection = $profileCollection;
        $this->currentCustomer = $this->_session->getCustomer();
        parent::__construct($context, $data);
    }



    public function getMostViews(){

        $ids =$this->getProductCollection();
        $objectManager = ObjectManager::getInstance();
        $productcollection = $objectManager->create('\Magento\Reports\Model\ResourceModel\Product\Collection');

        $prodData = $productcollection->addViewsCount()->getData();
        $data       = array();
        $i=1;
        if (count($prodData) > 0) {
            foreach ($prodData as $product) {

                if(in_array($product['entity_id'],$ids)){
                    $data[$i]=$product ;
                    $pro =  $objectManager->create('Magento\Catalog\Model\Product')->load($product["entity_id"]);
                    $data[$i]['name']= $pro->getName();
                    if($i < 5)
                        $i++;
                    else
                        break;
                }
            }
        }

        return $data;
    }

    public function getTopSelling(){

        $ids =$this->getProductCollection();
        $objectManager = ObjectManager::getInstance();
        $orders = $objectManager->create('\Magento\Reports\Model\ResourceModel\Product\Sold\Collection');
        $orders= $orders->getData();

        // to create 2 arrays for ids and names
        $data =array();
        $names =array();
        // set initial data for 2 arrays
        foreach ($ids as $id){
            $data[$id]= 0;
            $names[$id]=0;
        }

        $products = array();
        foreach ($orders as $order){
            $products[]= $this->getAllItems($order['entity_id'],$ids);
        }

        //set data for 2 arrays
        foreach ($products as $product){
            unset($product['total']);
            foreach ($product as $p ){
                    $data[$p['id']] += $p['quantity'];
                    $names[$p['id']] = $p['name'];
            }
        }
        $lastData = array();
        $j = 1 ;
        //sort by quantity
        arsort($data);

        foreach ($data as $k => $v){
            $lastData[$names[$k]] = $v ;
            if($j <5)
                $j++;
            else
                break;

        }


        return $lastData;


    }

    public function getOrdersChart(){

        $ids =$this->getProductCollection();
        $objectManager = ObjectManager::getInstance();
        $orders = $objectManager->create('\Magento\Reports\Model\ResourceModel\Product\Sold\Collection');
        $orders= $orders->getData();


        $today =  strtotime("today") ;
        //$today =  date("Y-m-d", $today);
        //to initial the  last 7 days from today
        $dates = array();
        for ($i = 0; $i < 7; $i++){
            $dates[date('Y-m-d', strtotime(strtotime($today). ' - '.$i .'days'))]=0;
        }

        /*
        foreach ($orders as $o ){
            echo date('Y-m-d',strtotime($o['created_at'])) ."---". $o['increment_id']."<br>";
        }
        */

        //to set count for all days by order using products
        foreach ($orders as $order){
            $products= $this->getAllItems($order['entity_id'],$ids);
            $d = date('Y-m-d',strtotime($order['created_at']));
            foreach ($products as $product){
                unset($product['total']);
                if( key_exists($d,$dates) && floor($product['qtyCancel']) == 0 ){
                    $dates[$d] += 1;
                    break;
                }
            }
        }

        return $dates;
    }


    public function getSalesOrderCollection(){
        $order= $this->_orderCollectionFactory->getCollection()->addOrder('entity_id','desc')->getData();
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
        $objectManager = ObjectManager::getInstance();
        $order = $objectManager->get('Magento\Sales\Model\Order')->load($id);
        return   $order;
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




    public function getShop()
    {

        return $this->profileCollection->addFieldToFilter('customer_id', $this->currentCustomer->getId())->getFirstItem();
    }


    public function getRates($shop_id)
    {

        return $this->rateCollection->addFieldToFilter('shop_id', $shop_id)
            ->setOrder('created_at','desc')
            ->getData();
    }


    public function getUrlRate($shop_title)
    {
        $route ="marketplace/shop/rating/profile/". $shop_title ;
        return $this->getUrl($route);

    }


    public function getStarColor($star){

        $star =intval($star);

        if($star == 1 )
            return  "red";
        elseif (in_array( $star,[2,3]))
            return "gold";
        else
            return "green";
    }

    public function getTotal(){

        $this->_total = 0 ;
        $orders =$this->getSalesOrderCollection();
        $ids = $this->getProductCollection();
        foreach ($orders as $order){
            $all = $this->getAllItems($order['entity_id'] ,$ids);
            if( $this->getStatus($all) != 'cancel')
                $this->_total += $all['total'];
        }

        return $this->_total;
    }
}