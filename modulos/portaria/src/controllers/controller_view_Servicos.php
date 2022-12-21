<?php
$dados['pc_id'] = $idCondominio;

//TOTAL DE SERVIÇOS NA BD :
$portariaCondominioServico = new PortariaCondominioServico;
$portariaCondominioServico->selectServicosDoCondominio($dados);
$totalServicos = $portariaCondominioServico->Read()->getRowCount();

//LISTA OS SERVIÇO COM PAGINAÇÃO :
$objPaginacaoServico = new paginacao(10,$totalServicos, PAG, 10);
$objPaginacaoServico->_pagina = PAGINA;
$limiteCondominio = $objPaginacaoServico->limit();

$dados['limit'] = $limiteCondominio;

if($acao=='pesquisarServicos' && !empty($buscarPor)){
    $dados['filtro'] = $buscarPor;
    $listaServico = $portariaCondominioServico->selectServicosDoCondominio($dados); //var_dump('com filtro',$dados,$listaServico);  
}else{
    $listaServico = $portariaCondominioServico->selectServicosDoCondominio($dados);   //var_dump('sem filtro',$dados,$listaServico);     
}

//LISTA TODOS OS SERVIÇOS PARA POPULAR OS options do select :
$portariaservico = new PortariaServico; 
$listaServicoSelect =   $portariaservico->select();
