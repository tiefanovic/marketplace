<?php
namespace AWstreams\Marketplace\Controller\Seller;

class Order extends \Magento\Framework\App\Action\Action
{

    public function execute()
    {

        $this->_view->loadLayout();
        $params = $this->getRequest()->getParams();
        $id = $params['id'];
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('Magento\Sales\Model\Order')->load($id);
        $order= $order->getData();
        $name= 'Order # '. $order['increment_id'];
        $this->_view->getPage()->getConfig()->getTitle()->set(__($name));
        $this->_view->renderLayout();

    }

}