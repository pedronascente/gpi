<?php  
include_once('../../Config.inc.php');

$id           = isset($_GET['id'])? $_GET['id']:"";

$desenvolvimento = new Desenvolvimento;

$desenvolvimento->select($id);


$usuario 		= $desenvolvimento->get("desenvolvimento_usuario");
$titulo 		= $desenvolvimento->get("desenvolvimento_modulo");
$programador 	= $desenvolvimento->get("desenvolvimento_programador");
$dataCriacao 	= $desenvolvimento->get("desenvolvimento_data_criacao");
$dataInicio 	= $desenvolvimento->get("desenvolvimento_data_inicio");
$dataFim    	= $desenvolvimento->get("desenvolvimento_data_final");
$descricao 		= $desenvolvimento->get("desenvolvimento_descricao");
$requisicao 	= $desenvolvimento->get("desenvolvimento_requisicao");
$setor 			= $desenvolvimento->get("desenvolvimento_setor");
$nivel 			= $desenvolvimento->get("desenvolvimento_nivel");
$status 		= $desenvolvimento->get("desenvolvimento_status");
$setorD			= $desenvolvimento->get("desenvolvimento_nivel_solicitacao");

$anexos = $desenvolvimento->selectAnexos($id);

$imagem1 = isset($anexos[0]['anexo_url']) ? "<img src='imagensSolicitacao/{$anexos[0]['anexo_url']}' style='max-height:250;max-width:500;'><br><br>" : "";
$imagem2 = isset($anexos[1]['anexo_url']) ? "<img src='imagensSolicitacao/{$anexos[1]['anexo_url']}' style='max-height:250;max-width:500;'><br><br>" : "";

require_once("sub-pasta/dadosOs.php");

//echo($html); die;

require_once("../dompdf/dompdf_config.inc.php");

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4","portrait");
$dompdf->render();
$dompdf->stream($id.'.pdf');
