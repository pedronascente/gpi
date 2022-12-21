<?php

$totalpontos = 0;

set_time_limit(45);
require('conecta.php');
require('class.util.php');

$data = Util::DatePtToDateMysql($_POST['data']);
$hora = date('H:i:s');

if (isset($_POST['cliente'])) {
    $cliente = ' ';
}
if (isset($_POST['conta'])) {
    $conta = ' ';
}
session_name('volpato');
session_start();

//testando e setando valor 0 qndo variavel estiver null
if (!isset($_POST['zona1ouqualquer'])) {
    $_POST['zona1ouqualquer'] = 0;
}
if ($_POST['zona1ouqualquer'] == '1') {
    $totalpontos = $totalpontos + 20;
}
if ($_POST['zona1ouqualquer'] == '2') {
    $totalpontos = $totalpontos + 30;
}
if ($_POST['zona1ouqualquer'] == '3') {
    $totalpontos = $totalpontos + 10;
}
//testando variavel disparos
if (!isset($_POST['disparos'])) {
    $_POST['disparos'] = 0;
}
if ($_POST['disparos'] == '1') {
    $totalpontos = $totalpontos + 5;
}
if ($_POST['disparos'] == '2') {
    $totalpontos = $totalpontos + 15;
}
if ($_POST['disparos'] == '3') {
    $totalpontos = $totalpontos + 30;
}
//testando variavel zonas
if (!isset($_POST['zonas'])) {
    $_POST['zonas'] = 0;
}
if ($_POST['zonas'] == '1') {
    $totalpontos = $totalpontos + 10;
}
if ($_POST['zonas'] == '2') {
    $totalpontos = $totalpontos + 30;
}
if ($_POST['zonas'] == '3') {
    $totalpontos = $totalpontos + 50;
}
//testando variavel todaszonas
if (!isset($_POST['todaszonas'])) {
    $_POST['todaszonas'] = 0;
}
if ($_POST['todaszonas'] == '1') {
    $totalpontos = $totalpontos + 0;
}
if ($_POST['todaszonas'] == '2') {
    $totalpontos = $totalpontos + 50;
}
//testando variavel 30dias
if (!isset($_POST['30dias'])) {
    $_POST['30dias'] = 0;
}
if ($_POST['30dias'] == '1') {
    $totalpontos = $totalpontos - 9;
}
if ($_POST['30dias'] == '2') {
    $totalpontos = $totalpontos + 2;
}
//testando variavel temporal
if (!isset($_POST['temporal'])) {
    $_POST['temporal'] = 0;
}
if ($_POST['temporal'] == '1') {
    $totalpontos = $totalpontos - 14;
}
if ($_POST['temporal'] == '2') {
    $totalpontos = $totalpontos + 0;
}
//$hora ='02:00:00';
if (($hora >= '00:00:00')and ( $hora < '03:30:00')) {
    $totalpontos = $totalpontos + 24;
}
if (($hora >= '03:30:00')and ( $hora < '07:00:00')) {
    $totalpontos = $totalpontos + 14;
}
if (($hora >= '07:00:00')and ( $hora < '19:00:00')) {
    $totalpontos = $totalpontos + 0;
}
if (($hora >= '19:00:00')and ( $hora <= '23:59:59')) {
    $totalpontos = $totalpontos + 4;
}

$pontos = $totalpontos;

if ($totalpontos <= 49) {
    $text = 'N�o enviar viatura, grande possibilidade de disparo em falso';
}
if (($totalpontos >= 50)and ( $totalpontos <= 90)) {
    $text = 'Enviar viatura, possibilidade de intrus�o.';
}
if ($totalpontos > 90) {
    $text = 'Enviar viatura, h� intrus�o no local.';
}

$query = "INSERT INTO viaturas (
           conta,
		   zona1ouqualquer,
		   disparos,
		   zonas,
		   todaszonas,
		   30dias,
		   temporal,
		   data,
		   hora,
		   atendente,
		   pontos,
		   texto	  
		   )VALUES(
           '{$_POST['conta']}',
           '{$_POST['zona1ouqualquer']}',
           '{$_POST['disparos']}',
		   '{$_POST['zonas']}',
		   '{$_POST['todaszonas']}',
		   '{$_POST['30dias']}',
		   '{$_POST['temporal']}',
		   '$data',
	       '$hora',
	       '{$_POST['operador']}',
	       '$pontos',
	       '$text'
		   )";
if (!mysql_query($query, $conexao)) {
    Util::Redireciona('javascript:history.go(-1)');
    exit();
} else {
    if ($totalpontos <= 49) {
        Util::Mensagem("N�o enviar viatura, grande possibilidade de disparo em falso!");
    }
    if (($totalpontos >= 50)and ( $totalpontos <= 90)) {
        Util::Mensagem("Enviar viatura, possibilidade de intrus�o.");
    }
    if ($totalpontos > 90) {
        Util::Mensagem("Enviar viatura, h� intrus�o no local.");
    }
}
Util::Redireciona('javascript:history.go(-1)');
?>