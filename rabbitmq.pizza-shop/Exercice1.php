<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once './vendor/autoload.php';

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'user', 'user');
$channel = $connection->channel();

$msg_body = [ "TESTTTTTTTTTTTT" ];

$channel->basic_publish(new AMQPMessage(json_encode($msg_body)), 'pizzashop', 'nouvelle');
print "[x] commande publiée\n";
$channel->close();
$connection->close();