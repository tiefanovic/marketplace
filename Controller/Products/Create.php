<?php
/**
 * Create
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Controller\Products;


use AWstreams\Marketplace\Controller\AbstractVendor;
use Magento\Customer\Controller\AbstractAccount;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;

class Create extends Action
{

    /** @var  \Magento\Framework\View\Result\Page */
    protected $resultPageFactory;
    protected $_session;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Session $session
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_session = $session;
        parent::__construct($context);
    }


    /**
     * Blog Index, shows a list of recent blog posts.
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Add Product'));

        return $resultPage;
    }
}