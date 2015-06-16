<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 16/06/15
 * Time: 11:42
 */

namespace DataAggregator\Test\Observer;

use DataAggregator\Observer\LogObserver;
use DataAggregator\Provider\NullProvider;
use DataAggregator\Log\FileLog;

class LogObserverTest extends \PHPUnit_Framework_TestCase
{
    const LOG_PATH = __DIR__ . '/../data/log/test.log';

    public function setUp()
    {
        if (file_exists(self::LOG_PATH)) {
            FileLog::reset();
            unlink(self::LOG_PATH);
        }
    }

    /**
     * @test
     */
    public function logObserver()
    {
        $observer = new LogObserver(FileLog::init(self::LOG_PATH));

        $provider = new NullProvider();
        $provider->attach($observer);
        $provider->getPosts();

        $file = file(self::LOG_PATH);
        $this->assertEquals(count($file), count($provider->exceptions));
    }
}