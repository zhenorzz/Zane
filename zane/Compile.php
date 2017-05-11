<?php
namespace zane;

/**
* 
*/
class Compile
{
	private $template;
	private $content;
	private $comfile;
	private $left = '{';
	private $right = '}';
	private $value = [];
	private $phpTurn;
	private $T_P = [];
	private $T_R = [];
	public function __construct($template, $compileFile, $config)
	{
		$this->template = $template;
		$this->comfile = $compileFile;
		$this->content = file_get_contents($template);
		if ($config['php_turn'] === false) {
			$this->T_P[] = "#<\?(=|php|)(.+?)\?>#is";
			$this->T_R[] = "&lt;?\\1\\2?&gt;"; 
		} 
		$this->T_P[] = "#\{\\$([a-zA-z_\x7f-\xff][a-zA-z0-9_\x7f-\xff]*)\}#";
		$this->T_R[] = "<?php echo \$this->value['\\1'];?>"; 

		
	}

	public function compile()
	{
		$this->c_var2();
		$this->c_staticFile();
		file_put_contents($this->comfile, $this->content);
	}

	public function c_var2()
	{
		$this->content = preg_replace($this->T_P, $this->T_R, $this->content);
	}

	public function c_staticFile()
	{
		$this->content = preg_replace('#\{\!(.*?)\!\}#', '<script src=\\1'.'?t='.time().'></script>', $this->content);

	}

	public function __set($name, $value)
	{
		$this->$name = $value;
	}

	public function __get($name)
	{
		return $this->$name;
	}
}