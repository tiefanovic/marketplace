<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 12/12/17
 * Time: 5:13 PM
 */

namespace AWstreams\Marketplace\Model\ResourceModel;

use AWstreams\Marketplace\Setup\InstallData;
use Magento\Catalog\Model\ResourceModel\Product as MasterProduct;

/**
 * Class Product
 * @package AWstreams\Marketplace\Model\ResourceModel
 */
class Product extends MasterProduct
{
    /**
     * Product constructor.
     * @param \Magento\Eav\Model\Entity\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Model\Factory $modelFactory
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     * @param \Magento\Catalog\Model\ResourceModel\Category $catalogCategory
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Eav\Model\Entity\Attribute\SetFactory $setFactory
     * @param \Magento\Eav\Model\Entity\TypeFactory $typeFactory
     * @param \Magento\Catalog\Model\Product\Attribute\DefaultAttributes $defaultAttributes
     * @param array $data
     */
    public function __construct(
        \Magento\Eav\Model\Entity\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\Factory $modelFactory,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Category $catalogCategory,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Eav\Model\Entity\Attribute\SetFactory $setFactory,
        \Magento\Eav\Model\Entity\TypeFactory $typeFactory,
        \Magento\Catalog\Model\Product\Attribute\DefaultAttributes $defaultAttributes,
        $data = []
    ) {
        parent::__construct(
            $context,
            $storeManager,
            $modelFactory,
            $categoryCollectionFactory,
            $catalogCategory,
            $eventManager,
            $setFactory,
            $typeFactory,
            $defaultAttributes
        );
    }


    /**
     * @return array|string[]
     */
    protected function _getDefaultAttributes()
    {
        return ['entity_id', 'attribute_set_id', 'type_id', 'created_at', 'updated_at', InstallData::VENDOR_ID];
    }
}