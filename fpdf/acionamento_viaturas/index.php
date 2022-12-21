<?php
include_once '../../Config.inc.php';
include_once '../../modulos/captacao/src/controllers/acionamentoVerificacao.php';

$html = '<table width="100%" border="0" cellpadding="10" cellspacing="10">
				<thead>
					<tr>
						<td colspan="3">
							<h1>Acionamento Viaturas - Visualiza&ccedil;&atilde;o</h1>            
		            		<div style="margin-left: 0" class="__box bg_button" id=""></div>
						</td>
					</tr>
				</thead>';
$html .= '<tbody>
			<tr>
				<td>
					<table width="100%" border="0" cellpadding="10" cellspacing="10">
						<tr>
							<td>C&oacute;digo:<br /></td>	
							<td>' . $viaturas_id . '</td>					
						</tr>
						<tr>
							<td>Data Atendimento:<br /></td>
							<td>' . $viaturas_data . '</td>
						</tr>
						<tr>
							<td>Hora Atendimento:<br /></td>
							<td>' . $viaturas_hora . '</td>
						</tr>
						<tr>
							<td>Atendente:<br /></td>
							<td>' . $viaturas_atendente . '</td>
						</tr>
						<tr>
							<td>Conta:<br /></td>
							<td>' . $viaturas_conta . '</td>
						</tr>					
					</table>					
				</td>				
			</tr>			
			<tr>
				<td>
					<table width="100%" border="0" cellpadding="10" cellspacing="10">		
						<tr>
							<td><strong>Qual zona disparou?</strong><br /></td>	
							<td>' . verificaOptions ( "zona1ouqualquer", $zona1ouqualquer ) . '</td>					
						</tr>
						<tr>
							<td><strong>N&uacute;mero de disparos?</strong><br /></td>
							<td>' . verificaOptions ( "disparos", $disparos ) . '</td>
						</tr>
						<tr>
							<td><strong>N&uacute;mero de zonas que dispararam?</strong><br /></td>
							<td>' . verificaOptions ( "zonas", $zonas ) . '</td>
						</tr>
						<tr>
							<td><strong>Todas as zonas que dispararam restauraram?</strong><br /></td>
							<td>' . verificaOptions ( "todaszonas", $todaszonas ) . '</td>
						</tr>
						<tr>
							<td><strong>A zona que disparou possui hist&oacute;rico de disparo nos &uacute;ltimos 30 dias?</strong><br /></td>
							<td>' . verificaOptions ( "trintadias", $trintadias ) . '</td>
						</tr>
						<tr>
							<td><strong>Est&aacute; acontecendo temporal?</strong><br /></td>
							<td>' . verificaOptions ( "temporal", $temporal ) . '</td>
						</tr>
						<tr>
							<td><strong>Pontua&ccedil;&atilde;o?</strong><br /></td>							
						</tr>						
						<tr>
						     <td>
							     <font size="5" color='.$valores["cor"].'>
									'.$pontos.'	Pontos - '.$valores["message"].'				          				  
							     </font>							 
							</td>							
						</tr>
						<tr>
							<td></td>
						</tr> 
					</table>
				</td>				
			</tr>		
		</tbody>
	</table>';

include_once ("../dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF ();
$dompdf->load_html ( $html );
$dompdf->set_paper ( "a4", "portrait" );
$dompdf->render ();
$dompdf->stream ( "acionamento_viaturas.pdf" );