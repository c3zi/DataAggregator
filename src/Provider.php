<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 14/06/15
 * Time: 17:02
 */

namespace DataAggregator;

use DataAggregator\Provider\FacebookProvider;
use DataAggregator\Provider\GoogleProvider;
use DataAggregator\ProviderException;

class Provider
{
    const FACEBOOK = 'facebook';
    const GOOGLE = 'google';

    /**
     * Returns a certain provider.
     *
     * @param $type
     * @param array $config
     * @return FacebookProvider|GoogleProvider
     * @throws \DataAggregator\ProviderException
     */
    public static function factory($type, array $config)
    {
        if (!self::validateConfig($type, $config)) {
            throw new ProviderException('Bad configuration.');
        }

        if ($type === self::FACEBOOK) {
            return new FacebookProvider($config['facebook']['facebook_id'], $config['facebook']['access_token']);
        }

        if ($type === self::GOOGLE) {
            return new GoogleProvider($config['google']['google_id'], $config['google']['access_token']);
        }
    }

    /**
     * Validates configuration.
     *
     * @param $type
     * @param array $config
     * @return bool
     */
    public static function validateConfig($type, array $config)
    {
        return true;
    }
}