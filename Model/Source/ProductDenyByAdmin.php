<?php

namespace AWstreams\Marketplace\Model\Source;

class ProductDenyByAdmin implements \Magento\Framework\Option\ArrayInterface
{ 
    /**
     * Return array of options as value-label pairs, eg. value => label
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            '0' => 'Product Deny Notification Mailto Seller (Default)',
            
        ];
    }
}