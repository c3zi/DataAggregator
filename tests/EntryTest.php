<?php

namespace DataAggregator\Test;

use DataAggregator\Entry;
use DataAggregator\Test\PrivateMethod;

/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 14/06/15
 * Time: 16:41
 */
class EntryTest extends \PHPUnit_Framework_TestCase
{
    use PrivateMethod;

    const FAKE_ID = '234324324324';

    public function testAddMessage()
    {
        $entry = new Entry(self::FAKE_ID);
        $entry->addMessage(1, 'Message #1');
        $entry->addMessage(2, 'Message #2');
        $entry->addMessage(3, 'Message #3');
        $entry->addMessage(4, 'Message #4');

        $this->assertEquals(4, count($entry->getMessages()));

        foreach($entry->getMessages() as $message) {
            $this->assertInstanceOf('DataAggregator\Message', $message);
        }
    }

    public function testAddException()
    {
        $entry = new Entry(self::FAKE_ID);
        $entry->addException('exception #1');
        $entry->addException('exception #2');

        $this->assertEquals(2, count($entry->getExceptions()));
    }

}