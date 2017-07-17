<?php
    /**
     * Has shipping been applied to quote?
     *
     * @var bool
     */
    protected $_hasShipping = false;
    /**
     * Set shipping method and rate if they do not exist yet
     */
    public function setQuoteShippingMethod()
    {
        if(!$this->_hasShipping) {
            $this->_hasShipping = true; // This is to avoid loops on totals collecting
            $quote = Mage::helper('checkout/cart')->getQuote();
            if (!$quote->getId()) return;
            $shippingMethod = $quote->getShippingAddress()->getShippingMethod();
            if ($shippingMethod) return;
            $shippingAddress = $quote->getShippingAddress();
            $country = 'FR'; // Some country code
            $postcode = '75000'; // Some postcode
            $regionId = '0'; // Some region id
            $method = 'tablerate_bestway'; // Used shipping method
            $shippingAddress
                ->setCountryId($country)
                ->setRegionId($regionId)
                ->setPostcode($postcode)
                ->setShippingMethod($method)
                ->setCollectShippingRates(true)
            ;
            $shippingAddress->save();
            $quote->save();
        }
    }