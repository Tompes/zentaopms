#!/usr/bin/env php
<?php
include dirname(dirname(dirname(__FILE__))) . '/lib/init.php';
include dirname(dirname(dirname(__FILE__))) . '/class/block.class.php';
su('admin');

/**

title=测试 blockModel->getStatisticParams();
cid=1
pid=1



*/

$block = new blockTest();

r($block->getStatisticParamsTest()) && p() && e();