<?php

namespace AWstreams\Marketplace\Block\Frontend\Shop;


use AWstreams\Marketplace\Model\ResourceModel\Profile\Collection;
use Magento\Framework\View\Element\Template;
use AWstreams\Marketplace\Model\ResourceModel\Rating\Collection AS Rate;
use Magento\Catalog\Model\ResourceModel\Product\Collection AS Product;
use \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class Shop extends \Magento\Framework\View\Element\Template
{
    protected $profileCollection ;
    protected $rateCollection ;
    protected $productCollection ;
    protected $collectionFactory;
    protected $listProductBlock;

    public function __construct(Template\Context  $context, array $data = [],
                                Collection $profileCollection,
                                Product $product,
                                CollectionFactory $collectionFactory,
                                \Magento\Catalog\Block\Product\ListProduct $listProductBlock,
                                Rate $rateCollection
    ){
        $this->rateCollection = $rateCollection;
        $this->profileCollection = $profileCollection;
        $this->productCollection = $product ;
        $this->listProductBlock = $listProductBlock;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);

    }

    public function getShop($shop_title)
    {

        return $this->profileCollection->addFieldToFilter('shop_title', $shop_title)->getFirstItem();
    }

    public function getUrlNav($shop_title)
    {
        $route = "marketplace/shop/shop/profile/" .$shop_title  ;
        return $this->getUrl($route);

    }

    public function getUrlImage()
    {
        return $this->getUrl("pub/media/shop");

    }

    public function getRates($shop_id)
    {

        return $this->rateCollection->addFieldToFilter('shop_id', $shop_id)
            ->setOrder('created_at','desc')
            ->addFilter('approve','1')
            ->getData();
    }

    public function getFormAction($url)
    {
        $url = "marketplace/shop/" . $url ;
        return $this->getUrl($url);

    }

    public function getUrlRate($shop_title)
    {
        $route ="marketplace/shop/rating/profile/". $shop_title ;
        return $this->getUrl($route);

    }

    public function test(){
        return $this->getRequest()->getParams();
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
        return $collection;
    }

    public function getAddToCartPostParams($product)
    {
        return $this->listProductBlock->getAddToCartPostParams($product);
    }


}