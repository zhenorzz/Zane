<?php
require  '../zane/Autoloader.php';
$loader = new \zane\Autoloader;
$loader->register();
$loader->addNamespace('zane', '../zane');

$tpl = new zane\Template();
$tpl->assign('data','hello world');
$tpl->show('member');