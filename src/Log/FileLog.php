<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 16/06/15
 * Time: 11:36
 */

namespace DataAggregator\Log;


class FileLog implements LogInterface
{
    public static $format = 'Y-m-d H:i:s';

    private $path;
    private $handler;
    private static $logger = null;

    /**
     * {@inheritdoc}
     */
    public static function init($path)
    {
        if (null === self::$logger) {
            self::$logger = new static($path);
        }
        return self::$logger;
    }

    /**
     * @param $path
     */
    private function __construct($path)
    {
        $this->path = $path;
        $this->openFile();
    }

    /**
     * Opens a file.
     */
    private function openFile()
    {
        $this->handler = fopen($this->path, 'a+');
    }

    /**
     * {@inheritdoc}
     */
    public function add($type, $message, \DateTime $date = null)
    {
        if (!$date) {
            $date = new \DateTime();
        }

        $line = sprintf("[%s] %s | %s", $type, $date->format(self::$format), $message) . PHP_EOL;
        fwrite($this->handler, $line);
    }

    /**
     * Resets a FileLog instance.
     */
    public static function reset()
    {
        self::$logger = null;
    }

    public function __destruct()
    {
        fclose($this->handler);
    }


}