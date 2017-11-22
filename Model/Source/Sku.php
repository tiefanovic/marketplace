<?php
/**
 * Sku
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Model\Source;


use Magento\Framework\Option\ArrayInterface;

class Sku implements ArrayInterface
{

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return [
            ['value'=>1, 'label'=>__('Static')],
            ['value'=>2, 'label'=>__('Dynamic')]
        ];
    }
}