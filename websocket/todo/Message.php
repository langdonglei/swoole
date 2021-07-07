<?php

class Message
{
    private $server;

    public function __construct($server)
    {
        $this->server = $server;
    }

    public function login($fd, $data)
    {
        $this->server->push($fd, $data);
    }
}