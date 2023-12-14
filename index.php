<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
$view->fileError = null;
$view->fileErrorMessage = "";
$view->fileUploaded = false;

$view->time = new DateTime(); // creates new time object
$view->chatCreationError = false;

if($_FILES){
    $target_dir = "Uploads/";
    $target_file = $target_dir . basename($_FILES["myFile"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
}

if (isset($_POST["submit"])) {

    // creates a time object to make a time stamp
    $timeStamp=time();
    $dateTime = new DateTime();
    $dateTime->setTimestamp($timeStamp);
    //echo $timeStamp. '<br>';

    //makes time stamp into a 24-hour clock style time
    $dateTime->setTimezone(new DateTimeZone('UTC')); //limited to UTC
    $format = $dateTime->format('H:i');

    $prompt = str_replace(" ","%20",htmlentities($_POST['chatMsg']));
    //sets time to the view
    $view->time = $format;
    if($_FILES AND $_FILES['myFile']['name']> 0){
        $check = gettype($_FILES["myFile"]["tmp_name"]);
//id the file already exists it will override the current file to change it to th new one
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["myFile"]["size"] > 500000) {
            $view->fileError = "File Size";
            $view->fileErrorMessage=  "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "csv" && $imageFileType != "xlsx") {
            $view->fileError =  "File Type";
            $view->fileErrorMessage = "Sorry, only CSV & XLSX files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk != 0) {
            $fileUpload = move_uploaded_file($_FILES["myFile"]["tmp_name"], $target_file);
            if ($fileUpload) {
                echo "The file " . htmlspecialchars(basename($_FILES["myFile"]["name"])) . " has been uploaded.";
                //calls the public api from the url given
                $view->fileUploaded = true;
            } else {
                $view->fileError = "File Upload";
                $view->fileErrorMessage = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        //calls the public api from the url given
        curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:5000/?prompt=".$prompt);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        $curl_data = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($curl_data);

        //if the response is set it will store the conversions to the database
        if(isset($response->response)){

            $conversations->storeConversation(htmlentities($_POST['chatMsg']),$response->response, 1,$view->time);

            /*set the view conversations to get all the conversation from the database
            *for the user to be able to see all the conversations that are stored in the data abase
            */
            $view->conversations = $conversations->fetchAllConversations();

            //displays error to the front end it there is an error occurs
        } else{
//        var_dump($response);
            $view->callError = $response->error;
        }
    }
}

if($view->fileUploaded){
    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:5000/?prompt=".$prompt."&file=http://localhost:8008/".$target_file);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


    $curl_data = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($curl_data);


    //if the response is set it will store the conversions to the database
    if(isset($response->response)){

        $conversations->storeConversation(htmlentities($_POST['chatMsg']),$response->response, 1,$view->time);

        /*set the view conversations to get all the conversation from the database
        *for the user to be able to see all the conversations that are stored in the data abase
        */
        $view->conversations = $conversations->fetchAllConversations();

        //displays error to the front end it there is an error occurs
    } else{
        $view->callError = $response->error;
    }

}


if(isset($_POST['newChat'])){
    $view->chatCreationError = $newChat->createChat(htmlentities($_POST['newConversationName']));
    if ($view->chatCreationError){
        $view->chats = $newChat->fetchAllChats();
    }
    var_dump($view->chatCreationError);
}

require_once('Views/index.phtml');