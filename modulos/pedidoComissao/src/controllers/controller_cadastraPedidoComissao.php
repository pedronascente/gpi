<?php
/*
 * *************************************
 * ********* VARIAVEIS DA URL **********
 * *************************************
 */
$DadosGet = filter_input_array(INPUT_GET);
$id_setor = isset($DadosGet['id_setor']) ? $DadosGet['id_setor'] : null;
$id_usuario = isset($DadosGet['id_u']) ? $DadosGet['id_u'] : null;
$id_supervisor = $_SESSION['user_info']['id_usuario'];
$acao = isset($DadosGet['acao']) ? $DadosGet['acao'] : null;
$status = isset($DadosGet['status']) ? $DadosGet['status'] : null;
$pag = isset($DadosGet['pag']) ? $DadosGet['pag'] : null;
$pg = $DadosGet ['pg'];
$pagina = str_replace('pg=', '', $_SERVER ['QUERY_STRING']);
$pedidoComisao = new PedidoComissao;
/*
 * ***********************************************
 * ********* SELECIONA SETOR DO USUARIO **********
 * ***********************************************
 */
$setor = new PedidoComissaoFuncionario;
$pcf = $setor->selDadoFuncionario($id_usuario);
$pcf_setor = !empty($pcf['planilha']) ? $pcf ['planilha'] : NULL;
$pcf_nome = !empty($pcf['nomeFuncionario']) ? $pcf ['nomeFuncionario'] : NULL;
$pcf_matricula = !empty($pcf['matriculaFuncionario']) ? $pcf ['matriculaFuncionario'] : NULL;
$pcf_id = !empty($pcf['pcf_id']) ? $pcf ['pcf_id'] : NULL;
$pcf_ctps = !empty($pcf['ctpsFuncionario']) ? $pcf ['ctpsFuncionario'] : NULL;
$pcf_periodo = !empty($pcf['pcf_periodo']) ? $pcf ['pcf_periodo'] : NULL;
$pcf_ano = !empty($pcf['pcf_ano']) ? $pcf ['pcf_ano'] : NULL;
$pcf_motivo = !empty($pcf['pcf_motivo']) ? $pcf ['pcf_motivo'] : NULL;
$pcf_ctps = empty($pcf['pcf_ctps']) && isset($pcf ['ctps']) ? $pcf['ctps'] : $pcf_ctps;
$pcf_matricula = empty($pcf['pcf_matricula']) && isset($pcf ['matricula']) ? $pcf['matricula'] : $pcf_matricula;
$pcf_nome = empty($pcf['pcf_nome']) && isset($pcf ['nome']) ? $pcf['nome'] : $pcf_nome;
$pcf_status = $pcf ['pcf_status'];
$page = $DadosGet['page'];

if ($page == 'arquivo'):
$pageHistory = "index.php?pg=7";

elseif ($page == 'conferencia'):
$pageHistory = "index.php?pg=8";

else:
$pageHistory = "index.php?pg=5";
endif;

/*
 * **********************************************************
 * ********* RETORNA O TOTAL DE REGISTRO NO BANCO. **********
 * **********************************************************
 */
$pedidoComisao->select(array("id_usuario" => $id_usuario));
$totalPedidoComissao = $pedidoComisao->Read()->getRowCount();
/*
 * ***************************************
 * ********* REALIZA PAGINAÇÃO. **********
 * ***************************************
*/
$objPaginacao = new paginacao(10, $totalPedidoComissao, $pag, 10);
$objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($DadosGet);
$limite = $objPaginacao->limit();
$lista_pedidoComissao = $pedidoComisao->select(array("id_usuario" => $id_usuario, "limite" => $limite));
$totalPorPagina = $pedidoComisao->Read()->getRowCount();

if ($totalPedidoComissao > 0) {
	echo '<input type="hidden" name="t" id="t" value="' . $totalPedidoComissao . '">';
}

/*
 * ************************************
 * ********* RODAPÉ DA TABLE **********
 * ************************************
 */

function _tfooter($c = NULL, $totalComissao = NULL, $total = NULL) {
	return '
        <tr>
          <td  colspan="'.($c).'" align="right"> <strong>Valor Total R$  ' . @Funcoes::formartaMoedaReal($totalComissao) . '</strong></td>
        </tr>
        <tr>
           <td  colspan="'.($c).'" align="right">	<strong>'.$total.' Registros Encontrados</strong></td>
        </tr>  		';
}

/*
 * **********************************************************
 * ********* GERADOR DE BOTÕES (EDITAR E EXCLUIR) **********
 * **********************************************************
 */

function _botoes(array $dados, $excluir) {
	$botoes = '<td>
				 <table width="100%">
				   <tr align="center">
					<td>
						<a id="modulos/pedidoComissao/src/views/formularios/form_modal.php?page=' . $dados['page'] .  '&id_u=' . $dados['id_usuario'] . '&id_setor=' . $dados['id_setor'] . '&id_pc=' . $dados['id_pc'] . '&acao=editarComissao&tipo=modal" class="modalOpen btn  btn-sm btn-info" data-target="#modalPedidoComissao">
							 Editar
						</a>
					 </td>
					 <td>';

	$botoes .=!$excluir ?
	'<td>
						<a id="modulos/pedidoComissao/src/controllers/pedido_comissao.php?page=' . $dados['page'] . '&id_setor=' . $dados['id_setor'] . '&id_pc=' . $dados['id_pc'] . '&id_user=' . $dados['id_usuario'] . '&acao=delete" class="botaoLoad deletePedidoComissao btn  btn-sm btn-danger" >
								 Deletar

						</a>
					  </td>
				   </tr>
				 </table>
			</td>' :
			' </tr>
				 </table>
			</td>';

	echo $botoes;
}

/*
 * ***********************************************************************************
 * ********* O FORMULARIO DE CADASTRO DE COMISSÔES SO VAI APARECER QUANDO O  **********
 * ********* STATUS == 0 OU SEJA ENQUANTO A PLANILHA ESTIVER ATIVA          **********
 * ***********************************************************************************
 */
echo ($status == 2) ? '<div class="ATENCAO"><img src="public/img/botoes/Advertencia.png" width="18" height="16">  ATENÇÃO : ' . $pcf_motivo . ' </div>' : '';

if (isset($acao) && $acao == "AddPedidoComissao"):

include_once __DIR__."/../views/formularios/form_modal.php";

endif;