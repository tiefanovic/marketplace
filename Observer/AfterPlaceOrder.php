<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 12/20/17
 * Time: 6:02 PM
 */

namespace AWstreams\Marketplace\Observer;


use AWstreams\Marketplace\Helper\SalesListHelper;
use Magento\Customer\Model\Session;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;

class AfterPlaceOrder implements ObserverInterface
{
    /*protected $session;
    protected $objectManager;
    protected $helper;
    protected $orderFactory;
    protected $logger;
    public function __construct(
        Session $session,
        ObjectManager $objectManager,
        SalesListHelper $helper,
        Order $orderFactory
    )
    {
        $this->objectManager = $objectManager::getInstance();
        $this->session = $session;
        $this->helper = $helper;
        $this->orderFactory = $orderFactory;
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $this->logger = $logger;
    }*/

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('Obeserved');

        $orderIds = $observer->getEvent()->getOrder();
        $lastorderId = $orderIds->getId();

        $logger->info('Order Id =>' . $lastorderId);
        /*$order = $this->orderFactory->load($lastorderId);
        $this->helper->getProductSalesCalculation($order);*/
    }
}