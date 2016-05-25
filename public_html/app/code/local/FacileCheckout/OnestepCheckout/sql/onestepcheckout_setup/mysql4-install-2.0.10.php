<?php

$installer = $this;
/* @var $installer Mage_Eav_Model_Entity_Setup */

$installer->startSetup();
 
 
$installer->addAttribute('customer_address', 'char_name', array(
    'type' => 'varchar',
    'input' => 'text',
    'label' => 'Character Name',
    'global' => 1,
    'visible' => 1,
    'required' => 0,
    'user_defined' => 1,
    'visible_on_front' => 1
));

$installer->addAttribute('customer_address', 'account_name', array(
    'type' => 'varchar',
    'input' => 'text',
    'label' => 'Game Account Login',
    'global' => 1,
    'visible' => 1,
    'required' => 0,
    'user_defined' => 1,
    'visible_on_front' => 1
));

$installer->addAttribute('customer_address', 'account_pwd', array(
    'type' => 'varchar',
    'input' => 'text',
    'label' => 'Game Account Password',
    'global' => 1,
    'visible' => 1,
    'required' => 0,
    'user_defined' => 1,
    'visible_on_front' => 1
));

$installer->addAttribute('customer_address', 'message', array(
    'type' => 'varchar',
    'input' => 'text',
    'label' => 'Message',
    'global' => 1,
    'visible' => 1,
    'required' => 0,
    'user_defined' => 1,
    'visible_on_front' => 1
));

$installer->addAttribute('customer_address', 'contact', array(
    'type' => 'varchar',
    'input' => 'text',
    'label' => 'Contact',
    'global' => 1,
    'visible' => 1,
    'required' => 0,
    'user_defined' => 1,
    'visible_on_front' => 1
));

$installer->addAttribute('customer_address', 'trade_method', array(
    'type' => 'varchar',
    'input' => 'text',
    'label' => 'Trading Method',
    'global' => 1,
    'visible' => 1,
    'required' => 0,
    'user_defined' => 1,
    'visible_on_front' => 1
));

Mage::getSingleton('eav/config')
    ->getAttribute('customer_address', 'account_name')
    ->setData('used_in_forms', array('customer_register_address','customer_address_edit','adminhtml_customer_address'))
    ->save();
	
	Mage::getSingleton('eav/config')
    ->getAttribute('customer_address', 'account_pwd')
    ->setData('used_in_forms', array('customer_register_address','customer_address_edit','adminhtml_customer_address'))
    ->save();
	
		Mage::getSingleton('eav/config')
    ->getAttribute('customer_address', 'message')
    ->setData('used_in_forms', array('customer_register_address','customer_address_edit','adminhtml_customer_address'))
    ->save();
	
		Mage::getSingleton('eav/config')
    ->getAttribute('customer_address', 'trade_method')
    ->setData('used_in_forms', array('customer_register_address','customer_address_edit','adminhtml_customer_address'))
    ->save();
	
		Mage::getSingleton('eav/config')
    ->getAttribute('customer_address', 'contact')
    ->setData('used_in_forms', array('customer_register_address','customer_address_edit','adminhtml_customer_address'))
    ->save();
	
Mage::getSingleton('eav/config')
    ->getAttribute('customer_address', 'char_name')
    ->setData('used_in_forms', array('customer_register_address','customer_address_edit','adminhtml_customer_address'))
    ->save(); 
	
$installer->endSetup();