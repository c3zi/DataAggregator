<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 15/06/15
 * Time: 18:47
 */

namespace DataAggregator\Observer;

use DataAggregator\Provider\AbstractProvider;

class EmailObserver implements ObserverInterface
{
    public function update(AbstractProvider $subject)
    {
        $entry = $subject->getEntry();

        if ($entry->getExceptions()) {
            // send an email to administrator
        }
    }
}