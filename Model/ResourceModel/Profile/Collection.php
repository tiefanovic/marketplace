<?php
namespace AWstreams\Marketplace\Model\ResourceModel\Profile;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'shop_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('AWstreams\Marketplace\Model\Profile', 'AWstreams\Marketplace\Model\ResourceModel\Profile');
    }

}