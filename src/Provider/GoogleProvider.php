<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 14/06/15
 * Time: 17:00
 */

namespace DataAggregator\Provider;


class GoogleProvider implements ProviderInterface
{
    public function getPosts($limit = 10)
    {
        $results = [];
        for ($i = 0; $i < $limit; $i++) {
            $results[] = $i;
        }
        return $results;
    }

}