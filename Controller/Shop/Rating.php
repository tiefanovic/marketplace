<?php
namespace AWstreams\Marketplace\Controller\Shop;


class Rating extends \Magento\Framework\App\Action\Action
{

    public function execute()
    {
        $this->_view->loadLayout();
        //$this->_view->getPage()->getConfig()->getTitle()->set(__('Shop'));
        $this->_view->renderLayout();
    }

}