<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 16/06/15
 * Time: 14:08
 */

namespace DataAggregator\Report;

use DataAggregator\Entry;

class TextReport implements ReportInterface
{
    private $path;

    /**
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Saves report to a file.
     *
     * @param Entry $entry
     * @throws ReportException
     */
    public function save(Entry $entry)
    {
        $content = sprintf("User: %s", $entry->getId());

        $messages = $this->createMessageReport($entry->getMessages());
        $exceptions = $this->createExceptionReport($entry->getExceptions());

        $content .= PHP_EOL . $messages . PHP_EOL . $exceptions;

        $this->saveToFile($content);
    }

    /**
     * Creates report's content for messages.
     *
     * @param array $messages
     * @return string
     */
    private function createMessageReport(array $messages)
    {
        $content = PHP_EOL . 'CONTENT: ' . PHP_EOL;
        $content .= PHP_EOL . 'FEED COUNT: ' . count($messages) . PHP_EOL;

        /** @var \DataAggregator\Message[] $messages */
        foreach ($messages as $message) {
            $content .= 'ID: ' . $message->getId() . PHP_EOL;
            $content .= 'FEED: ' . $message->getContent() . PHP_EOL;
            $content .= PHP_EOL . PHP_EOL;
        }

        return $content;
    }

    /**
     * Creates report's content for exceptions.
     *
     * @param array $exceptions
     * @return string
     */
    private function createExceptionReport(array $exceptions)
    {
        $content = PHP_EOL . 'EXCEPTIONS: ' . PHP_EOL;

        foreach ($exceptions as $exception) {
            $content .= '  --- ' . $exception . PHP_EOL;
            $content .= PHP_EOL . PHP_EOL;
        }

        return $content;
    }

    private function saveToFile($content)
    {
        if (false === file_put_contents($this->path, $content)) {
            throw new ReportException('Report has not been saved correctly.');
        }
    }

}