<?php
$getArray = filter_input_array(INPUT_GET);
$tipo_consulta = !empty($getArray['acao']) ? $getArray['acao'] : '';
$id_captacao = !empty($getArray['id']) ? $getArray['id'] : '';
$redirect = !empty($getArray['redirect']) ? $getArray['redirect'] : '';
$id_usuario = isset($_SESSION['user_info']['id_usuario']) ? $_SESSION['user_info']['id_usuario'] : NULL; // pega o id do usuario logado.
/*
 * ******************************************************************************************
 * ********* RESPONSAVEL POR TRAZER O RESULTADO DA CONSULTA SPC SERASA RASTREADOR **********
 * ******************************************************************************************
 */
$cliente = new Clientes;
// total:
$cliente->consultaSerasa(array("id_usuario" => $id_usuario));
$total = $cliente->Read()->getRowCount();
// paginacao:
$objPaginacao = new paginacao(20, $total, PAG, 10);
$objPaginacao->_pagina = PAGINA;
$limite = $objPaginacao->limit();


// listar:
$dadosClientes = $cliente->consultaSerasa(
    array(
        "id_usuario" => $id_usuario,
        "limite" => $limite
    )
);



if(!isset($_SESSION['user_info']))
	session_start();

$captacao = new Captacao;
$listaCaptacaoAbertas = $captacao->selectCaptacaoAbertaUsuarios($_SESSION['user_info']['id_usuario']);

if ($tipo_consulta == 'ex') :
    $mostra = null;
    $colspan = null;
else :
    $mostra = 'sel_campo';
    $colspan = 2;
endif;