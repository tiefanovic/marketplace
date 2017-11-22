<?php
/**
 * Vendor
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class Vendor extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Column name
     */
    const NAME = 'column.vendor_id';
    protected $_customerRepositoryInterface;
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\Locale\CurrencyInterface $localeCurrency
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
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

            $fieldName = $this->getData('vendor_id');
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['vendor_id'])) {
                    $vendorId = $item['vendor_id'];
                    $customer = $this->_customerRepositoryInterface->getById($vendorId);
                    $html = '';
                    $link = $this->urlBuilder->getUrl(
                        'customer/index/edit',
                        ['id' => $vendorId]);

                    $item[$fieldName] = '<a target="_blank" href="' . $link . '" >' . $customer->getFirstname() . " " . $customer->getLastname() . '</a>';
                }
                elseif (isset($item['entity_id']) && !isset($item['vendor_id']))
                {
                    $vendorId = $item['entity_id'];
                    $customer = $this->_customerRepositoryInterface->getById($vendorId);
                    $link = $this->urlBuilder->getUrl(
                        'customer/index/edit',
                        ['id' => $vendorId]);

                    $item[$fieldName] = '<a target="_blank" href="' . $link . '" >' . $customer->getFirstname() . " " . $customer->getLastname() . '</a>';

                }
            }
        }

        return $dataSource;
    }
}