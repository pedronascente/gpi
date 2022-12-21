<?php
$dadosFiltro = isset($_POST['acao']) ? filter_input_array(INPUT_POST) : filter_input_array(INPUT_GET);
$acao = isset($dadosFiltro['acao']) ? $dadosFiltro['acao'] : "";
$selectFiltro = filter_input(INPUT_POST, "filtros");
$busca = filter_input(INPUT_POST, "busca");
$selectSituacao = !empty($dadosFiltro ['situacao_os']) ? $dadosFiltro ['situacao_os'] : null;
$selectTipo = !empty($dadosFiltro ['tipo_os']) ? $dadosFiltro ['tipo_os'] : null;

$lista = null;
$veiculo = new Veiculos ();

if(!empty($busca))
	$veiculo->setFiltrosVeiculosOS($busca);
else if (empty($selectSituacao) && empty($selectTipo))
	$selectSituacao = 1;
	
//LISTAR OS EM ABERTO
$veiculo->selectOSEmAberto($selectTipo, $selectSituacao);
$totalOsAberto = $veiculo->Read()->getRowCount();
$objPaginacaoOSAberto =  new paginacao(10, $totalOsAberto, PAG, 30);
$objPaginacaoOSAberto->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
$objPaginacaoOSAberto->SetTabs('#osAbertas');
$limite = $objPaginacaoOSAberto->limit();
$listaOSAberto = $veiculo->selectOSEmAberto($selectTipo, $selectSituacao, $limite);


