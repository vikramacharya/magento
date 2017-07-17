<?php
// 1. Observe the following event: controller_action_predispatch_wishlist_index_add which calls, for example, the `forceReferer()` method

// 2. In your observer class, implement the `forceReferer()` method
/**
 * When adding a product to wishlist,
 * force redirection to wishlist page after customer login
 *
 */
public function forceReferer(Varien_Event_Observer $observer)
{
    Mage::getSingleton('customer/session')->setNoReferer(false);
}
?>
