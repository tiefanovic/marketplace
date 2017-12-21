<?php
namespace AWstreams\Marketplace\Controller\Sell;


class Sell extends \Magento\Framework\App\Action\Action
{

    public function execute()
    {

        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->set(__('Sell'));
        $this->_view->renderLayout();

    }

}