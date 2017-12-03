<?php
namespace AWstreams\Marketplace\Controller\Seller;


use AWstreams\Marketplace\Model\ResourceModel\Contact\Collection;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Controller\ResultFactory;


class DeleteContact extends Action
{

    /**
     * @var CustomerFactory
     */
    protected $contact;
    protected $_resultFactory;

    public function __construct(Context $context,
                                Collection $contact)

    {

       $this->contact = $contact;
        $this->_resultFactory = $context->getResultFactory();

        parent::__construct($context);
    }

    public function execute()
    {

        $post = $this->getRequest()->getPostValue();

        if (!$post)
            return $this->_redirect('*/*/');


        $id = $post['id'];
        $model = $this->contact->addFieldToFilter('id',$id )->getFirstItem();


        $model->delete();
        // Display the succes form validation message
        $this->messageManager->addSuccessMessage('Deleted !');

        // Redirect to your form page (or anywhere you want...)
        $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());

        return $resultRedirect;

    }

}



