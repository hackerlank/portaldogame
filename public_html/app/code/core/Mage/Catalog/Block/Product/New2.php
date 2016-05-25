<?php
class Mage_Catalog_Block_Product_New2 extends Mage_Catalog_Block_Product_Abstract
{
    /**
     * Current child categories collection
     * @var Mage_Catalog_Model_Resource_Category_Collection
     */
    protected $_currentChildCategories;
    /**
     * Set cache data
     */
    protected function _construct()
    {
        $this->addData(array('cache_lifetime' => false));
        $this->addCacheTag(array(
            Mage_Catalog_Model_Category::CACHE_TAG,
            Mage_Core_Model_Store_Group::CACHE_TAG
        ));
    }

    /**
     * Retrieve child categories of current category
     * @return Mage_Catalog_Model_Resource_Category_Collection
     */
    public function getCurrentChildCategories()
    {
        if (null === $this->_currentChildCategories) {
            $layer = Mage::getSingleton('catalog/layer');
            $category = $layer->getCurrentCategory();
            $this->_currentChildCategories = $category->getChildrenCategories();
            $productCollection = Mage::getResourceModel('catalog/product_collection');
            $layer->prepareProductCollection($productCollection);
            $productCollection->addCountToCategories($this->_currentChildCategories);
        }
        return $this->_currentChildCategories;
    }
	protected function getProductCollection(){
		$collection = Mage::getResourceModel('catalog/product_collection');
        $collection->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds());
		$collection = $this->_addProductAttributesAndPrices($collection)->addStoreFilter();
		return $collection;
	}
	/**
     * Retrieve url for direct adding product to cart
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $additional
     * @return string
     */
    public function getAddToCartUrl($product, $additional = array())
    {
        if ($this->hasCustomAddToCartUrl()) {
            return $this->getCustomAddToCartUrl();
        }

        if ($this->getRequest()->getParam('wishlist_next')) {
            $additional['wishlist_next'] = 1;
        }

        $addUrlKey = Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED;
        $addUrlValue = Mage::getUrl('*/*/*', array('_use_rewrite' => true, '_current' => true));
        $additional[$addUrlKey] = Mage::helper('core')->urlEncode($addUrlValue);

        return $this->helper('checkout/cart')->getAddUrl($product, $additional);
    }
}