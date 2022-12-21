<?php
$dadosFiltro = filter_input_array(INPUT_GET);
$acao = isset($dadosFiltro['acao']) ? $dadosFiltro['acao'] : "";
$id = filter_input(INPUT_GET, "id");
$selectStatus = filter_input(INPUT_GET, "credenciado_status");
$filtros = filter_input(INPUT_GET, "filtros");
$busca = filter_input(INPUT_GET, "busca");
$result = filter_input(INPUT_GET, "result");
$data1 = filter_input(INPUT_GET, "data1");
$data2 = filter_input(INPUT_GET, "data2");

$credenciado = new Credenciados;
$log = new Log;

$lista = null;
$logs = null;
$listaContato = null;
$nivelContato = 2;

$agendaContato = new AgendaContato;

$permissao = true;

$p = !in_array(array("tipo_permissao"=>"sac"), $_SESSION['user_info']['permissoes']) ? "visualizar" : "";

switch ($acao){
	case "listarCredenciado":
		$credenciado->select($id);
		$listaContato = $agendaContato->selectContatoCliente ($id, $nivelContato);
		
		//LISTA O LOG DO CREDENCIADO
		$log->listar(null, $id, 2, $data1, $data2);
		$totalLog = $log->Read()->getRowCount();
		$objPaginacaoLog = new paginacao(10, $totalLog, PAG, 10); // PAGINACAO
		$objPaginacaoLog->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
		$objPaginacaoLog->SetTabs('#log');
		$limite = $objPaginacaoLog->limit();
		$logs = $log->listar($limite, $id, 2, $data1, $data2);
		
		break;
		
	case "pesquisar":
		if(!empty($busca))
			$credenciado->setFiltros($busca);
		$credenciado->listar($selectStatus);
		$total = $credenciado->Read()->getRowCount();
		$objPaginacao = new paginacao(10, $total, PAG, 10);
		$objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
		$objPaginacao->SetTabs('#listaCredenciados');
		$limite = $objPaginacao->limit();
		$lista = $credenciado->listar($selectStatus, $limite);
		break;
}


