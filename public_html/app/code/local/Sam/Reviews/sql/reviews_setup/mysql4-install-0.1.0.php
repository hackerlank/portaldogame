<?php

$installer = $this;

$installer->startSetup();

Mage::getConfig()->saveConfig('reviewssection/settings/enabled', '0');
Mage::getConfig()->saveConfig('reviewssection/settings/recent_reviews', '1');
Mage::getConfig()->saveConfig('reviewssection/settings/view_type', 'list');
Mage::getConfig()->saveConfig('reviewssection/settings/total_recent_reviews', '5');
//Mage::getConfig()->saveConfig('reviewssection/settings/review_per_page_default', '10');
Mage::getConfig()->saveConfig('reviewssection/settings/review_per_page_allowed', '5,10,15,20');
$installer->endSetup(); 

