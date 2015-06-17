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
    const ACCESS_TOKEN = 'CAACEdEose0cBAHynLTyZAOGxOrFv92xzcQZAOW3PKY5OwEdnswbMSAhOwz5wZAYZANZC1H70XUfZAaWRZAkw0430A16dlFnDoyWusooUkeYMv96CK4rYVnE3ifPWSmFlbw4pnYbyXJ6F65YEWPPEaqMSSfqg5iHGxKSBGs5mn2CiegZCcniGFW9NzfNIGz6sWqIVFZCAQ54ZBmcVkeEaSfWC0ZA';
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