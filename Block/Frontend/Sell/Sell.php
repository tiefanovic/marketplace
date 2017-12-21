<?php

namespace AWstreams\Marketplace\Block\Frontend\Sell;


use AWstreams\Marketplace\Model\ResourceModel\Profile\Collection;
use Magento\Framework\View\Element\Template;
use AWstreams\Marketplace\Helper\Data ;
use Magento\Catalog\Model\ResourceModel\Product\Collection AS Product;
use \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class Sell extends \Magento\Framework\View\Element\Template
{
    protected $_helper ;
    protected $shopCollection ;
    protected $productCollection ;
    protected $collectionFactory;


    public function __construct(Template\Context  $context, array $data = [],
                                Data $helper,
                                Collection $shop,
                                CollectionFactory $collectionFactory,
                                Product $product

    ){
        $this->_helper = $helper;
        $this->shopCollection = $shop;
        $this->productCollection = $product;
        $this->collectionFactory = $collectionFactory;

        parent::__construct($context, $data);

    }

    public  function getData1()
    {
      return $this->_helper->getLandingPageConfig()->getConfig('marketplace');
    }

    /**
     * @return \Magento\Framework\DataObject Shop Profile
     */
    public function getShops()
    {
        return $this->shopCollection->addOrder('shop_id','asc')->getData();
    }


    public function getProducts($customer_id)
    {

        $vendor = $this->productCollection->getAllAttributeValues('vendor_id');

        $productIds = array() ;
        foreach ($vendor as $k =>$v){
            foreach ($v as $kk => $vv){
                if($vv == $customer_id)
                    array_push($productIds,$k);
            }
        }

        $collection = $this->collectionFactory->create()->addIdFilter($productIds);
        $collection->addAttributeToSelect("*");
        $collection->addAttributeToSort('entity_id','desc');
        //$collection->setPageSize(3);

        $items= array();
        $i= -1 ;
        $total = 0 ;
        foreach ($collection as $item){
            $i++;
            $pro = $item->getData();
            $items[$i][]= $pro['name'];
            $items[$i][] =$pro['image'];
            $total += 1 ;
           /* if ($i > 3)
                break;
            else
                $i++;*/
        }
        $items['total'] = $total ;
        return $items;
    }












}