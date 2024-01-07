<?php
require_once('Models/ConversationsDataSet.php');
require_once ('Models/DifferentChatsDataSet.php');
require_once('Models/FileHandling.php');
require_once('Models/FilesDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Home Page';





$conversations = new ConversationsDataSet();
$newChat = new differentChatsDataSet();

$view->conversations = $conversations->fetchAllConversations();
$view->chats = $newChat->fetchAllChats();
$view->callError = null; // makes an error check to be called in the front end
$view->fileError = null;
$view->fileErrorMessage = "";
$view->fileUploaded = false;
$view->filePath = null;


$view->files = new FilesDataSet();
if (isset($view->files->getFilePath(1)[0])){
$view->fileName = substr($view->files->getFilePath(1)[0]->getFilepath(),8);
}
$view->time = new DateTime(); // creates new time object
$view->chatCreationError = false;



if(isset($_POST["Upload"])){
    $target_dir = "Uploads/";
    $target_file = $target_dir . basename($_FILES["myFile"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $fileHandle = new FileHandling();

    if($_FILES AND $_FILES['myFile']['name']> 0){
        $fileHandle->uploadFile($target_file,$imageFileType);
        if ($fileHandle->getFileError()){
            $view->fileError = $fileHandle->getFileError();
            $view->fileErrorMessage = $fileHandle->getFileErrorMessage();
        } else {
            $view->fileUploaded = true;

            $view->files->removeFilePath(1);
            $view->files->addFilePath(1,$fileHandle->getTargetFile());
            $view->fileName = substr($view->files->getFilePath(1)[0]->getFilepath(),8);
        }
    }

}

if (isset($_POST["submit"])) {

    // creates a time object to make a time stamp
    $timeStamp=time();
    $dateTime = new DateTime();
    $dateTime->setTimestamp($timeStamp);

    $prompt = str_replace(" ","%20",htmlentities($_POST['chatMsg']));

    //makes time stamp into a 24-hour clock style time
    $dateTime->setTimezone(new DateTimeZone('UTC')); //limited to UTC
    $format = $dateTime->format('H:i');


    //sets time to the view
    $view->time = $format;



    $view->filePath = $view->files->getFilePath(1)[0]->getFilePath();
    if(isset($view->filePath)){
        if(file_exists($view->filePath)){
            $ch = curl_init();
            $dataFile = curl_file_create($view->filePath);
            $post = array('data_file'=> $dataFile);
            curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:5000/upload?prompt=".$prompt);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$post);

            $curl_data = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($curl_data);
        }
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
    } else {
        //calls the public api from the url given
        $ch = curl_init();
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
            $view->callError = $response->error;
        }
    }}

if(isset($_POST['newChat'])){
    $view->chatCreationError = $newChat->createChat(htmlentities($_POST['newConversationName']));
    if ($view->chatCreationError){
        $view->chats = $newChat->fetchAllChats();
    }
    var_dump($view->chatCreationError);
}

require_once('Views/index.phtml');