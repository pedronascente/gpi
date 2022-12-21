<?php
$id_u = !empty($_SESSION['user_info']['id_usuario']) ? $_SESSION ['user_info']['id_usuario'] : null;
$id_setor = isset($_SESSION['user_info']['id_setor']) ? $_SESSION ['user_info']['id_usuario'] : null;
$result = filter_input(INPUT_GET, 'result', FILTER_DEFAULT);
$filtros = filter_input_array(INPUT_POST);
$pedidoComissaoFuncionario = new PedidoComissaoFuncionario();
// Seleciona Tipos de Planilhas do usuario Logado :
// Select lista de planilhas de acordo com o id do supervisor :
if($filtros['acao'] == "buscar")
	$pedidoComissaoFuncionario->selectComFiltro($filtros['busca']);
$pedidoComissaoFuncionario->select(array("pcf_id_supervisor" => $id_u));
$total = $pedidoComissaoFuncionario->Read()->getRowCount();
// Calcula paginação com o valor calculado recebido na selecao acima :
$objPaginacao = new paginacao(10, $total, PAG, 10);
$objPaginacao->_pagina = PAGINA.Funcoes::getParametrosURL($filtros);
$limite = $objPaginacao->limit();
// Select lista de planilhas de acordo com o id do supervisor ordenado e com limite:
$lista = $pedidoComissaoFuncionario->select(array("limite" => $limite, "pcf_id_supervisor" => $id_u));
$totalPorPagina = $pedidoComissaoFuncionario->Read()->getRowCount();
$usuario = new Usuarios;
$lista_planilha = $usuario->selectPlanilhaUsuario($id_u);
$acao = "AddPedidoComissao";