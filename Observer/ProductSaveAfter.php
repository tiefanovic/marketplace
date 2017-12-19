<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 12/19/17
 * Time: 2:29 PM
 */

namespace AWstreams\Marketplace\Observer;


use Magento\Customer\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ProductSaveAfter implements ObserverInterface
{
    protected $session;

    public function __construct(
        Session $session
    )
    {
        $this->session = $session;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product  = $observer->getProduct();
        $product->setVendorId($this->session->getCustomerId());
        $product->save();
    }
}