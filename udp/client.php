<?php
$client = new Swoole\Client(SWOOLE_SOCK_UDP);
while (1) {
    fwrite(STDOUT, "输入消息:");
    $message = trim(fgets(STDIN));
    if ($message == "exit") {
        break;
    } else {
        $client->sendto("127.0.0.1", 9502, $message);
        printf("收到消息:%s" . PHP_EOL, $client->recv());
    }
}
