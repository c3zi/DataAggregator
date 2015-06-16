<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 14/06/15
 * Time: 15:20
 */

namespace DataAggregator;

class Message
{
    private $id;

    private $content;

    public function __construct($id, $content)
    {
        $this->id = $id;
        $this->content = $content;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContent()
    {
        return $this->content;
    }
}