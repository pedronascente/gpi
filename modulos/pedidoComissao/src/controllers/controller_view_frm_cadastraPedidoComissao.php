<?php
$DadosGet = filter_input_array(INPUT_GET);

$objetopcf->selDadoFuncionario($id_usuario);
/*
 * **********************************************************
 * ********* RETORNA O TOTAL DE REGISTRO NO BANCO. **********
 * **********************************************************
 */


if(!empty($busca))
	$pedidoComissao->setFiltros($busca);
$pedidoComissao->select(array("id_usuario" => $id_usuario));
$totalPedidoComissao = $pedidoComissao->Read()->getRowCount();

if ($totalPedidoComissao > 0) {
    echo '<input type="hidden" name="t" id="t" value="' . $totalPedidoComissao . '">';
}

/*
 * ***************************************
 * ********* REALIZA PAGINAÇÃO. **********
 * ***************************************
 */
$objPaginacao = new paginacao(10, $totalPedidoComissao, $pag, 10);
$objPaginacao->_pagina = PAGINA .Funcoes::getParametrosURL($DadosGet);
$limite = $objPaginacao->limit();
$lista_pedidoComissao = $pedidoComissao->select(array("id_usuario" => $id_usuario, "limite" => $limite));
$totalPorPagina = $pedidoComissao->Read()->getRowCount();

/*
 * ***********************************************************************************
 * ********* O FORMULARIO DE CADASTRO DE COMISSÔES SO VAI APARECER QUANDO O  **********
 * ********* STATUS == 0 OU SEJA ENQUANTO A PLANILHA ESTIVER ATIVA          **********
 * ***********************************************************************************
 */
echo ($objetopcf->get_pcf_status() == 2) ? '<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;ATENÇÃO : ' . $objetopcf->get_pcf_motivo() . ' </div>' : '';

if ($page == 'arquivo'):
    $pageHistory = "index.php?pg=7";
elseif ($page == 'conferencia'):
    $pageHistory = "index.php?pg=8";
else:
    $pageHistory = "index.php?pg=5";
endif;