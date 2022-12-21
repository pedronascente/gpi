<?php
include_once('../../Config.inc.php');
$id_proposta = isset($_GET['id_proposta']) ? $_GET['id_proposta'] : '';
$id_usuario = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';
$p = new Proposta();
$cliente = $p->selCliente($id_proposta); //busca o nome do cliente.
$veiculos = $p->selVeiculos($id_proposta); //busca os veiculos cadastrados.
$total_txInstalacao = $p->selectTotalTInst($id_proposta); //busca o tatal taxa de instalação.
$TotalMensal = $p->selectTotalMensal($id_proposta); //busca o tatal mensal.
$tipo_proposta = $p->selectProposta($id_proposta); //busca tipo de proposta.
#busca o cartao de visita do usuario com permissao vendedor.
$where = array('id_usuario' => $id_usuario, 'tipo_proposta' => $tipo_proposta["proposta_tipo_proposta"]);
$total_txInstalacao = null;
$TotalMensal = null;
$user = new Usuarios;
$cartao_visita = null;
$cartao_visita = $user->listaCartaoVisita($where);
$html = '
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
table,tr,td,img{margin:0; padding:0; border:0; float:left}
</style>
</head>
<body>
<table cellpadding="0" cellspacing="2">';
for ($i = 1; $i < 11; $i++):
    $html .='
  <tr>
	 <td><img src="img/' . $i . '.jpg" width="100%" ></td>
  </tr>';
endfor;

if ($tipo_proposta['proposta_tipo_proposta'] == 1):
    for ($i = 11; $i < 17; $i++):
        $html .='
      <tr>
             <td><img src="img/diamante/' . $i . '.jpg" width="100%" ></td>
      </tr>';
    endfor;
else:
    for ($i = 11; $i < 15; $i++):
        $html .='
	  <tr>
		 <td><img src="img/ouro/' . $i . '.jpg" width="100%" ></td>
	  </tr>';
    endfor;
endif;
$html .='
     <tr>
       <td>
	    	<img src="img/orcamento.jpg" width="100%" style="position:relative" border="0">
              <table width="100%" align="left" style="position:absolute; margin-top:240px">
				<tr>
					<td width="100%">
						<table width="65%" style="margin-left:130px; font-size:11px; float:left"  cellspacing="0" align="left">
							<tr>
								<td  colspan="5"  align="left" style="color:#F00">
									<strong>Taxa Instala&ccedil;&atilde;o</strong>
							    </td>
							</tr>
							<tr align="center" bgcolor="#214C83" style="color:#FFF">
								<td width="31%" style="border:1px solid  #000;">
									<strong>Descricao</strong>
								</td>
								<td width="25%" style="border:1px solid  #000;">
									<strong>Alimenta&ccedil;&atilde;o</strong>
								</td>
								<td width="12%" style="border:1px solid  #000;">
									<strong>Qtde.</strong>
								</td>
								<td width="18%" style="border:1px solid  #000;">
									<strong>Valor uni.</strong>
								</td>
								<td width="14%" style="border:1px solid  #000;">
									<strong>Total</strong>
								</td>
							</tr>';
foreach ($veiculos as $li):
    $descricao_veiculo = ($li["cpv_descricao_veiculo"] == "planoassistencial") ? "Plano Assistêncial" : $li["cpv_descricao_veiculo"];
    $html.=' 
							<tr>
								<td style="border:1px solid  #000;">
									' . ucfirst($descricao_veiculo) . '
								</td>
								<td align="center" style="border:1px solid  #000;">
									' . $li["cpv_alimentacao"] . 'V
								</td>
								<td align="center" style="border:1px solid  #000;">
									' . $li["cpv_qtd_veiculo"] . '
								</td>
								<td align="center" style="border:1px solid  #000;">
									' . $li["cpv_taxa_intalacao"] . '
								</td>
								<td align="center" style="border:1px solid  #000;">
									' . $li["cpv_total_taxa_intalacao"] . '
								</td>
							</tr>';
endforeach;
$html.='
							<tr>
								<td colspan="1">&nbsp;</td>
								<td  colspan="3" align="right" align="right">
									Valor Total - Taxa de Instala&ccedil;&atilde;o
								</td>
								<td align="center" style="border:1px solid  #000; background:#FF0; color:#F00">
									R$ ' . $total_txInstalacao['totalTxInst'] . '
								</td>
							</tr>
				        </table>';
switch (count($veiculos)) {
    case 2 : $html.='<br><br><br><br>';
        break;
    case 3 : $html.='<br><br><br><br><br>';
        break;
    case 4 : $html.='<br><br><br><br><br><br>';
        break;
    case 5 : $html.='<br><br><br><br><br><br><br>';
        break;
    case 6 : $html.='<br><br><br><br><br><br><br><br>';
        break;
    case 7 : $html.='<br><br><br><br><br><br><br><br><br>';
        break;
    case 7 : $html.='<br><br><br><br><br><br><br><br><br>';
        break;
    case 8 : $html.='<br><br><br><br><br><br><br><br>';
        break;
    default: $html.='<br><br><br>';
}
$html.='
						<table width="65%" border="0" style="margin-left:130px;font-size:12px;float:left;"  cellspacing="0" align="left">
						   <tr>
						   		<td  colspan="5" align="left" style="color:#F00"><strong>Mensalidade</strong></td>
						   </tr>
						   <tr align="center" bgcolor="#214C83" style="color:#FFF">
								<td width="31%" style="border:1px solid  #000;">
									<strong>Descricao</strong>
								</td>
								<td width="25%" style="border:1px solid  #000;">
									<strong>Alimenta&ccedil;&atilde;o</strong>
								</td>
								<td width="12%" style="border:1px solid  #000;">
									<strong>Qtde.</strong>
								</td>
								<td width="18%" style="border:1px solid  #000;">
									Valor uni.
								</td>
								<td width="14%" style="border:1px solid  #000;">
									<strong>Total</strong>
								</td>
						    </tr>';
foreach ($veiculos as $li):
    $html.=' 
						   <tr>
								<td style="border:1px solid #000;">
								    ' . ucfirst($li["cpv_descricao_veiculo"]) . '
								</td>
								<td align="center" style="border:1px solid  #000;">
									' . $li["cpv_alimentacao"] . 'V
								</td>
								<td align="center" style="border:1px solid  #000;">
									' . $li["cpv_qtd_veiculo"] . '
								</td>
								<td align="center" style="border:1px solid  #000;">
									' . $li["cpv_taxa_valor_mensal"] . '
								</td>
								<td align="center" style="border:1px solid  #000;">
									' . $li["cpv_total_valor_mensal"] . '
								</td>
						    </tr>';
endforeach;
$html.='
						    <tr>
							    <td colspan="1">&nbsp;</td>
							    <td  colspan="3" align="right" align="right">
								    Valor Total - Mensalidade
							    </td>
							    <td align="center" style="border:1px solid  #000; background:#FF0; color:#F00">
								    R$ ' . $TotalMensal['totalMensal'] . '
							    </td>
						  </tr>
				 	</table>
			  	 </td>
			  </tr>
		   </table>
	   </td>
    </tr>	
   <tr>
	  <td>
		<table>
		  <tr>
			 <td>
			   <img src="img/vendedores/' . $cartao_visita["cartao_visita_img"] . '" width="100%">
			 </td>
		  </tr>
		</table>
	  </td>
	</tr>
</table>
</body>
</html>';

//die($html);

#objeto que cria o arquivo PDF.
require_once("../../fpdf/dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->load_html(utf8_decode($html));
$dompdf->set_paper("a4", "landscape");
$dompdf->render();
$dompdf->stream("proposta.pdf");