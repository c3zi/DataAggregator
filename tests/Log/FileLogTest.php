<?php

namespace DataAggregator\Test\Log;

use DataAggregator\Log\FileLog;

/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 16/06/15
 * Time: 11:42
 */
class FileLogTest extends  \PHPUnit_Framework_TestCase
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
    public function initLog()
    {
        FileLog::init(self::LOG_PATH);

        $this->assertTrue(file_exists(self::LOG_PATH));
    }

    /**
     * @test
     */
    public function addLog()
    {
        $date = new \DateTime();

        $logger = FileLog::init(self::LOG_PATH);
        $logger->add(FileLog::ERROR, 'Something is broken #1.', $date);
        $logger->add(FileLog::WARNING, 'Something is broken #2.', $date);
        $logger->add(FileLog::INFO, 'Something is broken #3.', $date);

        $messages = [
            sprintf("[error] %s | Something is broken #1.\n", $date->format(FileLog::$format)),
            sprintf("[warning] %s | Something is broken #2.\n", $date->format(FileLog::$format)),
            sprintf("[info] %s | Something is broken #3.\n", $date->format(FileLog::$format)),
        ];

        $file = file(self::LOG_PATH);
        $this->assertEquals($file[0], $messages[0]);
        $this->assertEquals($file[1], $messages[1]);
        $this->assertEquals($file[2], $messages[2]);
    }
}