#!/usr/bin/env php
<?php
include dirname(dirname(dirname(__FILE__))) . '/lib/init.php';
include dirname(dirname(dirname(__FILE__))) . '/class/product.class.php';

/**

title=productModel->getOrderedProducts();
cid=1
pid=1

*/

$statusList  = array('all', 'noclosed', 'closed');

$product = new productTest('admin');

r($product->getOrderedProductsTest($statusList[0])) && p() && e('100'); // 测试获取状态为all的产品数量
r($product->getOrderedProductsTest($statusList[1])) && p() && e('60');  // 测试获取状态为noclosed的产品数量
r($product->getOrderedProductsTest($statusList[2])) && p() && e('40');  // 测试获取状态为closed的产品数量
