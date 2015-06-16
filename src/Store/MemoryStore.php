<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 16/06/15
 * Time: 11:21
 */

namespace DataAggregator\Store;

use DataAggregator\Entry;

class MemoryStore implements StoreInterface
{
    public static $added;

    /**
     * @var Entry
     */
    public static $entry;

    public function connect()
    {
    }

    public function add(Entry $entry)
    {
        $rowCount = 0;

        if ($entry->getId()) {
            ++$rowCount;
            foreach ($entry->getMessages() as $message) {
                ++$rowCount;
            }
        }
        self::$added = $rowCount;
        self::$entry = $entry;
    }

    public function get($limit = 10)
    {
        return self::$entry;
    }
}