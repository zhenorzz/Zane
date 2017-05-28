<?php
namespace app\front\controller;
use zane;
use zane\Mongodb;
class Index
{
    public function index()
    {
        $tpl = new zane\Template();
		$tpl->assign('data','hello world');
		$tpl->assign('person','zane');
		$tpl->assign('pai','3.14');
		$tpl->assign('b',[1,2,3,4,'gg','sb']);
		return $tpl->show();
    }
}
