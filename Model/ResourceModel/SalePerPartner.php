<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 12/20/17
 * Time: 4:02 PM
 */

namespace AWstreams\Marketplace\Model\ResourceModel;


class SalePerPartner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{


    protected $_date;

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('mmultivendor_saleperpartner', 'sale_id');
    }


}