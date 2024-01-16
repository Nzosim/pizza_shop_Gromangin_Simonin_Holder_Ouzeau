<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once './vendor/autoload.php';

$message_queue = 'nouvelles_commandes';
$connection = new AMQPStreamConnection('rabbitmq',5672, 'user', 'user');
$channel = $connection->channel();

$callback = function(AMQPMessage $msg) {
    $msg_body = json_decode($msg->body, true);
    var_dump($msg_body);
    $msg->getChannel()->basic_ack($msg->getDeliveryTag());
};
$msg = $channel->basic_consume($message_queue, '', false, false, false, false, $callback );

try {
    $channel->consume();
} catch (Exception $e) {
    echo $e->getMessage();
}

$channel->close();
$connection->close();