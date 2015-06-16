<?php

namespace DataAggregator\Test\Store;

use DataAggregator\Test\PrivateMethod;
use DataAggregator\Store\MySqlStore;
use DataAggregator\Entry;

/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 15/06/15
 * Time: 19:31
 */
class MysqlStoreTest extends \PHPUnit_Framework_TestCase
{
    use PrivateMethod;

    const DB = 'fake_db';
    const HOST = 'localhost';
    const USER = 'fake_user';
    const PASSWORD = 'fake_password';
    const FACEBOOK_ID = '234324324';


    /**
     * @test
     */
    public function configIsValid()
    {
        $config = [
            'db' => self::DB,
            'host' => self::HOST,
            'user' => self::USER,
            'password' => self::PASSWORD
        ];

        $store = new MySqlStore($config);
        $isValid = $this->invokeMethod($store, 'configIsValid', [$config]);

        $this->assertNull($isValid);
    }

    /**
     * @test
     *
     * @expectedException \DataAggregator\Store\StoreException
     */
    public function configIsInvalid()
    {
        $config = [
            'db' => self::DB,
            'host' => self::HOST,
            'user' => self::USER,
            'password' => self::PASSWORD
        ];

        $invalidConfig = $config;
        unset($invalidConfig['db']);

        $store = new MySqlStore($config);
        $this->invokeMethod($store, 'configIsValid', [$invalidConfig]);
    }

    /**
     * @test
     */
    public function connectIsValid()
    {
        $config = [
            'db' => self::DB,
            'host' => self::HOST,
            'user' => self::USER,
            'password' => self::PASSWORD
        ];

        $store = new MySqlStore($config);

        $this->assertNull($store->connect());
    }

    /**
     * @test
     *
     * @expectedException \DataAggregator\Store\StoreException
     */
    public function connectIsInvalid()
    {
        $config = [
            'db' => self::DB,
            'host' => self::HOST,
            'user' => self::USER,
            'password' => '$%^&*(#'
        ];

        $store = new MySqlStore($config);
        $this->assertNull($store->connect());
    }

    /**
     * @test
     */
    public function addEntry()
    {
        $entry = new Entry(self::FACEBOOK_ID); // 1 row
        $entry->addMessage(1, 'Message #1'); // 2 rows
        $entry->addMessage(2, 'Message #2'); // 3 rows
        $entry->addMessage(3, 'Message #3'); // 4 rows
        $entry->addMessage(4, 'Message #4'); // 5 rows

        $config = [
            'db' => self::DB,
            'host' => self::HOST,
            'user' => self::USER,
            'password' => self::PASSWORD
        ];

        $store = new MySqlStore($config);
        $store->connect();

        $this->assertEquals(5, $store->add($entry));
    }
}