<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 16/06/15
 * Time: 11:33
 */

namespace DataAggregator\Observer;


use DataAggregator\Log\LogInterface;
use DataAggregator\Provider\AbstractProvider;

class LogObserver implements ObserverInterface
{
    /**
     * @var LogInterface
     */
    private $logger;

    /**
     * @param LogInterface $logger
     */
    public function __construct(LogInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function update(AbstractProvider $subject)
    {
        $exceptions = $subject->getEntry()->getExceptions();
        if ($exceptions) {
            foreach ($exceptions as $exception) {
                $this->logger->add(LogInterface::ERROR, $exception, new \DateTime());
            }
        }
    }
}