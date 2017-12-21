<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 12/20/17
 * Time: 2:21 PM
 */

namespace AWstreams\Marketplace\Model;


use Magento\Framework\DataObject\IdentityInterface;

class SalesList extends \Magento\Framework\Model\AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'multivendor_saleslist';
    protected $_cacheTag = 'multivendor_saleslist';

    protected function _construct()
    {
        $this->_init('AWstreams\Marketplace\Model\ResourceModel\SalesList');
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

}