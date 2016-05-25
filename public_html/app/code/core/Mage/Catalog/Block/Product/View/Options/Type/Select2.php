<?php
class Mage_Catalog_Block_Product_View_Options_Type_Select2
    extends Mage_Catalog_Block_Product_View_Options_Abstract
{
    /**
     * Return html for control element
     *
     * @return string
     */
    public function getValuesHtml()
    {
        $_option = $this->getOption();
        $configValue = $this->getProduct()->getPreconfiguredValues()->getData('options/' . $_option->getId());
        $store = $this->getProduct()->getStore();
       // if ($_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN) {
            $require = ($_option->getIsRequire()) ? ' required-entry' : '';
            $extraParams = '';
            $select = $this->getLayout()->createBlock('core/html_select')->setData(array(
                    'id' => 'select_'.$_option->getId(),
                    'class' => $require.' product-custom-option'
                ));
            $select->setName('options['.$_option->getid().']')->addOption('', $this->__('-- Please Select --'));
            foreach ($_option->getValues() as $_value) {
                $priceStr = $this->_formatPrice(array(
                    'is_percent'    => ($_value->getPriceType() == 'percent'),
                    'pricing_value' => $_value->getPrice(($_value->getPriceType() == 'percent'))
                ), false);
                $select->addOption(
                    $_value->getOptionTypeId(),
                    $_value->getTitle() . ' ' . $priceStr . '',
                    array('price' => $this->helper('core')->currencyByStore($_value->getPrice(true), $store, false))
                );
            }
            if (!$this->getSkipJsReloadPrice()) {
                $extraParams .= 'onchange="reloadPrice()"';
            }
            $select->setExtraParams($extraParams);
            if ($configValue) {
                $select->setValue($configValue);
            }
            return $select->getHtml();
    }

}
