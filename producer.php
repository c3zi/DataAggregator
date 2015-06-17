<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 16/06/15
 * Time: 21:05
 */

require_once __DIR__.'/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
use DataAggregator\InputProvider\FileProvider;

$path = __DIR__ . '/data/facebook_contacts.txt';

try {
    $fileProvider = new FileProvider($path);
} catch (\InvalidArgumentException $ex) {
    print(sprintf("Some probles with file: %s\n", $path));
    die();
}

$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

foreach ($fileProvider->load() as $contact) {
    $msg = new AMQPMessage($contact,
        array('delivery_mode' => 2) # make message persistent
    );
    $channel->basic_publish($msg, '', 'task_aggregator2');
}

print(sprintf("\n [x] Sent contacts from file: %s\n", $path));

$channel->close();
$connection->close();