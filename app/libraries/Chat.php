<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $client;

    public function __construct() {
        $this->client = new SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn) {
        $sessionId = $this->getSessionIDFromCookie($conn);
        $conn = $this->addUserIDFromSessionToConnectionObject($conn, $sessionId);
        $this->client->attach($conn);
        echo $conn->id;
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        
    }

    public function onClose(ConnectionInterface $conn) {
        $this->client->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
    }

    private function addUserIDFromSessionToConnectionObject($conn, $sessionId) {
        if($sessionId) {
            session_id($sessionId);
            session_start();
            if(isset($_SESSION['id'])) {
                $conn->id = $_SESSION['id'];
            }
            session_write_close();
        }

        return $conn;
    }

    private function getSessionIDFromCookie($conn) {
        $cookies = $conn->httpRequest->getHeader('Cookie');
        $sessionId = null;
        if($cookies) {
            $cookies = explode(';', $cookies[0]);
            foreach($cookies as $cookie) {
                $parts = explode('=', trim($cookie));
                if($parts[0] === 'PHPSESSID') {
                    $sessionId = $parts[1];
                    break;
                }
            }
        }

        return $sessionId;
    }

}

?>