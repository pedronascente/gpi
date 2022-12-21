<?php
$id_usuario = $_SESSION ['user_info'] ['id_usuario'];
$Dados = filter_input_array(INPUT_GET);
unset($Dados['pg']);
$result = isset($Dados['result']) ? $Dados['result'] : '';
$acao = isset($Dados['acao']) ? $Dados['acao'] : '';
$desenvolvimento = new Desenvolvimento;
$permissao = new Usuarios;
$statusDesenvolvimento = filter_input(INPUT_GET, "status");

$desenvolvedor = in_array(array("tipo_permissao" => "desenvolvedor"), $_SESSION ['user_info'] ['permissoes']);
$supervisor = in_array(array("tipo_permissao" => "supervisor"), $_SESSION ['user_info'] ['permissoes']);
$gerente = in_array(array("tipo_permissao" => "gerente"), $_SESSION ['user_info'] ['permissoes']);
$suporte = in_array(array("tipo_permissao" => "suporte"), $_SESSION ['user_info'] ['permissoes']);
$ti = in_array(array("tipo_permissao" => "desenvolvedor"), $_SESSION ['user_info'] ['permissoes']) || in_array(array("tipo_permissao" => "suporte"), $_SESSION ['user_info'] ['permissoes']);

//listar somente as solicitações de cada setor, desenvolvimento, suporte
$n = $suporte ? "2" : ($desenvolvedor ? 1 : null);
$limitacao = false;
if($acao != "pesquisarGeral")
	$limitacao = true;


$listaValoresSolicitacoesGerais = "";
$listaValoresSolicitacoes = "";

//status em geral total
$listaValoresSolicitacoesGerais = $desenvolvimento->selectValoresStatus($n);

//pesquisa
if (!empty($acao) && $acao == "pesquisarGeral") {
    $Dados['status'] 	= filter_input(INPUT_GET, "status");
    $Dados['nivel'] 	= filter_input(INPUT_GET, "nivel");
    $desenvolvimento->selectComFiltros($Dados);
}

//solicitacoes gerais
$desenvolvimento->listar(false, false, $n, $limitacao);
$totalSolictacao = $desenvolvimento->Read()->getRowCount();
if($totalSolictacao == 0) {
	$desenvolvimento->listar(false, false, $n);
	$totalSolictacao = $desenvolvimento->Read()->getRowCount();
	$limitacao = false;
}

$objPaginacao = new paginacao(10, $totalSolictacao, PAG, 10);
$objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($Dados);
$limite = $objPaginacao->limit();
$listaSolicitacoesGerais = $desenvolvimento->listar(false, false, $n, $limitacao, $limite);

//lista de programadores
$listaProgramadores = $permissao->selUser("desenvolvedor");

$filtrosSolicitacoes = null;

$desenvolvimento->limparFiltros();
if($ti || $supervisor)
	$desenvolvimento->selectComFiltros(array("id_programador"=>$id_usuario));

$listaValoresSolicitacoes = $desenvolvimento->selectValoresStatus($n);

$n1 = filter_input(INPUT_GET, "n1");

$desenvolvimento->limparFiltros();
if ($acao == "pesquisar" && isset($Dados['status']))
    $filtrosSolicitacoes['status'] = $Dados['status'];

//solicitacoes
if ($ti) {
    $filtrosSolicitacoes['id_programador'] = $id_usuario;
    $desenvolvimento->selectComFiltros($filtrosSolicitacoes, true);
} else if ($supervisor){
    $filtrosSolicitacoes['id_programador'] = $id_usuario;
    $desenvolvimento->selectComFiltros($filtrosSolicitacoes, null);
}

$listaSolicitacoes = $desenvolvimento->listar($desenvolvedor, $supervisor, $n1, true);
$total = $desenvolvimento->Read()->getRowCount();
$objPagina = new paginacao(10, $total, PAG, 10);
$objPagina->_pagina = PAGINA . Funcoes::getParametrosURL($Dados);
$limite = $objPaginacao->limit();
$listaSolicitacoes = $desenvolvimento->listar($desenvolvedor, $supervisor, $n1, true, $limite);


$n2 = filter_input(INPUT_GET, "n2");


$filtro['id_usuario'] =  $id_usuario;

$desenvolvimento->limparFiltros();
$desenvolvimento->selectComFiltros($filtro);
//status total minhas solicitações
$listaValoresMinhasSolicitacoes = $desenvolvimento->selectValoresStatus($n);

if ($acao == "pesquisarM" && isset($Dados['status']))
	$filtro['status'] =  $Dados['status'];

$desenvolvimento->limparFiltros();
$desenvolvimento->selectComFiltros($filtro);

//minhas solicitacoes
$desenvolvimento->listar(false, false, $n2);
$totalMinhaSolicitacao = $desenvolvimento->Read()->getRowCount();
$objPag = new paginacao(10, $totalMinhaSolicitacao, PAG, 10);
$objPag->_pagina = PAGINA;
$limite = $objPag->limit();
$listaMinhasSolicitacoes = $desenvolvimento->listar(false, false, $n2, false, $limite);

