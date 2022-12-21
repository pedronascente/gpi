<?php

$buscaModulo = filter_input(INPUT_GET, "buscaModulo");
$buscaChip = filter_input(INPUT_GET, "buscaChip");
$status = filter_input(INPUT_GET, "status") == null ? 2 : filter_input(INPUT_GET, "status");
$statusModulo = filter_input(INPUT_GET, "status_modulo") == null ? 1 : filter_input(INPUT_GET, "status_modulo");
$statusChip = filter_input(INPUT_GET, "status_chip") == null ? 1 : filter_input(INPUT_GET, "status_chip");
$id_modulo = filter_input(INPUT_GET, "id_modulo");
$id_chip = filter_input(INPUT_GET, "id_chip");
$id_programacao = filter_input(INPUT_GET, "id_programacao");
$programacao = new Chip;
$acao = "";

$permissaoProgramacao = in_array(array("tipo_permissao" => "programacao"), $_SESSION['user_info']['permissoes']);

if ($acaoTela == "listar") {

    if (!empty($buscaModulo))
        $modulo->setFiltros($busca);

//LISTA MÒDULOS NÃO PROGRAMADOS
    $modulo->listar($statusModulo);
    $totalModulo = $modulo->Read()->getRowCount();
    $objPaginacao = new paginacao(5, $totalModulo, PAG, 10); // PAGINACAO
    $objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
    $limite = $objPaginacao->limit();
    $modulos = $modulo->listar($statusModulo, null, $limite);

    if (!empty($buscaChip))
        $chip->setFiltros($buscaChip);

//CHIPS NÃO PROGRAMADOS
    $chip->listar($statusChip);
    $totalChip = $chip->Read()->getRowCount();
    $objPaginacaoChip = new paginacao(5, $totalChip, PAG, 10); // PAGINACAO
    $objPaginacaoChip->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
    $limite = $objPaginacaoChip->limit();
    $chips = $chip->listar($statusChip, null, $limite);

    if (!empty($busca))
        $chip->setFiltros($busca, array("nome_cliente", "modulo_serial"));

//LISTA CHIPS PROGRAMACAO
    $chip->listarProgramacao($status);
    $total = $chip->Read()->getRowCount();
    $objPaginacaoLista = new paginacao(5, $total, PAG, 10); // PAGINACAO
    $objPaginacaoLista->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
    $limite = $objPaginacaoLista->limit();
    $lista = $chip->listarProgramacao($status, $limite);
} else if ($acaoTela == "modulo") {


//CAREGA MÓDULO PARA VISUALIZAÇÃO
    if (!empty($id_modulo)) {
        $modulo->select($id_modulo);
        $acao = $modulo->get("modulo_status", true) == 3 ? "visualizar" : "";
    }
} else if ($acaoTela == "chip") {


//CAREGA CHIP PARA VISUALIZAÇÃO
    if (!empty($id_chip)) {
        $chip->select($id_chip);
        $acao = $chip->get("chip_status", true) == 3 ? "visualizar" : "";
    }
} else if ($acaoTela == "programacao") {


//CARREGA CHIP PROGRAMACAO
    if (!empty($id_programacao))
        $programacao->selectProgramacao($id_programacao);

	
    $chip->limparFiltros();

    $log = new Log;

    $veiculos = null;
    $clientes = null;
    $logs = null;

//MÒDULOS E CHIPS NOVOS
    $listaModulos = $modulo->listar(1, $programacao->get("chip_modulo"));
    $listaChips = $chip->listar(1, $programacao->get("chip_id"));
    
    if ($programacao->get("chip_status", true) == 3 || $programacao->get("chip_status", true) == 5) {
        $relatorioCliente = new RelatorioCliente;
        $veiculo = new Veiculos;
        $clientes = $relatorioCliente->selectClientesComVeiculos($programacao->get("chip_cliente"));
        $veiculos = $programacao->get("chip_cliente") != null ? $veiculo->selectVeiculosPorCliente($programacao->get("chip_cliente")) : "";

        //LISTA O LOG DO CREDENCIADO
        $log->listar(null, $programacao->get("chip_id"), 3, null, null);
        $totalLog = $log->Read()->getRowCount();
        $objPaginacaoLog = new paginacao(30, $totalLog, PAG, 10); // PAGINACAO
        $objPaginacaoLog->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
        $objPaginacaoLog->SetTabs('#log');
        $limite = $objPaginacaoLog->limit();
        $logs = $log->listar($limite, $programacao->get("chip_id"), 3, null, null);
    }
}

$permissao = false;


