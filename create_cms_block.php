<?php
$content = <<<EOD
Block Content line 1
Block Content line 2
EOD;
$cmsBlock = Mage::getModel('cms/block')->addData(
    array(
        'title' => 'Block Title',
        'identifier' => 'block_identifier',
        'stores' => array(0), // Available in all stores
        'is_active' => '1',
        'content' => $content,
    )
);
$cmsBlock->save();
