<?php
/**
 * Class Conversations
 *
 * Represents a Class containing Conversations made up of various components.
 */
class Conversations
{
    /**
     * @var mixed Stores the conversation properties.
     */
    protected $key,$prompt,$response,$timeSent;

    /**
     * Conversations constructor.
     *
     * @param $dbRow
     *
     * Initialises  properties with a parameter of $dbRow.
     */
    public function __construct($dbRow)
    {
        $this->key = $dbRow['key'];
        $this->prompt = $dbRow['prompt'];
        $this->response = $dbRow['response'];
        $this->timeSent = $dbRow['timeSent'];
    }

    /**
     * Get the key stored in the database.
     *
     * @return mixed The key of the conversation.
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Get the prompt stored the database.
     *
     * @return mixed The prompt of the conversation.
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * Get the response from OpenAI stored in the database.
     *
     * @return mixed The response for the prompt in the conversation.
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get the time the prompt was sent from the database.
     *
     * @return mixed The Time Sent of the conversation prompt.
     */
    public function getTimeSent(): mixed
    {
        return $this->timeSent;
    }
}