<?php
namespace zane\response;
use zane\Response;

/**
* view response class
*/
class View extends Response
{
	
	protected $contentType = 'text/html';

    /**
     * 处理数据
     * @access protected
     * @param mixed $data 要处理的数据
     * @return mixed
     * @throws \Exception
     */
    protected function output($data)
    {
    	return $data;
    }
}