<?php

include_once '../../Config.inc.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
/*
 * ****************************************
 * ******** LISTAR OS DADOS DA OS *********
 * ****************************************
 */
$veiculo = new Veiculos;
$dadosOs = $veiculo->selectOS($id);

// ********* DADOS / CLIENTE *********
$protocolo 		= !empty($dadosOs ["veiculos_os_protocolo"]) 		? $dadosOs ["veiculos_os_protocolo"] 										: "&nbsp;";
$dataCriacaoOs 	= !empty($dadosOs ["veiculo_os_data_criacao"]) 		? Funcoes::formataDataComHora($dadosOs ["veiculo_os_data_criacao"])			: "&nbsp;";
$nome 			= !empty($dadosOs ["nome_cliente"]) 				? $dadosOs ["nome_cliente"] 												: "&nbsp;";
$cep 			= !empty($dadosOs ["cep_cliente"]) 					? $dadosOs ["cep_cliente"] 													: "&nbsp;";
$rua 			= !empty($dadosOs ["cliente_logradouro"]) 			? $dadosOs ["cliente_logradouro"] 											: "&nbsp;";
$numero 		= !empty($dadosOs ["numero_cliente"]) 				? $dadosOs ["numero_cliente"] 												: "&nbsp;";
$complemento 	= !empty($dadosOs ["complemento_cliente"]) 			? $dadosOs ["complemento_cliente"] 											: "&nbsp;";
$bairro 		= !empty($dadosOs ["bairro_cliente"]) 				? $dadosOs ["bairro_cliente"] 												: "&nbsp;";
$cidade 		= !empty($dadosOs ["cidade_cliente"]) 				? $dadosOs ["cidade_cliente"] 												: "&nbsp;";
$uf 			= !empty($dadosOs ["uf_cliente"]) 					? $dadosOs ["uf_cliente"] 													: "&nbsp;";

// ********* DADOS / VEICULO(S) *********
$placa 			= !empty($dadosOs ["placa"]) 		? $dadosOs ["placa"] 			: "&nbsp;";
$marca 			= !empty($dadosOs ["marca"]) 		? $dadosOs ["marca"] 			: "&nbsp;";
$modelo 		= !empty($dadosOs ["modelo"]) 		? $dadosOs ["modelo"] 			: "&nbsp;";
$cor 			= !empty($dadosOs ["cor"]) 			? $dadosOs ["cor"] 				: "&nbsp;";
$ano 			= !empty($dadosOs ["ano"]) 			? $dadosOs ["ano"] 				: "&nbsp;";
$renavam 		= !empty($dadosOs ["renavam"]) 		? $dadosOs ["renavam"] 			: "&nbsp;";
$chassis 		= !empty($dadosOs ["chassis"]) 		? $dadosOs ["chassis"] 			: "&nbsp;";
$tipoBateria 	= !empty($dadosOs ["tipo_bateria"]) ? $dadosOs ["tipo_bateria"] 	: "&nbsp;";

// ********* DADOS / EQUIPAMENTOS *********
$chip 			= !empty($dadosOs ["chip_chip"]) 			? $dadosOs ["chip_chip"] 		: "&nbsp;";
$operadora 		= !empty($dadosOs ["chip_operadora"]) 		? $dadosOs ["chip_operadora"] 	: "&nbsp;";
$modulo 		= !empty($dadosOs ["chip_modulo"]) 			? $dadosOs ["chip_modulo"] 		: "&nbsp;";
$linha 			= !empty($dadosOs ["chip_linha"]) 			? $dadosOs ["chip_linha"] 		: "&nbsp;";
// ********* DADOS / DE INSTALAÇÃO *********
$localBotaoPanico 					= !empty($dadosOs ["veiculos_equipamentos_local_botao_panico"]) 		? $dadosOs ["veiculos_equipamentos_local_botao_panico"] 			: "&nbsp;";
$localSirene 						= !empty($dadosOs ["veiculos_equipamentos_local_sirene"]) 				? $dadosOs ["veiculos_equipamentos_local_sirene"] 					: "&nbsp;";
$dataInstalacao 					= !empty($dadosOs ["veiculos_equipamentos_data_instalacao"]) 			? $dadosOs ["veiculos_equipamentos_data_instalacao"] 				: "&nbsp;";
$responsavelInstalacao 				= !empty($dadosOs ["veiculos_equipamentos_responsavel_instalacao"]) 	? $dadosOs ["veiculos_equipamentos_responsavel_instalacao"] 		: "&nbsp;";
$solicitante 						= !empty($dadosOs ["veiculos_os_solicitante"]) 							? $dadosOs ["veiculos_os_solicitante"] 								: "&nbsp;";
$enderecoManutencao 				= !empty($dadosOs ["veiculos_os_endereco_manutencao"]) 					? $dadosOs ["veiculos_os_endereco_manutencao"] 						: "&nbsp;";
$motivoManutencao 					= !empty($dadosOs ["veiculos_os_motivo_manutencao"]) 					? $dadosOs ["veiculos_os_motivo_manutencao"] 						: "&nbsp;";
$veiculos_os_manutencaoEfetuada 	= !empty($dadosOs ["veiculos_os_manutencao_efetuada"]) 					? $dadosOs ["veiculos_os_manutencao_efetuada"] 						: "&nbsp;";
$veiculos_os_tecnico 				= !empty($dadosOs ["veiculos_os_tecnico"]) 								? $dadosOs ["veiculos_os_tecnico"] 									: "&nbsp;";
$veiculos_os_credenciado			= !empty($dadosOs ["credenciado_razao_social"]) 						? $dadosOs ["credenciado_razao_social"] 							: "&nbsp;";

$id_cliente = $dadosOs ['id_cliente'];


$tipo_os = "&nbsp;";
$statusOS = "&nbsp;";
$gravidade = "&nbsp;";

switch ($dadosOs["veiculos_os_tipo"]){
	case 1: $tipo_os = "Manutenção"; break;
	case 2: $tipo_os = "Instalação"; break;
	case 3: $tipo_os = "Reclamação";  break;
}

switch ($dadosOs["veiculos_os_status"]) {
	case 1: $statusOS = "Aberto"; break;
	case 3: $statusOS = "Em Andamento"; break;
	case 2: $statusOS = "Finalizado";  break;
}

switch ($dadosOs["veiculos_os_gravidade"]) {
	case 1: $gravidade = "Baixa"; break;
	case 2: $gravidade = "Média"; break;
	case 3: $gravidade = "Alta";  break;
}

/*
 * *******************************************
 * ******** LISTAR TODOS OS CONTATOS *********
 * *******************************************
 */

$agenda = new AgendaContato;

$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ordem de Serviço</title>
<style type="text/css">
table{ font:9px Arial, Helvetica, "sans-serif"; }
h1{ font-size:11px;font-weight:bold;}
._span{padding:3px 0 3px 0;background:#DADADA;}
body{margin:0;padding:0}
</style>
</head>
<body>
<table  width="100%" cellpadding="5" cellspacing="0" border="0">
	<thead>
    	<tr>
		<td>
			<table width="100%" cellpadding="3" cellspacing="2" >
			  <tr>  
			    <td align="left"> <img src="logo_volpato.png" width="180" height="32" border="0" alt="" /></td>
		 	    <td align="right"><h1 style="font-size:15px;">Ordem de Serviço</h1></td>
			  </tr>
			</table>
	    </td>
	  </tr>
    </thead>
    <tbody>
        <tr>
          <td>
             <table width="100%" cellpadding="5" cellspacing="0" border="0">
                <tbody>
                  <tr >
                    <td colspan="4"><h1>Dados do Cliente</h1></td>
                     <td  align="right"><strong>Protocolo: ' . $protocolo . '<br />Data: ' . $dataCriacaoOs . '</strong></td>
                  </tr>
                  <tr>
                    <td colspan="5">Nome / Razão Social:<br /><div class="_span">' . $nome . '</div></td>
                  </tr>
                  <tr>
                    <td colspan="2" >Cep.:<br /><div class="_span">' . $cep . '</div></td>
                    <td colspan="3">Logradouro:<br /><div class="_span">' . $rua . '</div></td>
                  </tr>
                  <tr>
                    <td>N°<br /><div class="_span">' . $numero . '</div></td>
                    <td>Complemento:<br /><div class="_span">' . $complemento . '</div></td>
                    <td>Bairro:<br /><div class="_span">' . $bairro . '</div></td>
                    <td>Cidade:<br /><div class="_span">' . $cidade . '</div></td>
                    <td>UF:<br /><div class="_span">' . $uf . '</div></td>
                  </tr>';
if (isset($dadosContato)) {
    foreach ($dadosContato as $k => $liContato) {
        // RESPONSAVEL POR LSITAR TODOS OS TELEFONE DE CONTATO:
        $fones = (!empty($liContato ["contato_telefone1"])) ? $liContato ["contato_telefone1"] : "&nbsp;";
        if (!empty($liContato ["contato_telefone2"]) && empty($liContato ["contato_telefone3"])) :
            $fones .= " ; " . $liContato ["contato_telefone2"];
        elseif (!empty($liContato ["contato_telefone2"]) && !empty($liContato ["contato_telefone3"]) && empty($liContato ["contato_telefone4"])) :
            $fones .= " ; " . $liContato ["contato_telefone2"] . " ; " . $liContato ["contato_telefone3"];
        elseif (!empty($liContato ["contato_telefone2"]) && !empty($liContato ["contato_telefone3"]) && !empty($liContato ["contato_telefone4"])) :
            $fones .= " ; " . $liContato ["contato_telefone2"] . " ; " . $liContato ["contato_telefone3"] . " ; " . $liContato ["contato_telefone4"];
        endif;
        // RESPONSAVEL POR LSITAR TODOS OS E-MAILS DE CONTATO:
        $email = (!empty($liContato ["contato_email1"])) ? $liContato ["contato_email1"] : "&nbsp;";
        if (!empty($liContato ["contato_email2"]) && empty($liContato ["contato_email3"])) :
            $email .= " ; " . $liContato ["contato_email2"];
        elseif (!empty($liContato ["contato_email2"]) && !empty($liContato ["contato_email3"])) :
            $email .= " ; " . $liContato ["contato_email2"] . " ; " . $liContato ["contato_email3"];
        endif;
        $html .= '
									<tr>
										<td colspan="4">Contato' . ($k + 1) . '<br /><div class="_span">' . $liContato ["contato_nome"] . '</div></td>
										<td>Telefone .:<br /><div class="_span">' . $fones . '</div></td>
									</tr>
									<tr>
										<td colspan="5">E-mail:<br /><div class="_span">' . $email . '</div></td>
									</tr>';
		}

}
$html .= '</tbody>
             </table>  
          </td>
        </tr>
        <tr>
          <td>
             <table width="100%" cellpadding="5" cellspacing="0" border="0">
                <tbody>
                  <tr>
                    <td colspan="4"><h1>Dados veículo</h1></td>
                  </tr>
                  <tr>
                    <td>Placa:<br /><div class="_span">' . $placa . '</div></td>
                    <td>Marca:<br /><div class="_span">' . $marca . '</div></td>
                    <td>Modelo:<br /><div class="_span">' . $modelo . '</div></td>
                    <td>Cor:<br /><div class="_span">' . $cor . '</div></td>
                  </tr>
                  <tr>
                    <td>Ano:<br /><div class="_span">' . $ano . '</div></td>
                    <td>Renavam:<br /><div class="_span">' . $renavam . '</div></td>
                    <td>Chassi:<br /><div class="_span">' . $chassis . '</div></td>
                    <td>Voltagem:<br /><div class="_span">' . $tipoBateria . '</div></td>
                  </tr>
                </tbody>
             </table> 
          </td>
        </tr>
         <tr>
          <td>
             <table width="100%" cellpadding="5" cellspacing="0" border="0">
                <tbody>
                  <tr>
                    <td colspan="4"><h1>Dados do Equipamento</h1></td>
                  </tr>
                  <tr>
                    <td>Serial Módulo:<br /><div class="_span">' . $modulo . '</div></td>
                    <td>Chip:<br /><div class="_span">' . $chip . '</div></td>
                    <td>Operadora:<br /><div class="_span">' . $operadora . '</div></td>
                    <td>Linha:<br /><div class="_span">' . $linha . '</div></td>
                  </tr>
                </tbody>
             </table> 
          </td>
        </tr>
        <tr>
          <td>
              <table width="100%" cellpadding="5" cellspacing="0" border="0">
                <tbody>
                  <tr>
                    <td colspan="4"><h1>Dados de Instação</h1></td>
                  </tr>
                  <tr>
                    <td>Local Botão Pânico:<br /><div class="_span">' . $localBotaoPanico . '</div></td>
                    <td colspan="4">Local da Sirene:<br /><div class="_span">' . $localSirene . '</div></td>
                  </tr>
                  <tr>
                    <td> Data Instalação:<br /><div class="_span">' . $dataInstalacao . '</div></td>
                    <td colspan="4">Responsavel pela Instalação:<br /><div class="_span">' . $responsavelInstalacao . '</div></td>
                  </tr>
                </tbody>
             </table> 
          </td>
        </tr>
		 <tr>
          <td>
              <table width="100%" cellpadding="5" cellspacing="0" border="0">
                <tbody>
                  <tr>
                   <td colspan="4"><h2>Dados da Ordem de Serviço</h2></td>
                  </tr>
                  <tr>
                    <td colspan="2">Status:<br /><div class="_span">' . $statusOS . '</div></td>
                    <td  colspan="2">Tipo:<br /><div class="_span">' . $tipo_os . '</div></td>
                    <td  colspan="2">Gravidade:<br /><div class="_span">' . $gravidade . '</div></td>
                  </tr>
                  <tr>
                    <td colspan="3">Solicitante:<br /><div class="_span">' . trim($solicitante) . '</div></td>
                    <td  colspan="3">Endereço de Manutenção:<br /><div class="_span">' . trim($enderecoManutencao) . '</div></td>
                  </tr>
                  <tr>
                    <td colspan="3">Credenciado:<br /><div class="_span">' .$veiculos_os_credenciado . '</div></td>
                    <td  colspan="3">Técnico:<br /><div class="_span">' . $veiculos_os_tecnico . '</div></td>
                  </tr>
                  <tr>
                    <td colspan="6">Motivo da Manutenção:<br /><div class="_span" style="height:80px">' . $motivoManutencao . '</div></td>
                  </tr>
				  <tr>
				     <td colspan="6">Manutenção Efetuada:<br /><div class="_span" style="height:80px">' . $veiculos_os_manutencaoEfetuada . '</div></td>
				  </tr>
                </tbody>
             </table> 
          </td>
        </tr>
	   <tr>
         <td>
          <table width="100%" cellpadding="5" cellspacing="20" border="0">
            <tbody>
                  <tr>
                    <td>&nbsp;</td>
                     <td>&nbsp;</td>
                  </tr>
				  <tr>
                    <td>&nbsp;</td>
                     <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td style="border-bottom: 1px solid #000;width:30%" >&nbsp;</td>
                    <td style="border-bottom:1px solid #000;width:30%" >&nbsp;</td>
                  </tr>
                  <tr align="center">
                    <td>Técnico Responsável</td>
                    <td>Cliente</td>
                  </tr>
            </tbody> 
         </table>
         </td>
       </tr>
     </tfoot>
</table>
</body>
</html>';

/*
 * **************************************************
 * ********* objeto que cria o arquivo PDF **********
 * **************************************************
 */
if ($html) {
    include_once ("../dompdf/dompdf_config.inc.php");
    $dompdf = new DOMPDF ();
    $dompdf->load_html($html);
    $dompdf->set_paper("A4", "portrait");
    $dompdf->render();
    $dompdf->stream("os.pdf");
 
}