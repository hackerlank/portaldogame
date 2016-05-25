<?php

class Sam_Reviews_Model_Sidebar
{
    public function toOptionArray()
    {
        return array(
      		array('value' => '1', 'label' =>'Left'),
      		array('value' => '0', 'label' => 'Right'),
     		// and so on...
    	);
    }
}