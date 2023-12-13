<?php

class Conversations
{
    protected $key,$prompt,$response,$timeSent;

    public function __construct($dbRow)
    {
        $this->key = $dbRow['key'];
        $this->prompt = $dbRow['prompt'];
        $this->response = $dbRow['response'];
        $this->timeSent = $dbRow['timeSent'];
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    public function getTimeSent(): mixed
    {
        return $this->timeSent;
    }
}