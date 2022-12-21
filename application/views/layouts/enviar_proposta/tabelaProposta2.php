 <?php
//DECLARAÇÃO DE VARIAVEIS:
$mensalidade_totalVeiculo 	             = 0;
$oferta_plano_assostencial               =  FALSE;
$mensalidade_totalPlanoAssistencial      = 0;
$subTotal_cpv_taxa_valor_mensal          = 0;
$rowspan                                 = count($veiculos);
$mensalidadeTrTotal 		             = '';
$rowspan_planoAssist 		             = 0;
$loop                                    = 0;
$subTotal_cpv_vlr_mes_plano_assistencial = NULL;
//CALCULA O VALOR TOTAL DA   TAXA E DA  MENSALIDADE:
foreach($veiculos as $veiculo):
  $cpv_total_taxa_intalacao[]  = $veiculo['cpv_total_taxa_intalacao'];
  $total_valor_mensal[]        = $veiculo['cpv_total_valor_mensal'];
  $total_plano_assistencial[]  = $veiculo["cpv_qtd_plano_assistencial"] * $veiculo["cpv_vlr_mes_plano_assistencial"]; 
  # INCREMENTA 10px NA MARGEM TOP DA TABELA DA MENSALIDADE
  $loop++;
  $px = ($loop > 5)? 2 : 4;
endforeach;
#TAXA..............................................................................:
$_TOTAL_TAXA                      = array_sum($cpv_total_taxa_intalacao);
#MENSALIDADE.......................................................................:
$total_valor_mensal               = array_sum($total_valor_mensal);
$total_plano_assistencial         = array_sum($total_plano_assistencial);	
$_TOTAL_MENSALIDADE               = ($total_valor_mensal+$total_plano_assistencial);
//PLANO ASSISTENCIAL.
if($oferta_plano_assostencial == TRUE):
    $table1                                             = '';
    $mensalidade_titlePlanoAssistencial                 = '<td colspan="2" bgcolor="#4A4A4C"> <font color="#FFFFFF">PLANO ASSISTENCIAL </font></td>';
    $mensalidade_subTitleQtdPlanoAssistencial           = '<td bgcolor="#666666"><font size="9px" color="#FFFFFF">QTDE</font></td>';
    $mensalidade_subTitleValorUnitarioPlanoAssistencial = '<td bgcolor="#666666"><font size="9px" color="#FFFFFF">VALOR UNIT&Aacute;RIO</font></td>';
    $rowspan_planoAssist                                = 1;
    function _addCampoTd($campo,$valorCampo){
        if($campo =="mensalidade_cpv_qtd_plano_assistencial")
                 return '<td>'.$valorCampo.'</td>' ;
        else if($campo =="mensalidade_cpv_vlr_mes_plano_assistencial") 
                 return  '<td>R$&nbsp;&nbsp;'.$valorCampo.'</td>';
        else if($campo =="mensalidade_totalPlanoAssistencial")
                 return  '<td bgcolor="#4A4A4C"><font color="#FFFFFF">'.$valorCampo.'</font></td>';	 
        else if($campo =="subTotal_cpv_vlr_mes_plano_assistencial")
                 return  ' <td bgcolor="#4A4A4C"><font color="#FFFFFF">R$&nbsp;&nbsp;'.number_format($valorCampo, 2, ',', '.').'</font></td>';	  
    }
else:
    function  _addCampoTd(){};
	$table1 = '
	  <table width="30%" border="0" cellpadding="0" cellspacing="0" style="font:Arial, Helvetica, sans-serif; position:absolute ;">
		<tr>
		  <td  align="right" style=" line-height:4px; font-size:9px;text-align:center; color:#FFF; background:url(../fpdf/proposta/img/tarja_promocao.jpg) no-repeat center ; width:400px;">
			<p style="padding-top:7px">N&atilde;o perca tempo, contrate nosso Plano Assistencial por apenas R$ 29,90*</p>
			<p style="font-size:7px">*Valor promocional para aquisi&ccedil;&atilde;o com servi&ccedil;o de Rastreamento</p>
		  </td>
		</tr>
	  </table>';
	  $mensalidadeTrTotal = 'style="display:none"';
endif;

	//ASSINATURA DIGITAL:
		
	$VendedorNome   = $assinaturaDigital[0]['nome']; 	
	$VendedorEmail  = $assinaturaDigital[0]['usuario_email'];
	$VendedorRegiao = $assinaturaDigital[1]['estado_nome'];

	$html ='
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
		@page {margin:0; padding:0;}
	</style>
	</head>
	<body>
	<table align="center" style=" float:left; width:808px;"  > ';
		  for($i=1; $i<=7; $i++):  
		  	$html .=' <tr> <td><img  src="../../../../fpdf/proposta/img/'.$i.'.jpg" style="height:1048px; border:none" alt="Proposta Comercial - P&aacute;gina '.$i.'" /></td> </tr>';	
	      endfor;
		$html.='
		<tr>
			<td style="position:relative">
				   <img src="../../../../fpdf/proposta/img/orcamento.jpg" style="position:relative; border:none; height:1048px" alt="Proposta Comercial - P&aacute;gina 8" />
				   <div style="position:absolute; top:200px; width:720px; z-index:9999; left:44px; height:600px">
						<span style="font-family:Calibri, Arial, sans-serif; font-size:18px; font-weight:bold; color:#F00">TAXA DE HABILITA&Ccedil;&Atilde;O</span>
						<table style="width:100%; border-spacing:0; border-collapse:collapse; font-family:Calibri, Arial, sans-serif; font-size:18px;">
							<tr style="background-color:#254E84; height:22px; color:#FFF">
								<td style="text-align:center; border:solid 2px #000; font-weight:bold; width:25%">Descri&ccedil;&atilde;o Veicular</td>
								<td style="text-align:center; border:solid 2px #000; font-weight:bold; width:25%">Qtde</td>
								<td style="text-align:center; border:solid 2px #000; font-weight:bold; width:25%">Valor Unit&aacute;rio</td>
								<td style="text-align:center; border:solid 2px #000; font-weight:bold; width:25%">Total</td>
							</tr>';
							foreach($veiculos as $k=> $li):
								$taxa_descricao              = !empty($li["cpv_descricao_veiculo"]) ? ucfirst($li["cpv_descricao_veiculo"]) :"";
								$taxa_cpv_qtd_veiculo        = !empty($li["cpv_qtd_veiculo"])       ? $li["cpv_qtd_veiculo"] :""; 
								$taxa_cpv_taxa_intalacao     = !empty($li["cpv_taxa_intalacao"])    ? number_format($li["cpv_taxa_intalacao"], 2, ',', '.'):"";
								$v_total_taxa_instalacao     = !empty($li["cpv_total_taxa_intalacao"]) ? number_format($li["cpv_total_taxa_intalacao"],2, ',', '.'): "";
								$html.= '
								<tr>
									<td style="text-align:center; border:solid 2px #000">'.$taxa_descricao.'</td>
									<td style="text-align:center; border:solid 2px #000">'.$taxa_cpv_qtd_veiculo.'</td>
									<td style="text-align:center; border:solid 2px #000">R$ '.$taxa_cpv_taxa_intalacao.'</td>
									<td style="text-align:center; border:solid 2px #000">R$ '.$v_total_taxa_instalacao.'</td>
								</tr>';
							endforeach;
							
						$html.='
							<tr>
								<td style="text-align:right; font-weight:bold" colspan="3">Valor Total de Habilita&ccedil;&atilde;o:</td>
								<td style="text-align:center; border:solid 2px #000; font-weight:bold; background-color:#FFFF00">R$&nbsp;'.number_format($_TOTAL_TAXA, 2, ',', '.').'</td>
							</tr>
						</table>
			
						<span style="font-family:Calibri, Arial, sans-serif; font-size:18px; font-weight:bold; color:#F00; margin-top:21px; display:inline-block">MENSALIDADE</span>
						<table style="width:100%; border-spacing:0; border-collapse:collapse; font-family:Calibri, Arial, sans-serif; font-size:18px;">
							<tr style="background-color:#254E84; height:22px; color:#FFF">
								<td style="text-align:center; border:solid 2px #000; font-weight:bold; width:25%">Descri&ccedil;&atilde;o Veicular</td>
								<td style="text-align:center; border:solid 2px #000; font-weight:bold; width:25%">Qtde</td>
								<td style="text-align:center; border:solid 2px #000; font-weight:bold; width:25%">Valor Unit&aacute;rio</td>
								<td style="text-align:center; border:solid 2px #000; font-weight:bold; width:25%">Total</td>
							</tr>';
                            foreach($veiculos as $k=> $li):
								$mensalidade_descricao                      = !empty($li["cpv_descricao_veiculo"])          ? ucfirst($li["cpv_descricao_veiculo"]) :"";
								$mensalidade_cpv_qtd_veiculo                = !empty($li["cpv_qtd_veiculo"])                ? $li["cpv_qtd_veiculo"] :""; 
								$mensalidade_cpv_taxa_valor_mensal          = !empty($li["cpv_taxa_valor_mensal"])          ? number_format($li["cpv_taxa_valor_mensal"], 2, ',', '.'):"";
								$mensalidade_cpv_qtd_plano_assistencial     = !empty($li["cpv_qtd_plano_assistencial"])     ? $li["cpv_qtd_plano_assistencial"] :"";
								$mensalidade_cpv_vlr_mes_plano_assistencial = !empty($li["cpv_vlr_mes_plano_assistencial"]) ? number_format($li["cpv_vlr_mes_plano_assistencial"], 2, ',', '.'):"";
								$total_valor_mensal                         = !empty($li["cpv_total_valor_mensal"])        ? number_format($li["cpv_total_valor_mensal"], 2, ',', '.'):"";
								$html.= '
								<tr>
									<td style="text-align:center; border:solid 2px #000">'.$mensalidade_descricao.'</td>
									<td style="text-align:center; border:solid 2px #000">'.$mensalidade_cpv_qtd_veiculo.'</td>
									<td style="text-align:center; border:solid 2px #000">R$&nbsp;'.$mensalidade_cpv_taxa_valor_mensal.'</td>
									<td style="text-align:center; border:solid 2px #000">R$&nbsp;'.$total_valor_mensal.'</td>
								</tr>';
							endforeach;

						$html.='
							<tr>
								<td style="text-align:right; font-weight:bold" colspan="3">Valor Total da Mensalidade:</td>
								<td style="text-align:center; border:solid 2px #000; font-weight:bold; background-color:#FFFF00">R$&nbsp;'.number_format($_TOTAL_MENSALIDADE, 2, ',', '.').'</td>
							</tr>
						</table>
				   </div>
		</td>
		</tr>';	   
	   $html.='
	</table>
  </body>
</html>';