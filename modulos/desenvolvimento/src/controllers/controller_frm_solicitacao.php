<?php

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

$r  = filter_input(INPUT_GET, "result");

$acao = filter_input(INPUT_GET, 'acao', FILTER_DEFAULT);
$nivel_solicitacao = filter_input(INPUT_GET, 'nivel', FILTER_DEFAULT);
$permissao = filter_input(INPUT_GET, 'permissao', FILTER_DEFAULT);
$id_solicitacao = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
$historico = null;
$user = new Usuarios;
$desenvolvimento = new Desenvolvimento;
$anexos = '';
$totalAnexos = 0;
$limiteAnexo = 2;
$validaStatus = false;


$ti = in_array(array("tipo_permissao" => "desenvolvedor"), $_SESSION['user_info']['permissoes']) || in_array(array("tipo_permissao" => "suporte"), $_SESSION['user_info']['permissoes']);

if (!empty($id_solicitacao)) {
	$desenvolvimento->select($id_solicitacao);
	$desenvolvimento->selectStatusLog($id_solicitacao);
	$desenvolvimento->selectHistorico($id_solicitacao);
	$total = $desenvolvimento->Read()->getRowCount();
	$objPaginacao = new paginacao(5, $total, PAG, 5);
	$objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL(filter_input_array(INPUT_GET));
	$limite = $objPaginacao->limit();
	$historico = $desenvolvimento->selectHistorico($id_solicitacao, $limite);
	$anexos = $desenvolvimento->selectAnexos($id_solicitacao);
	$totalAnexos = $desenvolvimento->Read()->getRowCount();
	$limiteAnexo = empty($totalAnexos) ? 2 : 1;
	$nivel_solicitacao = $desenvolvimento->get("desenvolvimento_nivel_solicitacao", true);
}

$solicitacaoStatus = $desenvolvimento->get("desenvolvimento_status", true);

$id_usuario = $desenvolvimento->get("desenvolvimento_id_usuario", true);
$id_usuario = empty($id_usuario) ? $_SESSION['user_info']['id_usuario'] : $id_usuario;
$nome = '';
$setor = '';
$nomeProgramador = '';
$permissaoCampoUsuario = '';
$permissaoCampoProgramador = '';
$dataCriacao = $desenvolvimento->get("desenvolvimento_data_criacao");
$dataCriacao = !empty($dataCriacao) ? $desenvolvimento->get("desenvolvimento_data_criacao") : date("d/m/Y H:i:s");
$salvar = "submit";
$supervisor = in_array(array("tipo_permissao" => "supervisor"), $_SESSION ['user_info'] ['permissoes']);
$desenvolvedor = in_array(array("tipo_permissao" => "desenvolvedor"), $_SESSION ['user_info'] ['permissoes']);
$suporte = in_array(array("tipo_permissao" => "suporte"), $_SESSION ['user_info'] ['permissoes']);
$campoNivel = 'disabled="disabled"';
$status = 'disabled="disabled"';
$emailUsuario = "";

if (empty($acao)) {
	$usuario = $user->selUsuario($id_usuario);
	$nome = $usuario['nome'];
	$setor = $usuario['setor_local'];
	$acao = "cadastrarSolicitacao";
	$campoNivel = null;
	$emailUsuario = $usuario['usuario_email'];

	//LIBERA CAMPOS USUÀRIO PARA INFORMÀTIC
	if ($ti ||$supervisor) {
		$validaStatus = true;
		$permissaoCampoUsuario = "required";
		
		//BLOQUEIA CADASTRO DIRETO NÌVEIS DIFERENTES
		if(($nivel_solicitacao == 2 && $desenvolvedor) || ($nivel_solicitacao == 1 && $suporte)){
			$permissaoCampoProgramador = 'disabled="disabled"';
			$validaStatus = false;
		}
		
	} else {
		$permissaoCampoProgramador = 'disabled="disabled"';
		$permissaoCampoUsuario = 'required';
	}
}

if ($acao == "visualizar") {
	$permissaoCampoUsuario = 'disabled="disabled"';
	$permissaoCampoProgramador = 'disabled="disabled"';
	$salvar = "hidden";
} else if ($acao == "editar") {

	$nivel_solicitacao = $desenvolvimento->get("desenvolvimento_nivel_solicitacao", true);
	
	//DESABILITA OS CAMPOS DO USUÁRIO PARA DESENVOLVEDORES, SUPERVISOR
	if (($ti || $supervisor) && $desenvolvimento->get("desenvolvimento_id_usuario") != $_SESSION['user_info']['id_usuario']) 
		$permissaoCampoUsuario = 'disabled="disabled"';
	

	//DESABILITA CAMPOS DO PROGRAMADOR PARA USUÁRIOS E SUPERVISOR
	if(!$ti) 
		$permissaoCampoProgramador = 'disabled="disabled"';
	
	//LIBERA O CAMPO NÍVEL PARA EDIÇÃO PARA OS USUÁRIOS E O SUPERVISOR
	if (($supervisor && $solicitacaoStatus <= 1) || (!$ti && $solicitacaoStatus == 0 )) 
		$campoNivel = null;

	//STATUS OPÇÃO VAZIA PARA DESENVOLVEDORES
	$optionVazio = $ti ? true : false;

	//HABILITA O STATUS PARA DESENVOLVEDOR E SUPERVISOR
	$status = (($ti && $solicitacaoStatus >= 2) || $supervisor) && $solicitacaoStatus != 4 ? '' : 'disabled="disabled"';
	
	//HABILITA TESTE PARA OS USÁRIOS
	if($solicitacaoStatus == 4 && $desenvolvimento->get("desenvolvimento_id_usuario") == $_SESSION['user_info']['id_usuario']){
		$permissaoCampoUsuario = 'disabled="disabled"';
		$salvar = "hidden";
	}
		
}

$emailU = $desenvolvimento->get("desenvolvimento_email");
$email = !empty($emailU) ? $desenvolvimento->get("desenvolvimento_email") : $emailUsuario;

if(empty($emailUsuario) && !empty($emailU))
	$user->updateTempoUsuario(array("id"=>$id_usuario, "usuario_email"=>$email));

$desenvolvimento_id = $desenvolvimento->get("desenvolvimento_id");
$desenvolvimento_usuario = $desenvolvimento->get("desenvolvimento_usuario");
$desenvolvimento_setor = $desenvolvimento->get("desenvolvimento_setor");
$desenvolvimento_obs_supervisor = $desenvolvimento->get("desenvolvimento_obs_supervisor");

$validaUsuario = $desenvolvimento->get("desenvolvimento_id_programador") == $_SESSION['user_info']['id_usuario'];


