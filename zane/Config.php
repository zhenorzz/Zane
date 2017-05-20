<?php
namespace zane;

/**
* 配置加载
*/
class Config
{
	private static $config = [];

	public static function set($name)
	{
		self::$config += $name;
		return;
	}

	public static function get($name = null)
	{
		if (empty($name)) {
			return self::$config;
		}
		return self::$config[$name];
	}
}