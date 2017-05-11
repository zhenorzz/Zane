<?php
namespace zane;
/**
* 		
*/
class Template
{
	private $arrayConfig = [
		'suffix' => '.html',
		'templateDir' => '../template/',
		'compiledir' => '../runtime/cache/',
		'cache_htm' => true,
		'suffix_cache' => '.html',
		'cache_time' => 7200,
		'php_turn' => true,

		'cache_control' => 'control.dat',
		'debug' => false,
	];

	private static $instance = null;

	private $value = [];

	private $compileTool;

	public $file;

	public $debug = [];

	private $controlData = [];

	public function __construct(array $arrayConfig = [])
	{
		$this->debug['begin'] = microtime(true);
		$this->arrayConfig = $arrayConfig + $this->arrayConfig;

		if (!is_dir($this->arrayConfig['templateDir'])) {
			exit("template dir isn't found");
		}

		if (!is_dir($this->arrayConfig['compiledir'])) {
			mkdir($this->arrayConfig['compiledir'], 0770, true);
		}
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

	public function assign($key, $value)
	{
		$this->value[$key] = $value;
	}

	private function path()
	{
		return $this->arrayConfig['templateDir'] . $this->file . $this->arrayConfig['suffix'];
	}

	public function needCache()
	{
		return $this->arrayConfig['cache_htm'];
	}

	public function reCache($file)
	{
		$flag = false;
		$cacheFile = $this->arrayConfig['compiledir'] . md5($file) . '.html';
		if ($this->arrayConfig['cache_htm'] === true) {
			$timeFlag = (time() - filemtime($cacheFile)) < $this->arrayConfig['cache_time'] ? true : false;
			if (is_file($cacheFile) && filesize($cacheFile) > 1 && $timeFlag) {
				$flag = true;
			}  else {
				$flag = false;
			}
		}
		return $flag;
	}

	public function show($file)
	{
		$this->file = $file;
		if (!is_file($this->path())) {
			var_dump(is_file($this->path()));
			exit('找不到对应的模版');
		}
		$compileFile = $this->arrayConfig['compiledir'] . '/' . md5($file) . '.php';
		$cacheFile = $this->arrayConfig['compiledir'] . '/' . md5($file) . '.html';
		if ($this->reCache($file) === false) {
			$this->debug['cached'] = 'false';
			$this->compileTool = new Compile($this->path(), $compileFile, $this->arrayConfig);
			if ($this->needCache()) {
				ob_start();
			}
			extract($this->value);
			
			if (!is_file($compileFile) || filemtime($compileFile) < filemtime($this->path())) {
				$this->compileTool->value = $this->value;
				$this->compileTool->compile();
				include $compileFile;
			} else {
				include $compileFile;
			}
			if ($this->needCache()){
				$message = ob_get_contents();
				file_put_contents($cacheFile, $message);
			}
		} else {
			readfile($cacheFile);
			$this->debug['cached'] = 'true';
		}

		$this->debug['spend'] = microtime(true) - $this->debug['begin'];
		$this->debug['count'] = count($this->value);
		$this->debug_info(); 
	}

	public function debug_info()
	{
		echo PHP_EOL.'----debug info----'.PHP_EOL;
		echo '程序运行日期：'.date('Y-m-d h:i:s').PHP_EOL;
		echo '是否使用静态缓存：'.$this->debug['cached'].PHP_EOL;
		echo '模版引擎参数：'.var_dump($this->getConfig());
	}

	public function clean($path=null)
	{
		if ($path === null) {
			$path = $this->arrayConfig['compiledir'];
			$path = glob($path.'*'.$this->arrayConfig['suffix_cache']);
		} else {
			$path = $this->arrayConfig['compiledir'].md5($path).'.html';
		}

		foreach ((array)$path as $file) {
			unlink($file);
		}
		
	}
}