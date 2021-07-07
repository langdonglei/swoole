<?php

class Server
{
    private $server = null;
    private $users  = [];

    public function __construct()
    {
        $this->server = new Swoole\WebSocket\Server("0.0.0.0", 9504);
        $this->server->on("open", [$this, "onOpen"]);
        $this->server->on("close", [$this, "onClose"]);
        $this->server->on("message", [$this, "onMessage"]);
        $this->server->on("request", [$this, "onRequest"]);
        $this->server->start();
    }

    # todo
    public function beat()
    {
        while (1) {
            echo "beat";
            sleep(5);
            foreach ($this->server->connections as $fd) {
                $this->server->push($fd, json_encode($this->users));
            }
        }
    }

    public function onOpen($server, $request)
    {
        $this->users[] = $request->fd;
        echo "handshake success with fd{$request->fd}" . PHP_EOL;
    }

    public function onClose($server, $fd)
    {
        echo "连接关闭 fd${fd}" . PHP_EOL;
    }

    /**
     * $server和$this->server是同一个对象 $server->connection dump为空 实际遍历不空
     * @param $server
     * @param $frame
     */
    public function onMessage($server, $frame): void
    {
        echo "fd:{$frame->fd},data:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}" . PHP_EOL;
        $server->push($frame->fd, "this is server");
    }

    public function onRequest($request, $response)
    {
        $message = $request->get["message"];
        if ($message !== "") {
            foreach ($this->server->connections as $fd) {
                if ($this->server->isEstablished($fd)) {
                    $this->server->push($fd, $message);
                }
            }
        }
    }
}

new Server;