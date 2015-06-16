<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 15/06/15
 * Time: 18:37
 */

namespace DataAggregator\Provider;

use DataAggregator\Observer\ObserverInterface;
use DataAggregator\Entry;

abstract class AbstractProvider
{
    private $observers = array();

    /**
     * @var Entry
     */
    protected $entry;

    public function attach(ObserverInterface $observer)
    {
        $this->observers[spl_object_hash($observer)] = $observer;
    }


    public function detach(ObserverInterface $observer)
    {
        unset($this->observers[spl_object_hash($observer)]);
    }

    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function getEntry()
    {
        return $this->entry;
    }

    abstract public function getPosts($limit = 10);
}