#!/usr/bin/env php
<?php
include dirname(dirname(dirname(__FILE__))) . '/lib/init.php';
include dirname(dirname(dirname(__FILE__))) . '/class/tutorial.class.php';
su('admin');

/**

title=测试 tutorialModel->getProductStats();
cid=1
pid=1

*/

$tutorial = new tutorialTest();

r($tutorial->getProductStatsTest()) && p('1:code')        && e('test');        //测试是否能拿到数据
r($tutorial->getProductStatsTest()) && p('1[branches]:1') && e('Test branch'); //测试是否能拿到数据
