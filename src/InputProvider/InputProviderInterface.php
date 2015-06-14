<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 14/06/15
 * Time: 21:24
 */

namespace DataAggregator\InputProvider;

/**
 * Interface InputProviderInterface
 * @package DataAggregator\InputProvider
 */
interface InputProviderInterface
{
    /**
     * Loads contact data from InputProvider objects.
     *
     * @return \Generator
     */
    public function load();
}