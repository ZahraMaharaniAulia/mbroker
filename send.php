<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

// Make sure to set the 'durable' parameter to true
$channel->queue_declare('pesan', false, false, false, false);

$data = implode('', array_slice($argv, 1));
if (empty($data)) {
    $data = "hallo E1E121098_ZAHRA MAHARANI AULIA";
}

$msg = new AMQPMessage(
    $data,
    array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
);

$channel->basic_publish($msg, '', 'pesan');

echo ' [x] Sent ', $data, "\n";

$channel->close();
$connection->close();
?>