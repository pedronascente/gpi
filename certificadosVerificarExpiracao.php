<?php
/**
 * Created by PhpStorm.
 * User: desenvolvimento02
 * Date: 09/11/2017
 * Time: 07:51
 */

$url = 'gpi/modulos/certificados/src/controllers/Certificados.php';
$data = array('acao' => 'verificarExpiracao','alertar' => 'true');

include_once 'application/models/classes/Funcoes.class.php';
echo Funcoes::enviarPost($url,$data);

