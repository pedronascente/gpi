<?php
$Dados = filter_input_array(INPUT_GET);

$datas['dt_inicial'] =  filter_input(INPUT_GET, "dt_inicial");
$datas['dt_final'] =  filter_input(INPUT_GET, "dt_final");

unset($Dados['pg']);

$busca = filter_input(INPUT_GET, "texto_busca");
$status = filter_input(INPUT_GET, "pedido_comissao_status");

//var_dump($status, $datas,$busca);

if ($acao == "Pesquisar") {
	
	if(!empty($busca)){
        $pedidoComissao->setFiltros($busca,'pcf_nome');
    
        $pedidoComissao->listar($status, $datas);
        $total = $pedidoComissao->Read()->getRowCount();

        $objPaginacao = new paginacao(10, $total, PAG, 10);
        $objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($DadosGet);
        $limite = $objPaginacao->limit();

        $listComissoes = $pedidoComissao->listar($status, $datas, $limite);


       /*
             echo '<pre>';     
             echo $pedidoComissao->_sql;
             echo '</pre>';
       */

    }
		
}