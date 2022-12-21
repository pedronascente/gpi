<?php

function listaDados($lista_pedidoComissao, $id_setor) {
    $pcf = new PedidoComissaoFuncionario;
    $html = NULL;
    $loop = 0;

    foreach ($lista_pedidoComissao as $k => $li) :

        $loop ++;
        $pedido_comissao_id = !empty($li ['pedido_comissao_id']) ? $li ['pedido_comissao_id'] : NULL;
        $pedido_comissao_id_usuario = !empty($li ['pedido_comissao_id_usuario']) ? $li ['pedido_comissao_id_usuario'] : NULL;
        $pedido_comissao_data = !empty($li ['pedido_comissao_data']) ? Funcoes::formataData($li ['pedido_comissao_data']) : NULL;
        $pedido_comissao_cliente = !empty($li ['pedido_comissao_cliente']) ? ucfirst($li ["pedido_comissao_cliente"]) : ucfirst($li ["cliente"]);
        $pedido_comissao_comissao1 = !empty($li ['pedido_comissao_comissao1']) ? Funcoes::formartaMoedaReal($li ["pedido_comissao_comissao1"]) : NULL;
        $pedido_comissao_comissao2 = !empty($li ['pedido_comissao_comissao2']) ? Funcoes::formartaMoedaReal($li ["pedido_comissao_comissao2"]) : NULL;
        $pedido_comissao_comissao3 = !empty($li ['pedido_comissao_comissao3']) ? Funcoes::formartaMoedaReal($li ["pedido_comissao_comissao3"]) : NULL;
        $pedido_comissao_servico = !empty($li ['pedido_comissao_servico']) ? ucfirst($li ['pedido_comissao_servico']) : NULL;
        $pedido_comissao_captacao = !empty($li ['pedido_comissao_captacao']) ? $li ['pedido_comissao_captacao'] : NULL;
        $pedido_comissao_inst_venda = !empty($li ['pedido_comissao_inst_venda']) ? Funcoes::formartaMoedaReal($li ["pedido_comissao_inst_venda"]) : NULL;
        $pedido_comissao_mensal = !empty($li ['pedido_comissao_mensal']) ? Funcoes::formartaMoedaReal($li ['pedido_comissao_mensal']) : NULL;
        $pedido_comissao_conta = !empty($li ['pedido_comissao_conta']) ? $li ['pedido_comissao_conta'] : NULL;
        $pedido_comissao_equip_servico = !empty($li ['pedido_comissao_equip_servico']) ? $li ['pedido_comissao_equip_servico'] : NULL;
        $pedido_comissao_consultor = !empty($li ['pedido_comissao_consultor']) ? $li ['pedido_comissao_consultor'] : NULL;
        $pedido_comissao_n_os = !empty($li ['pedido_comissao_n_os']) ? $li ['pedido_comissao_n_os'] : NULL;
        $pedido_comissao_total_rastreadores = !empty($li ['pedido_comissao_total_rastreadores']) ? $li ['pedido_comissao_total_rastreadores'] : NULL;
        $pedido_comissao_status = !empty($li ['pedido_comissao_status']) ? $li ['pedido_comissao_status'] : NULL;
        $pedido_comissao_qtd_veiculo = !empty($li ['pedido_comissao_qtd_veiculo']) ? $li ['pedido_comissao_qtd_veiculo'] : NULL;
        $pedido_comissao_tx_instalacao = !empty($li ['pedido_comissao_tx_instalacao']) ? Funcoes::formartaMoedaReal($li ['pedido_comissao_tx_instalacao']) : NULL;
        $pedido_comissao_desc_comissao = !empty($li ['pedido_comissao_desc_comissao']) ? Funcoes::formartaMoedaReal($li ['pedido_comissao_desc_comissao']) : NULL;
        $pedido_comissao_obs_rastreamento = !empty($li ['pedido_comissao_obs_rastreamento']) ? $li ['pedido_comissao_obs_rastreamento'] : NULL;
        $pedido_comissao_placa = !empty($li ['pedido_comissao_placa']) ? $li ['pedido_comissao_placa'] : NULL;
        $pedido_comissao_empresa = !empty($li ['pedido_comissao_empresa']) ? $li ['pedido_comissao_empresa'] : NULL;
        $pedido_comissao_reclamacao = !empty($li ['pedido_comissao_reclamacao']) ? $li ['pedido_comissao_reclamacao'] : NULL;
        $inconsistencia = isset($li['situacao']) ? $li['situacao'] : "";
        if ($inconsistencia == 1)
            $inconsistencia = "Em Análise";
        else if ($inconsistencia == 2)
            $inconsistencia = "Aprovada";
        else if ($inconsistencia == 3)
            $inconsistencia = "Reprovada";

        switch ($id_setor) :
            case 33 :
                // PLANILHA - COMERCIAL DE ALARMES

                $html .= '
					<tr align="left" ';
                if ($k % 2 == 1) {
                    $html .= 'style="background:#c6c6c6" ';
                }
                $html .= '>
						<td>' . ($k + 1) . '</td>
						<td> ' . $pedido_comissao_data . '</td>
						<td align="left"> ' . $pedido_comissao_cliente . '</td>
						<td> ' . $pedido_comissao_conta . '</td>						
						<td> ' . $pedido_comissao_servico . '</td>
						<td> ' . $pedido_comissao_captacao . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_inst_venda . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_mensal . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_comissao1 . '</td>
						<td>' . $pedido_comissao_desc_comissao . '</td>
						<td>' . $inconsistencia . '</td>
					</tr>';
                break;
            case 46 :
                // PLANILHA - COMERCIAL RASTREAMENTO VEICULAR	

                $html .= '
					<tr align="left" ';
                if ($k % 2 == 1) {
                    $html .= ' style="background:#c6c6c6" ';
                }
                $html .= '>
						<td>' . ($k + 1) . '</td>
						<td> ' . $pedido_comissao_data . '</td>
						<td align="left"> ' . $pedido_comissao_cliente . '</td>
						<td align="center">' . $pedido_comissao_qtd_veiculo . '</td>
						<td>' . $pedido_comissao_placa . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_tx_instalacao . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_desc_comissao . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_mensal . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_comissao1 . '</td>
						<td>' . $inconsistencia . '</td>
					</tr>';
                break;
            case 60 :

                $html .= '
					<tr align="left" ';
                if ($k % 2 == 1) {
                    $html .= '  style="background:#c6c6c6" ';
                }
                $html .= '>
						<td>' . ($k + 1) . '</td>
						<td>' . $pedido_comissao_data . '</td>
						<td>' . $pedido_comissao_conta . '</td>
						<td align="left"> ' . $pedido_comissao_cliente . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_comissao1 . '</td>
						<td>' . $pedido_comissao_desc_comissao . '</td>
						<td>' . $inconsistencia . '</td>
					</tr>';
                break;
            case 61 :
                // PLANILHA - REVERSAO

                $html .= '
					<tr  align="left" ';
                if ($k % 2 == 1) {
                    $html .= '  style="background:#c6c6c6" ';
                }
                $html .= '>
						<td>' . ($k + 1) . '</td>
						<td> ' . $pedido_comissao_data . '</td>
						<td> ' . $pedido_comissao_cliente . '</td>
						<td> ' . $pedido_comissao_conta . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_comissao1 . '</td>
						<td>' . $pedido_comissao_desc_comissao . '</td>
						<td> ' . $pedido_comissao_empresa . '</td>
						<td> ' . $pedido_comissao_reclamacao . '</td>
						<td>' . $inconsistencia . '</td>
					</tr>';
                break;
            case 62 :
                // PLANILHA - SUPERVISAO_COMERCIAL_ALARMES_CERCA_ELETRICA_CFTV

                $html .= '
					<tr align="left" ';
                if ($k % 2 == 1) {
                    $html .= '  style="background:#c6c6c6" ';
                }
                $html .= '>
						<td>' . ($k + 1) . '</td>
						<td> ' . $pedido_comissao_data . '</td>
						<td align="left"> ' . $pedido_comissao_cliente . '</td>
						<td> ' . $pedido_comissao_conta . '</td>
						<td> ' . $pedido_comissao_servico . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_inst_venda . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_mensal . '</td>
						<td>' . $pedido_comissao_consultor . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_comissao1 . '</td>
						<td>' . $pedido_comissao_desc_comissao . '</td>
						<td>' . $inconsistencia . '</td>
					</tr>';
                break;
            case 63 :
                // PLANILHA - SUPERVISAO_COMERCIAL_RASTREAMENTO


                $html .= '
					<tr align="left" ';
                if ($k % 2 == 1) {
                    $html .= '  style="background:#c6c6c6" ';
                }
                $html .= '>
						<td>' . ($k + 1) . '</td>
						<td> ' . $pedido_comissao_data . '</td>
						<td> ' . $pedido_comissao_conta . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_comissao1 . '</td>
						<td>' . $pedido_comissao_desc_comissao . '</td>		
						<td>' . $pedido_comissao_total_rastreadores . '</td>
						<td>' . $inconsistencia . '</td>
					</tr>';
                break;
            case 64 :
                // PLANILHA - SUPERVISAO_COMERCIAL_E_SAC_ALARMES_CERCA_ELETRICA_CFTV

                $html .= '
					  <tr align="left"';
                if ($k % 2 == 1) {
                    $html .= ' style="background:#c6c6c6" ';
                }
                $html .= '>
						<td>' . ($k + 1) . '</td>
						<td>' . $pedido_comissao_data . '</td>
						<td>' . $pedido_comissao_conta . '</td>
						<td align="left">' . $pedido_comissao_cliente . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_comissao1 . '</td>
						<td>' . $pedido_comissao_desc_comissao . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_inst_venda . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_mensal . '</td>
						<td>' . $pedido_comissao_equip_servico . '</td>
						<td>' . $inconsistencia . '</td>
					 </tr>';
                break;
            case 65 :
                // PLANILHA - TECNICA_ALARMES_CERCA_ELETRICA_CFTV

                $html .= '
					<tr align="left" ';
                if ($k % 2 == 1) {
                    $html .= ' style="background:#c6c6c6" ';
                }
                $html .= '>
						<td>' . ($k + 1) . '</td>
						<td> ' . $pedido_comissao_data . '</td>
						<td>' . $pedido_comissao_conta . '</td>
						<td> ' . $pedido_comissao_n_os . '</td>
						<td> ' . $pedido_comissao_cliente . '</td>
						<td>' . $pedido_comissao_servico . ' </td> 
						<td> R$ &nbsp;' . $pedido_comissao_comissao1 . ' </td> 
						<td>' . $pedido_comissao_desc_comissao . '</td>
						<td>' . $inconsistencia . '</td>
					</tr>';
                break;
            case 66 :
                // PLANILHA - TECNICA_DE_RASTREAMENTO
                $html .= '
					<tr align="left" ';
                if ($k % 2 == 1) {
                    $html .= '  style="background:#c6c6c6" ';
                }

                $html .= '>
						<td>' . ($k + 1) . '</td>
						<td>' . $pedido_comissao_data . '</td>
						<td align="left">' . $pedido_comissao_cliente . '</td>
						<td>' . $pedido_comissao_conta . '</td>		
						<td>' . $pedido_comissao_placa . '</td>				
						<td>' . $pedido_comissao_obs_rastreamento . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_comissao1 . '</td> 
						<td>' . $pedido_comissao_desc_comissao . '</td>
						<td>' . $inconsistencia . '</td>
					</tr>';
                break;
            case 150 :
                // PLANILHA - PORTARIA
                $html .= '
					<tr align="left" ';
                if ($k % 2 == 1) {
                    $html .= '  style="background:#c6c6c6" ';
                }

                $html .= '>
						<td>' . ($k + 1) . '</td>
						<td>' . $pedido_comissao_data . '</td>
						<td align="left">' . $pedido_comissao_cliente . '</td>
						<td>' . $pedido_comissao_conta . '</td>		
						<td>' . $pedido_comissao_captacao . '</td>				
						<td>' . $pedido_comissao_inst_venda . '</td>
						<td>' . $pedido_comissao_mensal . '</td>
						<td> R$ &nbsp;' . $pedido_comissao_comissao1 . '</td> 
						<td>' . $pedido_comissao_desc_comissao . '</td>
						<td>' . $inconsistencia . '</td>
					</tr>';
                break;
            case 32 :
                // PLANILHA - PORTARIA
                $html .= '
					<tr align="left" ';
                if ($k % 2 == 1) {
                    $html .= '  style="background:#c6c6c6" ';
                }

                $html .= '>
						<td>' . ($k + 1) . '</td>
						<td>' . $pedido_comissao_data . '</td>
						<td align="left">' . $pedido_comissao_cliente . '</td>
						<td>' . $pedido_comissao_conta . '</td>		
						<td> R$ &nbsp;' . $pedido_comissao_comissao1 . '</td> 
						<td>' . $inconsistencia . '</td>
					</tr>';
                break;
        endswitch
        ;
        // FAZ A QUEBRA DE PÁGINA
// 		IF ($LOOP == 50) {
// 			$HTML .= '
// 			</TBODY> </TABLE> <DIV STYLE="PAGE-BREAK-BEFORE:ALWAYS;">&NBSP; </DIV>';
// 			$LOOP = 0;
// 		}
    endforeach;
    $html .= '</tbody> </table>';
    return $html;
}
