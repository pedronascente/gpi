<?php
@session_start();
//header('Content-Type: text/html; charset=utf-8');
include_once("../../../../Config.inc.php");

$dados = filter_input_array(INPUT_POST) != null ? filter_input_array(INPUT_POST) : filter_input_array(INPUT_GET);

$acao = isset($dados['acao']) ? $dados['acao'] : $_GET['acao'];
unset($dados['acao'], $dados['X'], $dados['Y']);

$pc = new PedidoComissao();
$pcf = new PedidoComissaoFuncionario();
$planilha = new PlanilhaComissoes;
$veiculo = new Veiculos;

$textos['pedido_comissao_data'] = isset($dados['pedido_comissao_data']) ? $dados['pedido_comissao_data'] : "";
$textos['pedido_comissao_conta'] = isset($dados['pedido_comissao_conta']) ? $dados['pedido_comissao_conta'] : "";
$textos['pedido_comissao_placa'] = isset($dados['pedido_comissao_placa']) ? $dados['pedido_comissao_placa'] : "";
$textos['pedido_comissao_comissao1'] = isset($dados['pedido_comissao_comissao1']) ? $dados['pedido_comissao_comissao1'] : "";
$textos['pedido_comissao_comissao2'] = isset($dados['pedido_comissao_comissao2']) ? $dados['pedido_comissao_comissao2'] : "";
$textos['pedido_comissao_comissao3'] = isset($dados['pedido_comissao_comissao3']) ? $dados['pedido_comissao_comissao3'] : "";
$textos['pedido_comissao_inst_venda'] = isset($dados['pedido_comissao_inst_venda']) ? $dados['pedido_comissao_inst_venda'] : "";
$textos['pedido_comissao_mensal'] = isset($dados['pedido_comissao_mensal']) ? $dados['pedido_comissao_mensal'] : "";
$textos['pedido_comissao_tx_instalacao'] = isset($dados['pedido_comissao_tx_instalacao']) ? $dados['pedido_comissao_tx_instalacao'] : "";
$textos['pedido_comissao_desc_comissao'] = isset($dados['pedido_comissao_desc_comissao']) ? $dados['pedido_comissao_desc_comissao'] : "";

$logs = new Log;

switch ($acao) {
        /*
     * ************************************************************
     * ********* REGISTRAR AS COMISSÕES DOS FUNCIONARIOS **********
     * ************************************************************
     */

    case "AddPedidoComissao":
        $page = $dados['page'];
        $setor = $dados['id_setor'];
        unset($dados['page'], $dados['id_setor']);
        $dados['pedido_comissao_data'] = Funcoes::FormatadataSql($dados['pedido_comissao_data']);
        $dados['pedido_comissao_conta'] = !empty($dados['pedido_comissao_conta']) ? $dados['pedido_comissao_conta'] : null;
        $dados['pedido_comissao_placa'] = !empty($dados['pedido_comissao_placa']) ? $dados['pedido_comissao_placa'] : null;
        $dados['pedido_comissao_comissao1'] = !empty($dados['pedido_comissao_comissao1']) ? Funcoes::moeda(str_replace('R$ ', '', $dados['pedido_comissao_comissao1'])) : null;
        $dados['pedido_comissao_comissao2'] = !empty($dados['pedido_comissao_comissao2']) ? Funcoes::moeda(str_replace('R$ ', '', $dados['pedido_comissao_comissao2'])) : null;
        $dados['pedido_comissao_comissao3'] = !empty($dados['pedido_comissao_comissao3']) ? Funcoes::moeda(str_replace('R$ ', '', $dados['pedido_comissao_comissao3'])) : null;
        $dados['pedido_comissao_inst_venda'] = !empty($dados['pedido_comissao_inst_venda']) ? Funcoes::moeda(str_replace('R$ ', '', $dados['pedido_comissao_inst_venda'])) : null;
        $dados['pedido_comissao_mensal'] = !empty($dados['pedido_comissao_mensal']) ? Funcoes::moeda(str_replace('R$ ', '', $dados['pedido_comissao_mensal'])) : null;
        $dados['pedido_comissao_tx_instalacao'] = !empty($dados['pedido_comissao_tx_instalacao']) ? Funcoes::moeda(str_replace('R$ ', '', $dados['pedido_comissao_tx_instalacao'])) : null;
        $dados['pedido_comissao_desc_comissao'] = !empty($dados['pedido_comissao_desc_comissao']) ? Funcoes::moeda(str_replace('R$ ', '', $dados['pedido_comissao_desc_comissao'])) : null;

        // INSERIR DADOS NO BANCO:
        $dados['pedido_comissao_id'] = $pc->insert($dados);

        $dados['id'] = $dados['pedido_comissao_id_usuario'];

        if (!empty($dados['pedido_comissao_id']))
            Funcoes::gerarLogCadastro($logs, "Cadastro Comissão", $dados, 4, array("pedido_comissao_id_usuario" => "id_planilha"), $textos);

        if ($page == "arquivo")
            header("Location: ../../../../index.php?pg=6&id_u=" . $dados['pedido_comissao_id_usuario'] . "&acao=visualizar&page=" . $page . "&id_setor=" . $setor);
        else
            header("Location: ../../../../index.php?pg=6&id_u=" . $dados['pedido_comissao_id_usuario'] . "&acao=" . $acao . "&page=" . $page . "&id_setor=" . $setor);
        break;


        /*
     * *********************************************************
     * ********* RESPONSAVEL POR EDITAR AS COMISSÕES **********
     * *********************************************************
     */
    case "editarComissao":
        // DADOS DE ENTRADAS:

        $anterior = $pc->selectIdPedidoComissaoArray($dados['pedido_comissao_id']);

        $setor = $dados['id_setor'];
        $id_u = $dados['pedido_comissao_id_usuario'];
        $page = !empty($dados['page']) ? $dados['page'] : "0";

        unset($dados['pedido_comissao_id_usuario'], $dados['status'], $dados['page'], $dados['id_setor']);

        $dados['pedido_comissao_data'] = Funcoes::FormatadataSql($dados['pedido_comissao_data']);
        $dados['pedido_comissao_conta'] = !empty($dados['pedido_comissao_conta']) ? preg_replace("/[^0-9]/", "", $dados['pedido_comissao_conta']) : null;
        $dados['pedido_comissao_placa'] = !empty($dados['pedido_comissao_placa']) ? $dados['pedido_comissao_placa'] : null;
        $dados['pedido_comissao_comissao1'] = !empty($dados['pedido_comissao_comissao1']) ? Funcoes::moeda(str_replace('R$ ', '', $dados['pedido_comissao_comissao1'])) : null;
        $dados['pedido_comissao_comissao2'] = !empty($dados['pedido_comissao_comissao2']) ? Funcoes::moeda(str_replace('R$ ', '', $dados['pedido_comissao_comissao2'])) : null;
        $dados['pedido_comissao_comissao3'] = !empty($dados['pedido_comissao_comissao3']) ? Funcoes::moeda(str_replace('R$ ', '', $dados['pedido_comissao_comissao3'])) : null;
        $dados['pedido_comissao_inst_venda'] = !empty($dados['pedido_comissao_inst_venda']) ? Funcoes::moeda(str_replace('R$ ', '', $dados['pedido_comissao_inst_venda'])) : null;
        $dados['pedido_comissao_mensal'] = !empty($dados['pedido_comissao_mensal']) ? Funcoes::moeda(str_replace('R$ ', '', $dados['pedido_comissao_mensal'])) : null;
        $dados['pedido_comissao_tx_instalacao'] = !empty($dados['pedido_comissao_tx_instalacao']) ? Funcoes::moeda(str_replace('R$ ', '', $dados['pedido_comissao_tx_instalacao'])) : null;
        $dados['pedido_comissao_desc_comissao'] = !empty($dados['pedido_comissao_desc_comissao']) ? Funcoes::moeda(str_replace('R$ ', '', $dados['pedido_comissao_desc_comissao'])) : null;

        // ATUALIZA DADOS NO BANCO
        $pc->updatePedidoComissao($dados);

        if ($page == "cadastrar")
            $acao = "AddPedidoComissao";
        else if ($page == "conferencia")
            $acao = "editarComissao";
        else
            $acao = "visualizar";

        $dados['id'] = $id_u;

        $anterior['pedido_comissao_data'] = substr($anterior['pedido_comissao_data'], 0, -9);

        Funcoes::gerarLogAlteracao($logs, "Edição Comissão", $dados, $anterior, 4, null, array("pedido_comissao_id_usuario" => "id_planilha"), $textos);

        header("Location: ../../../../index.php?pg=6&id_u=" . $id_u . "&acao=" . $acao . "&page=" . $page . "&id_setor=" . $setor);

        break;


        /*
     * ************************************************************
     * ********* RESPONSAVEL POR ENCAMINHAR AS PLANILHAS **********
     * ************************************************************
     */
    case "enviar_dados":

        $id = isset($_POST["id"]) ? $_POST["id"] : '';

        $pcf->liberarPlanilha($id);

        $total = $pcf->somarComissoes($id) - $pcf->somarDescontos($id);

        Funcoes::gerarLogCadastro($logs, "Envio Planilha de Comissão", array("id" => $id, "id_planilha" => $id, "valor" => $total), 4);

        die(json_encode(array("type" => 1)));
        break;

        /*
     * **********************************************************
     * ********* RESPONSAVEL POR ARQUIVAR AS PLANILHAS **********
     * **********************************************************
     */
    case "arquivarPlanilha":
        (new PedidoComissaoFuncionario())->arquivarDados($dados['id']);
        Funcoes::gerarLogCadastro($logs, "Arquivar Planilha de Comissão", array("id" => $dados['id'], "id_planilha" => $dados['id']), 4);
        header("location: ../../../../index.php?pg=8&result=on#tabs-1");
        break;

        /*
     * **********************************************************
     * ********* RESPONSAVEL POR REPROVAR AS PLANILHAS **********
     * **********************************************************
     */
    case "reprovarPlanilha":
        (new PedidoComissaoFuncionario())->reprovaPlanilha($dados['id'], $dados['motivo']);
        Funcoes::gerarLogCadastro($logs, "Reprovar Planilha de Comissão", array("id" => $dados['id'], "id_planilha" => $dados['id'], "motivo" => $dados['motivo']), 4);
        header("location: ../../../../index.php?pg=8&result=4#tabs-1");
        break;
        /*
     * *****************************************************************
     * ********* RESPONSAVEL POR GERÊNCIAR AS INCONSISTENCIAS **********
     * *****************************************************************
     */
    case "getInconsistencia":
        $listaInconsistencia = new PedidoComissaoFuncionario();
        $result = $listaInconsistencia->inconsistenciaDetalhe($dados["id_conta_placa"], $dados["tipo"]);
        die(json_encode($result));
        break;

        /*
     * *************************************
     * ********* DELETA COMISSÕES **********
     * *************************************
     */
    case "delete":

        $comissao = $pc->selectIdPedidoComissaoArray($dados['id_pc']);

        $pc->deletePedidoComissao($dados['id_pc']);
        $pc->deleteInconsistencias($dados['id_pc']);

        $comissao['id'] = $dados['id_user'];

        Funcoes::gerarLogCadastro($logs, "Exclusão Comissão", $comissao, 4, array("pedido_comissao_id_usuario" => "id_planilha"), $textos);

        if ($dados['page'] == "conferencia")
            header("Location: ../../../../index.php?pg=6&page=conferencia&id_u=" . $dados['id_user'] . "&id_setor=" . $dados['id_setor'] . "&acao=editarComissao");
        else
            header("Location: ../../../../index.php?pg=6&page=cadastrar&id_u=" . $dados['id_user'] . "&id_setor=" . $dados['id_setor'] . "&acao=AddPedidoComissao");
        break;

        /*
     * ****************************************
     * ********* DELETA FUNCIONARIOS **********
     * ****************************************
     */
    case "del_funcionario":

        $pedido_comissao_funcionario = $pcf->selectPCF($dados['id']);

        $comissoes = $pc->getComissoesPlanilha($dados['id']);

        if (!empty($comissoes)) {
            foreach ($comissoes as $c) {
                $pc->deletePedidoComissao($c['pedido_comissao_id']);
                $pc->deleteInconsistencias($c['pedido_comissao_id']);
            }
        }

        $pcf->deletePedidoComissaoFuncionario($dados['id']);

        $pedido_comissao_funcionario['id'] = $pedido_comissao_funcionario['pcf_id'];

        Funcoes::gerarLogCadastro($logs, "Exclusão Planilha Comissão", $pedido_comissao_funcionario, 4, array("pedido_comissao_id_usuario" => "id_planilha"));

        die(json_encode(array("type" => 1)));
        break;

        /*
     * *************************************************************
     * ********* RESPONSAVEL POR EXPORTA DADOS PARA EXCEL **********
     * *************************************************************
     */
    case "excel":
        $tipo = isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"] : $_GET["tipo"];

        if ($tipo == "arquivada") :
            $lista = $pcf->selectTodosArquivados(null, null);
        else :
            $lista = $pcf->selectTodos(null);
        endif;

        $html = '					
				<table width="100%" border="1">
				  <caption><h2>Planilhas Gerais de Comissões </h2></caption>
					<thead>
					   <tr align="left">
							<th>Nome</th>
							<th>Comiss&atilde;o</th>
							<th>Setor</th>
							<th>Per&iacute;odo</th>
							<th>Ano</th>
						</tr>    
					</thead>
					<tbody>';
        if ($lista) :
            foreach ($lista as $li) :
                $nome = !empty($li["pcf_nome"]) ? $li["pcf_nome"] : $li["nome"];
                $total_comissao = $pcf->somarComissoes($li['pcf_id']) - $pcf->somarDescontos($li['pcf_id']);
                $html .= '
							<tr align="left">
								<td>' . utf8_encode($nome) . '</td>
								<td>R$ <span class="span_direito">' . Funcoes::formartaMoedaReal($total_comissao) . '</td>
								<td>' . utf8_encode($li["setor_local"]) . '</td>
								<td align="center">' . $li["pcf_periodo"] . '</td>
								<td align="center">' . $li["pcf_ano"] . '</td>
							</tr>';
            endforeach;

        endif;
        $html .= '
					</tbody>
				</table>
				</table>';
        Funcoes::exportExel($html, "Planilha_geral_pedido_comissoes.xls");
        break;

    case "excel2":

        $id = $_GET['id'];
        $id_planilha = $_GET['id_planilha'];
        $usuario = $_GET['titulo'];
        $pc = new PedidoComissao(); // - obj ->pedidoComissao
        $lista_pedidoComissao = $pc->select(array("id_usuario" => $id, "status" => true)); // listar todas as comissões do funcionario 'X'
        switch ($id_planilha):
            case 33:
                $html = '<table width="100%" cellpadding="0" cellspacing="0" border="1" >
					<caption><h2>' . $usuario . '</h2></caption>
					<thead>
						<tr>
							<th>Linha</th>
							<th>Data</th>
							<th>Cliente</th>
							<th>Servi&ccedil;o</th>
							<th>Meio</th>
							<th>Ins. / Vendas</th>
							<th>Mensal</th>
							<th>Comiss&atilde;o</th>
							<th>Desconto de Comiss&atilde;o</th>
							<th>Inconsist&ecirc;ncia</th>
						</tr>
					</thead>
					<tbody>';
                if ($lista_pedidoComissao) :
                    foreach ($lista_pedidoComissao as $k => $dados) :
                        $nomeCliente = !empty($dados["cliente"]) ? $dados["cliente"] : "";
                        $data = !empty($dados['pedido_comissao_data']) ? Funcoes::formataData($dados['pedido_comissao_data']) : "";

                        $inconsistencia = isset($dados['situacao']) ? $dados['situacao'] : "";
                        if ($inconsistencia == 1)
                            $inconsistencia = "Em An&aacute;lise";
                        else if ($inconsistencia == 2)
                            $inconsistencia = "Liberada";
                        else if ($inconsistencia == 3)
                            $inconsistencia = "Reprovada";

                        $html .= '
									<tr align="left">
										<td>' . ($k + 1) . '</td> 
										<td>' . $data . '</td> 
										<td>' . utf8_encode($nomeCliente) . '</td> 
										<td>' . utf8_encode(ucfirst($dados["pedido_comissao_servico"])) . '</td> 
										<td>' . utf8_encode($dados["pedido_comissao_captacao"]) . '</td> 
										<td> R$ ' . Funcoes::formartaMoedaReal($dados["pedido_comissao_inst_venda"]) . '</td> 
										<td> R$ ' . Funcoes::formartaMoedaReal($dados["pedido_comissao_mensal"]) . '</td> 
										<td> R$ ' . Funcoes::formartaMoedaReal($dados["pedido_comissao_comissao1"]) . '</td>
										<td> R$ ' . Funcoes::formartaMoedaReal($dados["pedido_comissao_desc_comissao"]) . '</td> 
										<td>' . $inconsistencia . '</td>
									</tr>';
                    endforeach;

                endif;
                $html .= '	
					</tbody>
				</table>';
                break;
            case 46:
                $html = ' <table width="100%" cellpadding="0" cellspacing="0" border="1">
					<caption><h2>' . $usuario . '</h2></caption>
					<thead>
						<tr>
                                                <th>Linha</th>
                                                <th>Data</th>
                                                <th>Nome do cliente</th>
                                                <th>Qtd de Veículos</th>
                                                <th>Tx. Instala&ccedil;&atilde;o</th>
                                                <th>Desconto de Comiss&atilde;o</th>
                                                <th>Mensal</th>
                                                <th>Comiss&atilde;o</th>
                                                <th>Inconsist&ecirc;ncia</th>
						</tr>
					</thead>
					<tbody>';
                if ($lista_pedidoComissao) :
                    foreach ($lista_pedidoComissao as $k => $dados) :
                        $nomeCliente = !empty($dados["cliente"]) ? $dados["cliente"] : "";
                        $data = !empty($dados['pedido_comissao_data']) ? Funcoes::formataData($dados['pedido_comissao_data']) : "";

                        $inconsistencia = isset($dados['situacao']) ? $dados['situacao'] : "";
                        if ($inconsistencia == 1)
                            $inconsistencia = "Em An&aacute;lise";
                        else if ($inconsistencia == 2)
                            $inconsistencia = "Liberada";
                        else if ($inconsistencia == 3)
                            $inconsistencia = "Reprovada";

                        $html .= '
								<tr align="left">
									<td>' . ($k + 1) . '</td> 
									<td>' . $data . '</td> 
									<td>' . $nomeCliente . '</td> 
									<td>' . $dados["pedido_comissao_qtd_veiculo"] . '</td> 
									<td>R$' . Funcoes::formartaMoedaReal($dados["pedido_comissao_tx_instalacao"]) . '</td> 
									<td>R$' . Funcoes::formartaMoedaReal($dados["pedido_comissao_desc_comissao"]) . '</td> 
									<td>R$' . Funcoes::formartaMoedaReal($dados["pedido_comissao_mensal"]) . '</td> 
									<td>R$' . Funcoes::formartaMoedaReal($dados["pedido_comissao_comissao1"]) . '</td> 
									<td>' . $inconsistencia . '</td>
								  </tr>';
                    endforeach;

                endif;
                $html .= '	
						</tbody>
					</table>';
                break;
            case 60:
                $html = '<table width="100%" cellpadding="0" cellspacing="0" border="1">
					<caption><h2>' . $usuario . '</h2></caption>
					<thead>
						<tr>
							<th>Linha</th>
							<th>Data</th>
							<th>Nome Cliente</th>
							<th>Comiss&atilde;o</th>
							<th>Desconto de Comiss&atilde;o</th>
							<th>Conta</th> 
							<th>Inconsistencia</th>
						</tr>
					</thead>
					<tbody>';
                if ($lista_pedidoComissao) :
                    foreach ($lista_pedidoComissao as $k => $dados) :
                        $nomeCliente = !empty($dados["cliente"]) ? $dados["cliente"] : "";
                        $data = !empty($dados['pedido_comissao_data']) ? Funcoes::formataData($dados['pedido_comissao_data']) : "";

                        $inconsistencia = isset($dados['situacao']) ? $dados['situacao'] : "";
                        if ($inconsistencia == 1)
                            $inconsistencia = "Em An&aacute;lise";
                        else if ($inconsistencia == 2)
                            $inconsistencia = "Liberada";
                        else if ($inconsistencia == 3)
                            $inconsistencia = "Reprovada";

                        $html .= '
								<tr align="left">
									<td>' . ($k + 1) . '</td> 
									<td>' . $data . '</td> 
									<td>' . utf8_encode($nomeCliente) . '</td> 
									<td>R$' . Funcoes::formartaMoedaReal($dados["pedido_comissao_comissao1"]) . '</td>
									<td> R$ ' . Funcoes::formartaMoedaReal($dados["pedido_comissao_desc_comissao"]) . '</td> 
									<td>' . $dados["pedido_comissao_conta"] . '</td> 
									<td>' . $inconsistencia . '</td>		
							   </tr>';
                    endforeach;

                endif;
                $html .= '   
					</tbody>
				</table>';
                break;
            case 61:
                $html = '	<table width="100%" cellpadding="0" cellspacing="0" border="1">
					<caption><h2>' . $usuario . '</h2></caption>
					<thead>
					<tr>
						<th>Linha</th>
						<th>Data</th>
						<th>Cliente</th>
						<th>Comiss&atilde;o</th>
						<th>Desconto de Comiss&atilde;o</th>
						<th>Raz&atilde;o Social Antiga</th>
						<th>Motivo</th>
						<th>Inconsist&ecirc;ncia</th>
					</tr>
					</thead>
					<tbody>';
                if ($lista_pedidoComissao) :
                    foreach ($lista_pedidoComissao as $k => $dados) :
                        $raCliente = !empty($dados["pedido_comissao_razao_social_antiga"]) ? $dados["cliente"] : "";
                        $rnCliente = !empty($dados["pedido_comissao_razao_social_nova"]) ? $dados["cliente"] : '';
                        $data = !empty($dados['pedido_comissao_data']) ? Funcoes::formataData($dados['pedido_comissao_data']) : "";
                        $nomeCliente = !empty($dados["cliente"]) ? $dados["cliente"] : "";

                        $inconsistencia = isset($dados['situacao']) ? $dados['situacao'] : "";
                        if ($inconsistencia == 1)
                            $inconsistencia = "Em An&aacute;lise";
                        else if ($inconsistencia == 2)
                            $inconsistencia = "Liberada";
                        else if ($inconsistencia == 3)
                            $inconsistencia = "Reprovada";

                        $html .= '
							<tr align="left">
								<td>' . ($k + 1) . '</td> 
								<td>' . $data . '</td> 
								<td>' . $nomeCliente . '</td> 
								<td>R$' . Funcoes::formartaMoedaReal($dados["pedido_comissao_comissao1"]) . '</td> 
								<td> R$ ' . Funcoes::formartaMoedaReal($dados["pedido_comissao_desc_comissao"]) . '</td>
								<td>' . utf8_encode($raCliente) . '</td>
								<td>' . utf8_encode($rnCliente) . '</td> 
								<td>' . $inconsistencia . '</td>
							</tr>';
                    endforeach;

                endif;
                $html .= '
					</tbody>  
				</table>';
                break;
            case 62:
                $excel = $html = ' <table width="100%" cellpadding="0" cellspacing="0" border="1">
					<caption><h2>' . $usuario . '</h2></caption>
					<thead>
						<tr>
							<th>Linha</th>
							<th>Data</th>
							<th>Cliente</th>
							<th>Conta / Pedido</th>
							<th>Servi&ccedil;o</th>							
							<th>Inst. / Venda</th>
							<th>Mensal</th>
							<th>Consultor</th>
							<th>Comiss&atilde;o</th>
							<th>Desconto de Comiss&atilde;o</th>
							<th>Inconsist&ecirc;ncia</th>
						</tr>
					</thead>
					<tbody>';
                if ($lista_pedidoComissao) :
                    foreach ($lista_pedidoComissao as $k => $dados) :
                        $nomeCliente = !empty($dados["cliente"]) ? $dados["cliente"] : "";
                        $data = !empty($dados['pedido_comissao_data']) ? Funcoes::formataData($dados['pedido_comissao_data']) : "";

                        $inconsistencia = isset($dados['situacao']) ? $dados['situacao'] : "";
                        if ($inconsistencia == 1)
                            $inconsistencia = "Em An&aacute;lise";
                        else if ($inconsistencia == 2)
                            $inconsistencia = "Liberada";
                        else if ($inconsistencia == 3)
                            $inconsistencia = "Reprovada";

                        $html .= '
								  <tr align="left">
										<td>' . ($k + 1) . '</td> 
										<td>' . $data . '</td> 
										<td>' . utf8_encode($nomeCliente) . '</td>
										<td>' . $dados["pedido_comissao_conta"] . '</td> 
										<td>' . utf8_encode(ucfirst($dados["pedido_comissao_servico"])) . '</td>
										<td>R$ ' . Funcoes::formartaMoedaReal($dados["pedido_comissao_inst_venda"]) . '</td> 
										<td>R$ ' . Funcoes::formartaMoedaReal($dados["pedido_comissao_mensal"]) . '</td> 
										<td>' . utf8_encode(ucfirst($dados["pedido_comissao_consultor"])) . '</td> 
										<td> R$ ' . Funcoes::formartaMoedaReal($dados["pedido_comissao_comissao1"]) . '</td> 
										<td> R$ ' . Funcoes::formartaMoedaReal($dados["pedido_comissao_desc_comissao"]) . '</td>
										<td>' . $inconsistencia . '</td>
								  </tr>';
                    endforeach;

                endif;
                $html .= '
					</tbody>    
				</table> ';
                break;
            case 63:
                $excel = $html = ' <table width="100%" cellpadding="0" cellspacing="0" border="1">
					<caption><h2>' . $usuario . '</h2></caption>
					<thead>
						<tr>
							<th>Linha</th>
							<th>Data</th>
							<th>Cliente</th>
							<th>Conta Pedido</th>
							<th>Comiss&atilde;o</th>
							<th>Desconto de Comiss&atilde;o</th>
							<th>Total de Rastreadores</th>
							<th>Inconsist&ecirc;ncia</th>
						</tr>
					</thead>
					<tbody>';
                if ($lista_pedidoComissao) :
                    foreach ($lista_pedidoComissao as $k => $dados) :
                        $nomeCliente = !empty($dados["cliente"]) ? $dados["cliente"] : "";
                        $data = !empty($dados['pedido_comissao_data']) ? Funcoes::formataData($dados['pedido_comissao_data']) : "";

                        $inconsistencia = isset($dados['situacao']) ? $dados['situacao'] : "";
                        if ($inconsistencia == 1)
                            $inconsistencia = "Em An&aacute;lise";
                        else if ($inconsistencia == 2)
                            $inconsistencia = "Liberada";
                        else if ($inconsistencia == 3)
                            $inconsistencia = "Reprovada";

                        $html .= '
							<tr align="left">
									<td>' . ($k + 1) . '</td> 
									<td>' . $data . '</td> 
									<td>' . utf8_encode($nomeCliente) . '</td> 
									<td>' . $dados["pedido_comissao_conta"] . '</td> 
									<td> R$ ' . Funcoes::formartaMoedaReal($dados["pedido_comissao_comissao1"]) . '</td> 
									<td> R$ ' . Funcoes::formartaMoedaReal($dados["pedido_comissao_desc_comissao"]) . '</td>
									<td>' . $dados["pedido_comissao_total_rastreadores"] . '</td>
									<td>' . $inconsistencia . '</td> 
								</tr>';
                    endforeach;

                endif;
                $html .= '	
					</tbody>
				</table>';
                break;
            case 64:
                $excel = $html = ' <table width="100%" cellpadding="0" cellspacing="0" border="1">
				<caption><h2>' . $usuario . '</h2></caption>
				<thead>
					<tr>
						<th>Linha</th>
						<th>Data</th>
						<th>Nome do Cliente</th>
						<th>Comiss&atilde;o</th>
						<th>Desconto de Comiss&atilde;o</th>
						<th>Inst./Venda</th>
						<th>Mensal</th>
						<th>Conta</th>
						<th>Equip / Servi&ccedil;o</th>
						<th>Inconsist &ecirc;ncia</th>
					</tr>
				</thead>
				<tbody>';
                if ($lista_pedidoComissao) :
                    foreach ($lista_pedidoComissao as $k => $dados) :
                        $nomeCliente = !empty($dados["cliente"]) ? $dados["cliente"] : "";
                        $data = !empty($dados['pedido_comissao_data']) ? Funcoes::formataData($dados['pedido_comissao_data']) : "";

                        $inconsistencia = isset($dados['situacao']) ? $dados['situacao'] : "";
                        if ($inconsistencia == 1)
                            $inconsistencia = "Em Análise";
                        else if ($inconsistencia == 2)
                            $inconsistencia = "Liberada";
                        else if ($inconsistencia == 3)
                            $inconsistencia = "Reprovada";

                        $html .= '
							  <tr align="left">
									<td>' . ($k + 1) . '</td> 
									<td>' . $data . '</td> 
									<td>' . utf8_encode($nomeCliente) . '</td>
									<td> R$' . Funcoes::formartaMoedaReal($dados["pedido_comissao_comissao1"]) . '</td> 
									<td> R$ ' . Funcoes::formartaMoedaReal($dados["pedido_comissao_desc_comissao"]) . '</td>
									<td> R$' . Funcoes::formartaMoedaReal($dados["pedido_comissao_inst_venda"]) . '</td> 
									<td> R$' . Funcoes::formartaMoedaReal($dados["pedido_comissao_mensal"]) . '</td> 
									<td>' . $dados["pedido_comissao_conta"] . '</td>
									<td>' . utf8_encode($dados["pedido_comissao_equip_servico"]) . '</td> 
									<td>' . $inconsistencia . '</td>
								</tr>';
                    endforeach;

                endif;
                $html .= '
				</tbody>
			</table>';
                break;
            case 65:
                $excel = $html = '<table width="100%" cellpadding="0" cellspacing="0" border="1">
				<caption><h2>' . $usuario . '</h2></caption>
				<thead>
					<tr>
						<th>Linha</th>
						<th>Data</th>
						<th>Nome do Cliente</th>
						<th>Conta</th>
						<th>N° da O.S</th>
						<th>Servi&ccedil;o</th>
						<th>Comiss&atilde;o</th>
						<th>Desconto de Comiss&atilde;o</th>
						<th>Inconsist&ecirc;ncia</th>
					</tr>
				</thead>
				<tbody>';
                if ($lista_pedidoComissao) :
                    foreach ($lista_pedidoComissao as $k => $dados) :
                        $nomeCliente = !empty($dados["cliente"]) ? $dados["cliente"] : "";
                        $data = !empty($dados['pedido_comissao_data']) ? Funcoes::formataData($dados['pedido_comissao_data']) : "";

                        $inconsistencia = isset($dados['situacao']) ? $dados['situacao'] : "";
                        if ($inconsistencia == 1)
                            $inconsistencia = "Em An&aacute;lise";
                        else if ($inconsistencia == 2)
                            $inconsistencia = "Liberada";
                        else if ($inconsistencia == 3)
                            $inconsistencia = "Reprovada";

                        $html .= '
							<tr align="left">
								<td>' . ($k + 1) . '</td> 
								<td>' . $data . '</td> 
								<td>' . utf8_encode($nomeCliente) . '</td>
								<td>' . $dados["pedido_comissao_conta"] . '</td> 
								<td>' . $dados["pedido_comissao_n_os"] . '</td>
								<td>' . utf8_encode($dados["pedido_comissao_servico"]) . '</td>
								<td> R$' . Funcoes::formartaMoedaReal($dados["pedido_comissao_comissao1"]) . '</td> 
								<td> R$ ' . Funcoes::formartaMoedaReal($dados["pedido_comissao_desc_comissao"]) . '</td>
								<td>' . $inconsistencia . '</td>
							 </tr>';
                    endforeach;

                endif;

                $html .= '
				</tbody>
			</table>';
                break;
            case 66:
                /**
                 * ***************************************************************************
                 * ***************** PLANILHA EXCEL DE TECNICA DE RASTREAMENTO *****************
                 * ***************************************************************************
                 */
                $html = ' <table width="100%" cellpadding="0" cellspacing="0" border="1">
				<caption><h2>' . $usuario . '</h2></caption>
					<thead>
						<tr>
							<th>Linha</th>
							<th>Data</th>
							<th>Cliente</th>
							<th>Conta / Pedido</th>
							<th>Placa</th>
							<th>Observaç&atilde;o</th>
							<th>Comiss&atilde;o</th>
							<th>Desconto de Comiss&atilde;o</th>
							<th>Inconsist&ecirc;ncia</th>
						</tr>
						</thead>
						<tbody>';
                if ($lista_pedidoComissao) :
                    foreach ($lista_pedidoComissao as $k => $dados) :
                        $nomeCliente = !empty($dados["cliente"]) ? $dados["cliente"] : "";
                        $data = !empty($dados['pedido_comissao_data']) ? Funcoes::formataData($dados['pedido_comissao_data']) : "";

                        $inconsistencia = isset($dados['situacao']) ? $dados['situacao'] : "";
                        if ($inconsistencia == 1)
                            $inconsistencia = "Em An&aacute;lise";
                        else if ($inconsistencia == 2)
                            $inconsistencia = "Liberada";
                        else if ($inconsistencia == 3)
                            $inconsistencia = "Reprovada";

                        $html .= '
								   <tr align="left">
										<td>' . ($k + 1) . '</td> 
										<td>' . $data . '</td> 
										<td>' . utf8_encode($nomeCliente) . '</td>
										<td>' . $dados["pedido_comissao_conta"] . '</td>										
										<td>' . $dados["pedido_comissao_placa"] . '</td>
										<td>' . utf8_encode($dados["pedido_comissao_obs_rastreamento"]) . '</td>	
										<td> R$' . Funcoes::formartaMoedaReal($dados["pedido_comissao_comissao1"]) . '</td> 
										<td> R$ ' . Funcoes::formartaMoedaReal($dados["pedido_comissao_desc_comissao"]) . '</td>
										<td>' . $inconsistencia . '</td>
								   </tr>';
                    endforeach;


                endif;
                $html .= '
					</tbody>
				</table>';
                break;
            case 150:
                /**
                 * ***************************************************************************
                 * ***************** PLANILHA EXCEL DE TECNICA DE RASTREAMENTO *****************
                 * ***************************************************************************
                 */
                $html = ' <table width="100%" cellpadding="0" cellspacing="0" border="1">
				<caption><h2>' . $usuario . '</h2></caption>
					<thead>
						<tr>
							<th>Linha</th>
							<th>Data</th>
							<th>Cliente</th>
							<th>Conta / Pedido</th>
							<th>Meio</th>
							<th>Ins. / Vendas</th>
        					<th>Mensal</th>
							<th>Comiss&atilde;o</th>
							<th>Desconto de Comiss&atilde;o</th>
							<th>Inconsist&ecirc;ncia</th>
						</tr>
						</thead>
						<tbody>';
                if ($lista_pedidoComissao) :
                    foreach ($lista_pedidoComissao as $k => $dados) :
                        $nomeCliente = !empty($dados["cliente"]) ? $dados["cliente"] : "";
                        $data = !empty($dados['pedido_comissao_data']) ? Funcoes::formataData($dados['pedido_comissao_data']) : "";

                        $inconsistencia = isset($dados['situacao']) ? $dados['situacao'] : "";
                        if ($inconsistencia == 1)
                            $inconsistencia = "Em An&aacute;lise";
                        else if ($inconsistencia == 2)
                            $inconsistencia = "Liberada";
                        else if ($inconsistencia == 3)
                            $inconsistencia = "Reprovada";

                        $html .= '
								   <tr align="left">
										<td>' . ($k + 1) . '</td> 
										<td>' . $data . '</td> 
										<td>' . utf8_encode($nomeCliente) . '</td>
										<td>' . $dados["pedido_comissao_conta"] . '</td>										
										<td>' . $dados["pedido_comissao_captacao"] . '</td>
										<td>' . Funcoes::formartaMoedaReal($dados["pedido_comissao_inst_venda"]) . '</td>	
										<td> R$' . Funcoes::formartaMoedaReal($dados["pedido_comissao_mensal"]) . '</td> 
										<td> R$' . Funcoes::formartaMoedaReal($dados["pedido_comissao_comissao1"]) . '</td> 
										<td> R$ ' . Funcoes::formartaMoedaReal($dados["pedido_comissao_desc_comissao"]) . '</td>
										<td>' . $inconsistencia . '</td>
								   </tr>';
                    endforeach;


                endif;
                $html .= '
					</tbody>
				</table>';
                break;
            case 32:
                /**
                 * ***************************************************************************
                 * ***************** PLANILHA EXCEL DE TECNICA DE RASTREAMENTO *****************
                 * ***************************************************************************
                 */
                $html = ' <table width="100%" cellpadding="0" cellspacing="0" border="1">
				<caption><h2>' . $usuario . '</h2></caption>
					<thead>
						<tr>
							<th>Linha</th>
							<th>Data</th>
							<th>Cliente</th>
							<th>Conta / Pedido</th>
							<th>Comiss&atilde;o</th>
							<th>Inconsist&ecirc;ncia</th>
						</tr>
						</thead>
						<tbody>';
                if ($lista_pedidoComissao) :
                    foreach ($lista_pedidoComissao as $k => $dados) :
                        $nomeCliente = !empty($dados["cliente"]) ? $dados["cliente"] : "";
                        $data = !empty($dados['pedido_comissao_data']) ? Funcoes::formataData($dados['pedido_comissao_data']) : "";

                        $inconsistencia = isset($dados['situacao']) ? $dados['situacao'] : "";
                        if ($inconsistencia == 1)
                            $inconsistencia = "Em An&aacute;lise";
                        else if ($inconsistencia == 2)
                            $inconsistencia = "Liberada";
                        else if ($inconsistencia == 3)
                            $inconsistencia = "Reprovada";

                        $html .= '
								   <tr align="left">
										<td>' . ($k + 1) . '</td> 
										<td>' . $data . '</td> 
										<td>' . utf8_encode($nomeCliente) . '</td>
										<td>' . $dados["pedido_comissao_conta"] . '</td>										
										<td> R$' . Funcoes::formartaMoedaReal($dados["pedido_comissao_comissao1"]) . '</td> 
										<td>' . $inconsistencia . '</td>
								   </tr>';
                    endforeach;


                endif;
                $html .= '
					</tbody>
				</table>';
                break;
        endswitch;
        Funcoes::exportExel($html, "Planilha_geral_pedido_comissoes.xls");
        break;

    case 'insertPlanilha':
        /*
         * **************************************
         * *********** INSERT  PLANILHA**********
         * **************************************
         */

        $anterior = null;

        if (!empty($dados['pcf_id']))
            $anterior = $pcf->selectPlanilha($dados['pcf_id']);

        // 2- inserir a planilha na base de dados:
        $dados['pcf_id_setor'] = $planilha->selectSetor($dados['pcf_planilha']);
        if (empty($dados['pcf_id'])) {
            unset($dados['pcf_id']);
            $dados['pcf_id'] = $pcf->insert($dados);
        } else
            $pcf->atualizarDados($dados);

        $result = 'on';

        $dados['id'] = $dados['pcf_id'];

        if (!empty($result)) {
            if (empty($anterior))
                Funcoes::gerarLogCadastro($logs, "Cadastro Planilha Comissão", $dados, 4);
            else
                Funcoes::gerarLogAlteracao($logs, "Alteração Planilha Comissão", $dados, $anterior, 4);
        }

        header('location: ../../../../index.php?pg=5&result=' . $result);
        break;

    case "updateStatusInconsistencia":

        $id = $_SESSION['user_info']['id_usuario'];

        if ($dados['inconsistencia'] == 0) {
            $inconsistencia['supervisor_id'] = $id;
            $inconsistencia['usuario_id'] = $dados['id_usuario'];
            $inconsistencia['comissao_id'] = $dados['id_comissao'];;
            $inconsistencia['situacao'] = $dados['situacao'];
            $inconsistencia['data_criacao'] = date("Y-m-d H:i:s");
            $pc->insertInconsistencia($inconsistencia);
        } else {
            $pc->updateInconsistencia(array("id" => $dados['inconsistencia'], "situacao" => $dados['situacao'], "supervisor_id" => $id));
        }

        $log['id_comissao'] = $dados['id_comissao'];
        $log['id'] = $dados['id_planilha'];

        $log['situacao'] = $dados['situacao'] == 2 ? "Aprovada" : "Reprovada";

        Funcoes::gerarLogCadastro($logs, "Inconsistênia Comissão", $log, 4);

        die(json_encode(array("type" => "sucess")));
        break;

    case "verificarComissoes":

        $comissoes = $pc->getPedidoComissaoPorPlanilha($dados['id']);

        $verificar = 0;

        $planilha = $pcf->selectPCF($dados['id']);

        $datas = Funcoes::pegarDatasPeriodoPlanilha($planilha['pcf_periodo'], $planilha['pcf_ano']);

        foreach ($comissoes as $comissao) {

            if (!empty($comissao['pedido_comissao_placa']) || !empty($comissao['pedido_comissao_conta'])) {


                $pc->listaInconsistencia($comissao['pedido_comissao_placa'], $comissao['pedido_comissao_conta'], $datas, $comissao['pedido_comissao_id_usuario'], false, null, null, null);

                if ($pc->Read()->getRowCount() >= 1)
                    $verificar = 1;
            }
        }

        if ($verificar == 0) {
            $verificar = $pc->contarComissoes($dados['id']) < 1 ? 2 : 0;
        }
        die(json_encode(array("type" => $verificar)));
        break;

    case "getInconsistenciasPlanilha":

        $comissao = $pc->selectIdPedidoComissaoArray($dados['id']);

        $conta_placa = explode("_", $dados['conta_placa']);

        $conta = isset($conta_placa[0]) ? $conta_placa[0] : "";
        $placa = isset($conta_placa[1]) ? $conta_placa[1] : "";

        $comissoes = $pc->getInconsistencias($placa, $conta, true, $comissao['pedido_comissao_data']);

        $tr = "";

        foreach ($comissoes as $k => $c) {
            $tr .= "<tr " . Funcoes::zebrarTR($k) . " class='removeLinha'>
					<td>" . $c['nomeFuncionario'] . "</td>
					<td>" . $c['usuarioCadastro'] . "</td>
					<td>" . $dados['conta_placa'] . "</td>
					<td>" . $c['pcf_periodo'] . "</td>
					<td>" . $c['pcf_ano'] . "</td>
					<td>" . Funcoes::formataData($c['pedido_comissao_data']) . "</td>
					<td>" . $c['cliente'] . "</td>
					<td>" . $c['comissao'] . "</td>
					<td>" . $c['pedido_comissao_servico'] . "</td>
					<td>" . $c['pedido_comissao_n_os'] . "</td>
					</tr>";
        }

        die(json_encode(array("inconsistencias" => $tr)));
        break;


    case "gerarComissoes":

        $periodo = $pcf->selectPCF($dados['id_planilha']);

        $periodo = explode(" / ", $periodo['pcf_periodo']);

        $inicial = null;
        $final = null;

        $ano = date("Y");

        switch ($periodo[0]) {
            case "JAN":
                $inicial = "01";
                break;
            case "FEV":
                $inicial = "02";
                break;
            case "MAR":
                $inicial = "03";
                break;
            case "ABR":
                $inicial = "04";
                break;
            case "MAI":
                $inicial = "05";
                break;
            case "JUN":
                $inicial = "06";
                break;
            case "JUL":
                $inicial = "07";
                break;
            case "AGO":
                $inicial = "08";
                break;
            case "SET":
                $inicial = "09";
                break;
            case "OUT":
                $inicial = "10";
                break;
            case "NOV":
                $inicial = "11";
                break;
            case "DEZ":
                $inicial = "12";
                break;
        }

        switch ($periodo[1]) {
            case "JAN":
                $final = "01";
                break;
            case "FEV":
                $final = "02";
                break;
            case "MAR":
                $final = "03";
                break;
            case "ABR":
                $final = "04";
                break;
            case "MAI":
                $final = "05";
                break;
            case "JUN":
                $final = "06";
                break;
            case "JUL":
                $final = "07";
                break;
            case "AGO":
                $final = "08";
                break;
            case "SET":
                $final = "09";
                break;
            case "OUT":
                $final = "10";
                break;
            case "NOV":
                $final = "11";
                break;
            case "DEZ":
                $final = "12";
                break;
        }

        $inicial = $ano . "-" . $inicial . "-21 00:00:00";
        $ano = $final == "01" ? $ano + 1 : $ano;
        $final = $ano . "-" . $final . "-21 23:59:59";


        $contratos = $pc->gerarComissoes($_SESSION['user_info']['id_usuario'], $inicial, $final);

        if (!empty($contratos)) {
            foreach ($contratos as $con) {

                $veiculos = $veiculo->selectPorContrato($con['id_cliente']);
                $DadosComissoes = null;

                foreach ($veiculos as $v) {

                    unset($DadosComissoes['pedido_comissao_id'], $DadosComissoes['id']);

                    $valoresSeguros['Roubo ou Furto'] = 50.00;
                    $valoresSeguros['Roubo ou Furto + Colisão'] = 65.00;
                    $valoresSeguros['Roubo ou Furto + Assistência Residêncial'] = 65.00;
                    $valoresSeguros['Rastreamento + Proteção veicular'] = 65.00;
                    $valoresSeguros['Roubo ou Furto + Colisão + Assistência Residêncial'] = 80.00;

                    $DadosComissoes['pedido_comissao_id_usuario'] = $dados['id_planilha'];
                    $DadosComissoes['pedido_comissao_id_cliente'] = $con['cliente_ra'];
                    $DadosComissoes['pedido_comissao_id_contrato'] = $con['id_contrato'];
                    $DadosComissoes['pedido_comissao_data'] = date("Y-m-d H:i:s");
                    $DadosComissoes['pedido_comissao_comissao1'] = $v['seguro'] == "s" ? $valoresSeguros[$v['tipo_seguro']] : 35.00;
                    $DadosComissoes['pedido_comissao_tx_instalacao'] = $v['taxa_instalacao'];
                    $DadosComissoes['pedido_comissao_mensal'] = $v['taxa_monitoramento'];
                    $DadosComissoes['pedido_comissao_placa'] = $v['placa'];
                    $DadosComissoes['pedido_comissao_qtd_veiculo'] = 1;

                    $textos['pedido_comissao_data'] = Funcoes::formataDataComHora($DadosComissoes['pedido_comissao_data']);
                    $textos['pedido_comissao_comissao1'] = Funcoes::formartaMoedaReal($DadosComissoes['pedido_comissao_comissao1']);
                    $textos['pedido_comissao_mensal'] = Funcoes::formartaMoedaReal($DadosComissoes['pedido_comissao_tx_instalacao']);
                    $textos['pedido_comissao_tx_instalacao'] = Funcoes::formartaMoedaReal($DadosComissoes['pedido_comissao_mensal']);


                    $DadosComissoes['pedido_comissao_id'] = $pc->insert($DadosComissoes);
                    $DadosComissoes['id'] = $dados['id_planilha'];


                    if (!empty($DadosComissoes['pedido_comissao_id']))
                        Funcoes::gerarLogCadastro($logs, "Cadastro Comissão pelo Sistema", $DadosComissoes, 4, array("pedido_comissao_id_usuario" => "id_planilha"), $textos);
                }
            }
        }

        header("Location: ../../../../index.php?pg=6&id_u=" . $dados['id_planilha'] . "&acao=AddPedidoComissao&page=" . $dados['page'] . "&id_setor=" . $dados['id_setor']);
        break;

    case "salvarAlteracoesPlanilha":
        $pcf->atualizarDados(array("pcf_id" => $dados['id_pcf'], $dados['campo'] => $dados['texto']));
        die(json_encode(array("type" => "sucess")));
        break;
}
