<?php

if(!empty($busca))
	$monitoramento->setFiltros("guinchos", $busca);

$monitoramento->listarGuinchos();
$total = $monitoramento->Read()->getRowCount();

$objPaginacao = new paginacao(10, $total, PAG, 10);
$objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
$limite = $objPaginacao->limit();

$lista = $monitoramento->listarGuinchos($limite);

$listaPrecos = null;

$listaContatos = null;

if(!empty($id)){
	$monitoramento->selectGuincho($id);
	
	$monitoramento->getCondicoes($id);
	$totalC = $monitoramento->Read()->getRowCount();
	$objPaginacao2 = new paginacao(5, $total, PAG, 10);
	$objPaginacao2->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
	$limite = $objPaginacao2->limit();
	$listaPrecos = $monitoramento->getCondicoes($id, $limite);
	
	$listaContatos = $monitoramento->getContatosGuincho($id);
	
	
}