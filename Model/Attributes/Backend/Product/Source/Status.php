<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AWstreams\Marketplace\Model\Attributes\Backend\Product\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Eav\Model\Entity\Attribute\Source\SourceInterface;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Product status functionality model
 *
 * @api
 * @since 100.0.2
 */
class Status extends AbstractSource implements SourceInterface, OptionSourceInterface
{
    /**#@+
     * Product Approval values
     */
    const STATUS_APPROVED = 1;

    const STATUS_DISAPPROVED = 2;

    const STATUS_PENDING = 3;

    /**#@-*/

    /**
     * Retrieve Approved Ids
     *
     * @return int[]
     */
    public function getApprovedIds()
    {
        return [self::STATUS_APPROVED];
    }

    public function getPendingApprovalIds()
    {
        return [self::STATUS_PENDING];
    }

    /**
     * Retrieve option array
     *
     * @return string[]
     */
    public static function getOptionArray()
    {
        return [self::STATUS_APPROVED => __('Approved'), self::STATUS_DISAPPROVED => __('Disapproved'), self::STATUS_PENDING => __('Pending Approval')];
    }

    /**
     * Retrieve option array with empty value
     *
     * @return string[]
     */
    public function getAllOptions()
    {
        $result = [];

        foreach (self::getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }

    /**
     * Retrieve option text by option value
     *
     * @param string $optionId
     * @return string
     */
    public function getOptionText($optionId)
    {
        $options = self::getOptionArray();

        return isset($options[$optionId]) ? $options[$optionId] : null;
    }

    /**
     * Add Value Sort To Collection Select
     *
     * @param \Magento\Eav\Model\Entity\Collection\AbstractCollection $collection
     * @param string $dir direction
     * @return AbstractSource
     */
    public function addValueSortToCollection($collection, $dir = 'asc')
    {
        $attributeCode = $this->getAttribute()->getAttributeCode();
        $attributeId = $this->getAttribute()->getId();
        $attributeTable = $this->getAttribute()->getBackend()->getTable();
        $linkField = $this->getAttribute()->getEntity()->getLinkField();

        if ($this->getAttribute()->isScopeGlobal()) {
            $tableName = $attributeCode . '_t';

            $collection->getSelect()->joinLeft(
                [$tableName => $attributeTable],
                "e.{$linkField}={$tableName}.{$linkField}" .
                " AND {$tableName}.attribute_id='{$attributeId}'" .
                " AND {$tableName}.store_id='0'",
                []
            );

            $valueExpr = $tableName . '.value';
        } else {
            $valueTable1 = $attributeCode . '_t1';
            $valueTable2 = $attributeCode . '_t2';

            $collection->getSelect()->joinLeft(
                [$valueTable1 => $attributeTable],
                "e.{$linkField}={$valueTable1}.{$linkField}" .
                " AND {$valueTable1}.attribute_id='{$attributeId}'" .
                " AND {$valueTable1}.store_id='0'",
                []
            )->joinLeft(
                [$valueTable2 => $attributeTable],
                "e.{$linkField}={$valueTable2}.{$linkField}" .
                " AND {$valueTable2}.attribute_id='{$attributeId}'" .
                " AND {$valueTable2}.store_id='{$collection->getStoreId()}'",
                []
            );

            $valueExpr = $collection->getConnection()->getCheckSql(
                $valueTable2 . '.value_id > 0',
                $valueTable2 . '.value',
                $valueTable1 . '.value'
            );
        }

        $collection->getSelect()->order($valueExpr . ' ' . $dir);

        return $this;
    }
}
