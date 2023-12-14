<?php
/**
 * Class Database
 *
 * Represents the Connection to the Database.
 */
class Database
{
    /**
     * @var Database The instance of the Database.
     */
    protected static $_dbInstance = null;

    /**
     * @var PDO The PDO database connection handle.
     */
    protected $_dbHandle;

    /**
     * Get an instance of the Database class.
     *
     * @return Database Returns instance of the Database class.
     */
    public static function getInstance()
    {
        $host = 'poseidon.salford.ac.uk';
        $dbName = 'hc23_16';
        $username = 'hc23-16';
        $password = 'rEjEBVlTJeO606X';

        if (self::$_dbInstance === null) { // Checks if the PDO exists
            // creates new instance if not, sending in connection info.
            self::$_dbInstance = new self($username, $password, $host, $dbName);
        }
        // Returns the instance of the Database class.
        return self::$_dbInstance;
    }

    /**
     * Database Connection information:
     * @param $username
     * @param $password
     * @param $host
     * @param $database
     */
    private function __construct($username, $password, $host, $database)
    {
        try {
            $this->_dbHandle = new PDO("mysql:host=$host;dbname=$database", $username, $password); // creates the database handle with connection info
            //  $this->_dbHandle = new PDO('mysql:host=' . $host . ';dbname=' . $database,  $username, $password); // creates the database handle with connection info

        } catch (PDOException $e) { // catch any failure to connect to the database
            echo $e->getMessage();
        }
    }

    /**
     * Get the PDO database connection handle.
     *
     * @return PDO Returns the PDO handle to be used elsewhere.
     */
    public function getdbConnection()
    {
        return $this->_dbHandle;
    }

    /**
     * Destructor method to destroy the PDO handle when no longer needed.
     */
    public function __destruct()
    {
        $this->_dbHandle = null;
    }
}
