<?php

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use App\Websocket\Chat;
use Ratchet\WebSocket\WsServer;

require dirname(__FILE__) . '/../vendor/autoload.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    9000
);

$server->run();