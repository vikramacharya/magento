<?php
//Initialize Mage Object
require_once 'app/Mage.php';
Mage::app();

//Code to create coupon
$couponCode='COUPONCODE'; //couponcode

$rule = Mage::getModel('salesrule/rule'); //initialize salesrule
$customer_groups = array(0,1); // Add customer group here

$rule->setName('Name of coupon')
      ->setDescription('description of coupon')
      ->setFromDate('2017-07-01')
      ->setToDate('2017-12-12')
      ->setCouponType(2) //type of coupon
      ->setCouponCode($couponCode)
      ->setUsesPerCustomer(1) 
      ->setUsesPerCoupon(100)
      ->setCustomerGroupIds($customer_groups) 
      ->setIsActive(1)
      ->setConditionsSerialized('')
      ->setActionsSerialized('')
      ->setStopRulesProcessing(0)
      ->setIsAdvanced(1)
      ->setSortOrder(0)
      ->setSimpleAction('cart_fixed') //fixed amount discount on whole cart
      ->setDiscountAmount('100') //discount amount
      ->setDiscountQty(null)
      ->setDiscountStep(0)
      ->setSimpleFreeShipping('0')
      ->setApplyToShipping('0')
      ->setIsRss(0)
      ->setWebsiteIds(array(1));
$rule->save();
