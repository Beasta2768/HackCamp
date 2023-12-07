<?php

$view = new stdClass();
$view->pageTitle = 'Home Page';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:5000/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$curl_data = curl_exec($ch);
curl_close($ch);

$response = json_decode($curl_data);

$view->aiResponse = $response->response;

require_once('Views/index.phtml');
