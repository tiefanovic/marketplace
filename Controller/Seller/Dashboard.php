<?php
/**
 * Created by PhpStorm.
 * User: noh
 * Date: 12/17/17
 * Time: 5:00 PM
 */

namespace AWstreams\Marketplace\Controller\Seller;


class Dashboard extends \Magento\Framework\App\Action\Action
{

    public function execute()
    {

        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->set(__('Dashboard'));
        $this->_view->renderLayout();

    }

}