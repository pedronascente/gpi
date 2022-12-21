<?php
$id_u     = !empty($_SESSION['user_info']['id_usuario']) ? $_SESSION ['user_info']['id_usuario'] : null;
$id_setor = isset($_SESSION['user_info']['id_setor']) ? $_SESSION ['user_info']['id_usuario'] : null;
$result   = filter_input(INPUT_GET, 'result', FILTER_DEFAULT);
$id_pcf   = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

//SELECIONA A PLANILHA PARA EDIÇÃO
if(!empty($id_pcf)){
   $objetopcf->selDadoFuncionario($id_pcf);
}

/*
* **********************************************************************
* Seleciona Tipos de Planilhas do usuario Logado
* Select lista de planilhas de acordo com o id do supervisor
* **********************************************************************
*/


if(!empty($busca)){
	$objetopcf->setFiltros($busca);
}

@$objetopcf->select(array("pcf_id_supervisor" => $id_u));
$total = $objetopcf->Read()->getRowCount();
/*
* **********************************************************************
* Calcula paginação com o valor calculado recebido na selecao acima
* **********************************************************************
*/

$objPaginacao = new paginacao(10, $total, PAG, 10);
$objPaginacao->_pagina = PAGINA;
$limite = $objPaginacao->limit();

/*
* *************************************************************************************
* Select lista de planilhas de acordo com o id do supervisor ordenado e com limite
* *************************************************************************************
*/
$lista = $objetopcf->select(array("limite" => $limite, "pcf_id_supervisor" => $id_u));
$totalPorPagina = $objetopcf->Read()->getRowCount();

/*
* *************************************************************************************
* Select lista de planilhas 
* *************************************************************************************
*/
$usuario = new Usuarios;

$lista_planilha = $usuario->selectPlanilhaUsuario($id_u, true);
$acao = "AddPedidoComissao";
$cadastraPlanilha = sizeof($lista_planilha) != 0;

/**
 * @param String  $id_permissaouser 9
 * @return array Retorna ARRAYLIST de usuarios com permissao de captacao :( nome - id_empresa). 
 */
$ArrayListNomes  = $usuario->getJoinUsuarioPermissaouserUsuarios('9');