<?php
namespace AWstreams\Marketplace\Controller\Seller;


class Contact extends \Magento\Framework\App\Action\Action
{

    public function execute()
    {

        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->set(__('Seller Contacts'));
        $this->_view->renderLayout();

    }

}