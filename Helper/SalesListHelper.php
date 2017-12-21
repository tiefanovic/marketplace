<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 12/20/17
 * Time: 3:47 PM
 */

namespace AWstreams\Marketplace\Helper;


use AWstreams\Marketplace\Model\ResourceModel\SalesList\Collection;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper as Helper;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\StoreManagerInterface;

class SalesListHelper extends Helper
{
    protected $collection;
    protected $helper;
    protected $objectManager;
    protected $session;
    protected $storeManager;
    public function __construct(
        Context $context,
        Collection $collection,
        Data $helper,
        StoreManagerInterface $storeManager,
        Session $session,
        ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->collection = $collection;
        $this->helper = $helper;
        $this->session = $session;
        $this->storeManager = $storeManager;
        $this->objectManager = $objectManager;

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('Observed');

    }
    public function getProductSalesDetailById($productId){
        $data = array();
        if($productId > 0){
            $this->collection->addFieldToFilter('product_id',array('eq'=>$productId));
            $i=0;
            foreach ($this->collection as $record) {
                $data[$i]=array(
                    'quantity'=>$record->getQuantity(),
                    'actualparterprocost'=>$record->getActualparterprocost()
                );
                $i++;
            }
            return $data;
        }
    }

    public function getCommsionCalculation($order){
        $percent = $this->helper->getGeneralConfig()->get('global_commission_rate');
        $lastOrderId=$order->getId();
        $ordercollection = $this->collection
            ->addFieldToFilter('order_id',array('eq'=>$lastOrderId))
            ->addFieldToFilter('product_status',array('eq'=>0));
        foreach($ordercollection as $item){
            $actparterprocost = $item->getActualparterprocost();
            $totalamount = $item->getTotalAmount();
            $seller_id = $item->getVendorId();

            $collectionverifyread = ($this->objectManager->create('AWstreams\Marketplace\Model\SalePerPartner'))->getCollection();
            $collectionverifyread->addFieldToFilter('vendor_id',array('eq'=>$seller_id));
            if(count($collectionverifyread)>=1){
                foreach($collectionverifyread as $verifyrow){
                    $totalsale=$verifyrow->getTotalSale()+$totalamount;
                    $totalremain=$verifyrow->getAmountRemain()+$actparterprocost;
                    $verifyrow->setTotalSale($totalsale);
                    $verifyrow->setAmountRemain($totalremain);
                    $verifyrow->save();
                }
            }
            else{
                $collectionf= $this->objectManager->create('AWstreams\Marketplace\Model\SalePerPartner');
                $collectionf->setVendorId($seller_id);
                $collectionf->setTotalSale($totalamount);
                $collectionf->setAmountRemain($actparterprocost);
                $collectionf->setCommision($percent);
                $collectionf->save();
            }
            $item->setProductStatus(1)->save();
        }
    }


    public function getProductSalesCalculation($order){
        $percent = $this->helper->getGeneralConfig()->get('global_commission_rate');
        $lastOrderId=$order->getId();

        foreach ($order->getAllItems() as $item){
            $temp=$item->getProductOptions();
            if (array_key_exists('vendor_id', $temp['info_buyRequest'])) {
                $seller_id= $temp['info_buyRequest']['vendor_id'];
            }
            else {
                $seller_id='';
            }
            $price=$item->getPrice()/$this->storeManager->getStore()->getCurrentCurrencyRate();
            /*if($seller_id==''){
                $collection_product = Mage::getModel('marketplace/product')->getCollection();
                $collection_product->addFieldToFilter('mageproductid',array('eq'=>$item->getProductId()));
                foreach($collection_product as $selid){
                    $seller_id=$selid->getuserid();
                }
            }*/
            if($seller_id==''){$seller_id=0;}
            $collection1 = ($this->objectManager->create('AWstreams\Marketplace\Model\SalePerPartner'))->getCollection();
            $collection1->addFieldToFilter('vendor_id',array('eq'=>$seller_id));
            $qty=$item->getQtyOrdered();
            $totalamount=$qty*$price;

            if(count($collection1)!=0){
                foreach($collection1 as $rowdatasale) {
                    $commision=($totalamount*$rowdatasale->getcommision())/100;
                }
            }
            else{
                $commision=($totalamount*$percent)/100;
            }

            $wholedata['id'] = $item->getProductId();
            ($this->objectManager->get('Magento\Framework\Event\ManagerInterface'))->dispatch('mp_advance_commission', $wholedata);
            /*$advancecommission = Mage::getSingleton('core/session')->getData('commission');
            if($advancecommission!=''){
                $percent=$advancecommission;
                $commType = Mage::getStoreConfig('mpadvancecommission/mpadvancecommission_options/commissiontype');
                if($commType=='fixed')
                {
                    $commision=$percent;
                }
                else
                {
                    $commision=($totalamount*$advancecommission)/100;
                }
                if($commision>$totalamount){ $commission= $totalamount*($this->helper->getGeneralConfig()->get('global_commission_rate'))/100; }
            }*/

            $actparterprocost=$totalamount-$commision;
            $collectionsave = $this->objectManager->create('AWstreams\Marketplace\Model\SalesList');
            $collectionsave->setProductId($item->getProductId());
            $collectionsave->setOrderId($lastOrderId);
            $collectionsave->setRealOrderId($order->getIncrementId());
            $collectionsave->setQuantity($qty);
            $collectionsave->setVendorId($seller_id);
            $collectionsave->setProductStatus(0);
            $collectionsave->setBuyerId($this->session->getCustomer()->getId());
            $collectionsave->setProductPrice($price);
            $collectionsave->setProductName($item->getName());
            if($totalamount!=0){
                $collectionsave->setTotalAmount($totalamount);
            }
            else{
                $collectionsave->setTotalAmount($price);
            }
            $collectionsave->setTotalCommision($commision);
            $collectionsave->setActualparterprocost($actparterprocost);
            $collectionsave->setClearedAt(date('Y-m-d H:i:s'));
            $collectionsave->save();
            $qty='';
        }
    }

    /*public function getSalesdetail($mageproid){
        $data = array(
            'quantitysoldconfirmed'=>0,
            'quantitysoldpending'=>0,
            'amountearned'=>0,
            'clearedat'=>0,
            'quantitysold'=>0,
        );
        $sum=0;
        $arr=array();
        $quantity = Mage::getModel('marketplace/saleslist')->getCollection()
            ->addFieldToFilter('mageproid',array('eq'=>$mageproid));

        foreach($quantity as $rec){
            $status=$rec->getCpprostatus();
            $data['quantitysold']=$data['quantitysold']+$rec->getMagequantity();
            if($status==1){
                $data['quantitysoldconfirmed']=$data['quantitysoldconfirmed']+$rec->getMagequantity();
            }else{
                $data['quantitysoldpending']=$data['quantitysoldpending']+$rec->getMagequantity();
            }
        }

        $amountearned = Mage::getModel('marketplace/saleslist')->getCollection()
            ->addFieldToFilter('cpprostatus',array('eq'=>1));
        $amountearned->getSelect()->where('mageproid ='.$mageproid);
        foreach($amountearned as $rec) {
            $data['amountearned']=$data['amountearned']+$rec->getactualparterprocost();
            $arr[]=$rec->getClearedAt();
        }
        $data['clearedat']=$arr;
        return $data;
    }
    public function createdAt($mageproid){
        $arr=array();
        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection->addFieldToFilter('entity_id',array('eq' => $mageproid));
        foreach($collection as $rec) {
            $arr[]=$rec->getCreatedAt();
        }
        return $arr;
    }
    public function getDateDetail(){
        $session = Mage::getSingleton('customer/session');
        $cidvar = $session->getId();
        $collection1 = Mage::getModel('marketplace/saleslist')->getCollection()
            ->addFieldToFilter('mageproownerid',array('eq'=>$cidvar))
            ->addFieldToFilter('mageorderid',array('neq'=>0));
        $collection2= Mage::getModel('marketplace/saleslist')->getCollection()
            ->addFieldToFilter('mageproownerid',array('eq'=>$cidvar))
            ->addFieldToFilter('mageorderid',array('neq'=>0));
        $collection3 = Mage::getModel('marketplace/saleslist')->getCollection()
            ->addFieldToFilter('mageproownerid',array('eq'=>$cidvar))
            ->addFieldToFilter('mageorderid',array('neq'=>0));
        $first_day_of_week = date('Y-m-d', strtotime('Last Monday', time()));
        $last_day_of_week = date('Y-m-d', strtotime('Next Sunday', time()));
        $month=$collection1->addFieldToFilter('cleared_at', array('datetime' => true,'from' =>  date('Y-m').'-01 00:00:00','to' =>  date('Y-m').'-31 23:59:59'));
        $week=$collection2->addFieldToFilter('cleared_at', array('datetime' => true,'from' =>  $first_day_of_week.' 00:00:00','to' =>  $last_day_of_week.' 23:59:59'));
        $day=$collection3->addFieldToFilter('cleared_at', array('datetime' => true,'from' =>  date('Y-m-d').' 00:00:00','to' =>  date('Y-m-d').' 23:59:59'));
        $sale=0;

        $data1['year']=$sale;
        $sale1=0;
        foreach($day as $record1) {
            $sale1=$sale1+$record1->gettotalamount();
        }
        $data1['day']=$sale1;
        $sale2=0;
        foreach($month as $record2) {
            $sale2=$sale2+$record2->gettotalamount();
        }
        $data1['month']=$sale2;
        $sale3=0;
        foreach($week as $record3) {
            $sale3=$sale3+$record3->gettotalamount();
        }
        $data1['week']=$sale3;
        return $data1;
    }
    public function getMonthlysale(){
        $customerid = Mage::getSingleton('customer/session')->getId();
        $data=array();
        $curryear = date('Y');
        for($i=1;$i<=12;$i++){
            $date1=$curryear."-".$i."-01 00:00:00";
            $date2=$curryear."-".$i."-31 23:59:59";
            $collection = Mage::getModel('marketplace/saleslist')->getCollection();
            $collection=$collection->addFieldToFilter('mageproownerid',array('eq'=>$customerid));
            $collection=$collection->addFieldToFilter('cleared_at', array('datetime' =>true,'from' =>  $date1,'to' =>  $date2));
            $sum=array();
            $temp=0;
            foreach ($collection as $record) {
                $temp = $temp+$record->getactualparterprocost();
            }
            $baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode();
            $currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
            $price = Mage::helper('directory')->currencyConvert($temp, $baseCurrencyCode, $currentCurrencyCode);
            $data[$i]=$price;
        }
        return json_encode($data);
    }
    public function getOrderdetails(){
        $customerid = Mage::getSingleton('customer/session')->getId();
        $collection = Mage::getModel('marketplace/saleslist')->getCollection();
        $collection->addFieldToFilter('mageproownerid',array('eq'=>$customerid))->setOrder('autoid','DESC');
        $userorder=array();
        $gropoid=array();
        $groporderid=array();
        $productname=array();
        $i=0;
        foreach ($collection as $record) {
            $i++;
            if($i<=5){
                if(count($gropoid) && $record->getmagerealorderid()==$gropoid[$i-1]){
                    $i--;
                    $productid=$productid.",".$record->getmageproid();
                    $productname=$productname.",".$record->getmageproname()." X ".$record->getmagequantity();
                    $pprice=$pprice+$record->getactualparterprocost();
                    $userorder[$i]=array('mageproid'=>$productid,
                        'mageorderid'=>$record->getmageorderid(),
                        'magerealorderid'=>$record->getmagerealorderid(),
                        'mageproname'=>$productname,
                        'actualparterprocost'=>$pprice,
                        'cleared_at'=>$record->getcleared_at()
                    );
                }
                else{
                    $productname=$record->getmageproname()." X ".$record->getmagequantity();
                    $productid=$record->getmageproid();
                    $pprice=$record->getactualparterprocost();
                    $groporderid[$i]=$record->getmageorderid();
                    $gropoid[$i]=$record->getmagerealorderid();
                    $userorder[$i]=array('mageproid'=>$record->getmageproid(),
                        'mageorderid'=>$record->getmageorderid(),
                        'magerealorderid'=>$record->getmagerealorderid(),
                        'mageproname'=>$productname,
                        'actualparterprocost'=>$pprice,
                        'cleared_at'=>$record->getcleared_at()
                    );
                }
            }
        }
        return $userorder;
    }
    public function getPaymentDetailById(){
        $customerid = Mage::getSingleton('customer/session')->getId();
        $collection = Mage::getModel('marketplace/userprofile')->getCollection();
        $collection->addFieldToFilter('mageuserid',array('eq'=>$customerid));
        foreach($collection as $row){
            $paymentsource=$row->getPaymentsource();
        }
        return $paymentsource;
    }

    public function getpronamebyorder($mageorderid){
        $customerid=Mage::getSingleton('customer/session')->getCustomerId();
        $name='';
        $_collection = Mage::getModel('marketplace/saleslist')->getCollection();
        $_collection->addFieldToFilter('mageorderid',$mageorderid);
        $_collection->addFieldToFilter('mageproownerid',$customerid);
        foreach($_collection as $res){
            $name = $name."<p style='color:silver;float:left;'>".$res['mageproname']." X ".$res['magequantity']."&nbsp;</p>";
        }
        return $name;
    }

    public function getPricebyorder($mageorderid){
        $customerid=Mage::getSingleton('customer/session')->getCustomerId();
        $_collection = Mage::getModel('marketplace/saleslist')->getCollection();
        $_collection->getSelect()
            ->where('mageproownerid ='.$customerid)
            ->columns('SUM(actualparterprocost) AS qty')
            ->group('mageorderid');
        foreach($_collection as $coll){
            if($coll->getMageorderid() == $mageorderid){
                return $coll->getQty();
            }
        }
    }
    */
}