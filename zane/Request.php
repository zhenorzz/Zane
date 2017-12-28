<?php
namespace zane;
/**
* 		
*/
class Request
{
	
	/**
     * @var object 对象实例
     */
    protected static $instance;
    /**
     * @var array 请求参数
     */
    protected $param   = [];
    protected $get     = [];
    protected $post    = [];
    protected $request = [];
    protected $server  = [];

	/**
     * 构造函数
     * @access protected
     * @param array $options 参数
     */
    protected function __construct($options = [])
    {
        foreach ($options as $name => $item) {
            if (property_exists($this, $name)) {
                $this->$name = $item;
            }
        }
        // 保存 php://input
        $this->input = file_get_contents('php://input');
    }

	/**
     * 初始化
     * @access public
     * @param array $options 参数
     * @return Request
     */
    public static function instance($options = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new static($options);
        }
        return self::$instance;
    }

    /**
     * 设置获取获取GET参数
     * @access public
     * @param string|array  $name 变量名
     * @return mixed
     */
    public function get($name = '')
    {
        if (empty($this->get)) {
            $this->get = $_GET;
        }
        if (is_array($name)) {
            $this->param      = [];
            return $this->get = array_merge($this->get, $name);
        }
        if (!empty($name) && is_string($name)) {
        	if (isset($this->get[$name])) {
        		return $this->get[$name];
        	} else {
        		return '';
        	}
        }
        return $this->get;
    }

    /**
     * 设置获取获取POST参数
     * @access public
     * @param string        $name 变量名
     * @return mixed
     */
    public function post($name = '')
    {
        if (empty($this->post)) {
            $content = $this->input;
            if (empty($_POST) && false !== strpos($this->contentType(), 'application/json')) {
                $this->post = (array) json_decode($content, true);
            } else {
                $this->post = $_POST;
            }
        }
        if (is_array($name)) {
            $this->param       = [];
            return $this->post = array_merge($this->post, $name);
        }
        if (!empty($name) && is_string($name)) {
        	if (isset($this->post[$name])) {
        		return $this->post[$name];
        	} else {
        		return '';
        	}
        }
        return $this->post;
    }

    /**
     * 获取server参数
     * @access public
     * @param string|array  $name 数据名称
     * @return mixed
     */
    public function server($name = '')
    {
        if (empty($this->server)) {
            $this->server = $_SERVER;
        }
        if (is_array($name)) {
            return $this->server = array_merge($this->server, $name);
        }
        if (!empty($name) && is_string($name)) {
        	if (isset($this->server[$name])) {
        		return $this->server[$name];
        	} else {
        		return '';
        	}
        }
        return $this->server;
    }

    /**
     * 当前请求 HTTP_CONTENT_TYPE
     * @access public
     * @return string
     */
    public function contentType()
    {
        $contentType = $this->server('CONTENT_TYPE');
        if ($contentType) {
            if (strpos($contentType, ';')) {
                list($type) = explode(';', $contentType);
            } else {
                $type = $contentType;
            }
            return trim($type);
        }
        return '';
    }
}