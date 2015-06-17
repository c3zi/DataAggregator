<?php

namespace DataAggregator\Test\Provider;

use DataAggregator\Provider\FacebookProvider;

/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 14/06/15
 * Time: 14:14
 */
class FacebookProviderTest extends \PHPUnit_Framework_TestCase
{
    const APP_ID = "867767336632517";
    const SECRET = "1dce17253232607ef58d2a38a27b6516";
    const TOKEN = "c3aca7ce6f8d81861f4213c116cd94ed";
    const ACCESS_TOKEN = 'CAACEdEose0cBAFZC99yIEZA6oJyz0QGgu95JYZAqcmVIl8warmNCBsfqwOTw60LaPJNHlhDzOR4jd4dUtvZA8YrXXTpvkYVjQU3xzenQZC5zOX9YtMB2nbJtup43o7RQD2CZB6XMO2IIPAI3lYmAGBBPMLM1W8sQNsOqpOnsXsvL0hBRDVNBCVZAwnA2qnx6a4YKqjVo5YCKAeRqq21vb6W';
    const FACEBOOK_ID = '178008815547857';


    /**
     * @test
     */
    public function get1Posts()
    {
        $facebookProvider = new FacebookProvider(self::FACEBOOK_ID, self::ACCESS_TOKEN);
        $this->assertEquals(1, count($facebookProvider->getPosts(1)->getMessages()));
    }

    /**
     * @test
     */
    public function get2Posts()
    {
        $facebookProvider = new FacebookProvider(self::FACEBOOK_ID, self::ACCESS_TOKEN);
        $this->assertEquals(2, count($facebookProvider->getPosts(2)->getMessages()));
    }

    public function notify()
    {

    }

}