<?php
require  '../zane/Autoloader.php';
$loader = new \zane\Autoloader;
$loader->register();
$loader->addNamespace('zane', '../zane');

$whoops = new \Whoops\Run;
$PrettyPageHandler = new \Whoops\Handler\PrettyPageHandler();
// $PrettyPageHandler->setPageTitle('nihao');
$whoops->pushHandler($PrettyPageHandler);
$whoops->register();


$tpl = new zane\Template();
$tpl->assign('data','hello world');
$tpl->assign('person','zane');
$tpl->assign('pai','3.14');
$tpl->assign('b',[1,2,3,4,'gg','sb']);
$tpl->show('member');