<?php
namespace AWstreams\Marketplace\Controller\Seller;

class Invoice extends \Magento\Framework\App\Action\Action
{

    public function execute()
    {

        $this->_view->loadLayout();
        $params = $this->getRequest()->getParams();
        $id = $params['order_id'];
        $invoiceid = $params['invoice_id'];
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('Magento\Sales\Model\Order')->load($id);
        $invoices = $order->getInvoiceCollection()->getData();
        foreach ($invoices as $inv){
            if($inv['entity_id'] == $invoiceid){
                $name= 'Invoice # '. $inv['increment_id'];

            }
        }

        $this->_view->getPage()->getConfig()->getTitle()->set(__($name));
        $this->_view->renderLayout();

    }

}