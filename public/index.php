<?php
require  '../zane/Autoloader.php';
$loader = new \zane\Autoloader;
$loader->register();
$loader->addNamespace('zane', '../zane');

$tpl = new zane\Template();
var_dump($tpl->getConfig());