<?php

namespace AWstreams\Marketplace\Setup;

use AWstreams\Marketplace\Model\Attributes\Backend\Product\Source\Status;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


class InstallData implements InstallDataInterface
{
    /**
     * Customer Attributes
     * shop_url|string, is_vendor|boolean, approved_account|boolean, premium_user|boolean
     * commission|int
     * Products Attributes
     * vendor_id
     */
    /*
     *  attribute to identify a customer shop url
     */
    const SHOP_URL = 'shop_url';
    /*
     *  attribute to identify a customer is vendor or not
     */
    const IS_VENDOR = 'is_vendor';

    /**
     * attribute to identify vendor account is approved or not
     */
    const APPROVED_ACCOUNT = 'approved_account';
    /*
     * attribute to check if seller is premium or not
     * boolean
     */
    const PREMIUM_SELLER = 'is_premium';

    /*
     * Commission for each user
     */
    const COMMISTION = 'commission';

    /*
     * Vendor UID of products
     */
    const VENDOR_ID = 'vendor_id';

    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * @param EavSetupFactory $eavSetupFactory
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }


    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /**
         *  Product attributes
         */

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

     
        /**
         *  Create Vendor Id attribute
         */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            self::VENDOR_ID,
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Vendor Id',
                'input' => '',
                'class' => '',
                'source' => '',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => false,
                'unique' => false,
                'apply_to' => ''
            ]
        );
        /**
         * Create Is Approved Attribute for Products
         */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            self::APPROVED_ACCOUNT,
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Is Approved ?',
                'input' => 'select',
                'class' => '',
                'source' => '\AWstreams\Marketplace\Model\Attributes\Backend\Product\Source\Status',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => Status::STATUS_DISAPPROVED,
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => false,
                'unique' => false,
                'apply_to' => ''
            ]
        );

        /**
         * Create Product purchase limit for product
         */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'product_purchase_limit',
            [
                'type' => 'int',
                'backend' => '\AWstreams\Marketplace\Model\Attributes\Backend\PurchaseLimit',
                'label' => ' Product Purchase Limit for Customer',
                'input' => 'text',
                'class' => '',
                'source' => '',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => ''
            ]
        );
        /**
         *  Customer attributes
         */
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        /** @var $attributeSet AttributeSet */
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        /**
         * Create customer attribute : shop_url
         */
        $customerSetup->addAttribute(Customer::ENTITY, self::SHOP_URL,
            [
                'type' => 'varchar',
                'label' => 'shop_url',
                'input' => 'text',
                'required' => false,
                'default' => '',
                'visible' => true,
                'user_defined' => true,
                'sort_order' => 100,
                'position' => 100,
                'system' => false,
            ]);
        $shop_url = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, self::SHOP_URL)
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer','checkout_register','customer_account_create','customer_account_edit','adminhtml_checkout'],
            ]);

        $shop_url->save();
        /**
         *  create customer attribute is_vendor
         */
        $customerSetup->addAttribute(Customer::ENTITY, self::IS_VENDOR,
            [
                'type' => 'int',
                'label' => 'Is Vendor?',
                'input' => 'select',
                "source" => "AWstreams\Marketplace\Model\Source\CustomerYesNoOptions",
                'required' => false,
                'default' => '0',
                'visible' => true,
                'user_defined' => true,
                'sort_order' => 210,
                'position' => 210,
                'system' => false,
            ]);
        $is_vendor = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, self::IS_VENDOR)
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer','checkout_register','customer_account_create','customer_account_edit','adminhtml_checkout'],
            ]);

        $is_vendor->save();

        /**
         * Create customer attribute account_approve
         */
        $customerSetup->addAttribute(Customer::ENTITY, self::APPROVE_ACCOUNT,
            [
                'type' => 'int',
                'label' => 'Approve Account',
                'input' => 'select',
                "source" => "AWstreams\Marketplace\Model\Source\CustomerYesNoOptions",
                'required' => false,
                'default' => '0',
                'visible' => true,
                'user_defined' => true,
                'sort_order' => 215,
                'position' => 215,
                'system' => false,
            ]);
        $approve_account = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, self::APPROVE_ACCOUNT)
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer','customer_account_create','customer_account_edit'],
            ]);
        $approve_account->save();


        $setup->endSetup();
    }
}
