<?php

$id = filter_input(INPUT_GET, "id");
$id_requisicao = filter_input(INPUT_GET, "id_requisicao");
$buscaRequisicao = filter_input(INPUT_GET, "buscaRequisicao");
$acao = filter_input(INPUT_GET, "acao");
$filtro = filter_input(INPUT_GET, "filtro");

$produtosRequisicao = new Produtos;


if (!empty($id)){
    $produtos->select($id);
}

if (!empty($id_requisicao)){
    $produtosRequisicao->selectRequisicao($id_requisicao);
}


if (!empty($busca)){
    $produtos->setFiltros($busca);
}

$listaCategorias = $produtos->selectCategorias();
$listaUnidades = $produtos->selectUnidades();

$produtos->listar($filtro);
$total = $produtos->Read()->getRowCount();
$objPaginacao = new paginacao(10, $total, PAG, 10);
$objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
$limite = $objPaginacao->limit();
$lista = $produtos->listar($filtro, $limite);

$tipo = $produtosRequisicao->get("produto_requisicao_tipo") != null ? $produtosRequisicao->get("produto_requisicao_tipo") : "saida";
$setores = $setor->selectTodosSetores();
$listaProdutos = $produtos->selectProdutosDisponiveis($tipo);

$produtosRequisicao->setFiltrosRequisicao($buscaRequisicao);
$produtosRequisicao->listarRequisicao();
$totalRequisicao = $produtosRequisicao->Read()->getRowCount();
$objPaginacaoRequisicao = new paginacao(30, $totalRequisicao, PAG, 10);
$objPaginacaoRequisicao->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
$limite = $objPaginacaoRequisicao->limit();
$listaRequisicao = $produtosRequisicao->listarRequisicao($limite);







