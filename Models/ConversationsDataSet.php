<?php
require_once('Database.php');
require_once('Conversations.php');
class ConversationsDataSet
{
    protected $_dbHandle, $_dbInstance;
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function fetchAllConversations(){
        $sqlQuery = 'select * from conversations';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new Conversations($row);
        }
        return $dataSet;
    }

    public function storeConversation($prompt,$response, $typeOfChat){
        $sqlQuery = 'insert into conversations (prompt, response, typeOfChat) values (?,?,?);';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1,$prompt);
        $statement->bindParam(2,$response);
        $statement->bindParam(3, $typeOfChat);
        $statement->execute(); // execute the PDO statement

        return $statement->rowCount();

    }

    public function getConversation($diffChat){
        $sqlQuery = 'SELECT * FROM conversations WHERE (typeOfCaht = ?) ';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1,$diffChat);
        $statement->execute();

        $dataSet = [];
        while ($row = $statement->fetch()){
            $dataSet[] = new DifferentChatsData($row);
        }
        return $dataSet;
    }
}