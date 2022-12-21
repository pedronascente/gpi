<?php

$conexao =  filter_input(INPUT_GET, "conexao") == "false" ? false : true;

if(!empty($busca))
	$monitoramento->setFiltros("assistencia", $busca);

if(!empty($id))
	$monitoramento->selectAssistencia($id);

$monitoramento->listaAssistencia();
$total = $monitoramento->Read()->getRowCount();

$objPaginacao = new paginacao(10, $total, PAG, 10);
$objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
$limite = $objPaginacao->limit();

$lista = $monitoramento->listaAssistencia($limite);

$id_guincho = $acao == "visualizar" ? $monitoramento->get("assistencia_guincho") : "";

$guinchos = $monitoramento->listarGuinchos(null, $id_guincho);

