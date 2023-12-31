<?php
require_once('Models/Database.php');
require_once ('Models/DifferentChatsData.php');
class DifferentChatsDataSet {
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function fetchAllChats() {
        $sqlQuery = 'SELECT * FROM different_chats order by id';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement

        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DifferentChatsData($row);
        }
        return $dataSet;


    }

    public function createChat($chatName){
        $sqlQuery = 'insert into different_chats (chat) values (?)';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1,$chatName);

        try {
        $statement->execute();
        } catch (Exception  $ex){
            return false;
        }

        return true;
    }


}