<?php

unset($dadosFiltro['pg']);
unset($dadosFiltro['pag']);

$status 	= isset($dadosFiltro['agenda_contato_status']) ? $dadosFiltro['agenda_contato_status'] : -1;
$vendedor 	= filter_input(INPUT_GET, "id");
$dt_inicial = filter_input(INPUT_GET, "dt_inicial");
$dt_final 	= filter_input(INPUT_GET, "dt_final");

$agenda->selectPorUsuarioData($dadosFiltro, 1000);
$total = $agenda->Read()->getRowCount();
$objPaginacao = new paginacao(10, $total, PAG, 10); // PAGINACAO
$objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
$limite = $objPaginacao->limit();
$lista_historico = $agenda->selectPorUsuarioData($dadosFiltro, $limite);

$lista_usuario = $agenda->selecionarUsuariosAlertas();


