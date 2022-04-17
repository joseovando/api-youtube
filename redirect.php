<?php
require_once 'config.php';
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);
    $_SESSION['upload_token'] = $token;
    header('Location: paso3.php');
}
