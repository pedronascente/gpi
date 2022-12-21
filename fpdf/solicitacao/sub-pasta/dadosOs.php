<?php

$imagem = file_exists("../img/logo-contrato.jpg") ? "../img/logo-contrato.jpg" : "../../../../fpdf/img/logo-contrato.jpg";


$html = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>ORDEM SERVIÇO - INFORMÁTICA</title>
        <body>
            <table width="700px" style="font-size:18px;">
                <tr>
                    <td  colspan="2">
                        <table style="" width="700px;">
                            <tr>
                                <td style="background-color:#C0C0C0;text-align: center; border:1px solid;border-radius: 10px;"><h2>ORDEM DE SERVIÇO - INFORMÁTICA</h2></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="700px" cellpadding="5" cellspacing="5">
                            <tr>
                                <td style="border-radius: 10px;border:1px solid;"><strong>Assunto Problema:<br>' . mb_strtoupper($titulo, 'UTF-8') . '</strong></td>
                                <td style="border-radius: 10px;border:1px solid;"><strong>OS:<br>' . $id . '</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="700px" cellpadding="5" cellspacing="5">
                            <tr>
                                <td colspan="2" style="border-radius: 10px;border:1px solid;"><strong>Solicitante:<br>' . mb_strtoupper($usuario, 'UTF-8') . '</strong></td>
                                <td style="border-radius: 10px;border:1px solid;"><strong>Setor:<br>' . mb_strtoupper($setor, 'UTF-8') . '</strong></td>
                            </tr>
                            <tr>
                                <td style="border-radius: 10px;border:1px solid;"><strong>Data Solicitação:<br>' . $dataCriacao . '</strong></td>
                                <td style="border-radius: 10px;border:1px solid;"><strong>Prioridade:<br>' . mb_strtoupper($nivel, 'UTF-8') . '</strong></td>
                                <td style="border-radius: 10px;border:1px solid;"><strong>Status:<br>' . mb_strtoupper($status, 'UTF-8') . '</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="700px" cellpadding="5" cellspacing="5">
                            <tr>
                                <td colspan="2" style="border-radius: 10px;border:1px solid"><strong>Requisicão:<br>' . mb_strtoupper($requisicao, 'UTF-8') . '</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="700px"  cellpadding="5" cellspacing="5">
                            <tr>
                                <td width="350px" style="border-radius: 10px;border:1px solid;"><strong>Consultor:<br>' . mb_strtoupper($programador, 'UTF-8') . '</strong></td>
                                <td style="border-radius: 10px;border:1px solid;"><strong>Setor:<br>' . mb_strtoupper($setorD, 'UTF-8') . '</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="700px"  cellpadding="5" cellspacing="5">
                            <tr>
                                <td style="background-color:#C0C0C0;border-radius: 10px;border:1px solid;"><strong>Data Solicitação:<br>' . $dataCriacao . '</strong></td>
                                <td style="background-color:#C0C0C0;border-radius: 10px;border:1px solid;"><strong>Data Inicialização:<br>' . $dataInicio . '</strong></td>
                                <td style="background-color:#C0C0C0;border-radius: 10px;border:1px solid;"><strong>Data Finalização:<br>' . $dataFim . '</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
';
If (!empty($anexos)) {
    $html .= '
 			<table width="700px"  cellpadding="5" cellspacing="5" style="font-size:18px;">
		             <tr>
		                <td><strong>Imagens:</strong></td>
		             </tr>
		             <tr>
		            	<td>' . $imagem1 . '</td>
		             </tr>
		             <tr>
		            	<td>' . $imagem2 . '</td>
		            </tr>
          	 </table>
		     <br><br>';
}
$html .= '<br><br>
		<table width="700px" border="0"  cellpadding="0" cellspacing="0" style="font-size:12px">
			  <tr>
					<td height="50px" style="padding:0; margin:0" width="350px">
						<div align="left" style=" margin:0;margin-right:10px; border-top:1px solid">
						<center><strong>RESPONSÁVEL</strong></center>
				  	</td>
					<td  height="50px" style="padding:0; margin:0">
						<div align="left" style=" margin:0;margin-right:10px; border-top:1px solid">
						<center><strong>CONSULTOR</strong></center>
				  	</td>
				</tr>
		  </table>
        </body>
</html>';

