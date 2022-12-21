<?php
require_once("../fpdf/dompdf/dompdf_config.inc.php");
include_once('../model/classes/Captacao.class.php');

$viewProposta = new Captacao();
$lista_proposta  = $viewProposta->selectProposta($id_captacao);
$lista_veiculos  = $viewProposta->selectVeiculos($id_captacao); 
$total           = $viewProposta->selectTotal($id_captacao);
$totalTxInst     = $viewProposta->selectTotalTInst($id_captacao);
$totalMensal     = $viewProposta->selectTotalMensal($id_captacao);
  
$html = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Grupo Volpato</title>
</head>
<body>

<table>
<tr>
<td>
	<table>
  <tr>
    <td colspan="5">Taxa Instalação</td>  
  </tr>
  <tr style="background:#214c83;  padding:5px;" align="center" >
    <td>Descrição Veículo</td>
    <td>Alimentacao</td>
    <td>Qtde</td>
    <td>Válor Unitario</td>
    <td>Total</td>
  </tr>
  <tr align="center">
    <td>Carro</td>
    <td>12v</td>
    <td>1</td>
    <td>R$:200,00</td>
    <td>R$:200,00</td>
  </tr>
  <tr align="center">
    <td>Carro</td>
    <td>12v</td>
    <td>1</td>
    <td>R$:200,00</td>
    <td>R$:200,00</td>
  </tr>
  <tr align="center">
    <td>Carro</td>
    <td>12v</td>
    <td>1</td>
    <td>R$:200,00</td>
    <td>R$:200,00</td>
  </tr>
  <tr align="center">
    <td>Carro</td>
    <td>12v</td>
    <td>1</td>
    <td>R$:200,00</td>
    <td>R$:200,00</td>
  </tr>
  <tr align="center">
    <td>Carro</td>
    <td>12v</td>
    <td>1</td>
    <td>R$:200,00</td>
    <td>R$:200,00</td>
  </tr>
  <tr align="center">
    <td>Carro</td>
    <td>12v</td>
    <td>1</td>
    <td>R$:200,00</td>
    <td>R$:200,00</td>
  </tr>
  <tr align="center">
    <td>Carro</td>
    <td>12v</td>
    <td>1</td>
    <td>R$:200,00</td>
    <td>R$:200,00</td>
  </tr>
  <tr align="center">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>R$:200,00</td>
  </tr>
</table>
</td>

</tr>
<tr>
<td><table >

  <tr>
    <td>mensalidade</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr style="background:#214c83;  padding:5px;" align="center" >
    <td>Descrição Veículo</td>
    <td>Alimentacao</td>
    <td>Qtde</td>
    <td>Válor Unitario</td>
    <td>Total</td>
  </tr>
  <tr align="center">
    <td>Carro</td>
    <td>12v</td>
    <td>1</td>
    <td>R$:200,00</td>
    <td>R$:200,00</td>
  </tr>
  <tr align="center">
    <td>Carro</td>
    <td>12v</td>
    <td>1</td>
    <td>R$:200,00</td>
    <td>R$:200,00</td>
  </tr>
  <tr align="center">
    <td>Carro</td>
    <td>12v</td>
    <td>1</td>
    <td>R$:200,00</td>
    <td>R$:200,00</td>
  </tr>
  <tr align="center">
    <td>Carro</td>
    <td>12v</td>
    <td>1</td>
    <td>R$:200,00</td>
    <td>R$:200,00</td>
  </tr>
  <tr align="center">
    <td>Carro</td>
    <td>12v</td>
    <td>1</td>
    <td>R$:200,00</td>
    <td>R$:200,00</td>
  </tr>
  <tr align="center">
    <td>Carro</td>
    <td>12v</td>
    <td>1</td>
    <td>R$:200,00</td>
    <td>R$:200,00</td>
  </tr>
  <tr align="center">
    <td>Carro</td>
    <td>12v</td>
    <td>1</td>
    <td>R$:200,00</td>
    <td>R$:200,00</td>
  </tr>
  <tr align="center">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>R$:200,00</td>
  </tr>
</table>
</td>
</tr>
</table>
</body>
</html>';



$dompdf = new DOMPDF();
$dompdf->load_html(utf8_decode($html));
//$dompdf->set_paper("A4","portrait"); // aqui voc? pode configurar o layout da página! :)
$dompdf->set_paper('A4','landscape');
$dompdf->render();

$file_to_save = '../fpdf/proposta/arquivos_pdf/'.$id_captacao.'.pdf';

//save the pdf file on the server
file_put_contents($file_to_save, $dompdf->output()); 



