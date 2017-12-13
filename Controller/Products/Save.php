<?php
/**
 * Save
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Controller\Products;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context as ActionContext;
use Magento\Catalog\Controller\Adminhtml\Product\Builder as ProductBuilder;
use Magento\Catalog\Controller\Adminhtml\Product\Initialization\Helper as ProductInitializationHelper;
use Magento\Framework\View\Result\PageFactory;

class Save extends Action
{

    protected $initializationHelper;

    protected $productBuilder;

    protected $productTypeManager;

    protected $_session;
    public function __construct(
        ActionContext $context,
        ProductBuilder $productBuilder,
        ProductInitializationHelper $initializationHelper,
        PageFactory $resultPageFactory,
        Session $session,
        \Magento\Catalog\Model\Product\TypeTransitionManager $productTypeManager
    )
    {
        $this->_session = $session;
        $this->initializationHelper = $initializationHelper;
        $this->productBuilder = $productBuilder;
        $this->productTypeManager = $productTypeManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $request = $this->getRequest();
        $post = $this->getRequest()->getPostValue();
        if (!$post) {
            $resultRedirect->setPath('*/*/');
            return $resultRedirect;
        }
        $product = $this->initializationHelper->initialize($this->productBuilder->build($request));
        $this->productTypeManager->processProduct($product);
        $imagePaths = $request->getParam('image');
        if ($imagePaths) {
            $isFirst = true;
            foreach ($imagePaths as $path) {
                $product->addImageToMediaGallery($path, $isFirst ? ['image', 'small_image', 'thumbnail'] : null, false, false);
                $isFirst = false;
            }
        }
        $product->setTypeId('simple'); // Simple.
        $product->setAttributeSetId(4); // Default.
        $product->setStatus(1); // 1 - Enable, 2 - Disable.
        $product->setVisibility(4);
        $product->setSku($product->getName());
        $product->setVendorId($this->_session->getCustomerId());
        $product->save();
        $resultRedirect->setPath('marketplace/products');
        return $resultRedirect;
    }
}