<?php
require_once('Database.php');
require_once('FilesData.php');
class FilesDataSet
{

    protected $_dbHandle, $_dbInstance;
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function fetchAllConversations(){
        $sqlQuery = 'select * from files';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new FilesData($row);
        }
        return $dataSet;
    }

    public function getFilePath($chat){
        $sqlQuery = 'select * from files where chat = ?';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1,$chat);
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new FilesData($row);
        }
        return $dataSet;
    }

    public function  addFilePath($chat,$filepath){
        $sqlQuery = 'insert into files (chat, filepath) values (?,?);';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1,$chat);
        $statement->bindParam(2,$filepath);

        $statement->execute(); // execute the PDO statement

        return $statement->rowCount();
    }
}