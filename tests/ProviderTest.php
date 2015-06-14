<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 14/06/15
 * Time: 17:06
 */

namespace DataAggregator\Test;

use DataAggregator\Provider;

class ProviderTest extends \PHPUnit_Framework_TestCase
{
    const ACCESS_TOKEN = 'CAACEdEose0cBAOEGnJBZCrHxrQ86F8UjZBlNF76luaBr78EjYuVKp7wUjGvPHZCHZCNcYuQNwcrCgaEtETzIGzivVVabW9AIT6Kgv9ZCkCEChOysbiejuK7FU8Y4ZBtxLRZBQx49iNgokEpvuiDn9VhT9Hg4MyuTwPKgWx5eQv545GvjDGL3tninE3ScHaviIbKeZBOZC0glavU425MuqmDZCT';
    const FACEBOOK_ID = '178008815547857';

    /**
     * @test
     */
    public function factoryFacebook()
    {
        $config = [
            'facebook' => [
                'facebook_id' => self::FACEBOOK_ID,
                'access_token' => self::ACCESS_TOKEN
            ]
        ];
        $this->assertInstanceOf('DataAggregator\Provider\FacebookProvider', Provider::factory('facebook', $config));
    }

}