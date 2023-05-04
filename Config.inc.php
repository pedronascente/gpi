<?php
date_default_timezone_set('America/Sao_Paulo');
//  senha zenvia : $humanMultipleSend = new HumanMultipleSend("volpatoapipos", "bmHvfLRFlr");           
/*
 * **************************************************
 * ******** CONFIGURAÇOES DA BASE DE DADOS **********
 * **************************************************
 */
define("HOST", "localhost");
define("USER", "root");
define("MEDIAS", '/_MIDIAS_');

define("_DESTINO_MIDIAS_", "../../../../../_MIDIAS_/anexosContrato/clientes/");

define("_BUSCAR_MIDIAS_LOCAL_", "/_MIDIAS_/anexosContrato/clientes/");

if ($_SERVER['SERVER_NAME'] == 'localhost') :
    define("PASS", "rooooot");
    define("DBSA", "volpato_novo");
else :
    define("PASS", "@g@pi.@v@olpato.911");
    define("DBSA", "volpato_novo");
endif;

$protocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false) ? 'http' : 'https';
$host = $_SERVER['HTTP_HOST'];
define("BASE_URL", $protocolo . '://' . $host);

define('MAIL_CHARSET', 'UTF-8');
define('MAIL_SMTPAUTH', true);
define('MAIL_SMTPSECURE', 'ssl');
define('MAIL_HOST', 'smtp.seguidor.com.br');
define('MAIL_PORT', 587);
define('MAIL_USER_NAME', "seguidor@seguidor.com.br");
define('MAIL_PASSWORD', '33jps666');



/*
 * ****************************************
 * ******** AUTO LOAD DE CLASSES **********
 * ****************************************
 */

define('DIRETORIO', 'application/models/');
define('MODULO_RAMAL', 'modulos/ramal/');
define('MODULO_USUARIO', 'modulos/usuarios/');
define('MODULO_SAC', 'modulos/sac/');
define('MODULO_PEDIDO_COMISSAO', 'modulos/pedidoComissao/');
define('MODULO_CAPTACAO', 'modulos/captacao/');
define('MODULO_PORTARIA', 'modulos/portaria/');
define('MODULO_DESENVOLVIMENTO', 'modulos/desenvolvimento/');
define('MODULO_ARQUIVO', 'modulos/arquivo/');
define('MODULO_CLIENTE', 'modulos/clientes/');
define('MODULO_COMPRAS', 'modulos/compras/');
define('MODULO_MONITORAMENTO', 'modulos/monitoramento/');
define('MODULO_CERTIFICADOS', 'modulos/certificados/');
define('MODULO_SESMT', 'modulos/sesmt/');



function __autoload($class)
{
    //function spl_autoload_register($class){

    $cDir = array(
        DIRETORIO . 'Conn',
        DIRETORIO . 'ConnASC',
        DIRETORIO . 'classes',
        DIRETORIO . 'classes/paginacao',
        DIRETORIO . 'classes/phpmailer',
        MODULO_RAMAL . 'src/models/classes',
        MODULO_USUARIO . 'src/models/classes',
        MODULO_SAC . 'src/models/classes',
        MODULO_PEDIDO_COMISSAO . 'src/models/classes',
        MODULO_CAPTACAO . 'src/models/classes',
        MODULO_PORTARIA . 'src/models/classes',
        MODULO_CLIENTE . 'src/models/classes',
        MODULO_COMPRAS . 'src/models/classes',
        MODULO_DESENVOLVIMENTO . 'src/models/classes',
        MODULO_ARQUIVO . 'src/models/classes',
        MODULO_MONITORAMENTO . 'src/models/classes',
        MODULO_CERTIFICADOS . 'src/models/classes',
        MODULO_SESMT . 'src/models/classes',

    );

    $iDir = null;
    foreach ($cDir as $dirName) :
        if (!$iDir && file_exists(__DIR__ . "\\{$dirName}\\{$class}.class.php") && !is_dir(__DIR__ . "\\{$dirName}\\{$class}.class.php")) :
            // var_dump(__DIR__."\\{$dirName}\\{$class}.class.php");
            include_once(__DIR__ . "\\{$dirName}\\{$class}.class.php");
            $iDir = true;
        endif;
    endforeach;

    if (!$iDir) :
        trigger_error("Não foi possivel incluir {$class}.class.php", E_USER_ERROR);
        die();
    endif;
}

/*
 * ************************************************************
 * ******** WSErro :: Exibe erros lançados :: Front **********
 * ************************************************************
 */
function WSErro($ErrMsg, $ErrNo, $ErrDie = null)
{
    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));
    echo "<p class=\"trigger {$CssClass}\">{$ErrMsg}<span class=\"ajax_close\"></span></p>";
    if ($ErrDie) :
        die();
    endif;
}

/*
 * ***********************************************************
 * ******** PHPErro :: personaliza o gatilho do PHP **********
 * ***********************************************************
 */
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine)
{
    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));
    echo "<p class =\"trigger {$CssClass}\">";
    echo "<b>Erro na Linha: #{$ErrLine} :: </b>  {$ErrMsg} <br>";
    echo "<small>{$ErrFile}</small>";
    echo "<span class=\"ajax_close\"></span></p>";
    if ($ErrNo == E_USER_ERROR) :
        die();
    endif;
}

define("WS_ACCEPT", "accept");
define("WS_INFOR", "infor");
define("WS_ALERT", "alert");
define("WS_ERROR", "error");

/*
 **********************************
 ********* DEBUGAR ERROS **********
 **********************************
*/
set_error_handler('PHPErro');
ini_set('xdebug.var_display_max_data', 3000000);
