<?php
# DECLARAÇÃO DE VARIAVEIS:
$mensalidade_totalVeiculo = 0;
$mensalidade_totalPlanoAssistencial = 0;
$subTotal_cpv_taxa_valor_mensal = 0;
$rowspan = count($veiculos);
$mensalidadeTrTotal = '';
$rowspan_planoAssist = 0;
$loop = 0;
$subTotal_cpv_vlr_mes_plano_assistencial = NULL;
# CALCULA O VALOR TOTAL DA TAXA E DA  MENSALIDADE :
foreach ($veiculos as $veiculo):
    $cpv_total_taxa_intalacao[] = $veiculo['cpv_total_taxa_intalacao'];
    $total_valor_mensal[] = $veiculo['cpv_total_valor_mensal'];
    $total_plano_assistencial[] = $veiculo["cpv_qtd_plano_assistencial"] * $veiculo["cpv_vlr_mes_plano_assistencial"];
    # INCREMENTA 10px NA MARGEM TOP DA TABELA DA MENSALIDADE
    $loop++;
    $px = ($loop > 5) ? 2 : 4;
endforeach;
# TAXA :
$_TOTAL_TAXA = array_sum($cpv_total_taxa_intalacao);
# MENSALIDADE :
$total_valor_mensal = array_sum($total_valor_mensal);
$total_plano_assistencial = array_sum($total_plano_assistencial);
$_TOTAL_MENSALIDADE = ($total_valor_mensal + $total_plano_assistencial);
# ASSINATURA DIGITAL :
$VendedorNome = isset($assinaturaDigital["0"]["nome"]) ? $assinaturaDigital["0"]['nome'] : null;
$VendedorRamal = isset($assinaturaDigital["0"]["ramal_ramal"]) ? $assinaturaDigital["0"]['ramal_ramal'] : null;
$VendedorRegiao = utf8_decode($assinaturaDigital["1"]["regiao_cidade"]) . '/' . $assinaturaDigital["1"]["estado_nome"];
$valorLaco = 4;

$path_proposta_img = '../../../../fpdf/proposta/img/';

$html = '
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css"> @page {margin:0; padding:0;}</style>
    </head>
    <body>
	<table align="center" style=" float:left; width:805px;">';
            for ($i = 0; $i<count($veiculos);$i++):
                $array_tipo_servico[] = $veiculos[$i]["tipo_seguro"];  
            endfor;

            //CAPAS:
            if(
                in_array('a', $array_tipo_servico) && in_array('b', $array_tipo_servico) &&  in_array('c', $array_tipo_servico) &&  in_array('d', $array_tipo_servico) || 
                in_array('b', $array_tipo_servico) &&  in_array('c', $array_tipo_servico) && in_array('d', $array_tipo_servico)  || 
                in_array('b', $array_tipo_servico) && in_array('c', $array_tipo_servico) || 
                in_array('b', $array_tipo_servico) && in_array('d', $array_tipo_servico) || 
                in_array('c', $array_tipo_servico)) 
            {
                $html .=' <tr> <td><img  src="'.$path_proposta_img.'protecao/capa_assistencial.jpg" width="805" height="1048"></td> </tr>';
            }

            else if( 
                in_array('a', $array_tipo_servico) && in_array('b', $array_tipo_servico) || 
                in_array('b', $array_tipo_servico))  
            {
                $html .=' <tr> <td><img  src="'.$path_proposta_img.'protecao/capa_veicular.jpg" width="805" height="1048"></td> </tr>';

            }
            else if(
                in_array('a', $array_tipo_servico) &&  in_array('d', $array_tipo_servico) ||  
                in_array('d', $array_tipo_servico)) 
            {
                $html .=' <tr> <td><img  src="'.$path_proposta_img.'assistencia/capa.jpg" width="805" height="1048"></td> </tr>';
            }
            else
            {
                $html .=' <tr> <td><img  src="'.$path_proposta_img.'capa_rastreamento.jpg" width="805" height="1048"></td></tr>';
            }

            //CORPO:
            for ($i = 2; $i <= $valorLaco; $i++):
                $html .=' <tr> <td><img  src="'.$path_proposta_img.'/' . $i . '.jpg" width="805" height="1048"></td> </tr>';
            endfor;
            
            if(
                in_array('a', $array_tipo_servico) &&  in_array('b', $array_tipo_servico) &&  in_array('c', $array_tipo_servico) &&  in_array('d', $array_tipo_servico) || 
                in_array('b', $array_tipo_servico) &&  in_array('c', $array_tipo_servico) && in_array('d', $array_tipo_servico)  || 
                in_array('c', $array_tipo_servico))
            {
                $html .=' <tr> <td><img src="'.$path_proposta_img.'protecao/1.jpg" width="805" height="1048"></td> </tr>';
                $html .=' <tr> <td><img src="'.$path_proposta_img.'protecao/2.jpg" width="805" height="1048"></td> </tr>';
            }else if(
                in_array('a', $array_tipo_servico) && in_array('b', $array_tipo_servico) ||
                in_array('b', $array_tipo_servico))
            {
                 $html .=' <tr> <td><img src="'.$path_proposta_img.'protecao/1.jpg" width="805" height="1048"></td> </tr>';
            }  
            else if(
                in_array('a', $array_tipo_servico) && in_array('d', $array_tipo_servico) ||
                in_array('d', $array_tipo_servico))
            {
                 $html .=' <tr> <td><img src="'.$path_proposta_img.'assistencia/1.jpg" width="805" height="1048"></td> </tr>';
            }      
            $html.='
            <tr>
                <td style="position:relative">
                    <img src="'.$path_proposta_img.'orcamento.jpg" style="position:relative; border:none; height:1048px" width="805" />
                    <div style="position:absolute; top:100px; width:720px; z-index:9999; left:44px; height:600px;">
                         <span style="font-family:Calibri, Arial, sans-serif; font-size:11px; font-weight:bold; color:#F00">TAXA DE HABILITA&Ccedil;&Atilde;O</span>
                         <table style="width:100%; border-spacing:0; border-collapse:collapse; font-family:Calibri, Arial, sans-serif; font-size:11px;">
                             <tr style="background-color:#254E84; height:22px; color:#FFF">
                                 <td style="text-align:center; border:solid 2px #000; font-weight:bold; width:10%">Descri&ccedil;&atilde;o </td>
                                 <td style="text-align:center; border:solid 2px #000; font-weight:bold; width:35%">Tipo de Serviço</td>
                                 <td style="text-align:center; border:solid 2px #000; font-weight:bold; width:10%">Qtde</td>
                                 <td style="text-align:center; border:solid 2px #000; font-weight:bold; width:15%">Valor Unit&aacute;rio</td>
                                 <td style="text-align:center; border:solid 2px #000; font-weight:bold; width:20%">Total</td>
                             </tr>';
                            foreach ($veiculos as $k => $li):
                                $taxa_descricao = !empty($li["cpv_descricao_veiculo"]) ? ucfirst($li["cpv_descricao_veiculo"]) : "";
                                if($li["tipo_seguro"]=='a'){
                                    $tipo_servico = "Rastreamento";
                                }
                                elseif($li["tipo_seguro"]=='b'){
                                    $tipo_servico = "Rastreamento + Proteção Veicular";
                                }
                                elseif($li["tipo_seguro"]=='c'){
                                    $tipo_servico = "Rastreamento + Proteção Veicular + Assistência Veicular";
                                }
                                elseif($li["tipo_seguro"]=='d'){
                                    $tipo_servico = "Rastreamento + Assistência Veicular";
                                }
                                $taxa_cpv_qtd_veiculo = !empty($li["cpv_qtd_veiculo"]) ? $li["cpv_qtd_veiculo"] : "";
                                $taxa_cpv_taxa_intalacao = !empty($li["cpv_taxa_intalacao"]) ? number_format($li["cpv_taxa_intalacao"], 2, ',', '.') : "";
                                $v_total_taxa_instalacao = !empty($li["cpv_total_taxa_intalacao"]) ? number_format($li["cpv_total_taxa_intalacao"], 2, ',', '.') : "";
                                $html.= '
                                <tr>
                                    <td style="text-align:center; border:solid 2px #000">' . $taxa_descricao . '</td>
                                    <td style="text-align:center; border:solid 2px #000">' . $tipo_servico . '</td>
                                    <td style="text-align:center; border:solid 2px #000">' . $taxa_cpv_qtd_veiculo . '</td>
                                    <td style="text-align:center; border:solid 2px #000">R$' . $taxa_cpv_taxa_intalacao . '</td>
                                    <td style="text-align:center; border:solid 2px #000">R$' . $v_total_taxa_instalacao . '</td>
                                </tr>';
                            endforeach;
                            $html.='
                             <tr>
                                 <td style="text-align:right; font-weight:bold" colspan="4">Valor Total de Habilita&ccedil;&atilde;o:</td>
                                 <td style="text-align:center; border:solid 2px #000; font-weight:bold; background-color:#FFFF00">R$&nbsp;' . number_format($_TOTAL_TAXA, 2, ',', '.') . '</td>
                             </tr>
                         </table>
                         <span style="font-family:Calibri, Arial, sans-serif; font-size:11px; font-weight:bold; color:#F00; margin-top:21px; display:inline-block">MENSALIDADE</span>
                         <table style="width:100%; border-spacing:0; border-collapse:collapse; font-family:Calibri, Arial, sans-serif; font-size:11px;">
                             <tr style="background-color:#254E84; height:22px; color:#FFF">
                                 <td style="text-align:center; border:solid 2px #000; font-weight:bold; width:10%">Descrição</td>
                                 <td style="text-align:center; border:solid 2px #000; font-weight:bold; width:30%">Tipo de Serviço</td>
                                 <td style="text-align:center; border:solid 2px #000; font-weight:bold; width:10%">Qtde</td>
                                 <td style="text-align:center; border:solid 2px #000; font-weight:bold; width:15%">Forma Pgto</td>
                                 <td style="text-align:center; border:solid 2px #000; font-weight:bold; width:10%">Valor Unit&aacute;rio</td>
                                 <td style="text-align:center; border:solid 2px #000; font-weight:bold; width:20%">Total</td>
                             </tr>';
                            foreach ($veiculos as $k => $li):
                                $mensalidade_descricao = !empty($li["cpv_descricao_veiculo"]) ? ucfirst($li["cpv_descricao_veiculo"]) : "";
                                if($li["tipo_seguro"]=='a'){
                                    $tipo_servico = "Rastreamento";
                                }
                                elseif($li["tipo_seguro"]=='b'){
                                    $tipo_servico = "Rastreamento + Proteção Veicular";
                                }
                                elseif($li["tipo_seguro"]=='c'){
                                    $tipo_servico = "Rastreamento + Proteção Veicular + Assistência Veicular";
                                }
                                elseif($li["tipo_seguro"]=='d'){
                                    $tipo_servico = "Rastreamento + Assistência Veicular";
                                }
                                $mensalidade_cpv_qtd_veiculo = !empty($li["cpv_qtd_veiculo"]) ? $li["cpv_qtd_veiculo"] : "";
                                $mensalidade_cpv_taxa_valor_mensal = !empty($li["cpv_taxa_valor_mensal"]) ? number_format($li["cpv_taxa_valor_mensal"], 2, ',', '.') : "";
                                $mensalidade_cpv_formapagamento = !empty($li["forma_pagamento"]) ? ($li["forma_pagamento"] == 1 ? "Boleto" : "Cart&atilde;o") : "";
                                $mensalidade_cpv_vlr_mes_plano_assistencial = !empty($li["cpv_vlr_mes_plano_assistencial"]) ? number_format($li["cpv_vlr_mes_plano_assistencial"], 2, ',', '.') : "";
                                $total_valor_mensal = !empty($li["cpv_total_valor_mensal"]) ? number_format($li["cpv_total_valor_mensal"], 2, ',', '.') : "";
                                $html.= '
                                    <tr>
                                        <td style="text-align:center; border:solid 2px #000">' . $mensalidade_descricao . '</td>
                                        <td style="text-align:center; border:solid 2px #000">' . $tipo_servico . '</td>
                                        <td style="text-align:center; border:solid 2px #000">' . $mensalidade_cpv_qtd_veiculo . '</td>
                                        <td style="text-align:center; border:solid 2px #000">' . $mensalidade_cpv_formapagamento . '</td>
                                        <td style="text-align:center; border:solid 2px #000">R$&nbsp;' . $mensalidade_cpv_taxa_valor_mensal . '</td>
                                        <td style="text-align:center; border:solid 2px #000">R$&nbsp;' . $total_valor_mensal . '</td>
                                    </tr>';
                            endforeach;
                            $html.='
                             <tr>
                                 <td style="text-align:right; font-weight:bold" colspan="5">Valor Total da Mensalidade:</td>
                                 <td style="text-align:center; border:solid 2px #000; font-weight:bold; background-color:#FFFF00">R$&nbsp;' . number_format($_TOTAL_MENSALIDADE, 2, ',', '.') . '</td>
                             </tr>
                         </table>
                    </div>';
                    $html.='<div style="position:absolute; top:460px;  z-index:9999; left:620px; font-size:11px ; width:160px;font-family:Calibri, Arial, sans-serif;"> '. utf8_encode(' Vigência de contrato') . $tipo_proposta['vigencia'] . ' Meses. </div>';
                    $html.='<div style="position:absolute; top:790px; width:450px; z-index:9999; left:360px; height:400px;">
                         <table style="width:100%; border-spacing:0; border-collapse:collapse; font-family:Calibri, Arial, sans-serif; font-size:12px;">
                             <tr style=" height:22px; color:#333" align="center">
                                <td style="text-align:center; font-weight:bold; width:25%">' . $VendedorNome . '</td>
                             </tr>
                             <tr style=" height:22px; color:#333" align="center">
                                <td style="text-align:center; font-weight:bold;  font-size:20px;    width:25%"> RAMAL:' . $VendedorRamal . '</td>
                             </tr>
                             <tr style=" height:22px; color:#333" align="center">
                                <td style="text-align:center; font-weight:bold; width:25%">' . utf8_decode($VendedorRegiao) . '</td>
                             </tr>
                         </table>
                    </div>
                </td>
            </tr>
	</table>
  </body>
</html>';
