<?php
include_once "../application/model/DadosTransacao.php";

$ACAO = $_GET['acao'];
$ID = $_GET['id'];

$dadosTransacao = new DadosTransacao();

if($ACAO=="visualizarStatusTransacao"){
    echo $dadosTransacao->visualizarStatusTransacao($ID);
}
else if($ACAO=="visualizarLogs"){
    echo $dadosTransacao->VisualizarLogs($ID);
}