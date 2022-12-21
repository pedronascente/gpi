<?php

if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}
/*
 * -----------------------------------------------------------------------------
 * Responsavel por recuperrar um POST vindo do site do PagSeguro .
 * Parametros recuperados:
 * @ paramn string notificationType
 * @ paramn string notificationCode
 * ----------------------------------------------------------------------------- 
 */
include_once './application/model/Conn/Dadabase.php';
include_once './application/model/PagSeguro.class.php';
include_once './application/controller/SeguidorController.php';

?>