<?php
$server = new swoole_websocket_server('0.0.0.0', 9999);
$server->on('open',function($server,$frame){
	var_dump($frame);
});
$server->on('message',function($server,$frame){
	var_dump($frame);
});
$server->start();
