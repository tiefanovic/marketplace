<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 12/20/17
 * Time: 1:41 PM
 */

namespace AWstreams\Marketplace\Block\Frontend\Seller;


use AWstreams\Marketplace\Model\ResourceModel\SalesList\Collection;
use Magento\Backend\Block\Template\Context;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;
class Transaction extends Template
{

    protected $_productsCollection = null;
    protected $_session;
    public function __construct(
        Context $context,
        Session $session,
        Collection $salesCollection
    ){

         parent::__construct($context);
         $this->_session = $session;
         $id = $this->_session->getCustomerId();
         $collection = $salesCollection;
         $collection->addFieldToFilter('vendor_id',array('eq'=>$id));
         $collection->addFieldToFilter('product_status',array('eq'=>!0));
         $collection->setOrder('list_id');
         $this->setCollection($collection);
     }
    protected function _prepareLayout() {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager', 'custom.pager');
        $pager->setAvailableLimit(array(5=>5,10=>10,20=>20,'all'=>'all'));
        $pager->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        $this->getCollection()->load();
        return $this;
    }

    public function getPagerHtml() {
        return $this->getChildHtml('pager');
    }
    public function isPartner()
    {
        if($this->_session->getCustomer()->getIsVendor() == 1 && $this->_session->getCustomer()->getApprovedAccount() ==1)
            return true;
        return false;
    }
}