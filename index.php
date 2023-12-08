<?php
require_once('Models/ConversationsDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Home Page';

$ch = curl_init();


$conversations = new ConversationsDataSet();

$view->conversations = $conversations->fetchAllConversations();
$view->count = 0;

if (isset($_POST['chatSnd'])) {
    $prompt = str_replace(" ","%20",htmlentities($_POST['chatMsg']));

    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:5000/?prompt=".$prompt);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $curl_data = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($curl_data);

    $conversations->storeConversation(htmlentities($_POST['chatMsg']),$response->response);
    $view->conversations = $conversations->fetchAllConversations();
    echo $response->response;
}

require_once('Views/index.phtml');