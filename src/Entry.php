<?php
/**
 * Created by PhpStorm.
 * User: c3zi
 * Date: 14/06/15
 * Time: 16:28
 */

namespace DataAggregator;


class Entry
{
    private $id;
    private $messages = [];
    private $exceptions = [];

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function addMessage($messageId, $messageContent)
    {
        $this->messages[] = new Message($messageId, $messageContent);
    }

    public function addException($exception)
    {
        $this->exceptions[] = $exception;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function getExceptions()
    {
        return $this->exceptions;
    }
}