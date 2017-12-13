<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 12/12/17
 * Time: 3:40 PM
 */

namespace AWstreams\Marketplace\Controller\Products;

use AWstreams\Marketplace\Helper\ImageHelper;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;

class Image extends Action
{

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;
    protected $_helper;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory,
        ImageHelper $helper
    )
    {
        parent::__construct($context, $resultPageFactory);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_helper = $helper;
    }

    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();
        $post = $this->getRequest()->getPostValue();
        if (!$_FILES['file']) {
            return $resultJson->setData(
                [
                    'error' => 400
                ]
            );
        }
        $path = $this->_helper->uploadImage($_FILES['file']);
        return $resultJson->setData(
            [
                'success' => $path['success'] ? 200 : 400,
                'path' => $path['result'],
            ]
        );

    }
}