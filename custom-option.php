<?php
require_once 'app/Mage.php';
umask(0);

Mage::app('admin');

// If your database is having lots of data then use set_time_limit / ini_set
//set_time_limit(0);
//ini_set('memory_limit','1024M');

$option1 = array(
    'title' => 'Customization',
    'type' => 'checkbox', // could be drop_down ,checkbox , multiple
    'is_require' => 0,
    'sort_order' => 0,
    'values' => getOption1()
    );


$option2 = array(
    'title' => 'Customization Details',
    'type' => 'radio', // could be drop_down ,checkbox , multiple
    'is_require' => 1,
    'sort_order' => 0,
    'values' => getOption2()
    );

$sku ="";

$product_id = Mage::getModel('catalog/product')->getIdBySku($sku);
 $product = Mage::getModel('catalog/product')->load($product_id);
        $product->setProductOptions(array($option));
        $product->setCanSaveCustomOptions(true);
        //Do not forget to save the product
        $product->save();
        echo "Done";
/*
$collection = Mage::getModel('catalog/product')->getCollection();

foreach ($collection as $product_all) {

        $sku = $product_all['sku'];
        // retrieve product id using sku
        $product_id = Mage::getModel('catalog/product')->getIdBySku($sku);

        //In Case of creating a new product.
        //$product = Mage::getModel('catalog/product');
        //$product->setProductOptions(array($option));
        //$product->setCanSaveCustomOptions(true);

        //Or if we are adding the options to a already created product.
        $product = Mage::getModel('catalog/product')->load($product_id);
        $product->setProductOptions(array($option));
        $product->setCanSaveCustomOptions(true);

        //Do not forget to save the product
        $product->save();
        echo "Done";
}  */

function getOption2(){
   return array(
   array(
        'title' => 'Customization Text',
        'price' =>0,
        'price_type' => 'fixed',
        'sku' => '',
        'sort_order' => '1'
    ),
    array(
        'title' => 'Customization Detail',
        'price' =>0,
        'price_type' => 'fixed',
        'sku' => '',
        'sort_order' => '1'
    );
}

function getOption1(){
   return array(
    array(
        'title' => 'Need Customization',
        'price' =>500,
        'price_type' => 'fixed',
        'sku' => '',
        'sort_order' => '1'
    );
}
