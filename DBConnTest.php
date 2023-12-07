<?php
echo "<h1>mySQL DB connection test</h1>";
$host = 'poseidon.salford.ac.uk';
$dbName = 'hc23_16';
$user = 'hc23-16';
$pass = 'rEjEBVlTJeO606X';
$dbHandle = new PDO("mysql:host=$host;dbname=$dbName",$user,$pass);

$sqlQuery = 'SELECT * FROM conversations'; // put your students table name

echo $sqlQuery;  //helpful for debugging to see what SQL query has been created

$statement = $dbHandle->prepare($sqlQuery); // prepare PDO statement
$statement->execute();   // execute the PDO statement

echo "<table>";
while ($row = $statement->fetch()) {
    echo "<tr><td>" . $row[0] ."</td><td>". $row[1] . "</td><td>" . $row[2];
}

echo "</table>";
$dbHandle = null;
