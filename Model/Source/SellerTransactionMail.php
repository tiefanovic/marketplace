<?php

namespace AWstreams\Marketplace\Model\Source;

class SellerTransactionMail implements \Magento\Framework\Option\ArrayInterface
{ 
    /**
     * Return array of options as value-label pairs, eg. value => label
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            '0' => 'Transaction Notification  on Mail of Payment to Seller (Default)',
            
        ];
    }
}