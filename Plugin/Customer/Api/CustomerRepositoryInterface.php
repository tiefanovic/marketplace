<?php

namespace AWstreams\Marketplace\Plugin\Customer\Api;

use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;
use Magento\Customer\Api\Data\CustomerInterface;


class CustomerRepositoryInterface
{
    /**
     * Check if customer applied to become a seller
     * @param CustomerRepository $customerRepository
     * @param CustomerInterface $customer
     * @return array
     */
    public function afterSave(CustomerRepository $customerRepository, CustomerInterface $customer)
    {

        //$isVendor = $customerRepository->getById($customer->getId())->getCustomAttribute('is_vendor')->getValue();

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('beforeSave');
        $logger->info($customer->getCustomAttributes());

        return $customer;
    }
}