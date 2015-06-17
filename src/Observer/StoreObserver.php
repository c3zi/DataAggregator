<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 15/06/15
 * Time: 18:47
 */

namespace DataAggregator\Observer;

use DataAggregator\Log\LogInterface;
use DataAggregator\Store\StoreInterface;
use DataAggregator\Provider\AbstractProvider;
use DataAggregator\Store\StoreException;

class StoreObserver implements ObserverInterface
{
    /**
     * @var StoreInterface
     */
    private $store;

    /**
     * @var LogInterface
     */
    private $logger;

    public function __construct(StoreInterface $store, LogInterface $logger = null)
    {
        $this->store = $store;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function update(AbstractProvider $subject)
    {
        $entry = $subject->getEntry();

        try {
            $this->store->connect();
            $this->store->add($entry);
        } catch (StoreException $ex) {
            if ($this->logger) {
                $this->logger->add(LogInterface::ERROR, $ex->getMessage());
            }
        }
    }
}