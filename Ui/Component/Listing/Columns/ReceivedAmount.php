<?php
/**
 * Vendor
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Ui\Component\Listing\Columns;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column as Column;
class ReceivedAmount extends Column
{
    /**
     * Column name
     */
    const NAME = 'column.entity_id';
    protected $_customerRepositoryInterface;
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param CustomerRepositoryInterface $customerRepositoryInterface
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        CustomerRepositoryInterface $customerRepositoryInterface,
        array $components = [],
        array $data = []
    )
    {
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }



    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {

            $fieldName = $this->getData('entity_id');
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['entity_id'])) {
                    $entityId = $item['entity_id'];
                    $customer = $this->_customerRepositoryInterface->getById($entityId);
                    //$item[$fieldName] = '<a target="_blank" href="' . $link . '" >' . $customer->getFirstname() . " " . $customer->getLastname() . '</a>';
                    $item['received_amount'] = '$0.0';
                }
            }
        }

        return $dataSource;
    }
}