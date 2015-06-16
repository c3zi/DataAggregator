<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 16/06/15
 * Time: 09:37
 */

namespace DataAggregator\Provider;

use DataAggregator\Entry;

/**
 * Class NullProvider is used only in tests.
 *
 * @package DataAggregator\Provider
 */
class NullProvider extends AbstractProvider
{
    const FAKE_ID = '12222112';

    public function getPosts($limit = 10)
    {
        $this->entry = new Entry(self::FAKE_ID);
        $this->entry->addMessage(1, 'Null Message #1');
        $this->entry->addMessage(2, 'Null Message #1');
        $this->entry->addMessage(3, 'Null Message #1');
        $this->entry->addMessage(4, 'Null Message #1');

        $this->notify();

        return $this->entry;
    }
}