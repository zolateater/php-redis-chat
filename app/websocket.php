<?php

use Ratchet\Server\IoServer;
use App\Websocket\Chat;

require dirname(__FILE__) . '/../vendor/autoload.php';

$server = IoServer::factory(
    new Chat(),
    8080
);

$server->run();