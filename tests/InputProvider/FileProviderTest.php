<?php

namespace DataAggregator\Test\InputProvider;

use DataAggregator\InputProvider\FileProvider;
use DataAggregator\Test\PrivateMethod;

/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 14/06/15
 * Time: 21:31
 */
class FileProviderTest extends \PHPUnit_Framework_TestCase
{
    use PrivateMethod;

    const FILE = __DIR__ . '/../data/file_provider.txt';

    /**
     * @test
     */
    public function validateFile()
    {
        $fileProvider = new FileProvider(self::FILE);
        $validateFile = $this->invokeMethod($fileProvider, 'validateFile', array());

        $this->assertNull($validateFile);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function checkWhenFileDoesNotExist()
    {
        new FileProvider('test.txt');
    }

    /**
     * @test
     */
    public function loadLines()
    {
        $fileProvider = new FileProvider(self::FILE);

        $results = [];

        foreach ($fileProvider->load() as $value) {
            $results[] = $value;
        }

        $this->assertEquals(4, count($results));
    }
}