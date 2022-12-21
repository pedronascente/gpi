<?php

include_once '../../../../../Config.inc.php';

$desenvolvimento = new Desenvolvimento;

$funcoes = new Funcoes;

$listaSms = $desenvolvimento->selectSMSOraculo();

if(!empty($listaSms)){
	include_once("../../../../../application/models/classes/api_sms/HumanClientMain.php");
	foreach ($listaSms as $sms){
		$funcoes::EnviarSMSAgendada("555180130816", utf8_decode("Há um nova solicitação do oráculo || Tipo: {$sms->get("desenvolvimento_nivel_solicitacao")} || Nível: {$sms->get("desenvolvimento_nivel")}"), "55555555555");
		$desenvolvimento->atualizarStatusSms($sms->get("so_id"));
	}
}

die(json_encode(array("msg"=>"success")));