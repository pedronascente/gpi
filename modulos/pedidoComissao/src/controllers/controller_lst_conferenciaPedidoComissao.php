<?php
$result = filter_input(INPUT_GET, 'result', FILTER_DEFAULT);
$filtros = filter_input_array(INPUT_POST);
$pedidoComissaoFuncionario = new PedidoComissaoFuncionario;
$pedidoComissao = new PedidoComissao;
/*
 * ***********************************************************
 * ********** Seleciona as planilhas dos vendedores **********
 * ***********************************************************
 */

var_dump($filtros); die;

if($filtros["acao"] == "buscar")
	$pedidoComissaoFuncionario->selectComFiltro($filtros['busca']);
$pedidoComissaoFuncionario->selectTodos(null);
$total = $pedidoComissaoFuncionario->Read()->getRowCount();
// paginação:
$objPaginacao = new paginacao(10, $total, PAG, 10);
$objPaginacao->_pagina = PAGINA.Funcoes::getParametrosURL($filtros);
$objPaginacao->setTabs('#tabs-1');
$limite = $objPaginacao->limit();
$lista = $pedidoComissaoFuncionario->selectTodos($limite);
$totalPorPagina = $pedidoComissaoFuncionario->Read()->getRowCount();

$total_read_Inconsistencia = sizeof($pedidoComissao->listaInconsistencia(null, null, null, null, true, null, null, $filtros));
// paginação:
$objPaginacaoRelatorioInconsistencia = new paginacao(10, $total_read_Inconsistencia, PAG, 10);
$objPaginacaoRelatorioInconsistencia->_pagina = PAGINA . Funcoes::getParametrosURL($filtros);
$objPaginacaoRelatorioInconsistencia->setTabs('#tabs-2');
$limiteInconsistencia = $objPaginacaoRelatorioInconsistencia->limit();
$listaInconsistencia = $pedidoComissao->listaInconsistencia(null, null, null, null, true, null, $limite, $filtros);