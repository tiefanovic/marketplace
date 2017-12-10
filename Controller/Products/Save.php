<?php
/**
 * Save
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Controller\Products;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
class Save extends Action
{
    protected $pageFactory;
    protected $productCollection;
    protected $_customerSession;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        CollectionFactory $collectionFactory,
        Session $session
    )
    {
        $this->_customerSession = $session;
        $this->pageFactory = $pageFactory;
        $this->productCollection = $collectionFactory->create();
        parent::__construct($context);
    }
    
    public function execute()
    {
        $result = $this->pageFactory->create();
        $post = (array) $this->getRequest()->getPost();
        var_dump($post);
        //$result->getConfig()->getTitle()->set(_('Products List'));
        /*$this->productCollection->addFieldToSelect('*');
        $customerId = $this->_customerSession->getCustomer()->getId();
        $this->productCollection->addAttributeToFilter('vendor_id', ['eq'=>$customerId]);
        /*$post = $this->getRequest()->getPost();
        if (!empty($post)) {
            $needle = $post['name'];
            $this->productCollection->addAttributeToFilter('name', array(
                array('like' => '% '.$needle.' %'), //spaces on each side
                array('like' => '% '.$needle), //space before and ends with $needle
                array('like' => $needle.' %') // starts with needle and space after
            ));

        }
        $block = $result->getLayout()->getBlock('marketplace_products_list');
        $block->setProductCollection($this->productCollection);*/
        return $result;
    }

}