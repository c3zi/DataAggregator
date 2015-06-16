<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 16/06/15
 * Time: 11:34
 */

namespace DataAggregator\Log;


interface LogInterface
{
    const ERROR = 'error';
    const WARNING = 'warning';
    const INFO = 'info';

    /**
     * Initializes logger instance. Mostly it will be responsible for creating a handler.
     *
     * @param $path
     * @return mixed
     */
    public static function init($path);

    /**
     * Adds message to a logger.
     *
     * @param $type
     * @param $message
     * @param \DateTime|null $date
     * @return mixed
     */
    public function add($type, $message, \DateTime $date = null);
}