<?php
class Namespace_Module_Model_Price_Import extends Mage_Core_Model_Abstract
{

    /**
     * DB Connection
     *
     * @var Varien_Db_Adapter_Interface
     */
    protected $_conn;

    /**
     * Table to update
     *
     * @var string
     */
    protected $_groupPriceTable;

    /**
     * Group price config ready to be imported
     *
     * @var array
     */
    protected $_dataToImport = array(
        array(
            'entity_id' => PRODUCT_ID,
            'all_groups' => 0,
            'customer_group_id' => CUSTOMER_GROUP_ID_FOR_GROUP_PRICE,
            'value' => PRICE_FOR_GROUP,
            'website_id' => Mage_Core_Model_App::ADMIN_STORE_ID
        ),
        array(
            'entity_id' => PRODUCT_ID,
            'all_groups' => 0,
            'customer_group_id' => CUSTOMER_GROUP_ID_FOR_GROUP_PRICE,
            'value' => PRICE_FOR_GROUP,
            'website_id' => Mage_Core_Model_App::ADMIN_STORE_ID
        ),
        
        // etc...
    );

    public function __construct()
    {
        $model = Mage::getModel('catalog/product');
        $this->_conn = $model->getCollection()->getConnection();
        $this->_groupPriceTable = $model->getResource()->getTable('catalog/product_attribute_group_price');
    }

    /**
     * Process to prices creation
     *
     * @return Namespace_Module_Model_Price_Import
     */
    public function process()
    {
        $this->_saveToDb();

        return $this;
    }

    /**
     * Save group prices to DB
     *
     * @return Namespace_Module_Model_Price_Import
     */
    protected function _saveToDb()
    {
        $i = 0;
        $savedItems = array();

        foreach ($this->_dataToImport as $item) {
            $i++;

            $savedItems[] = $item;

            // Save to DB every 1000 items
            if ($i % 1000 == 0) {
                $this->_saveItems($savedItems);
                $savedItems = array();
            }
        }

        // Save the remaining items to DB (the one that failed on the modulo check above)
        $this->_saveItems($savedItems);

        return $this;
    }

    /**
     * Save items to DB
     *
     * @param array $savedItems
     * @return Namespace_Module_Model_Price_Import
     */
    protected function _saveItems($savedItems)
    {
        // Insert in 'catalog_product_entity_group_price'
        $this->_conn->insertOnDuplicate($this->_groupPriceTable, $savedItems);

        return $this;
    }
}

?>
