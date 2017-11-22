<?php

namespace AWstreams\Marketplace\Model\Source;

class ProductEditApprovalRequestToAdmin implements \Magento\Framework\Option\ArrayInterface
{ 
    /**
     * Return array of options as value-label pairs, eg. value => label
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            '0' => 'Edit Product Notification Mail to Admin (Default)',
            
        ];
    }
}