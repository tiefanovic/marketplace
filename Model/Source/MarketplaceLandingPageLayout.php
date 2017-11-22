<?php

namespace AWstreams\Marketplace\Model\Source;

class MarketplaceLandingPageLayout implements \Magento\Framework\Option\ArrayInterface
{ 
    /**
     * Return array of options as value-label pairs, eg. value => label
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            '0' => 'Layout 1',
            '1' => 'Layout 2',
            '2' => 'Layout 3',
            
        ];
    }
}