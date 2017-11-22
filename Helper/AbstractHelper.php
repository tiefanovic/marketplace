<?php
/**
 * AbstractHelper
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Helper;


use Magento\Framework\ObjectManagerInterface;
use \Magento\Framework\App\Helper\AbstractHelper as Helper;
use \Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class AbstractHelper extends Helper
{
    protected $_objectManager = null;
    protected $logger;
    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager
    )
    {
        parent::__construct($context);
        $this->_objectManager = $objectManager;
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $this->logger = new \Zend\Log\Logger();
        $this->logger->addWriter($writer);
    }
    /**
     * The Basics:
     * These functions are used to do the basic functionality
     */

    /**
     * Send Configuration path to this function and get the module admin Config data
     * @param @var $configPath
     * @return string
     */
    public function getConfig($configPath)
    {
        return $this->scopeConfig->getValue(
            $configPath,
            ScopeInterface::SCOPE_STORE);
    }

}