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

    public $messages = [
        1 => 'Null Message #1',
        2 => 'Null Message #2',
        3 => 'Null Message #3',
        4 => 'Null Message #4',
    ];

    public $exceptions = [
        'Exception #1',
        'Exception #2',
    ];


    public function getPosts($limit = 10)
    {
        $this->entry = new Entry(self::FAKE_ID);

        foreach ($this->messages as $key => $message) {
            $this->entry->addMessage($key, $message);
        }

        foreach ($this->exceptions as $exception) {
            $this->entry->addException($exception);
        }

        $this->notify();

        return $this->entry;
    }
}