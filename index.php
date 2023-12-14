<?php
require_once('Models/ConversationsDataSet.php');
require_once ('Models/DifferentChatsDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Home Page';

$ch = curl_init();



$conversations = new ConversationsDataSet();
$newChat = new differentChatsDataSet();

$view->conversations = $conversations->fetchAllConversations();
$view->chats = $newChat->fetchAllChats();
$view->callError = null; // makes an error check to be called in the front end
$view->time = new DateTime(); // creates new time object

if (isset($_POST['submit'])) {
    // creates a time object to make a time stamp
    $timeStamp=time();
    $dateTime = new DateTime();
    $dateTime->setTimestamp($timeStamp);
//    echo $timeStamp. '<br>';

    //makes time stamp into a 24-hour clock style time
    $dateTime->setTimezone(new DateTimeZone('UTC')); //limited to UTC
    $format = $dateTime->format('H:i');

    //sets time to the view
    $view->time = $format;
//    echo($view->time);

    $prompt = str_replace(" ","%20",htmlentities($_POST['chatMsg']));

    //calls the public api from the url given
    curl_setopt($ch, CURLOPT_URL, "http://realmheart.pythonanywhere.com/?prompt=".$prompt);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $curl_data = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($curl_data);

    //if the response is set it will store the conversions to the database
    if(isset($response)){
    $conversations->storeConversation(htmlentities($_POST['chatMsg']),$response->response, 1,$view->time);

    /*set the view conversations to get all the conversation from the database
    *for the user to be able to see all the conversations that are stored in the data abase
    */
    $view->conversations = $conversations->fetchAllConversations();


    } else{
        $view->callError = $response->error;
    }

}

if(isset($_POST['newChat'])){
    $newChat->createChat(htmlentities($_POST['newConversationName']));
    $view->chats = $newChat->fetchAllChats();
}

require_once('Views/index.phtml');