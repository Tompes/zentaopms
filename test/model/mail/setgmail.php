#!/usr/bin/env php
<?php
include dirname(dirname(dirname(__FILE__))) . '/lib/init.php';
include dirname(dirname(dirname(__FILE__))) . '/class/mail.class.php';
su('admin');

/**

title=测试 mailModel->setGMail();
cid=1
pid=1

*/

$mail = new mailTest();

r($mail->setGMailTest()) && p() && e();
