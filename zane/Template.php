<?php
namespace zane;
/**
* 		
*/
class Template
{
	private $arrayConfig = [
		'suffix' => '.html',
		'templateDir' => 'template/',
		'compiledir' => 'cache/',
		'cache_htm' => false,
		'suffix_cache' => '.html',
		'cache_time' => 7200,
	];

	public $file;

	private static $instance = null;

	public function __construct(array $arrayConfig = [])
	{
		$this->arrayConfig = $arrayConfig + $this->arrayConfig;
	}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new Template();
		}
		return self::$instance;
	}

	public function setConfig($key, $value = null)
	{
		if (is_array($key)) {
			$this->arrayConfig = $key + $this->arrayConfig;
		} else {
			$this->arrayConfig[$key] = $value;
		}
	}

	public function getConfig($key = null)
	{
		if ($key) {
			return $this->arrayConfig[$key];
		} else {
			return $this->arrayConfig;
		}
	}


}