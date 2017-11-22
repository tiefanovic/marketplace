<?php
/**
 * Tabs
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Block\Adminhtml\Customer\Edit;
use Magento\Customer\Controller\RegistryConstants;
use Magento\Ui\Component\Layout\Tabs\TabInterface;
use Magento\Backend\Block\Widget\Form;
use Magento\Backend\Block\Widget\Form\Generic;
/**
 * Customer account form block
 */
class Tabs extends Generic implements TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    protected $_yesno;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Config\Model\Config\Source\Yesno $yesno,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_systemStore = $systemStore;
        $this->_yesno = $yesno;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->_coreRegistry->registry(RegistryConstants::CURRENT_CUSTOMER_ID);
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Do You Want To Make This Customer As Seller ?');
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Do You Want To Make This Customer As Seller ?');
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Tab class getter
     *
     * @return string
     */
    public function getTabClass()
    {
        return '';
    }

    /**
     * Return URL link to Tab content
     *
     * @return string
     */
    public function getTabUrl()
    {
        return '';
    }

    /**
     * Tab should be loaded trough Ajax call
     *
     * @return bool
     */
    public function isAjaxLoaded()
    {
        return false;
    }
    public function initForm()
    {

        if (!$this->canShowTab()) {
            return $this;
        }
        /**@var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('myform_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Do You Want To Make This Customer As Seller ?')]);

        $fieldset->addField(
            'shop_url',
            'text',
            [
                'name' => 'shop_url',
                'data-form-part' => $this->getData('target_form'),
                'label' => __('Shop Url'),
                'title' => __('Shop Url'),
                'value' => '',
            ]
        );
        $fieldset->addField(
            'is_vendor',
            'select',
            [
                'name' => 'is_vendor',
                'data-form-part' => $this->getData('target_form'),
                'label' => __('Is Vendor ?'),
                'title' => __('Is Vendor ?'),
                'values' =>  $this->_yesno->toOptionArray(),
                'value' => 1,
            ]
        );
        $fieldset->addField(
            'approve_account',
            'select',
            [
                'name' => 'approve_account',
                'data-form-part' => $this->getData('target_form'),
                'label' => __('Approved Account ?'),
                'title' => __('Approved Account ?'),
                'values' =>  $this->_yesno->toOptionArray(),
                'value' => 1
            ]
        );
        $this->setForm($form);
        return $this;
    }
    /**
     * @return string
     */
    protected function _toHtml()
    {
        if ($this->canShowTab()) {
            $this->initForm();
            return parent::_toHtml();
        } else {
            return '';
        }
    }
    /**
     * Prepare the layout.
     *
     * @return $this
     */
// You can call other Block also by using this function if you want to add phtml file.
    public function getFormHtml()
    {
        $html = parent::getFormHtml();
        return $html;
    }
}