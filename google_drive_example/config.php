<?php
require_once 'vendor/autoload.php';
session_start();
$redirect_uri = 'http://localhost:8080/api-youtube/redirect.php';
$client = new Google_Client();
$client->setAuthConfig('json/client_secret.json');
$client->setRedirectUri($redirect_uri);
$client->addScope("https://www.googleapis.com/auth/drive");
