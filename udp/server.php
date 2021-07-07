<?php
$server = new Swoole\Server("0.0.0.0", 9502, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);
$server->on("Packet", function ($server, $data, $clientInfo) {
    printf("address=%s,port=%s,data=%s" . PHP_EOL, $clientInfo["address"], $clientInfo["port"], $data);
    sleep(5);
    $server->sendto($clientInfo["address"], $clientInfo["port"], $data);
});
$server->start();