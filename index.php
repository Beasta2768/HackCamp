<?php
// Includes Classes
require_once('Models/ConversationsDataSet.php');
require_once ('Models/DifferentChatsDataSet.php');
// Initialises variables
$view = new stdClass();
$view->pageTitle = 'Home Page';
// Initialises cURL resource handle
$ch = curl_init();

// Creates new Instances of the two included Classes
$conversations = new ConversationsDataSet();
$newChat = new differentChatsDataSet();
// Fetches all Conversations and Chats using the Methods from the included Classes
// Retrieved data is then stored in corresponding $view
$view->conversations = $conversations->fetchAllConversations();
$view->chats = $newChat->fetchAllChats();
$view->callError = null; // Makes an error check to be called in the front end
$view->time = new DateTime(); // Creates new time Object

if (isset($_POST['submit'])) {
    // Creates a time Object to make a time stamp
    $timeStamp=time();
    $dateTime = new DateTime();
    $dateTime->setTimestamp($timeStamp);
    // Echo $timeStamp. '<br>';

    // Makes time stamp into a 24-hour clock style time
    $dateTime->setTimezone(new DateTimeZone('UTC')); //limited to UTC
    $format = $dateTime->format('H:i');

    // Sets time to the $view
    $view->time = $format;
    // echo($view->time);

    $prompt = str_replace(" ","%20",htmlentities($_POST['chatMsg']));

    // Calls the public api from the url given
    curl_setopt($ch, CURLOPT_URL, "http://realmheart.pythonanywhere.com/?prompt=".$prompt);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $curl_data = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($curl_data);

    // If the response is set it will store the conversations to the database
    if(isset($response)){
        $conversations->storeConversation(htmlentities($_POST['chatMsg']),$response->response, 1,$view->time);

        /*Set the view conversations to get all the conversations from the database
        * for the user to be able to see all the conversations that are stored in the database
        */
        $view->conversations = $conversations->fetchAllConversations();

    // Error response
    } else{
        $view->callError = $response->error;
    }
}
// New chat created and updated by fetching all chats
if(isset($_POST['newChat'])){
    $newChat->createChat(htmlentities($_POST['newConversationName']));
    $view->chats = $newChat->fetchAllChats();
}
require_once('Views/index.phtml');