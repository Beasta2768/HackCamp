<?php
$view = new stdClass();
$view->pageTitle = 'Intelligent Minds';

$view->count=0;
$view->chatMsg = array("First Message","Second Message");

if (isset($_POST['chatSnd'])) {
    array_push($view->chatMsg,htmlentities($_POST['chatMsg']));
}
require_once('Views/index.phtml');