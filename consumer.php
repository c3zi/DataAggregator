<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 16/06/15
 * Time: 21:05
 */

namespace DataAggregator;

require_once __DIR__ . '/vendor/autoload.php';

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

$channel->queue_declare('task_aggregator2', false, false, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function($msg){
    $pathToReportFile = __DIR__ . '/report/' . $msg->body . '.txt';
    $pathToLogFile = __DIR__ . '/log/logs.txt';

    $token = 'CAACEdEose0cBAA0O213y3ZAMMaV4xpArTDCnmbMBltZBOJxyMg5ZAAErmkhFbLzDYF2x7JZBkoV2G10lByLbQxZB9sRFBV16pgmjabi2ybQIzTmc2E24CMUFDko5ZCWEkAZBilVpIV5w5ZCGzniMgjaMqcBHVZAwlRHIqc5qZCCa2ZBjiYZBNRZACAG59EEd5LDE5Wd0k5rN021QeEZASkCTAdVZCsZA';
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

    $logger = FileLog::init($pathToLogFile);

    $observers = [
        new StoreObserver(new MySqlStore($dbConfig)),
        new ReportObserver(new TextReport($pathToReportFile)),
        new LogObserver($logger),
    ];
    $provider = Provider::factory('facebook', $config, $observers);
    $provider->getPosts();

    echo " [x] Received ", $msg->body, " contact.\n";
    echo " [x] Done", "\n";
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};


$channel->basic_qos(null, 1, null);
$channel->basic_consume('task_aggregator2', '', false, false, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}