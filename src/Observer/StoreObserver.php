<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 15/06/15
 * Time: 18:47
 */

namespace DataAggregator\Observer;

use DataAggregator\Store\StoreInterface;
use DataAggregator\Provider\AbstractProvider;
use DataAggregator\Store\StoreException;

class StoreObserver implements ObserverInterface
{
    /**
     * @var StoreInterface
     */
    private $store;

    public function __construct(StoreInterface $store)
    {
        $this->store = $store;
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

        }
    }
}