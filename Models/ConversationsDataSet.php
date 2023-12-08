<?php
require_once ('Models/Database.php');
require_once ('Models/ConversationsData.php');
class ConversationsDataSet {
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function fetchAllStudents() {
        $sqlQuery = 'SELECT * FROM conversations';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new ConversationsData($row);
        }
        return $dataSet;
    }
}