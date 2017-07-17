<?php
    $customerGroupId = SOME_CUSTOMER_GROUP_ID;
    $table = Mage::getModel('customer/customer')->getResource()
        ->getWriteConnection()
        ->getTable('customer/entity');
    $query = "UPDATE {$table} SET group_id = {$customerGroupId} WHERE group_id != {$customerGroupId}";
    $conn->query($query);
?>
