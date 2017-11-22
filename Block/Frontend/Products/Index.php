<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 19/11/17
 * Time: 01:07 م
 */

namespace AWstreams\Marketplace\Block\Frontend\Products;

use Magento\Catalog\Block\Product\ListProduct;
use Magento\Catalog\Model\ResourceModel\Product\Collection;

class Index extends ListProduct
{
    public function getLoadedProductCollection()
    {
        return $this->_productCollection;
    }

    public function setProductCollection(Collection $collection)
    {
        $this->_productCollection = $collection;
    }
    public function getSearchableUrl(){
        return $this->_urlBuilder->getUrl('marketplace/products/index');
    }
    public function getSalesDeails($id){
        return $this->_urlBuilder->getUrl('marketplace/products/salesdetails', ['id' => $id]);
    }

}