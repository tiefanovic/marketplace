<?php
/**
 * Created by PhpStorm.
 * User: noh
 * Date: 11/28/17
 * Time: 12:33 PM
 */
namespace AWstreams\Marketplace\Controller\Shop;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;



class SaveRating extends Action
{



    protected $_resultFactory;


    public function __construct(Context $context)

    {
        $this->_resultFactory = $context->getResultFactory();


        parent::__construct($context);
    }

    public function execute()
    {
        $post = $this->getRequest()->getPostValue();


        if (!$post)
            return $this->_redirect('*/*/');

        $model = $this->_objectManager->create('AWstreams\Marketplace\Model\Rating');
        $model->setName($post['name']);
        $model->setPrice($post['feed_price']);
        $model->setValue($post['feed_value']);;
        $model->setQuality($post['feed_quality']);
        $model->setSummary($post['summary']);
        $model->setReview($post['review']);
        $model->setShopId($post['shop_id']);

        $model->save();
        // Display the succes form validation message
        $this->messageManager->addSuccessMessage('Done !');

        // Redirect to your form page (or anywhere you want...)
        $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());

        return $resultRedirect;

    }

}



