<?php

class differentChatsData {
    protected $id, $chat;

    public function __construct($dbRow) {
        $this->id = $dbRow['id'];
        $this->chat = $dbRow['chat'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getChat()
    {
        return $this->chat;
    }
}