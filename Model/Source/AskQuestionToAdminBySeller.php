<?php

namespace AWstreams\Marketplace\Model\Source;

class AskQuestionToAdminBySeller implements \Magento\Framework\Option\ArrayInterface
{ 
    /**
     * Return array of options as value-label pairs, eg. value => label
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            '0' => 'Ask Query to Admin to Seller (Default)',
            
        ];
    }
}