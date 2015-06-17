<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 16/06/15
 * Time: 21:05
 */

namespace DataAggregator;

require_once __DIR__ . '/vendor/autoload.php';

use DataAggregator\Log\LogInterface;
use PhpAmqpLib\Connection\AMQPConnection;
use DataAggregator\Provider;
use DataAggregator\Report\TextReport;
use DataAggregator\Store\MySqlStore;
use DataAggregator\Log\FileLog;
use DataAggregator\Observer\ReportObserver;
use DataAggregator\Observer\StoreObserver;
use DataAggregator\Observer\LogObserver;

$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('task_aggregator3', false, true, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function($msg) {
    $pathToReportFile = __DIR__ . '/report/' . $msg->body . '.txt';
    $pathToLogFile = __DIR__ . '/log/logs.txt';

    $token = 'CAACEdEose0cBAFZC99yIEZA6oJyz0QGgu95JYZAqcmVIl8warmNCBsfqwOTw60LaPJNHlhDzOR4jd4dUtvZA8YrXXTpvkYVjQU3xzenQZC5zOX9YtMB2nbJtup43o7RQD2CZB6XMO2IIPAI3lYmAGBBPMLM1W8sQNsOqpOnsXsvL0hBRDVNBCVZAwnA2qnx6a4YKqjVo5YCKAeRqq21vb6W';
    $config = [
        'facebook' => [
            'facebook_id' => $msg->body,
            'access_token' => $token,
        ]
    ];

    $dbConfig = [
        'db' => 'fake_db',
        'host' => 'localhost',
        'user' => 'fake_user',
        'password' => 'fake_password',
    ];

    /** @var LogInterface $logger */
    $logger = FileLog::init($pathToLogFile);

    $observers = [
        new StoreObserver(new MySqlStore($dbConfig), $logger),
        new ReportObserver(new TextReport($pathToReportFile), $logger),
        new LogObserver($logger),
    ];
    $provider = Provider::factory('facebook', $config, $observers);
    $provider->getPosts();

    echo " [x] Received ", $msg->body, " contact.\n";
    echo " [x] Done", "\n";
    $logger->add(LogInterface::INFO, sprintf("Feeds for contact %s have been parsed properly.", $msg->body));
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};


$channel->basic_qos(null, 1, null);
$channel->basic_consume('task_aggregator3', '', false, false, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

