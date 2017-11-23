<?php
namespace AWstreams\Marketplace\Block\Frontend\Seller;

use AWstreams\Marketplace\Model\ResourceModel\Profile\Collection;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;
use AWstreams\Marketplace\Model\Data;

class Profile extends Template
{


    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $currentCustomer;
    /**
     * @var \AWstreams\Marketplace\Model\Profile
     */
    protected $profile ;
    /**
     * @var Collection
     */
    protected $profileCollection;
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
                                \AWstreams\Marketplace\Model\Profile $profile,
                                Session $session,
                                Collection $profileCollection
    )
    {
        $this->profile =$profile;
        $this->profileCollection = $profileCollection;
        $this->_session = $session;
        $this->currentCustomer = $this->_session->getCustomer();
        parent::__construct($context, $data);
    }


    /**
     * @return string url
     */
    public function getFormAction()
    {
        return $this->getUrl("marketplace/seller/saveprofile");

    }

    public function getUrlImage()
    {
        return $this->getUrl("pub/media/shop");

    }

    /**
     * @return \Magento\Framework\DataObject Shop Profile
     */
    public function getCurrentProfile()
    {

        $profile = $this->profileCollection->addFieldToFilter('customer_id', $this->currentCustomer->getId());
        return $profile->getFirstItem();
    }



}
