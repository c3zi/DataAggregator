<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 14/06/15
 * Time: 14:23
 */

namespace DataAggregator\Provider;

/**
 * Interface ProviderInterface
 * @package DataAggregator\Provider
 */
interface ProviderInterface
{
    /**
     * Gets posts and returns \DataAggregator\Entry object.
     *
     * @param int $limit Limit data
     * @return \DataAggregator\Entry
     */
    public function getPosts($limit = 10);
}