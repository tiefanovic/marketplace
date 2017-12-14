<?php
namespace AWstreams\Marketplace\Controller\Seller;

class Ship extends \Magento\Framework\App\Action\Action
{

    public function execute()
    {

        $this->_view->loadLayout();
        $params = $this->getRequest()->getParams();
        $id = $params['order_id'];
        $shipid = $params['ship_id'];
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('Magento\Sales\Model\Order')->load($id);
        $ships = $order->getShipmentsCollection()->getData();
        foreach ($ships as $inv){
            if($inv['entity_id'] == $shipid){
                $name= 'Shipments # '. $inv['increment_id'];

            }
        }

        $this->_view->getPage()->getConfig()->getTitle()->set(__($name));
        $this->_view->renderLayout();

    }

}