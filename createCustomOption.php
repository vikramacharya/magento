<?php
require_once 'app/Mage.php';
Mage::app('default');
$productIds = array(100, 101, 102);
$option = array(
    'title' => 'Test Option',
    'type' => 'file',
    'is_require' => 1,
    'price' => 10,
    'price_type' => 'fixed',
    'sku' => 'testsku',
    'file_extension' => 'png,jpg',
    'image_size_x' => '100',
    'image_size_y' => '200'
);
foreach ($productIds as $productId) {
    $product = Mage::getModel('catalog/product')->load($productId);
    $optionInstance = $product->getOptionInstance()->unsetOptions();
    $product->setHasOptions(1);
    if (isset($option['is_require']) && ($option['is_require'] == 1)) {
        $product->setRequiredOptions(1);
    }
    $optionInstance->addOption($option);
    $optionInstance->setProduct($product);
    $product->save();
}
