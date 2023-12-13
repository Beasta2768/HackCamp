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
$view->callError = false;

if (isset($_POST['submit'])) {
    sleep(2);
/*    $prompt = str_replace(" ","%20",htmlentities($_POST['chatMsg']));

    curl_setopt($ch, CURLOPT_URL, "http://realmheart.pythonanywhere.com/?prompt=".$prompt);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $curl_data = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($curl_data);

    if(isset($response)){
    $conversations->storeConversation(htmlentities($_POST['chatMsg']),$response->response, 1);
    $view->conversations = $conversations->fetchAllConversations();
    } else{
        $view->callError = true;
    }*/
}

if(isset($_POST['newChat'])){
    $newChat->createChat(htmlentities($_POST['newConversationName']));
    $view->chats = $newChat->fetchAllChats();
}

require_once('Views/index.phtml');