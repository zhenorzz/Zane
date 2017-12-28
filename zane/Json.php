<?php
namespace zane;
/**
 *返回json
 */
class Json
{
	public function show($data, $code = 200, $header = [], $options = [])
	{
		return Response::create($data, 'json', $code, $header, $options);
	}
}