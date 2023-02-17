<?php

require_once 'vendor/autoload.php';
require_once 'libraries/Chat.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(new HttpServer(new WsServer(new Chat())), 8082);
$server->run();

?>