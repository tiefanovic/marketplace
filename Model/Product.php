<?php

namespace AWstreams\Marketplace\Model;

use AWstreams\Marketplace\Setup\InstallData;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Pricing\SaleableInterface;
use AWstreams\Marketplace\Api\Data\VendorProductInterface;

class Product extends \Magento\Catalog\Model\Product implements
    IdentityInterface,
    SaleableInterface,
    ProductInterface,
    VendorProductInterface
{

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Api\ProductAttributeRepositoryInterface $metadataService,
        \Magento\Catalog\Model\Product\Url $url,
        \Magento\Catalog\Model\Product\Link $productLink,
        \Magento\Catalog\Model\Product\Configuration\Item\OptionFactory $itemOptionFactory,
        \Magento\CatalogInventory\Api\Data\StockItemInterfaceFactory $stockItemFactory,
        \Magento\Catalog\Model\Product\Option $catalogProductOption,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\Catalog\Model\Product\Attribute\Source\Status $catalogProductStatus,
        \Magento\Catalog\Model\Product\Media\Config $catalogProductMediaConfig,
        \Magento\Catalog\Model\Product\Type $catalogProductType,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Catalog\Helper\Product $catalogProduct,
        \Magento\Catalog\Model\ResourceModel\Product $resource,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $resourceCollection,
        \Magento\Framework\Data\CollectionFactory $collectionFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Indexer\Model\IndexerRegistry $indexerRegistry,
        \Magento\Catalog\Model\Indexer\Product\Flat\Processor $productFlatIndexerProcessor,
        \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor,
        \Magento\Catalog\Model\Indexer\Product\Eav\Processor $productEavIndexerProcessor,
        CategoryRepositoryInterface $categoryRepository,
        \Magento\Catalog\Model\Product\Image\CacheFactory $imageCacheFactory,
        \Magento\Catalog\Model\ProductLink\CollectionProvider $entityCollectionProvider,
        \Magento\Catalog\Model\Product\LinkTypeProvider $linkTypeProvider,
        \Magento\Catalog\Api\Data\ProductLinkInterfaceFactory $productLinkFactory,
        \Magento\Catalog\Api\Data\ProductLinkExtensionFactory $productLinkExtensionFactory,
        \Magento\Catalog\Api\Data\ProductAttributeMediaGalleryEntryInterfaceFactory $mediaGalleryEntryFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $joinProcessor,
        array $data = []
    )
    {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $storeManager,
            $metadataService,
            $url,
            $productLink,
            $itemOptionFactory,
            $stockItemFactory,
            $catalogProductOption,
            $catalogProductVisibility,
            $catalogProductStatus,
            $catalogProductMediaConfig,
            $catalogProductType,
            $moduleManager,
            $catalogProduct,
            $resource,
            $resourceCollection,
            $collectionFactory,
            $filesystem,
            $indexerRegistry,
            $productFlatIndexerProcessor,
            $productPriceIndexerProcessor,
            $productEavIndexerProcessor,
            $categoryRepository,
            $imageCacheFactory,
            $entityCollectionProvider,
            $linkTypeProvider,
            $productLinkFactory,
            $productLinkExtensionFactory,
            $mediaGalleryEntryFactory,
            $dataObjectHelper,
            $joinProcessor
        );
    }


    public function getVendorId()
    {
        return $this->getData(InstallData::VENDOR_ID);
    }


    public function setVendorId($vendorId)
    {
        return $this->setData(InstallData::VENDOR_ID, $vendorId);
    }

    protected function _construct()
    {
        $this->_init('AWstreams\Marketplace\Model\ResourceModel\Product');
    }
}