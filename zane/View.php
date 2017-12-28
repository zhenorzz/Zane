<?php
namespace zane;
/**
*模板生成
*/
class View
{
	private $arrayConfig = [
		'suffix' => '.html',
		'templateDir' => '',
		'compileDir' => CACHE_PATH,
		'cache_htm' => false,
		'suffix_cache' => '.html',
		'cache_time' => 7200,
		'php_turn' => true,
		'cache_control' => 'control.dat',
		'debug' => true,
	];

	private $value = [];

	private $compileTool;

	public $file;

	public $debug = [];

	private $controlData = [];

    /**
     * View constructor.
     * @param array $arrayConfig
     * @throws \Exception
     */
    public function __construct(array $arrayConfig = [])
	{
		$this->arrayConfig = $arrayConfig + $this->arrayConfig;
		$this->arrayConfig['templateDir'] = APP_PATH . MODULE . '/view/' . CONTROLLER . DS;
		if (!is_dir($this->arrayConfig['templateDir'])) {
			throw new \Exception("template dir isn't found");
		}
		if (!is_dir($this->arrayConfig['compileDir'])) {
			mkdir($this->arrayConfig['compileDir'], 0770, true);
		}
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
		$cacheFile = $this->arrayConfig['compileDir'] . md5($file) . '.html';
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

    /**
     * @param null $file
     * @return Response|response\View
     * @throws \Exception
     */
    public function show($file = null)
	{
		if (isset($file)) {
			$this->file = $file;
		} else {
			$this->file = ACTION;
		}
		if (!is_file($this->path())) {
			throw new \Exception("template view isn't found");
		}
		$compileFile = $this->arrayConfig['compileDir'] . '/' . md5($file) . '.php';
		$cacheFile = $this->arrayConfig['compileDir'] . '/' . md5($file) . '.html';
		if ($this->reCache($file) === false) {
			$this->compileTool = new Compile($this->path(), $compileFile, $this->arrayConfig);
//			extract($this->value);
			if (!is_file($compileFile) || filemtime($compileFile) < filemtime($this->path()) || $this->arrayConfig['debug']) {
//				$this->compileTool->value = $this->value;
				$data = $this->compileTool->compile();
				return Response::create($data, 'view');
			} else {
                $data = file_get_contents($compileFile);
				return Response::create($data, 'view');
			}
		} else {
			$data = file_get_contents($compileFile);
			return Response::create($data, 'view');
		}
	}

	public function clean($path=null)
	{
		if ($path === null) {
			$path = $this->arrayConfig['compileDir'];
			$path = glob($path.'*'.$this->arrayConfig['suffix_cache']);
		} else {
			$path = $this->arrayConfig['compileDir'].md5($path).'.html';
		}
		foreach ((array)$path as $file) {
			unlink($file);
		}
		
	}
}