<?php

namespace AWstreams\Marketplace\Block\Frontend\Shop;


use AWstreams\Marketplace\Model\ResourceModel\Profile\Collection;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ResourceModel\Product\Collection as Product;
use Magento\Setup\Exception;
use Magento\Catalog\Model\Product\Attribute\Repository;
class ShopView extends \Magento\Framework\View\Element\Template
{
    protected $profileCollection ;
    protected $productCollection ;
    protected $productAttributeRepository;

    public function __construct(Template\Context  $context, array $data = [],
                                Collection $profileCollection,
                                Repository $productAttributeRepository,
                                Product $product)
    {
        $this->profileCollection= $profileCollection;
        $this->productCollection = $product;
        $this->productAttributeRepository = $productAttributeRepository;
        parent::__construct($context, $data);

    }

    public function getShop($id)
    {

        return $this->profileCollection->addFieldToFilter('customer_id', $id)->getFirstItem();
    }



    public function getShopView($key)
    {
        $product = $this->productCollection->addFilter('sku',$key)->getFirstItem();

        $productId = $product->getID();


        $vendor = $this->productCollection->getAllAttributeValues('vendor_id');

        if(!array_key_exists($productId,$vendor))
            return false ;

        $customerId = $vendor[$productId][0];

        $shop = $this->getShop($customerId)->getData();


        return $shop['shop_title'];




    }


}