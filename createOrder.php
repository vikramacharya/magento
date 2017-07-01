 <?php
$productids = array(1, 2, 4, 3);
$websiteId = Mage::app()->getWebsite()->getId();
$store = Mage::app()->getStore();
// Start New Sales Order Quote
$quote = Mage::getModel('sales/quote')->setStoreId($store->getId());
// Set Sales Order Quote Currency
$quote->setCurrency($order->AdjustmentAmount->currencyID);
$customer = Mage::getModel('customer/customer')
        ->setWebsiteId($websiteId)
        ->loadByEmail($email);
if ($customer->getId() == "") {
    $customer = Mage::getModel('customer/customer');
    $customer->setWebsiteId($websiteId)
            ->setStore($store)
            ->setFirstname('Vikram')
            ->setLastname('Acharya')
            ->setEmail($email)
            ->setPassword("password");
    $customer->save();
}

// Assign Customer To Sales Order Quote
$quote->assignCustomer($customer);
// Configure Notification
$quote->setSendCconfirmation(1);
foreach ($productids as $id)
{
    $product = Mage::getModel('catalog/product')->load($id);
    $quote->addProduct($product, new Varien_Object(array('qty' => 1)));
}
// Set Sales Order Billing Address
$billingAddress = $quote->getBillingAddress()->addData(array(
    'customer_address_id' => '',
    'prefix' => '',
    'firstname' => 'Vikram',
    'middlename' => '',
    'lastname' => 'Acharya',
    'suffix' => '',
    'company' => '',
    'street' => array(
        '0' => 'Flatno',
        '1' => 'East'
    ),
    'city' => 'Mumbai',
    'country_id' => 'IN',
    'region' => 'MH',
    'postcode' => '400001',
    'telephone' => '9999999999',
    'fax' => 'gghlhu',
    'vat_id' => '',
    'save_in_address_book' => 1
        ));
// Set Sales Order Shipping Address
$shippingAddress = $quote->getShippingAddress()->addData(array(
    'customer_address_id' => '',
    'prefix' => '',
    'firstname' => 'Vikram',
    'middlename' => '',
    'lastname' => 'Acharya',
    'suffix' => '',
    'company' => '',
    'street' => array(
        '0' => 'Flatno',
        '1' => 'East'
    ),
    'city' => 'Mumbai',
    'country_id' => 'IN',
    'region' => 'MH',
    'postcode' => '400001',
    'telephone' => '9999999999',
    'fax' => 'gghlhu',
    'vat_id' => '',
    'save_in_address_book' => 1
        ));
if ($shipprice == 0) {
    $shipmethod = 'freeshipping_freeshipping';
}

// Collect Rates and Set Shipping & Payment Method
$shippingAddress->setCollectShippingRates(true)
        ->collectShippingRates()
        ->setShippingMethod('flatrate_flatrate')
        ->setPaymentMethod('checkmo');

// Set Sales Order Payment
$quote->getPayment()->importData(array('method' => 'checkmo'));

// Collect Totals & Save Quote
$quote->collectTotals()->save();

try {
    // Create Order From Quote
    $service = Mage::getModel('sales/service_quote', $quote);
    $service->submitAll();
    $increment_id = $service->getOrder()->getRealOrderId();
}
catch (Exception $ex) {
    echo $ex->getMessage();
}
catch (Mage_Core_Exception $e) {
    echo $e->getMessage();
}

// Resource Clean-Up
$quote = $customer = $service = null;

// Finished
return $increment_id;
?>