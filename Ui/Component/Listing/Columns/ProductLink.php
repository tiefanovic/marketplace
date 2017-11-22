<?php
/**
 * Vendor
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Ui\Component\Listing\Columns;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class ProductLink extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Column name
     */
    const NAME = 'column.entity_id';
    protected $_productCollection;
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
        ProductRepositoryInterface $productRepository,
        \Magento\Framework\Url $urlBuilder,
        array $components = [],
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->_productCollection = $productRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function getFrontendUrl($routePath, $routeParams)
    {
        return $this->urlBuilder->getUrl($routePath, $routeParams);
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

            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['entity_id'])) {
                    $product = $this->_productCollection->getById($item['entity_id']);
                    $link = $this->getFrontendUrl(
                        'catalog/product/view',
                        ['id' => $item['entity_id']]);

                    $item[$fieldName] = '<a target="_blank" href="' . $link . '" >' . $product->getName() . '</a>';
                }
            }
        }

        return $dataSource;
    }
    
}