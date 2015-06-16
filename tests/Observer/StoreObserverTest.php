<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 16/06/15
 * Time: 09:33
 */

namespace DataAggregator\Test\Observer;

use DataAggregator\Observer\StoreObserver;
use DataAggregator\Provider\NullProvider;
use DataAggregator\Store\MemoryStore;

class StoreObserverTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function testObserver()
    {
        $provider = new NullProvider();
        $store = new MemoryStore();
        $observer = new StoreObserver($store);

        $provider->attach($observer);
        $this->assertEquals($provider->getPosts(), MemoryStore::$entry);
    }

    /**
     * Mockups MysqlStore object.
     *
     * @todo This method should be remobed because instead of Mock we use MemoryStore.
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getStoreMockup()
    {

        $stubStore = $this->getMock('DataAggregator\Store\MysqlStore', [], [], '', false);

        $stubStore->expects($this->any())->method('connect')->will($this->returnValue(TRUE));
        $stubStore->expects($this->any())->method('add')->will($this->returnValue(5));

        return $stubStore;
    }
}