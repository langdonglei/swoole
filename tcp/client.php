<?php
$client = new Swoole\Client(SWOOLE_SOCK_TCP);
$client->connect("127.0.0.1", 9501);
while (1) {
    fwrite(STDOUT, "输入消息:");
    $message = trim(fgets(STDIN));
    if ($message == "exit") {
        break;
    } else {
        $client->send($message);
        printf("收到消息:%s" . PHP_EOL, $client->recv());
    }
}
$client->close();

