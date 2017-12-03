<?php
namespace AWstreams\Marketplace\Controller\Shop;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Customer\Model\Session;



class SaveContact extends Action
{



    protected $_resultFactory;
    protected $customerSession;
    protected $currentCustomer;


    public function __construct(Context $context,
                                Session $customerSession)

    {
        $this->_resultFactory = $context->getResultFactory();
        $this->customerSession = $customerSession;
        $this->currentCustomer =$this->customerSession->getCustomer();

        parent::__construct($context);
    }

    public function execute()
    {
        $post = $this->getRequest()->getPostValue();

        if (!$post)
            return $this->_redirect('*/*/');

        $model = $this->_objectManager->create('AWstreams\Marketplace\Model\Contact');

        $customerId = $this->currentCustomer->getId();

        $model->setName($post['name']);
        $model->setEmail($post['email']);;
        $model->setSubject($post['subject']);
        $model->setMessage($post['message']);
        $model->setCustomerId($customerId);

        $model->save();
        // Display the succes form validation message
        $this->messageManager->addSuccessMessage('Done !');

        // Redirect to your form page (or anywhere you want...)
        $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());

        return $resultRedirect;

    }

}



