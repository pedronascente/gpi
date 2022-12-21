<?php
include_once "../model/PagSeguro.class.php";

$ACAO = $_POST['acao']; 
$ID = $_POST['id'];

$pagSeguro = new PagSeguro();
         
if ($ACAO=='visualizarLogs'){
    die(json_encode($pagSeguro->VisualizarLogs($ID)));
}