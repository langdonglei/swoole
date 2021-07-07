<?php
$server = new Swoole\Http\Server("0.0.0.0", 9503);
//$server->set([
//    "enable_static_handler" => true,
//    "document_root"         => "./static"
//]);
$server->on("Request", function ($request, $response) {
    var_dump($request->get, $request->post);
    $response->end("swoole http server response end");
});
$server->start();