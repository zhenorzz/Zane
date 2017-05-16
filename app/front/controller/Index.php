<?php
namespace app\front\controller;
use zane;
use zane\Mongodb;

class Index
{
    public function index()
    {


  //   	$manager = new \MongoDB\Driver\Manager("mongodb://localhost:27017");

		// $bulk = new \MongoDB\Driver\BulkWrite;
		// $bulk->insert(['x' => 6]);
		// $manager->executeBulkWrite('ascs.collection', $bulk);

		$filter = ['x' => ['$gt' => 1]];
		$options = [
		    'projection' => ['_id' => 0],
		    'sort' => ['x' => -1],
		];

		// $query = new \MongoDB\Driver\Query($filter, $options);
		// $cursor = $manager->executeQuery('ascs.collection', $query);

    	$mongodb = new Mongodb('db');
    	//$result = $mongodb->table('collection')->add(['x' => 7]);
    	$result = $mongodb->table('collection')->where(['x' => 7])->save(['x' => 2]);
    	var_dump($result);
    	$cursor = $mongodb->table('collection')->where($filter)->order($options)->select();

		foreach ($cursor as $document) {
		    var_dump($document);
		}
		die;
        $arry = [
           ['id'=>2,'title'=>'t2'],
           ['id'=>null,'title'=>'t3'],
           ['id'=>null,'title'=>'t4'],
           ['id'=>null,'title'=>'t5'],
           ['id'=>7,'title'=>'t7'],
        ];
        $tpl = new zane\Template();
		$tpl->assign('data','hello world');
		$tpl->assign('person','zane');
		$tpl->assign('pai','3.14');
		$tpl->assign('b',[1,2,3,4,'gg','sb']);
		return $tpl->show();
    }
}
