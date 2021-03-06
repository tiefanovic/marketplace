<?php
/**
 * Index
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Controller\Adminhtml\Commission;


use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;


class Index extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return void
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('AWstreams_Marketplace::commissions');
        $resultPage->addBreadcrumb(__('AWstreams'), __('AWstreams'));
        $resultPage->addBreadcrumb(__('Manage Commissions'), __('Manage Commissions'));
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Commissions'));

        return $resultPage;
    }
}