<?php
class My_Module_Model_Observer {
	/**
	 * Update admin menu with dynamic items
	 */
	public function updateAdminMenu()
	{
		$menu = Mage::getSingleton('admin/config')->getAdminhtmlConfig()->getNode('menu/MAIN_MENU_ITEM/children/MENU_ITEMS_CONTAINER/children');
    		// Repeat numbered steps below as many times as you want to add items to the admin menu
    		// 1. Create $xml which is a valid admin menu item definition
		$xml = '<dynamic_item><title>Dynamic Item</title><sort_order>10</sort_order><action>adminhtml/some/route</action></dynamic_item>';
    		// 2. Make a config node with $xml content
		$node = new Mage_Core_Model_Config_Element($xml);
		
		// 3. Append $node to existing loaded menu node
		$menu->appendChild($node);
	}
}