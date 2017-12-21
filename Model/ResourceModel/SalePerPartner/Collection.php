<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 12/20/17
 * Time: 4:04 PM
 */

namespace AWstreams\Marketplace\Model\ResourceModel\SalePerPartner;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'sale_id';
    protected $_eventPrefix = 'marketplace_saleperpartner_collection';
    protected $_eventObject = 'saleperpartner_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
{
    $this->_init('AWstreams\Marketplace\Model\SalePerPartner', 'AWstreams\Marketplace\Model\ResourceModel\SalePerPartner');
}
}