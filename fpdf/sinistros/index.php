<?php 
include_once '../../Config.inc.php';

$id = filter_input(INPUT_GET, "id");

$monitoramento = new Monitoramento;

$monitoramento->selectSinistro($id);

$senha = $monitoramento->get("sinistro_confirmacao_senha") == 1 ? "Sim" : "Não";
$bloqueio = $monitoramento->get("sinistro_bloqueio") == 1 ? "Sim" : "Não";
$ocorrencia = $monitoramento->get("sinistro_ocorrencia") == 1 ? "Sim" : "Não";
$contato = $monitoramento->get("sinistro_contato") == 1 ? "Sim" : "Não";
$fotos = $monitoramento->get("sinistro_fotos") == 1 ? "Sim" : "Não";

$acionados = $monitoramento->get("sinistro_resgate");

$acionamento = "&nbsp;";

if(in_array("1", $acionados))
	$acionamento .= "Unidades Volantes Volpato";
if(in_array("2", $acionados))
	$acionamento .= "; &nbsp;Unidades Tercerizadas";
if(in_array("3", $acionados))
	$acionamento .= "; &nbsp;Policia Militar";

$html = '<style type="text/css">
tr.text {font-family:Calibri;font-size:14px;}
tr.text2 {font-family:Calibri;font-size:11px;}
</style>
<table width="100%" cellpadding="5" cellspacing="5">
	<tr>
		<td colspan="3" align="center" style="color:#002060;font-family:Calibri;font-size:14px;"><strong>RELATÓRIO DE AÇÕES VOLPATO - RASTREAMENTO VEICULAR</strong></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr class="text">
		<td colspan="3" align="center" style="background-color:#002060;color:#FFFFFF" valign="middle"><strong>Dados do Cliente</strong></td>
	</tr>
	<tr class="text">
		<td><strong>Coordenador:</strong>&nbsp;'.$monitoramento->get("sinistro_coordenador").'</td>
		<td><strong>Operador:</strong>&nbsp;'.$monitoramento->get("a_nome_responsavel").'</td>
		<td>&nbsp;</td>
	</tr>
	<tr class="text">
		<td colspan="2"><strong>Cliente:</strong>&nbsp;'.$monitoramento->get("a_nome_cliente").'</td>
		<td><strong>Telefone:</strong>&nbsp;'.$monitoramento->get("sinistro_telefone").'</td>
	</tr>
	<tr class="text">
		<td colspan="3" align="center" style="background-color:#002060;color:#FFFFFF" valign="middle"><strong>Dados do Veículo</strong></td>
	</tr>
	<tr class="text">
		<td><strong>Placa:</strong>&nbsp;'.$monitoramento->get("a_placa_veiculo").'</td>
		<td><strong>Marca:</strong>&nbsp;'.$monitoramento->get("a_marca_veiculo").'</td>
		<td><strong>Ano:</strong>&nbsp;'.$monitoramento->get("a_ano_veiculo").'</td>
	</tr>
	<tr class="text">
		<td colspan="2"><strong>Modelo:</strong>&nbsp;'.$monitoramento->get("a_modelo_veiculo").'</td>
		<td><strong>Cor:</strong>&nbsp;'.$monitoramento->get("a_cor_veiculo").'</td>
	</tr>
	<tr class="text">
		<td colspan="3" align="center" style="background-color:#002060;color:#FFFFFF" valign="middle"><strong>Descrição do Evento</strong></td>
	</tr>
	<tr class="text">
		<td colspan="2"><strong>Evento:</strong>&nbsp;'.$monitoramento->get("sinistro_evento").'</td>
		<td><strong>Atendimento:</strong>&nbsp;'.$monitoramento->get("sinistro_atendimento").'</td>
	</tr>';
	if($monitoramento->get("sinistro_evento") == 3)
		$html .= '<tr class="text">
			<td colspan="3"><strong>Se Evento "Outro", preencher:</strong>&nbsp;'.$monitoramento->get("sinistro_outro").'</td>;
		</tr>';
	$html .= '<tr class="text">
		<td colspan="3"><strong>Comunicante:</strong>&nbsp;'.$monitoramento->get("sinistro_comunicante").'</td>
	</tr>
	<tr class="text">
		<td colspan="3"><strong>Confirmação de Senha e Contra-Senha:</strong>&nbsp;'.$senha.'</td>
	</tr>
	<tr class="text">
		<td colspan="3" align="center" style="background-color:#002060;color:#FFFFFF" valign="middle"><strong>Descrição das Ações com os devidos horários</strong></td>
	</tr>
	<tr class="text">
		<td><strong>Data:</strong>&nbsp;'.$monitoramento->get("sinistro_data").'</td>
		<td><strong>Hora:</strong>&nbsp;'.$monitoramento->get("sinistro_hora").'</td>
		<td><strong>UF:</strong>&nbsp;'.$monitoramento->get("sinistro_uf").'</td>
	</tr>
	<tr class="text">
		<td colspan="3"><strong>Endereço - Local do Evento:</strong>&nbsp;'.$monitoramento->get("sinistro_local_evento").'</td>
	</tr>
	<tr class="text">
		<td colspan="3"><strong>O veículo foi bloqueado?</strong>&nbsp;'.$bloqueio.'</td>
	</tr>';
	if($monitoramento->get("sinistro_bloqueio") == 2)
		$html .= '<tr class="text">
			<td colspan="3"><strong>Se "Não", descreva o porquê?</strong>&nbsp;'.$monitoramento->get("sinistro_bloqueio_obs").'</td>
		</tr>';
	$html .= '<tr class="text">
		<td colspan="3"><strong>Quem foi acionado para o resgate:</strong>'.$acionamento.'</td>
	</tr>
	<tr class="text">
		<td colspan="3"><strong>Houve registro de ocorrência?</strong>'.$ocorrencia.'</td>
	</tr>';
	if($monitoramento->get("sinistro_ocorrencia") == 1)
		$html .= '<tr class="text">
			<td colspan="3"><strong>Se "Sim", qual o número do B.O.?</strong>&nbsp;'.$monitoramento->get("sinistro_bo").'</td>
		</tr>';
	$html .= '<tr class="text">
		<td colspan="3"><strong>Houve contato posterior à recuperação com  o Cliente?</strong>&nbsp;'.$contato.'</td>
	</tr>
	<tr class="text">
		<td colspan="3"><strong>Endereço - Recuperação:</strong>&nbsp;'.$monitoramento->get("sinistro_endereco_recuperacao").'</td>
	</tr>
		<tr class="text">
		<td><strong>Data:</strong>&nbsp;'.$monitoramento->get("sinistro_data_recuperacao").'</td>
		<td><strong>Hora:</strong>&nbsp;'.$monitoramento->get("sinistro_hora_recuperacao").'</td>
		<td><strong>&nbsp;</strong></td>
	</tr>
	<tr class="text">
		<td colspan="3"><strong>Houve registro de fotos?</strong>&nbsp;'.$fotos.'</td>
	</tr>
	<tr class="text">
		<td colspan="3"><strong>Como ocorreu o evento? (Detalhes dos fatos)</strong>&nbsp;'.$monitoramento->get("sinistro_obs").'</td>
	</tr>
</table>';

require_once("../../fpdf/dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("a4","landscape");
$dompdf->render();
$dompdf->stream("sinistro.pdf");

?>

