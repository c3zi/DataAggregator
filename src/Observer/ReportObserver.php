<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 15/06/15
 * Time: 18:46
 */

namespace DataAggregator\Observer;

use DataAggregator\Provider\AbstractProvider;
use DataAggregator\Report\ReportInterface;

class ReportObserver implements ObserverInterface
{
    /**
     * @var ReportInterface
     */
    private $report;

    public function __construct(ReportInterface $report)
    {
        $this->report = $report;
    }

    /**
     * {@inheritdoc}
     */
    public function update(AbstractProvider $subject)
    {
        $entry = $subject->getEntry();
        $this->report->save($entry);
    }
}