<?php
$server = new Swoole\Server("0.0.0.0", 9501);
# $server->on("Connect", function ($server, $fd) {
#     printf("fd=%s connect" . PHP_EOL, $fd);
# });
# $server->on("Close", function ($server, $fd) {
#     printf("fd=%s close" . PHP_EOL, $fd);
# });
$server->on("Receive", function ($server, $fd, $from_id, $data) {
    printf("fd=%s,from_id=%s,data=%s" . PHP_EOL, $fd, $from_id, $data);
    $server->send($fd, $data);
});
$server->start();
