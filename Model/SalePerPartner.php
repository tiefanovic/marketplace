<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 12/20/17
 * Time: 4:01 PM
 */

namespace AWstreams\Marketplace\Model;


class SalePerPartner extends \Magento\Framework\Model\AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'mmultivendor_saleperpartner';
    protected $_cacheTag = 'mmultivendor_saleperpartner';

    protected function _construct()
    {
        $this->_init('AWstreams\Marketplace\Model\ResourceModel\SalePerPartner');
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