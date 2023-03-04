<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn) {
        $conn->id = $this->getIDParamInConnectionObjectURI($conn);
        $this->clients->attach($conn);

        echo "Client ".$conn->id." connected.\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $msg = json_decode($msg, true);

        switch($msg['action']) {
            case 'BROADCAST_IM_ONLINE':
                $this->broadcastOnlineToAllClient($msg);
                break;
            case 'CHECK_IF_ONLINE':
                $this->checkUserIfOnline($from, $msg);
                break;
            case 'SEND_MESSAGE':
                $this->sendMessage($msg);
                break;
            case 'DOCUMENT_REQUEST_ACTION':
                $this->documentRequestAction($msg);
                break;
            case 'CONSULTATION_REQUEST_ACTION':
                $this->consultationRequestAction($msg);
                break;
        }     
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        $this->broadcastOfflineToAllClient($conn->id);
        echo "Client ".$conn->id." disconnected.\n";   
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }

    private function sendMessage($msg) {
        foreach($this->clients as $client) {
            if ($client->id == $msg['receiver']) {
                $client->send(json_encode([ 'action' => 'RECEIVE_MESSAGE', 'message' => $msg['message']]));
                return;
            }
        }
    }

    private function checkUserIfOnline($from, $msg) {
        $msg['action'] = 'IS_USER_ONLINE';
        foreach($this->clients as $client) {
            if($client->id == $msg['id']) {
                $from->send(json_encode($msg));
                return;
            }
        }
    }

    private function broadcastOfflineToAllClient($id) {
        foreach($this->clients as $client) {
            $client->send(json_encode(['action' => 'USER_OFFLINE_BROADCAST', 'id' => $id]));
        }
    }

    private function broadcastOnlineToAllClient($msg) {
        $msg['action'] = 'USER_ONLINE_BROADCAST';
        foreach($this->clients as $client) {
            $client->send(json_encode($msg));
        }
    }

    private function documentRequestAction($msg) {
        $msg['action'] = 'DOCUMENT_REQUEST_ACTION_NOTICE';
        foreach($this->clients as $client) {
            $client->send(json_encode($msg));
        }
    }

    private function consultationRequestAction($msg) {
        $msg['action'] = 'CONSULTATION_REQUEST_ACTION_NOTICE';
        foreach($this->clients as $client) {
            $client->send(json_encode($msg));
        }   
    }

    private function getIDParamInConnectionObjectURI($conn) {
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $queryParameters);

        if(isset($queryParameters['id'])) return $queryParameters['id'];
        
        return null;
    }
}

?>