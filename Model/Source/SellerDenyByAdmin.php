<?php

namespace AWstreams\Marketplace\Model\Source;

class SellerDenyByAdmin implements \Magento\Framework\Option\ArrayInterface
{ 
    /**
     * Return array of options as value-label pairs, eg. value => label
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            '0' => 'Seller Deny Notification Mail to Seller (Default)',
            
        ];
    }
}