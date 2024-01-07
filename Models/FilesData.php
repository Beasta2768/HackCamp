<?php

class FilesData
{
    protected $id,$chat,$filepath;

    public function __construct($dbRow)
    {
        $this->id = $dbRow['id'];
        $this->chat =$dbRow['chat'];
        $this->filepath = $dbRow['filepath'];

    }

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getChat(): mixed
    {
        return $this->chat;
    }

    /**
     * @return mixed
     */
    public function getFilepath(): mixed
    {
        return $this->filepath;
    }


}