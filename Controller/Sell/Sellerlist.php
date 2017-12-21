<?php
namespace AWstreams\Marketplace\Controller\Sell;


class Sellerlist extends \Magento\Framework\App\Action\Action
{

    public function execute()
    {

        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->set(__('Seller list'));
        $this->_view->renderLayout();

    }

}