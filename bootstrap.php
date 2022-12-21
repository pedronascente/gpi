<?php

// Recuperar parametro da url
$pg = filter_input(INPUT_GET, 'pg', FILTER_DEFAULT);

// echo $pg;

define('PAG', filter_input(INPUT_GET, 'pag', FILTER_VALIDATE_INT));
define('PAGINA', filter_input(INPUT_GET, 'pg', FILTER_DEFAULT));

$caminho = $_SERVER ['SERVER_NAME'];
$caminho .= $_SERVER ['SERVER_NAME'] != 'localhost' ? ":81/" : '/';

$name = explode("\\", __DIR__);
$name = $name[sizeof($name) - 1];
//$name = $name == "www" ? "" : $name . "/";
$caminho .= $name;
$caminho = trim($caminho);

define('ROOT', __DIR__);
define('CAMINHOSITE', $caminho);
session_start();

$_SESSION['caminho_local'] 	= __DIR__;
$_SESSION['caminho_site'] 	= $caminho;

//START NA SESSÃO
@session_start();

define('_SERVER', 'http://' . $_SERVER ['SERVER_NAME'] . 'gp2');

//REGISTRA ERROS DA APLICAÇÃO 
 ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL ^ E_DEPRECATED);

//MAPEA AS PASTAS INTERNAS

set_include_path('.' . PATH_SEPARATOR . './'
        . PATH_SEPARATOR . 'application/controllers/'
        . PATH_SEPARATOR . 'application/views/'
        . PATH_SEPARATOR . 'application/views/layouts/'
        . PATH_SEPARATOR . 'application/models/'
        . PATH_SEPARATOR . 'application/models/classes/'
        . PATH_SEPARATOR . 'application/modulos/'
        . PATH_SEPARATOR . 'application/modulos/ramal/'
        . PATH_SEPARATOR . 'application/modulos/usuarios/'
        . PATH_SEPARATOR . 'application/modulos/sac/'
        . PATH_SEPARATOR . 'application/modulos/pedidoComissao/'
        . PATH_SEPARATOR . 'application/modulos/captacao/'
        . PATH_SEPARATOR . 'fpdf/dompdf/'
        . PATH_SEPARATOR . 'fpdf/help/'
        . PATH_SEPARATOR . 'fpdf/gerarOsSac/'
        . PATH_SEPARATOR . get_include_path()
);

/*
 * **************************************
 * ********* PEGA A URL ATUAL **********
 * **************************************
 */

function pegaUrlAtual() {
    $protocolo = (strpos(strtolower($_SERVER ['SERVER_PROTOCOL']), 'https') === false) ? 'http' : 'https';
    $host = $_SERVER ['HTTP_HOST'];
    $script = $_SERVER ['SCRIPT_NAME'];
    $parametros = $_SERVER ['QUERY_STRING'];
    $UrlAtual = $protocolo . '://' . $host . $script . '?' . $parametros;
    define('URL', $UrlAtual);
}

pegaUrlAtual();

/*
 * **************************************************************
 * ********* Verifica se existe um usuario autenticado **********
 * **************************************************************
 */

if (!isset($_SESSION ['user_info'] ['usuario'])) :
    session_destroy(); // Destrói a sessão por segurança.
    header('location: login.php');
    exit();
// Redireciona o visitante de volta pro login :
endif;

