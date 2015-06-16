<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 16/06/15
 * Time: 10:04
 */

namespace DataAggregator\Observer;

use DataAggregator\Provider\AbstractProvider;

interface ObserverInterface
{
    public function update(AbstractProvider $subject);
}