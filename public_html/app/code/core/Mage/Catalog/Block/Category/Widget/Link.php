<?php
class Mage_Catalog_Block_Category_Widget_Link
    extends Mage_Catalog_Block_Widget_Link
{
    protected function _construct()
    {
        parent::_construct();
        $this->_entityResource = Mage::getResourceSingleton('catalog/category');
    }
}
