<?php
/**
 * Data
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Helper;


use AWstreams\Marketplace\Helper\Config\GeneralConfig;
use AWstreams\Marketplace\Helper\Config\GlobalConfig;
use AWstreams\Marketplace\Helper\Config\InventoryConfig;
use AWstreams\Marketplace\Helper\Config\SellerOrderConfig;
use AWstreams\Marketplace\Helper\Config\SellerProductConfig;
use AWstreams\Marketplace\Helper\Config\SellerProfilePageConfig;
use AWstreams\Marketplace\Helper\Config\SellerReviewConfig;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;

class Data extends AbstractHelper
{
    /**
     * the GlobalConfig object
     * @var GlobalConfig
     */
    protected $_generalConfig;
    /**
     * the SellerProductConfig object
     * @var SellerProductConfig
     */
    protected $_sellerProductConfig;
    /**
     * @var InventoryConfig
     */
    protected $_inventoryConfig;
    /**
     * @var SellerOrderConfig
     */
    protected $_sellerOrderConfig;
    /**
     * @var SellerProductConfig
     */
    protected $_sellerProfilePageConfig;
    /**
     * @var SellerReviewConfig
     */
    protected $_sellerReviewConfig;

    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        GeneralConfig $generalConfig ,
        SellerProductConfig $sellerProductConfig,
        InventoryConfig $inventoryConfig,
        SellerOrderConfig $sellerOrderConfig,
        SellerProfilePageConfig $sellerProfilePageConfig,
        SellerReviewConfig $sellerReviewConfig)
    {
        $this->_generalConfig = $generalConfig;
        $this->_sellerProductConfig = $sellerProductConfig;
        $this->_inventoryConfig = $inventoryConfig;
        $this->_sellerOrderConfig = $sellerOrderConfig;
        $this->_sellerProfilePageConfig = $sellerProfilePageConfig;
        $this->_sellerReviewConfig = $sellerReviewConfig;

        parent::__construct($context, $objectManager);
    }

    /**
     * Getter Method for GlobalConfig
     * @return  GlobalConfig
     */
    public function getGeneralConfig()
    {
        return $this->_generalConfig;
    }

    /**
     * Getter Method for SellerProductConfig
     * @return  SellerProductConfig
     */
    public function getSellerProductConfig()
    {
        return $this->_sellerProductConfig;
    }

    /**
     * @return InventoryConfig
     */
    public function getInventoryConfig()
    {
        return $this->_inventoryConfig;
    }

    /**
     * @return SellerOrderConfig
     */
    public function getSellerOrderConfig()
    {
        return $this->_sellerOrderConfig;
    }

    /**
     * @return SellerProductConfig
     */
    public function getSellerProfilePageConfig()
    {
        return $this->_sellerProfilePageConfig;
    }

    /**
     * @return SellerReviewConfig
     */
    public function getSellerReviewConfig()
    {
        return $this->_sellerReviewConfig;
    }



}