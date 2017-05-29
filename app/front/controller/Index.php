<?php
namespace app\front\controller;
use zane;
use zane\Mongodb;
class Index
{
    public function index()
    {
        $tpl = new zane\View();
		$tpl->assign('data','hello world');
		$tpl->assign('person','zane');
		$tpl->assign('pai','3.14');
		$tpl->assign('b',[1,2,3,4,'gg','sb']);
		return $tpl->show();
    }

    public function test()
    {   
        $array = [1,2,3,4,'gg','sb'];
        $json = new zane\Json();
        return $json->show($array);
    }
}
