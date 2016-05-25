<?php
class FacileCheckout_OnestepCheckout_Model_Service_Quote extends Mage_Sales_Model_Service_Quote
{
    protected function _validate()
    {
        $helper = Mage::helper('sales');
        if (!$this->getQuote()->isVirtual())
        {
            $address = $this->getQuote()->getShippingAddress();
            
			$address->setShippingMethod('flatrate_flatrate');
			$this->getQuote()->setShippingAddress($address);
            $ship_method = $address->getShippingMethod();
            $rate = $address->getShippingRateByCode($ship_method);
            if (!$this->getQuote()->isVirtual() && (!$ship_method))
                Mage::throwException($helper->__('Please specify a shipping method.'));
        }
		
        if (!($this->getQuote()->getPayment()->getMethod()))
			Mage::throwException($helper->__('Please select a valid payment method.'));

        return $this;
    }
}
