<?php
$dadosFiltro = filter_input_array(INPUT_GET);
$pg = filter_input(INPUT_GET, 'pg');
$acao = filter_input(INPUT_GET, 'acao');
$selectFiltro = filter_input(INPUT_GET, 'selectFiltro');
$selectStatus = filter_input(INPUT_GET, 'status');
$statusVeiculo = filter_input(INPUT_GET, 'status_veiculo');
$campo_pesquisa = filter_input(INPUT_GET, 'campo_pesquisa');
$data1 = filter_input(INPUT_POST, "data1");
$data2 = filter_input(INPUT_POST, "data2");
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$classe = 'style="display:none"';
$classe2 = $classe;

$cliente = new Clientes ();
$veiculo = new Veiculos ();
$chip = new Chip;
$credenciado = new Credenciados;
$log = new Log;
$equipamentoSac = new Equipamento;

$display = $acao == "ListarCliente";
$nivelContato = 1;

$listaVeiculos = null;
$totalVeiculos = null;
$veiculoCliente = null;
$equipamento = null;
$listaChips = null;
$listaCredenciados = null;
$equipamentoChip = null;
$limite = null;
$logs = null;
$listaEquipamentos = null;
$listaEquipamentosCliente = null;

$permissao = true;

$p = !in_array(array("tipo_permissao"=>"sac"), $_SESSION['user_info']['permissoes']) ? "visualizar" : "";


/*
 * *************************************************************
 * ********* SELECT CLIENTE pag ->sacDadosCliente.php **********
 * *************************************************************
 */
$tipoPessoa = '';
$contrato = '';
if ($acao == "ListarCliente") {
	//DADOS CLIENTE
	$classe = 'style="display:block"';
	$dadosCliente = $cliente->selectClienteEnderecoCobranca($id);
	$contrato = !empty($dadosCliente['id_cliente']) ? true : false;
	$tipoPessoa = isset($dadosCliente['tipo_pessoa']) ? $dadosCliente['tipo_pessoa'] : "";
	$objPaginacao = new paginacao(10, 1, PAG, 10);
	$total = 1;
	$objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
	$dadosDoCliente [0] = $dadosCliente;
	
	//LISTA VEICULOS
	$veiculo->selectVeiculosPorCliente($id, $statusVeiculo);
	$totalVeiculos = $veiculo->Read()->getRowCount();
	$objPaginacao3 = new paginacao(5, $totalVeiculos, PAG, 10);
	$objPaginacao3->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
	$objPaginacao3->SetTabs('#cliente');
	$limite = $objPaginacao3->limit();
	$listaVeiculos = $veiculo->selectVeiculosPorClienteSac($id,$statusVeiculo, $limite);
	
	//VEICULO
	$id_veiculo = filter_input(INPUT_GET, "id_veiculo");
	
	if (!empty($id_veiculo)) {
		$veiculoCliente = $veiculo->selectVeiculoSac($id_veiculo);
		$equipamento = $veiculo->selectEquipamentos($id_veiculo);
		
		$id_chip = !empty($equipamento['veiculos_equipamentos_id_chip']) ? $equipamento['veiculos_equipamentos_id_chip'] : "";
		
		//LISTA OS CHIPS
		$listaChips = $chip->listarDisponiveis($id_chip);
		
		if(!empty($id_chip))
			$chip->select($id_chip);
		
		$listaEquipamentos = $equipamentoSac->listarEquipamentos();
		
		$listaEquipamentosCliente = $equipamentoSac->selectEquipamentosClienteEquipamentos($id);
		
	}
	
	//OS CLIENTE
	$acaoSessao = '';
	
	if (!empty($id) && $totalVeiculos > 0) {
		$classe2 = "";
		$veiculo->selectVeiculcosOS(array(
				"id_cliente" => $id
		));
		
		$totalOs = $veiculo->Read()->getRowCount(); // TOTAL DE OS
		$objPaginacaoOS = new paginacao(10, $totalOs, PAG, 10); // PAGINACAO
		$objPaginacaoOS->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
		$objPaginacaoOS->SetTabs('#os');
		$limite = $objPaginacaoOS->limit();
		$listaOs = $veiculo->selectVeiculcosOS(array(
				"id_cliente" => $id,
				"limite" => $limite
		));
		
		//LISTA OS CREDENCIADOS
		$listaCredenciados = $credenciado->listar();
		
		//LISTA O LOG DO CLIENTE
		$log->listar(null, $id, 1, $data1, $data2);
		$totalLog = $log->Read()->getRowCount();
		$objPaginacaoLog = new paginacao(10, $totalLog, PAG, 10); // PAGINACAO
		$objPaginacaoLog->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
		$objPaginacaoLog->SetTabs('#log');
		$limite = $objPaginacaoLog->limit();
		$logs = $log->listar($limite, $id, 1, $data1, $data2);
	}
	
	//LISTA CONTATOS CLIENTES
	$agendaContato    		= new AgendaContato ();
	$listaContato    		= $agendaContato->selectContatoCliente ($id, $nivelContato);
	
} else if ($acao == "Pesquisar") {
	/*
	 * ************************************************************
	 * ********* LISTA CLIENTE pag ->sacDadosCliente.php **********
	 * ************************************************************
	 */
	// TOTAL DE CLIENTE NA BUSCA
	$cliente->selectComFiltros($dadosFiltro);
	$total = $cliente->Read()->getRowCount();
	// PAGINACAO
	$objPaginacao = new paginacao(10, $total, PAG, 10);
	if ($objPaginacao->totReg > 10) :
	$_SESSION ['filtro'] ['selectFiltro'] = $selectFiltro;
	$_SESSION ['filtro'] ['campo_pesquisa'] = $campo_pesquisa;
	$_SESSION ['filtro'] ['acao'] = $acao;
	else :
	unset($_SESSION ['filtro']);
	endif;
	$objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
	$objPaginacao->SetTabs('#listarClientes');
	$limite = $objPaginacao->limit();

	// LISTAR CLIENTE COM FILTRO
	// ATUALIZAÇÃO 09/07/2015
	$dadosFiltro ['limite'] = $limite;
	$dadosDoCliente = $cliente->selectComFiltros($dadosFiltro);
	
}


