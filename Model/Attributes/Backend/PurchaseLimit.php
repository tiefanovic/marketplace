<?php
/**
 * PurchaseLimit
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Model\Attributes\Backend;


use AWstreams\Marketplace\Helper\Data;
use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;

class PurchaseLimit extends  AbstractBackend
{
    protected $_helper;
    function __construct(Data $helper)
    {
        $this->_helper = $helper;
    }

    public function beforeSave($object)
    {
        // Get Product Purchase Limit attribue value
        $purchaseLimitAttribute = $this->getAttribute()->getAttributeCode();
        $limitValue = (int) $object->getData($purchaseLimitAttribute);

        // Check if limit is more than 0
        if(!empty($limitValue) && $limitValue < 0 ){
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The value of attribute "%1" must be greater than or equal 0', $purchaseLimitAttribute)
            );
        }
        if(!is_int($object->getData($purchaseLimitAttribute)) || trim($object->getData($purchaseLimitAttribute)) == '')
            $object->setData($purchaseLimitAttribute, $this->_helper->getSellerProductConfig()->getPurchaseLimit());
        parent::beforeSave($object);
        return true;
    }
}