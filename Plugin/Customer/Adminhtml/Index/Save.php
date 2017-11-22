<?php
/**
 * Save
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Plugin\Customer\Adminhtml\Index;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Customer\Api\CustomerRepositoryInterface;
use  Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\Response\Http as ResponseHttp;

class Save
{
    /**
     * @var Session
     */
    protected $session;

    /** @var Validator */
    protected $formKeyValidator;

    /** @var CustomerRepositoryInterface */
    protected $customerRepositoryInterface;

    /** @var ManagerInterface * */
    protected $messageManager;

    /** @var ResponseHttp * */
    protected $responseHttp;

    protected $currentCustomer;

    /** @var AccountManagementInterface */
    protected $customerAccountManagement;


    public function __construct(
        Session $customerSession,
        Validator $formKeyValidator,
        CustomerRepositoryInterface $customerRepositoryInterface,
        ManagerInterface $messageManager,
        ResponseHttp $responseHttp,
        AccountManagementInterface $customerAccountManagement
    )
    {
        $this->session = $customerSession;
        $this->formKeyValidator = $formKeyValidator;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->messageManager = $messageManager;
        $this->responseHttp = $responseHttp;
        $this->customerAccountManagement = $customerAccountManagement;
    }

    public function aroundExecute(\Magento\Customer\Controller\Adminhtml\Index\Save $save, \Closure $proceed)
    {

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('before execute from save');
        $logger->info($save->getRequest()->getPostValue());

        return $proceed();
    }

    /**
     * @param $email
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    public function getCustomer($email)
    {
        $this->currentCustomer = $this->customerRepositoryInterface->get($email);
        return $this->currentCustomer;
    }

    /**
     * Check if customer is a vendor and account is approved
     * @return bool
     */
    public function isAVendorAndAccountNotApproved($customer)
    {
        $isVendor = $customer->getCustomAttribute('is_vendor')->getValue();
        $isApprovedAccount = $customer->getCustomAttribute('approve_account')->getValue();
        if ($isVendor && !$isApprovedAccount) {
            return true;
        }
        return false;
    }
}