<?php
/**
 * Create
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Block\Frontend\Products;


use AWstreams\Marketplace\Helper\Data;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;

class Create extends Template
{
    protected $helper;
    protected $_productFactory;

    public function __construct(
        Context $context,
        Data $helper,
        ProductFactory $productFactory

    )
    {
        $this->_productFactory = $productFactory;
        $this->helper = $helper;
        parent::__construct($context);
    }

    public function getPostActionUrl()
    {
        return $this->getUrl('marketplace/products/save');
    }

    public function getAjaxUrl()
    {
        return $this->getUrl('marketplace/products/search');
    }

    public function getImageUploadAction()
    {
        return $this->_urlBuilder->getUrl('marketplace/products/image');
    }
    public function getCustomAttributes(){
        return $this->helper->getCustomAttributes($this->_productFactory->create()->getDefaultAttributeSetId());
    }
}