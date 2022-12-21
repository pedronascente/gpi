<?php
$filtros = filter_input_array(INPUT_POST);

$select = new PedidoComissaoFuncionario ();
$pcf = new PedidoComissaoFuncionario;
/*
 * ************************************
 * ********* LISTAR OS DADOS **********
 * ************************************
 */
if (!empty($filtros ['acao']) && $filtros ['acao'] == "buscar") 
	$select->selectComFiltro($filtros['busca']);

$lista = $select->selectTodosArquivados();
// Listar dados da base com filtro.

$total_registro = count($lista); // Total Registro

/*
 * ******************************
 * ********* PAGINAÇÃO **********
 * ******************************
*/
$objPaginacao = new paginacao(10, $total_registro, PAG, 10);
$objPaginacao->_pagina = PAGINA.Funcoes::getParametrosURL($filtros);
$limite = $objPaginacao->limit();
$lista = $select->selectTodosArquivados($limite);