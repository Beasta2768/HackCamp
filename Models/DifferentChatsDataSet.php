<?php
require_once('Models/Database.php');
require_once ('Models/DifferentChatsData.php');
class DifferentChatsDataSet {
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function fetchAllStudents() {
        $sqlQuery = 'SELECT * FROM different_chats';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DifferentChatsData($row);
        }
        return $dataSet;
    }
}