<?php
namespace AWstreams\Marketplace\Controller\Seller;


class Profile extends \Magento\Framework\App\Action\Action
{

    public function execute()
    {

        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->set(__('Seller Profile'));
        $this->_view->renderLayout();

    }

}