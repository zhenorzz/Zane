<?php
namespace zane\response;
use zane\Response;

/**
* json response class
*/
class Json extends Response
{
	
	// 输出参数
    protected $options = [
        'json_encode_param' => JSON_UNESCAPED_UNICODE,
    ];

    protected $contentType = 'application/json';

    /**
     * 处理数据
     * @access protected
     * @param mixed $data 要处理的数据
     * @return mixed
     * @throws \Exception
     */
    protected function output($data)
    {
        $data = json_encode($data, $this->options['json_encode_param']);
        return $data;
    }
}