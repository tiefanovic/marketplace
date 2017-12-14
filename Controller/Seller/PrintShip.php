<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AWstreams\Marketplace\Controller\Seller;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class PrintShip extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magento_Sales::sales_shipment';

    protected $_fileFactory;
    protected $resultForwardFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
                                Context $context,
                                \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
                                \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->_fileFactory = $fileFactory;
        parent::__construct($context);
        $this->resultForwardFactory = $resultForwardFactory;
    }

    /**
     * @return ResponseInterface|void
     */
    public function execute()
    {
        $shipId = $this->getRequest()->getParam('ship_id');
        if ($shipId) {
            $ship = $this->_objectManager->create('Magento\Sales\Api\ShipmentRepositoryInterface')->get($shipId);
            if ($ship) {
                //print_r($ship->getData());die();
                $pdf = $this->_objectManager->create('Magento\Sales\Model\Order\Pdf\Shipment')->getPdf([$ship]);
                $date = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->date('Y-m-d_H-i-s');
                return $this->_fileFactory->create(
                    'shipment' . $date . '.pdf',
                    $pdf->render(),
                    DirectoryList::VAR_DIR,
                    'application/pdf'
                );
            }
        } else {
            return $this->resultForwardFactory->create()->forward('noroute');
        }
    }
}
