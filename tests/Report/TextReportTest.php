<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 16/06/15
 * Time: 14:10
 */

namespace DataAggregator\Test\Report;

use DataAggregator\Report\TextReport;
use DataAggregator\Entry;
use DataAggregator\Test\PrivateMethod;

class TextReportTest extends \PHPUnit_Framework_TestCase
{
    use PrivateMethod;

    const FAKE_ID = '12121212';
    const REPORT_PATH = __DIR__ . '/../data/report/';

    /**
     * @var Entry
     */
    private $entry;

    public function setUp()
    {
        $this->entry = new Entry(self::FAKE_ID);
        $this->entry->addMessage(1, 'Message #1');
        $this->entry->addMessage(2, 'Message #2');
        $this->entry->addMessage(3, 'Message #3');
        $this->entry->addMessage(4, 'Message #4');
        $this->entry->addException('Exception #1');
        $this->entry->addException('Exception #2');

        $this->path = self::REPORT_PATH . $this->entry->getId() . '.txt';
    }


    /**
     * @test
     */
    public function saveReport()
    {
        $report = new TextReport($this->path);
        $saved = $report->save($this->entry);
    }

    /**
     * @test
     */
    public function createMessageReport()
    {
        $report = new TextReport($this->path);
        $messages = $this->invokeMethod($report, 'createMessageReport', [$this->entry->getMessages()]);
        $this->assertNotNull($messages);
    }

    public function createExceptionReport()
    {
        $report = new TextReport($this->path);
        $messages = $this->invokeMethod($report, 'createExceptionReport', [$this->entry->getExceptions()]);
        $this->assertNotNull($messages);
    }
}