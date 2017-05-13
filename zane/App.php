<?php
namespace zane;

/**
* 	
*/
class App
{
	
	public function __construct()
	{
		
	}

	public static function run()
	{
		$URI = $_SERVER['REQUEST_URI'];
		$file = explode('/', $URI);
		$module = $file[1];
		$controller = $file[2];
		$action = explode('.', $file[3])[0];
		define('MODULE',$module);
		define('CONTROLLER',$controller);
		define('ACTION',$action);
		$class = '\\app\\' . $module . '\\controller\\' . $controller;
		$view = new $class();
		$view->$action();
	}

}