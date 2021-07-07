<?php

class Server
{
    private static $instance;
    private $server;
    private $message;

    public function __construct()
    {
        $this->server = new swoole_websocket_server('0.0.0.0', 9999);
        $this->server->on('message', [$this, 'onMessage']);
        $this->server->on('workerStart', [$this, 'onWorkerStart']);
    }

    public function onMessage($server, $frame)
    {
        $this->server->reload();
        $arr = json_decode($frame->data, true);
        if (method_exists($this->message, $arr['cmd'])) {
            call_user_func([$this->message, $arr['cmd']], $frame->fd, $arr['data']);
        }
    }

    public function onWorkerStart()
    {
        require_once './Message.php';
        $this->message = new Message($this->server);
    }

    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function start()
    {
        $this->server->start();
    }

}

Server::getInstance()->start();
