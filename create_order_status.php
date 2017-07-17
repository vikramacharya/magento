<?php
// Create new order status
$data = array(
    'status' => 'status_code',
    'label' => 'Default Label'
);
$status = Mage::getModel('sales/order_status');
$status->setData($data)->save();
// Assign to some order state
$status->assignState(Mage_Sales_Model_Order::CONST_KEY_FOR_STATE);
?>
