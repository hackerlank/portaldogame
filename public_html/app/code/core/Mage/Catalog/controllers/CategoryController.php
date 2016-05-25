<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2016 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Category controller
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_Catalog_CategoryController extends Mage_Core_Controller_Front_Action
{
    /**
     * Initialize requested category object
     *
     * @return Mage_Catalog_Model_Category
     */
    protected function _initCatagory()
    {
        Mage::dispatchEvent('catalog_controller_category_init_before', array('controller_action' => $this));
        $categoryId = (int) $this->getRequest()->getParam('id', false);
        if (!$categoryId) {
            return false;
        }

        $category = Mage::getModel('catalog/category')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($categoryId);

        if (!Mage::helper('catalog/category')->canShow($category)) {
            return false;
        }
        Mage::getSingleton('catalog/session')->setLastVisitedCategoryId($category->getId());
        Mage::register('current_category', $category);
        Mage::register('current_entity_key', $category->getPath());

        try {
            Mage::dispatchEvent(
                'catalog_controller_category_init_after',
                array(
                    'category' => $category,
                    'controller_action' => $this
                )
            );
        } catch (Mage_Core_Exception $e) {
            Mage::logException($e);
            return false;
        }

        return $category;
    }

    /**
     * Recursively apply custom design settings to category if it's option
     * custom_use_parent_settings is setted to 1 while parent option is not
     *
     * @deprecated after 1.4.2.0-beta1, functionality moved to Mage_Catalog_Model_Design
     * @param Mage_Catalog_Model_Category $category
     * @param Mage_Core_Model_Layout_Update $update
     *
     * @return Mage_Catalog_CategoryController
     */
    protected function _applyCustomDesignSettings($category, $update)
    {
        if ($category->getCustomUseParentSettings() && $category->getLevel() > 1) {
            $parentCategory = $category->getParentCategory();
            if ($parentCategory && $parentCategory->getId()) {
                return $this->_applyCustomDesignSettings($parentCategory, $update);
            }
        }

        $validityDate = $category->getCustomDesignDate();

        if (array_key_exists('from', $validityDate) &&
            array_key_exists('to', $validityDate) &&
            Mage::app()->getLocale()->isStoreDateInInterval(null, $validityDate['from'], $validityDate['to'])
        ) {
            if ($category->getPageLayout()) {
                $this->getLayout()->helper('page/layout')
                    ->applyHandle($category->getPageLayout());
            }
            $update->addUpdate($category->getCustomLayoutUpdate());
        }

        return $this;
    }

    /**
     * Category view action
     */
    public function viewAction()
    {
        if ($category = $this->_initCatagory()) {
            $design = Mage::getSingleton('catalog/design');
            $settings = $design->getDesignSettings($category);

            // apply custom design
            if ($settings->getCustomDesign()) {
                $design->applyCustomDesign($settings->getCustomDesign());
            }

            Mage::getSingleton('catalog/session')->setLastViewedCategoryId($category->getId());

            $update = $this->getLayout()->getUpdate();
            $update->addHandle('default');

            if (!$category->hasChildren()) {
                $update->addHandle('catalog_category_layered_nochildren');
            }

            $this->addActionLayoutHandles();
            $update->addHandle($category->getLayoutUpdateHandle());
            $update->addHandle('CATEGORY_' . $category->getId());
            $this->loadLayoutUpdates();

            // apply custom layout update once layout is loaded
            if ($layoutUpdates = $settings->getLayoutUpdates()) {
                if (is_array($layoutUpdates)) {
                    foreach($layoutUpdates as $layoutUpdate) {
                        $update->addUpdate($layoutUpdate);
                    }
                }
            }

            $this->generateLayoutXml()->generateLayoutBlocks();
            // apply custom layout (page) template once the blocks are generated
            if ($settings->getPageLayout()) {
                $this->getLayout()->helper('page/layout')->applyTemplate($settings->getPageLayout());
            }

            if ($root = $this->getLayout()->getBlock('root')) {
                $root->addBodyClass('categorypath-' . $category->getUrlPath())
                    ->addBodyClass('category-' . $category->getUrlKey());
            }

            $this->_initLayoutMessages('catalog/session');
            $this->_initLayoutMessages('checkout/session');
            $this->renderLayout();
        }
        elseif (!$this->getResponse()->isRedirect()) {
            $this->_forward('noRoute');
        }
    }
	public function getdataAction()
	{ 
		  $Id = (int) $this->getRequest()->getParam('idd', false);
		  $mydata;
		  $products= Mage::getModel('catalog/category')->load($Id)->getProductCollection();
		  $products->addAttributeToSelect(array('name', 'id', 'price', 'url_key', 'small_image',));
		  $products->addAttributeToFilter('status', 1);
		  $products ->addAttributeToFilter('visibility', 4);
		  foreach ($products as $key=>$product) {
			$mydata.='<option value='.$product->getId().'>'.$product->getName().'</option>';
		  }
		  echo Zend_Json::encode($mydata);
	}
	public function getProductdataAction()
	{ 
		  $Id = (int) $this->getRequest()->getParam('idd', false);
		  $mydata = array();
		  	$_product = Mage::getModel('catalog/product')->load($Id);
			$_options = Mage::helper('core')->decorateArray($_product->getOptions());
			$i=0;
			foreach ( $_options as $_option ) {
				$bl = Mage::getBlockSingleton ( 'catalog/product_view_options');
				$bl->addOptionRenderer ( 'select', 'catalog/product_view_options_type_select2', 'catalog/product/view/options/type/select2.phtml' );
				$mydata[0] .= $bl->getOptionHtml ( $_option );
				$i++;
			}
			$mydata[1] = Mage::helper('checkout/cart')->getAddUrl($_product);
		   	echo Zend_Json::encode($mydata);
	}
	public function getProductpriceAction()
	{ 
		  $_product = Mage::getModel('catalog/product')->load($Id);
		  $_options = Mage::helper('core')->decorateArray($_product->getOptions());
		  
		  echo Zend_Json::encode($mydata);
	}
}
