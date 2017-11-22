<?php

namespace AWstreams\Marketplace\Model\Source;

class SellerOrderInvoicedNotificationMail implements \Magento\Framework\Option\ArrayInterface
{ 
    /**
     * Return array of options as value-label pairs, eg. value => label
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            '0' => 'Order Invoiced Notification Mailto Seller (Default)',
            
        ];
    }
}