<?php
/**
 * Class differentChatsData
 *
 * Represents a Class containing the data from Other Chats.
 */
class differentChatsData
{
    /**
     * @var mixed Stores the differentChatsData properties.
     */
    protected $id, $chat;

    /**
     * dataChatsData constructor.
     *
     * @param $dbRow
     *
     * Initialises properties with a parameter of $dbRow.
     */
    public function __construct($dbRow) {
        $this->id = $dbRow['id'];
        $this->chat = $dbRow['chat'];
    }

    /**
     * Get the id stored in the database.
     *
     * @return mixed The ID of the conversation.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the Chat stored in the database.
     *
     * @return mixed The Chats of the conversation.
     */
    public function getChat()
    {
        return $this->chat;
    }
}