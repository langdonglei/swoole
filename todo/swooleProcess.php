<?php

$workers = [];
for ($i = 10; $i--;) {
    $process       = new Swoole_process(function ($worker) {
        $worker->write('123');
    });
    $pid           = $process->start();
    $workers[$pid] = $process;
}

foreach ($workers as $worker) {
    echo $worker->read();
}
