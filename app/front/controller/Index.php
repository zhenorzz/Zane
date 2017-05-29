<?php
namespace app\front\controller;

use zane;
use zane\Mongodb;
use zane\Request;
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
        $request = Request::instance();
        $data = $request->post();
        $array = [
            "sites" => [
                ['Name' => 'zane', 'Country' => 'China'],
                ['Name' => 'lucy', 'Country' => 'Amarican']
            ],
        ];
        $json = new zane\Json();
        return $json->show($array);
    }
}
