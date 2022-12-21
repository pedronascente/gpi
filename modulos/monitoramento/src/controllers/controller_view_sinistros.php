<?php

if(!empty($busca))
	$monitoramento->setFiltros("sinistro", $busca);

$monitoramento->listaSinistro();
$total = $monitoramento->Read()->getRowCount();
$objPaginacao = new paginacao(10, $total, PAG, 10);
$objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
$limite = $objPaginacao->limit();
$lista = $monitoramento->listaSinistro($limite);


if(!empty($id))
	$monitoramento->selectSinistro($id);