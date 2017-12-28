<?php
namespace app\front\controller;

use zane;
use zane\Mongodb;
use zane\Request;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Index
{
    /**
     * @return zane\response\View
     * @throws \Exception
     */
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
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('hello', false, false, false, false);
        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        $callback = function($msg) {
          echo " [x] Received ", $msg->body, "\n";
        };
        $channel->basic_consume('hello', '', false, true, false, false, $callback);
        while(count($channel->callbacks)) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }
}
