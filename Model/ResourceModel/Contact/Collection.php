<?php
namespace AWstreams\Marketplace\Model\ResourceModel\Contact;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('AWstreams\Marketplace\Model\Contact', 'AWstreams\Marketplace\Model\ResourceModel\Contact');
    }

}