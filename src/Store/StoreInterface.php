<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 15/06/15
 * Time: 18:57
 */

namespace DataAggregator\Store;

use DataAggregator\Entry;

interface StoreInterface
{
    public function connect();

    public function add(Entry $entry);

    public function get($limit = 10);
}