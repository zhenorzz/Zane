<?php
require  '../zane/Autoloader.php';
date_default_timezone_set('PRC');
define('EXT', '.php');
define('DS', DIRECTORY_SEPARATOR);
defined('APP_PATH') or define('APP_PATH', __DIR__ . '/../app/');
defined('ROOT_PATH') or define('ROOT_PATH', dirname(realpath(APP_PATH)) . DS);
defined('ZANE_PATH') or define('ZANE_PATH', ROOT_PATH . 'zane' . DS);
defined('VENDOR_PATH') or define('VENDOR_PATH', ROOT_PATH . 'vendor' . DS);
defined('RUNTIME_PATH') or define('RUNTIME_PATH', ROOT_PATH . 'runtime' . DS);
defined('CACHE_PATH') or define('CACHE_PATH', RUNTIME_PATH . 'cache' . DS);

$loader = new \zane\Autoloader;
$loader->addNamespace('zane', ZANE_PATH);
$loader->addNamespace('app', APP_PATH);
$loader->register();
$whoops = new \Whoops\Run;
$PrettyPageHandler = new \Whoops\Handler\PrettyPageHandler();
//$PrettyPageHandler->setPageTitle('zane');
$whoops->pushHandler($PrettyPageHandler);
$whoops->register();

\zane\Config::set(include APP_PATH.'config.php');
\zane\App::run();