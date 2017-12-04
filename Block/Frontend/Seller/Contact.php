<?php
namespace AWstreams\Marketplace\Block\Frontend\Seller;

use AWstreams\Marketplace\Model\ResourceModel\Contact\Collection;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;
use AWstreams\Marketplace\Model\Data;

class Contact extends Template
{


    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $currentCustomer;
    /**
     * @var \AWstreams\Marketplace\Model\Profile
     */
    protected $contactCollection ;
    /**
     * @var Collection
     */
    /**
     * @var Session
     */
    protected $_session;

    /**
     * Profile constructor.
     * @param Template\Context $context
     * @param array $data
     * @param \AWstreams\Marketplace\Model\Profile $profile
     * @param Session $session
     * @param Collection $profileCollection
     */
    public function __construct(Template\Context $context, array $data = [],
                                Session $session,
                                Collection $collection
    )
    {
        $this->contactCollection = $collection;
        $this->_session = $session;
        $this->currentCustomer = $this->_session->getCustomer();
        parent::__construct($context, $data);
    }


    /**
     * @return string url
     */
    public function getFormAction($url)
    {
        $url = "marketplace/seller/" .$url;
        return $this->getUrl($url);

    }

    public function getUrlImage()
    {
        return $this->getUrl("pub/media/shop");

    }

    /**
     * @return \Magento\Framework\DataObject Shop Profile
     */
    public function getCurrentContact()
    {
        return $this->contactCollection->addFieldToFilter('customer_id', $this->currentCustomer->getId())->getData()   ;
    }



}