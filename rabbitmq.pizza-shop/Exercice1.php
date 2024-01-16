<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once './vendor/autoload.php';

try {
    $connection = new AMQPStreamConnection('rabbitmq', 5672, 'user', 'user');
}catch(Exception $e) {
    echo $e->getMessage();
}


//$channel = $connection->channel();
//
//$msg_body = [ 'id' => 1, 'nom' => 'Pizza 4 fromages', 'prix' => 12.5 ];
//
//$channel->basic_publish(new AMQPMessage(json_encode($msg_body)), 'pizzashop', 'nouvelle');
//print "[x] commande publiée : \n";
//$channel->close();
//$connection->close();
