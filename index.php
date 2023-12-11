<?php
$view = new stdClass();
$view->pageTitle = 'Intelligent Minds';

$view->count=0;
$view->chatMsg = array();

if (isset($_POST['Submit'])) {
    array_push($view->chatMsg,htmlentities($_POST['chatMsg']));
    echo $_POST['chatMsg'];
}
require_once('Views/index.phtml');