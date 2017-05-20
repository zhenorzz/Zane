<?php
namespace app\front\controller;
use zane;
use zane\Mongodb;
class Index
{
    public function index()
    {
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
