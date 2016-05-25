<?php
/**
 * MagenMarket.com
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Edit or modify this file with yourown risk.
 *
 * @category    Extensions
 * @package     Ma2_WidgetTabsF
 * @copyright   Copyright (c) 2013 MagenMarket. (http://www.magenmarket.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
**/
/* $Id: Widgettabs.php 8 2013-11-05 07:29:49Z linhnt $ */

class Ma2_WidgetTabsF_Block_Widgettabs extends Mage_Catalog_Block_Product_Abstract implements Mage_Widget_Block_Interface
{
	/**
     * A model to serialize attributes
     * @var Varien_Object
     */
    protected $_serializer = null;
    /**
     * Initialization
     */
    protected function _construct()
    {
        $this->_serializer = new Varien_Object();
        parent::_construct();    
    }
	/**
	 *	Assign variables
	 **/
    protected function _toHtml()
    {
        $this->assign('tabsData',json_decode($this->getData('tab_item'),true));
        return parent::_toHtml();
    } 
}