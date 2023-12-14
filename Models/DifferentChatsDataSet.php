<?php
// Includes necessary Classes
require_once('Models/Database.php');
require_once ('Models/DifferentChatsData.php');
/**
 * Class DifferentChatsDataSet
 *
 * Represents a dataset containing different chats.
 */
class DifferentChatsDataSet
{
    /**
     * @var PDO The PDO database connection handle.
     */
    protected $_dbHandle, $_dbInstance;

    /**
     * DifferentChatsDataSet constructor.
     *
     * Initialises the database instance and connection handle.
     */
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * Fetches all chats from the database.
     *
     * @return array An array of DifferentChatsData objects.
     */
    public function fetchAllChats() {
        $sqlQuery = 'SELECT * FROM different_chats';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DifferentChatsData($row);
        }
        return $dataSet;
    }

    /**
     * Creates a new chat and inserts it into the database.
     *
     * @param string $chatName The name of the new chat.
     * @return void
     */
    public function createChat($chatName){
        $sqlQuery = 'insert into different_chats (chat) values (?)';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1,$chatName);

        $statement->execute();

        $statement->rowCount();
    }
}