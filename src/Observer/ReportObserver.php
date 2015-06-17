<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 15/06/15
 * Time: 18:46
 */

namespace DataAggregator\Observer;

use DataAggregator\Log\LogInterface;
use DataAggregator\Provider\AbstractProvider;
use DataAggregator\Report\ReportException;
use DataAggregator\Report\ReportInterface;

class ReportObserver implements ObserverInterface
{
    /**
     * @var ReportInterface
     */
    private $report;

    /**
     * @var LogInterface
     */
    private $logger;

    public function __construct(ReportInterface $report, LogInterface $logger = null)
    {
        $this->report = $report;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function update(AbstractProvider $subject)
    {
        $entry = $subject->getEntry();
        try {
            $this->report->save($entry);
        } catch (ReportException $ex) {
            if ($this->logger) {
                $this->logger->add(LogInterface::ERROR, $ex->getMessage());
            }
        }
    }
}