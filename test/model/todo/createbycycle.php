#!/usr/bin/env php
<?php
include dirname(dirname(dirname(__FILE__))) . '/lib/init.php';
include dirname(dirname(dirname(__FILE__))) . '/class/todo.class.php';
su('admin');

/**

title=测试 todoModel->createByCycle();
cid=1
pid=1

测试创建周期日待办 >> 11
测试创建周期周待办 >> 9
测试创建周期月待办 >> 70

*/

$todo1 = new stdclass();
$todo1->name               = 'cycle生成的待办1';
$todo1->config             = '{"specify":{"month":"0","day":"1"},"day":"1","type":"day","beforeDays":11,"end":"","begin":"2022-03-23"}';

$todo2 = new stdclass();
$todo2->name               = 'cycle生成的待办2';
$todo2->config             = '{"specify":{"month":"0","day":"1"},"week":"2,4,7","type":"week","beforeDays":31,"end":"","begin":"2022-03-23"}';

$todo3 = new stdclass();
$todo3->name               = 'cycle生成的待办3';
$todo3->config             = '{"specify":{"month":"0","day":"1"},"month":"1,8,13,15,27,29,30","type":"month","beforeDays":301,"end":"","begin":"2022-03-23"}';

$todo = new todoTest();

r($todo->createByCycleTest($todo1)) && p() && e('11'); // 测试创建周期日待办
r($todo->createByCycleTest($todo2)) && p() && e('9');  // 测试创建周期周待办
r($todo->createByCycleTest($todo3)) && p() && e('70'); // 测试创建周期月待办
system("./ztest init");
