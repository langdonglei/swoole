<?php
$server = new Swoole\Server("127.0.0.1", 9505);
$server->set([
    'task_worker_num' => 8
]);
$server->on('receive', function ($server, $fd, $from_id, $data) {
    $taskID = $server->task($data);
    printf("投递任务 taskID=%s" . PHP_EOL, $taskID);
});
$server->on('task', function ($server, $taskID, $from_id, $data) {
    printf("开始任务 taskID=%s" . PHP_EOL, $taskID);
    sleep(5);
    $server->finish("完成任务 taskID=$taskID");
});
$server->on('finish', function ($server, $taskID, $finish) {
    printf("接受任务 taskID=%s finish=%s" . PHP_EOL, $taskID, $finish);
});
$server->start();
