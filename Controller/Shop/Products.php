<?php
namespace AWstreams\Marketplace\Controller\Shop;


class Products extends \Magento\Framework\App\Action\Action
{

    public function execute()
    {
        $this->_view->loadLayout();
       $this->_view->getPage()->getConfig()->getTitle()->set(__('Shop Products'));
        $this->_view->renderLayout();
    }

}