<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 16/06/15
 * Time: 14:06
 */

namespace DataAggregator\Report;

use DataAggregator\Entry;

interface ReportInterface
{
    public function save(Entry $entry);
}