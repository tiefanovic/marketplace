<?php
namespace AWstreams\Marketplace\Block\Adminhtml\Product;
/**
 * Class Grid
 * @package AWstreams\Marketplace\Block\Adminhtml\StoreLocator
 */
use \Magento\Backend\Block\Widget\Grid\Extended;
use Magento\TestFramework\Event\Magento;

class Grid extends Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_productFactory;

    protected $_customerRepositoryInterface;
    private $_objectManager;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productFactory
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        $this->_productFactory = $productFactory;
        $this->moduleManager = $moduleManager;
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('productsGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_productFactory->create();
        $collection->addAttributeToSelect('*');
        $vendorAttributeId = $this->_objectManager->create('Magento\Eav\Model\Config')
            ->getAttribute(\Magento\Catalog\Model\Product::ENTITY, 'vendor_id')->getAttributeId();
        $collection->getSelect()->join([
            'product_int' => $collection->getTable('catalog_product_entity_int')
        ],

            "product_int.entity_id = e.entity_id AND product_int.attribute_id = $vendorAttributeId ");
        $collection->getSelect()->joinLeft(
            ['customer' => $collection->getTable('customer_entity')],
            "product_int.value = customer.entity_id"
        );
        var_dump($collection->getSelect()->__toString());
        foreach ($collection as $k => $product)
        {
            $vendor_id = $product->getVendorId() ?: 4;
            $customer = $this->_customerRepositoryInterface->getById($vendor_id);

        }
        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
        /**
         *
         * ID
         * Product ID
         * Seller Name
         * Product Name
         * Price
         * Quantity
         * Status
         * Created
         * Modified
         * Preview
         * Deny
         * Store View
         * Product
         * View
         */

        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
                'filter' => false,

            ]
        );

        $this->addColumn(
            'entity_id',
            [
                'header' => __('Product ID'),
                'type' => 'number',
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
                'filter' => false,

            ]
        );
        $this->addColumn(
            'vendor_id',
            [
                'header' => __('Seller Name'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => 'firstname',

                        'url' => [
                            'base' => 'customer/index/edit/*/'
                        ],
                        'field' => 'id'
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'firstname',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );
        $this->addColumn(
            'names',
            [
                'header' => __('Product Name'),
                'index' => 'name',
                'class' => 'xxx',
                'filter' => false,

            ]
        );
        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'type' => 'currency',
                'index' => 'price',
                'filter' => false,

            ]
        );

        $this->addColumn(
            'quantity',
            [
                'header' => __('Quantity'),
                'index' => 'quantity',
                'class' => 'xxx',
                'filter' => false,

            ]
        );
        $this->addColumn(
            'marketplace_status',
            [
                'header' => __('Status'),
                'class' => 'xxx',
                'filter' => false,

            ]
        );
        $this->addColumn(
            'created_at',
            [
                'header' => __('Created'),
                'class' => 'xxx',
                'filter' => false,

            ]
        );
        $this->addColumn(
            'modified_at',
            [
                'header' => __('Modified'),
                'class' => 'xxx',
                'filter' => false,

            ]
        );
        $this->addColumn(
            'thumbnail',
            [
                'header' => __('Preview'),
                'class' => 'xxx',
                'filter' => false,

            ]
        );
        $this->addColumn(
            'created_at',
            [
                'header' => __('Created'),
                'class' => 'xxx',
                'filter' => false,
            ]
        );
        $this->addColumn(
            'view',
            [
                'header' => __('View'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('View'),
                        'url' => [
                            'base' => '*/*/edit'
                        ],
                        'field' => 'entity_id'
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );



        return parent::_prepareColumns();
    }

    /**
     * @return $this
     */
   protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setTemplate('AWstreams_Marketplace::grid/massaction_extended.phtml');
        $this->getMassactionBlock()->setFormFieldName('marketplace');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('marketplace/*/massDelete'),
                'confirm' => __('Are you sure?')
            ]
        );


        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('marketplace/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                    ]
                ]
            ]
        );


        return $this;
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('marketplace/*/grid', ['_current' => true]);
    }

}