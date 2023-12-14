<?php
// Includes necessary Classes
require_once('Database.php');
require_once('Conversations.php');
/**
 * Class ConversationsDataSet
 *
 * Represents a dataset containing conversations.
 */
class ConversationsDataSet
{
    /**
     * @var PDO The PDO database connection handle.
     */
    protected $_dbHandle, $_dbInstance;

    /**
     * ConversationsDataSet constructor.
     *
     * Initialises the database instance and connection handle.
     */
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * Fetches all conversations from the database.
     *
     * @return array An array of Conversations objects.
     */
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

    /**
     * Stores a new conversation in the database.
     *
     * @param string $prompt The prompt of the conversation.
     * @param string $response The response of the conversation.
     * @param int $typeOfChat The type of chat.
     * @param string $time The timestamp of the conversation.
     * @return int The number of affected rows.
     */
    public function storeConversation($prompt,$response, $typeOfChat, $time){
        $sqlQuery = 'insert into conversations (prompt, response, typeOfChat, timeSent) values (?,?,?,?);';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1,$prompt);
        $statement->bindParam(2,$response);
        $statement->bindParam(3, $typeOfChat);
        $statement->bindParam(4, $time);
        $statement->execute(); // execute the PDO statement

        return $statement->rowCount();

    }

    /**
     * Gets conversations depending on the type of chat.
     *
     * @param int $diffChat The type of chat.
     * @return array An array of DifferentChatsData objects.
     */
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