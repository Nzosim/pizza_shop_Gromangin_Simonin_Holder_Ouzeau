<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;

require_once './vendor/autoload.php';

$message_queue = 'nouvelles_commandes';
$connection = new AMQPStreamConnection('rabbitmq',5672, 'user', 'user');
$channel = $connection->channel();

$msg = $channel->basic_get($message_queue);
if ($msg) {
    $content = json_decode($msg->body, true);
    var_dump($content);
    $channel->basic_ack($msg->getDeliveryTag());
} else {
    echo "[x] pas de message reçu\n";
}

$channel->close();
$connection->close();