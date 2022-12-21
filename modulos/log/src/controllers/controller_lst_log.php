<?php

$acao = filter_input(INPUT_GET, "acao");
$acaoP = filter_input(INPUT_GET, "acaoP");

$permissao = false;

$nivel = null;

$id_tabela = filter_input(INPUT_GET, "id_tabela");
$data1 = filter_input(INPUT_GET, "data1");
$data2 = filter_input(INPUT_GET, "data2");

$desenvolvedor = false;

if($acao != "reprovados") {
	$permissao = true;
	$desenvolvedor = in_array(array("tipo_permissao"=>"desenvolvedor"), $_SESSION['user_info']['permissoes']) || in_array(array("tipo_permissao"=>"gerente"), $_SESSION['user_info']['permissoes']);
} else{
	$id_tabela = 6;
}

$dadosFiltro = filter_input_array(INPUT_GET);

$log = new Log();


if(!empty($dadosFiltro['busca'])){
	$log->setFiltros($dadosFiltro['busca']);
}

$listaTabelas = $log->selectTabelas();

$limite = null;

if(empty($acaoP) && $acao != "reprovados"){
	$limite = "30";
}


$log->listar($limite, null, $id_tabela, $data1, $data2);

$totalLog = $log->Read()->getRowCount();
$objPaginacaoLog = new paginacao(10, $totalLog, PAG, 10); // PAGINACAO
$objPaginacaoLog->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
$limite = $objPaginacaoLog->limit();
$logs = $log->listar($limite, null, $id_tabela, $data1, $data2);

?>