<?php
require  '../zane/Autoloader.php';
date_default_timezone_set('PRC');
define('EXT', '.php');
define('DS', DIRECTORY_SEPARATOR);
defined('ZANE_PATH') or define('ZANE_PATH', __DIR__ . DS);
defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . DS);
defined('ROOT_PATH') or define('ROOT_PATH', dirname(realpath(APP_PATH)) . DS);
defined('VENDOR_PATH') or define('VENDOR_PATH', ROOT_PATH . 'vendor' . DS);
defined('RUNTIME_PATH') or define('RUNTIME_PATH', ROOT_PATH . 'runtime' . DS);
defined('CACHE_PATH') or define('CACHE_PATH', RUNTIME_PATH . 'cache' . DS);

$loader = new \zane\Autoloader;
$loader->addNamespace('zane', '../zane');
$loader->register();

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