<?php
  $string = 'My String';
  $urlKeyString = Mage::getSingleton('catalog/product')->formatUrlKey($string);
  // Returns => my-string
?>
