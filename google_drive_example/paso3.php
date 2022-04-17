<?php

require_once 'config.php';

if (!empty($_SESSION['upload_token'])) {
    $client->setAccessToken($_SESSION['upload_token']);
    if ($client->isAccessTokenExpired()) {
        unset($_SESSION['upload_token']);
        echo 'La sesion expiro. <a href="paso1.php">Volver a comenzar</a>';
        die;
    }
}
echo 'Autenticacion completa <a href="paso4.php">Descargar archivo</a>';
