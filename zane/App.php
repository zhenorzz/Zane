<?php
namespace zane;

/**
* 	App 运行
*/
class App
{
	
	public static function run()
	{	
		$URI = $_SERVER['REQUEST_URI'];
		$file = explode('/', $URI);
		$module = isset($file[1]) && !empty($file[1])? $file[1] : 'front';
		$controller = isset($file[2]) ? $file[2] : 'Index';
		$action = isset($file[3]) ? explode('.', $file[3])[0] : 'index';
		define('MODULE',$module);
		define('CONTROLLER',$controller);
		define('ACTION',$action);
		$class = '\\app\\' . $module . '\\controller\\' . $controller;
		$view = new $class();
		$response = $view->$action();
		if ($response instanceof Response) {
		} elseif (is_string($response)) {
			$response = Response::create($response, 'view');
		} elseif (is_array($response)) {
			$response = Response::create(print_r($response,true), 'view');
		} else {
			$response = Response::create('', 'view');
		}
		return $response;
	}

}