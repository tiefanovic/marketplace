<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 12/20/17
 * Time: 1:36 PM
 */

namespace AWstreams\Marketplace\Controller\Seller;


use Magento\Framework\App\Action\Action;

class Transaction extends Action
{

    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->set(__('Seller Transaction'));
        $this->_view->renderLayout();

    }
}