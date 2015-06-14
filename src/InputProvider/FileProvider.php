<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 14/06/15
 * Time: 21:24
 */

namespace DataAggregator\InputProvider;

/**
 * Class FileProvider
 * @package DataAggregator\InputProvider
 */
class FileProvider implements InputProviderInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->validateFile();
        $this->openFile();
    }

    /**
     * Validates if given file exists.
     *
     * @throws \InvalidArgumentException
     */
    private function validateFile()
    {
        if (!file_exists($this->path)) {
            throw new \InvalidArgumentException(sprintf("File %s does not exist.", $this->path));
        }
    }

    /**
     * Opens a file.
     */
    private function openFile()
    {
        $this->file = new \SplFileObject($this->path);
    }

    /**
     * Loads lines from the given file.
     *
     * @return \Generator
     */
    public function load()
    {
        foreach ($this->file as $line) {
            yield trim($line);
        }
    }

}