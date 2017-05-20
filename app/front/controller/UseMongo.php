<?php
namespace app\front\controller;
use zane;
use zane\Mongodb;

class UseMongo
{
    public function index()
    {

		$filter = ['x' => ['$gt' => 1]];
		$options = [
		    'projection' => ['_id' => 0],
		    'sort' => ['x' => -1],
		];
		//初始化
    	$mongodb = new Mongodb('collection');
    	//新增
    	//$result = $mongodb->add(['x' => 7]);
    	//更新
    	//$result = $mongodb->where(['x' => 7])->save(['x' => 2]);
    	//删除
    	//$result = $mongodb->where(['x' => 2])->delete(['limit'=>1]);
    	//查询
    	$cursor = $mongodb->where($filter)->order($options)->select();

		foreach ($cursor as $document) {
		    var_dump($document);
		}
    }
}
