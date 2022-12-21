<?php

include_once '../../../../../Config.inc.php';

$supervisor['tipo_permissao'] = 'supervisor';
$suporte['tipo_permissao'] = 'suporte';
$desenvolvedor['tipo_permissao'] = 'desenvolvedor';
$captacao['tipo_permissao'] = 'captacao';

if(!isset($_SESSION['user_info']))
	@session_start();

$permissoes = $_SESSION['user_info']['permissoes'];

$desenvolvimento = new Desenvolvimento;

$total = 0;

//listar somente as solicitações de cada setor, desenvolvimento, suporte
$nivel = in_array($suporte, $permissoes) ? 2 : (in_array($desenvolvedor, $permissoes) ? 1 : null);

$lista = $desenvolvimento->selectValoresStatus($nivel);
$desenvolvimento->selectComFiltros(array("id_programador" => $_SESSION['user_info']['id_usuario']), null);
$lista2 = $desenvolvimento->selectValoresStatus($nivel);
$desenvolvimento->selectComFiltros(array("id_usuario" => $_SESSION['user_info']['id_usuario']), null);
$lista3 = $desenvolvimento->selectValoresStatus();
$mensagem = "";

$ti = in_array($suporte, $permissoes) || in_array($desenvolvedor, $permissoes);


if (in_array($ti, $permissoes)) {
	$aprovadas = isset($lista[1]) && $lista[1] == 1 ? " {$lista[1]} solicitação aprovada" : "";
	$aprovadas = isset($lista[1]) && $lista[1] > 1 ? " {$lista[1]} solicitações aprovadas" : $aprovadas;
	$total = isset($lista[1]) && $lista[1] !=0 ? (int) $total+$lista[1] : $total;

	$viniciadas = (!empty($aprovadas) && (isset($lista2[2])) && $lista2[2] >= 1) ? "," : "";
	$iniciadas = isset($lista2[2]) && $lista2[2] == 1 ? "{$viniciadas} {$lista2[2]} solicitação iniciada" :  "";
	$iniciadas = isset($lista2[2]) && $lista2[2] > 1 ? "{$viniciadas} {$lista2[2]} solicitações iniciadas" : $iniciadas;
	$total = isset($lista2[2]) && $lista2[2] !=0 ? (int) $total+$lista2[2] : $total;


	$vparadas = (!empty($aprovadas) || !empty($iniciadas)) && (isset($lista2[3]) && $lista2[3] >= 1) ? "," : "";
	$paradas = isset($lista2[3]) && $lista2[3] == 1 ? "{$vparadas} {$lista2[3]} solicitação parada" : "";
	$paradas = isset($lista2[3]) && $lista2[3] > 1 ? "{$vparadas} {$lista2[3]} solicitações paradas" : $paradas;
	$total = isset($lista2[3]) && $lista2[3] !=0 ? (int) $total+$lista2[3] : $total;

	$vbugs = (!empty($aprovadas) || !empty($iniciadas) || !empty($paradas)) && (isset($lista2[7]) && $lista2[7] >= 1) ? " e" : "";
	$bugs = isset($lista2[7]) && $lista2[7] == 1 ? "{$vbugs} {$lista2[7]} solicitação com bug" : "";
	$bugs = isset($lista2[7]) && $lista2[7] > 1 ? "{$vbugs} {$lista2[7]} solicitações com bugs" : $bugs;
	$total = isset($lista2[7]) && $lista2[7] !=0 ? (int)$total+$lista2[7] : $total;

	$mensagem = "Você tem" . $aprovadas . $iniciadas . $paradas . $bugs;
	
} else if (in_array($supervisor, $permissoes)) {

	$storyboard = isset($lista[0]) && $lista[0] == 1 ? "  {$lista[0]} solicitação na storyboard" : "";
	$storyboard = isset($lista[0]) && $lista[0] > 1 ? "  {$lista[0]} solicitações na storyboard" : $storyboard;
	$total = isset($lista[0]) && $lista[0] !=0 ? (int) $total+$lista[0] : $total;
	
	$reanalise = isset($lista[8]) && $lista[8] == 1 	? " e  {$lista[8]} solicitação na reanálise" : "";
	$reanalise = isset($lista[8]) && $lista[8] > 1 		? " e  {$lista[8]} solicitações na reanálise" : $reanalise;
	$total = isset($lista[8]) && $lista[8] !=0 ? (int) $total+$lista[8] : $total;
	$mensagem = "Você tem" . $storyboard.$reanalise;

}

if(!empty($lista3[4])) {
	$testes = isset($lista3[4]) && $lista3[4] == 1 ? "  {$lista3[4]} solicitação para ser testada" : "";
	$testes = isset($lista3[4]) && $lista3[4] > 1 ? "  {$lista3[4]} solicitações para serem testadas" : $testes;
	$total = isset($lista3[4]) && $lista3[4] !=0 ? (int) $total+$lista3[4] : $total;
	strlen(str_replace("Você tem", "", $mensagem)) == 0 ? $mensagem = "" : null;
	$mensagem .= empty($mensagem) ? "Você tem" : " e ";
	$mensagem .=  $testes;
}

$notificacoes = null;

//quantidade solicitacioes
if($_SESSION['user_info']['versao'] == 1){
	$notificacoes['desenvolvimento'] = array();
	if(!empty($aprovadas))
		array_push ($notificacoes['desenvolvimento'] , $aprovadas);
	if(!empty($iniciadas))
		array_push ($notificacoes['desenvolvimento'] , $iniciadas);
	if(!empty($paradas))
		array_push ($notificacoes['desenvolvimento'] , $paradas);
	if(!empty($bugs))
		array_push ($notificacoes['desenvolvimento'] , $bugs);
	if(!empty($storyboard))
		array_push ($notificacoes['desenvolvimento'] , $storyboard);
	if(!empty($testes))
		array_push ($notificacoes['desenvolvimento'] , $testes);
	
	$notificacoes['captacao'] = 0;
	$notificacoes['agenda'] = 0;
	
	if(in_array($captacao, $permissoes)) {
		//quantidade captações  novas
		$captacao = new Captacao;
		$captacao->selectCaptacaoUser(array('id'=>$_SESSION['user_info']['id_usuario'], "status"=>"novo"), null);
		$totalC = (int) $captacao->Read()->getRowCount();;
		$total = $total+ $totalC;
		$notificacoes['captacao'] = $totalC;
		
		$agenda = new AgendaContato;
		$agenda->selectPorUsuarioData(array('id'=>$_SESSION['user_info']['id_usuario'], "status"=>"0"));	
		$totalA = (int) $agenda->Read()->getRowCount();
		$total = $total + $totalA;
		$notificacoes['agenda'] = $totalA;
	}
}

$mensagem = str_replace("Você tem", "", $mensagem) != null ? $mensagem : "";

die(json_encode(array("msg"=>$mensagem, "notificacoes"=>$notificacoes, "versao"=>$_SESSION['user_info']['versao'], "total"=>$total)));

