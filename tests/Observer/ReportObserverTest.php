<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 16/06/15
 * Time: 20:04
 */

namespace DataAggregator\Test\Observer;

use DataAggregator\Observer\ReportObserver;
use DataAggregator\Provider\NullProvider;
use DataAggregator\Report\TextReport;

class ReportObserverTest extends \PHPUnit_Framework_TestCase
{
    const REPORT_PATH = __DIR__ . '/../data/report/';

    private $path;

    public function setUp()
    {
        $this->path = self::REPORT_PATH . NullProvider::FAKE_ID . '_observer.txt';

        if (file_exists($this->path)) {
            unlink($this->path);
        }
    }

    /**
     * @test
     */
    public function reportShouldBeCreated()
    {
        $report = new TextReport($this->path);
        $observer = new ReportObserver($report);

        $provider = new NullProvider();
        $provider->attach($observer);
        $provider->getPosts();

        $file = file($this->path);
        $this->assertGreaterThan(1, count($file));
    }
}