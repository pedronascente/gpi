<?php

header('Content-Type: text/html; charset=utf-8');
include_once '../../../../Config.inc.php';

$dados = filter_input_array(INPUT_POST);
$conta = isset($dados['conta']) ? $dados['conta'] : null;
$operador = isset($dados['operador']) ? $dados['operador'] : null;
$hora = date("H:i:s");
$data = date("y-m-d");
$acao = isset($dados ['acao']) ? $dados ['acao'] : null;

$captacao = new Captacao();

unset($dados['conta'], $dados['operador'], $dados['hora'], $dados['data'], $dados['acao']);

if ($hora >= '00:00:00' && $hora < '03:30:00') {
    $pontos = $pontos + 24;
} else if ($hora >= '03:31:00' && $hora < '07:00:00') {
    $pontos = $pontos + 14;
} else if ($hora >= '07:01:00' && $hora < '19:00:00') {
    $pontos = $pontos + 0;
} else if ($hora >= '19:01:00' && $hora <= '23:59:59') {
    $pontos = $pontos + 4;
}


/*if ($hora >= '00:00:00' && $hora < '03:30:00') {
    $pontos = $pontos + 24;
} else if ($hora >= '03:30:00' && $hora < '07:00:00') {
    $pontos = $pontos + 14;
} else if ($hora >= '07:00:00' && $hora < '19:00:00') {
    $pontos = $pontos + 0;
} else if ($hora >= '19:00:00' && $hora <= '23:59:59') {
    $pontos = $pontos + 4;
}
*/


foreach ($dados as $d) {
    $pontos = $pontos + (int) $d;
}

if ($pontos <= 49) {
    $valores = array("cor" => "green", "message" => "N&atilde;o enviar viatura, grande possibilidade de disparo em falso.");
} else if ($pontos >= 50 && $pontos <= 90) {
    $valores = array("cor" => "#FF8C00", "message" => "Enviar viatura, possibilidade de intrus&atilde;o.");
} else if ($pontos > 90) {
    $valores = array("cor" => "red", "message" => "Enviar viatura, h&aacute; intrus&atilde;o no local.");
}

foreach ($dados as $d => $v) {
    $aux = explode('.', $v);
    $valores[] = $aux[1];
}

switch ($acao) :
    case "enviaViaturas" :
        $captacao->insertViaturas(array(
            'conta' => $conta,
            'zona1ouqualquer' => (int) $valores[0],
            'disparos' => (int) $valores[1],
            'zonas' => (int) $valores[2],
            'todaszonas' => (int) $valores[3],
            '30dias' => (int) $valores[4],
            'temporal' => (int) $valores[5],
            'data' => $data,
            'hora' => $hora,
            'atendente' => $operador,
            'pontos' => $pontos,
            'texto' => $text
        ));
        header("Location: ../../../../index.php?pg=26&pontos={$pontos}");
        break;
endswitch;
