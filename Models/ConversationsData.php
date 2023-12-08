<?php

class ConversationsData {
    protected $key, $prompt, $response;

    public function __construct($dbRow) {
        $this->key = $dbRow['key'];
        $this->prompt = $dbRow['prompt'];
        $this->response = $dbRow['response'];

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
}