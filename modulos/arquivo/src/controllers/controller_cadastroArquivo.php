<?php

$dadoURL = filter_input_array(INPUT_GET);
$id = !empty($dadoURL['id']) ? $dadoURL['id'] : NULL;
$acao = !empty($dadoURL['acao']) ? $dadoURL['acao'] : NULL;
$arquivo = null;
$listaVeiculo = null;
$cliente = null;
$arquivos = new Arquivo;
$veiculo = new Veiculos;
$cli = new Clientes;
$armarios = $arquivos->selectArquivoArmario();

$disabled = !empty($id) ? "disabled" : "";

unset($dadoURL['pg']);

$arquivos->select(null, $dadoURL);
$total = $arquivos->Read()->getRowCount();
$objPaginacao = new paginacao(30, $total, PAG, 10);
$objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($dadoURL);
$limite = $objPaginacao->limit();
$lista = $arquivos->select(null, $dadoURL);
$armarios = $arquivos->selectArquivoArmario();
$gavetas = isset($armarios[0]['arquivo_armario_id']) ? $arquivos->selectArquivoGaveta($armarios[0]['arquivo_armario_id']) : null;
if (!isset($_SESSION['user_info']))
    @session_start();

if (!empty($id)) {
    $arquivo = $arquivos->limparArray($arquivos->select(null, array("filtro" => "id_arquivo", "texto" => $id)));
    $listaVeiculo = $arquivos->selectVeiculosPorCliente($arquivo['arquivo_cliente']);
    $cliente = $cli->select($arquivo['arquivo_cliente']);
}

$id_cliente = isset($arquivo['arquivo_cliente']) ? $arquivo['arquivo_cliente'] : "";
$arquivoArmario = isset($arquivo['arquivo_armario_id']) ? $arquivo['arquivo_armario_id'] : NULL;
$arquivoGaveta = isset($arquivo['arquivo_gaveta']) ? $arquivo['arquivo_gaveta'] : NULL;
$_gavetas = empty($arquivoGaveta) && isset($armarios[0]['arquivo_armario_id']) ? $arquivos->selectArquivoGaveta($armarios[0]['arquivo_armario_id']) : NULL;
$gavetas = empty($_gavetas) && !empty($arquivoArmario) ? $arquivos->selectArquivoGaveta($arquivoArmario) : $_gavetas;
$tipoPessoaAcao = empty($id_cliente) ? "tipoPessoa" : "";
$tiPoPessoa = !empty($cliente['tipo_pessoa']) ? $cliente['tipo_pessoa'] : "f";

