<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 12/20/17
 * Time: 2:18 PM
 */

namespace AWstreams\Marketplace\Model\ResourceModel\SalesList;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'list_id';
    protected $_eventPrefix = 'multivendor_saleslist_collection';
    protected $_eventObject = 'saleslist_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('AWstreams\Marketplace\Model\SalesList', 'AWstreams\Marketplace\Model\ResourceModel\SalesList');
    }
}