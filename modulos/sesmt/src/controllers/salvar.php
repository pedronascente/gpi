<?php
header('Content-Type: text/html; charset=utf-8');
include_once("../../../../Config.inc.php");
$data_inputs =  filter_input_array(INPUT_POST);
$redirecionar_pagina_sucesso = "http://" . $_SERVER['HTTP_HOST'] . "/gpi/index.php?pg=73";
$redirecionar_pagina_formulario = "http://" . $_SERVER['HTTP_HOST'] . "/gpi/index.php?pg=72";

$help = new Help();

if (
	(!isset($data_inputs['pergunta1'])) or
	(!isset($data_inputs['pergunta2'])) or
	(!isset($data_inputs['pergunta3'])) or
	(!isset($data_inputs['pergunta4'])) or
	(!isset($data_inputs['pergunta5'])) or
	(!isset($data_inputs['pergunta6'])) or
	(!isset($data_inputs['pergunta7']))
) {

	// session_start inicia a sessão
	session_start();


	if ((!isset($data_inputs['pergunta1']))) {
		unset($_SESSION['pergunta1']);
		$_SESSION['pergunta1'] = 'fail';
	} else {
		unset($_SESSION['pergunta1']);
		$_SESSION['pergunta1'] = $data_inputs['pergunta1'];
	}
	if ((!isset($data_inputs['pergunta2']))) {
		unset($_SESSION['pergunta2']);
		$_SESSION['pergunta2'] = 'fail';
	} else {
		unset($_SESSION['pergunta2']);
		$_SESSION['pergunta2'] = $data_inputs['pergunta2'];
	}
	if ((!isset($data_inputs['pergunta3']))) {
		unset($_SESSION['pergunta3']);
		$_SESSION['pergunta3'] = 'fail';
	} else {
		unset($_SESSION['pergunta3']);
		$_SESSION['pergunta3'] = $data_inputs['pergunta3'];
	}
	if ((!isset($data_inputs['pergunta4']))) {
		unset($_SESSION['pergunta4']);
		$_SESSION['pergunta4'] = 'fail';
	} else {
		unset($_SESSION['pergunta4']);
		$_SESSION['pergunta4'] = $data_inputs['pergunta4'];
	}

	if ((!isset($data_inputs['pergunta5']))) {
		unset($_SESSION['pergunta5']);
		$_SESSION['pergunta5'] = 'fail';
	} else {
		unset($_SESSION['pergunta5']);
		$_SESSION['pergunta5'] = $data_inputs['pergunta5'];
	}

	if ((!isset($data_inputs['pergunta6']))) {
		unset($_SESSION['pergunta6']);
		$_SESSION['pergunta6'] = 'fail';
	} else {
		unset($_SESSION['pergunta6']);
		$_SESSION['pergunta6'] = $data_inputs['pergunta6'];
	}

	if ((!isset($data_inputs['pergunta7']))) {
		unset($_SESSION['pergunta7']);
		$_SESSION['pergunta7'] = 'fail';
	} else {
		unset($_SESSION['pergunta7']);
		$_SESSION['pergunta7'] = $data_inputs['pergunta7'];
	}

	header("Location:$redirecionar_pagina_formulario");
	exit;
}

$pergunta1 = $data_inputs['pergunta1'];
$pergunta2 = $data_inputs['pergunta2'];
$pergunta3 = $data_inputs['pergunta3'];
$pergunta4 = $data_inputs['pergunta4'];
$pergunta5 = $data_inputs['pergunta5'];
$pergunta6 = $data_inputs['pergunta6'];
$pergunta7 = $data_inputs['pergunta7'];

$quiz = new QuizModel();
$usuario = "USER-QUIZ-SESMT-" . md5(time()); //gerar user automatico
$quiz_id = $quiz->insert(array('usuario' => $usuario)); //recuperar quiz_id

if ($quiz_id) {
	//registrar pergunta1
	$Pergunta1 = new Pergunta1Model();
	$Pergunta1->insert([
		'quiz_id' => $quiz_id,
		'resposta' => $help->get_dia_semana($pergunta1)
	]);

	//registrar pergunta2
	$Pergunta2 = new Pergunta2Model();
	$Pergunta2->insert([
		'quiz_id' => $quiz_id,
		'resposta' => $help->get_dia_semana($pergunta2)
	]);

	//percorres os dados vindos do formulario, e registrar pergunta3
	if (!empty($pergunta3)) {
		foreach ($pergunta3 as $resposta) {
			$Pergunta3 = new Pergunta3Model();
			$Pergunta3->insert([
				'quiz_id' => $quiz_id,
				'resposta' => $help->get_problema($resposta)
			]);
		}
	}
	//percorres os dados vindos do formulario, e registrar pergunta4
	if (!empty($pergunta4)) {
		foreach ($pergunta4 as $resposta) {
			$pergunta4Obj = new Pergunta4Model();
			$pergunta4Obj->insert([
				'quiz_id' => $quiz_id,
				'resposta' => $help->get_problema($resposta)
			]);
		}
	}
	//percorres os dados vindos do formulario, e registrar pergunta5
	if (!empty($pergunta5)) {
		foreach ($pergunta5 as $resposta) {
			$pergunta5Obj = new Pergunta5Model();
			$pergunta5Obj->insert([
				'quiz_id' => $quiz_id,
				'resposta' => $help->get_problema($resposta)
			]);
		}
	}
	//percorres os dados vindos do formulario, e registrar pergunta6
	if (!empty($pergunta6)) {
		foreach ($pergunta6 as $resposta) {
			$pergunta6Obj = new Pergunta6Model();
			$pergunta6Obj->insert([
				'quiz_id' => $quiz_id,
				'resposta' => $help->get_problema($resposta)
			]);
		}
	}
	//percorres os dados vindos do formulario, e registrar pergunta7
	if (!empty($pergunta7)) {
		foreach ($pergunta7 as $resposta) {
			$pergunta7Obj = new Pergunta7Model();
			$pergunta7Obj->insert([
				'quiz_id' => $quiz_id,
				'resposta' => $help->get_problema($resposta)
			]);
		}
	}
} else {
	die('Error:Não foi possivel Registrar , tente novamente mais Tarde!');
}

header("Location:$redirecionar_pagina_sucesso");

exit;











































/*

switch ($acao) {

	case "cadastrarGuincho":

		if (empty($Dados['guincho_latitude']) || empty($Dados['guincho_longitude']))
			unset($Dados['guincho_latitude'], $Dados['guincho_longitude'], $Dados['guincho_local']);

		$id = $Dados['guincho_id'];

		if (empty($id))
			$id = $monitoramento->insert("guinchos", $Dados);
		else
			$monitoramento->updateGuincho($Dados);

		header("Location: ../../../../index.php?pg=48#lista");
		break;

	case "salvarCondicao":
		$id = $monitoramento->insert("guinchos_precos", $Dados);
		die(json_encode(array("result" => $id)));
		break;

	case "excluirCondicao":
		$monitoramento->deletarCondicao($Dados['id']);
		header("Location: ../../../../index.php?pg=48&id=" . $Dados['guincho_id'] . "#cadastro");
		break;

	case "pegarGuinchos":
		$lista = $monitoramento->listarGuinchosArray();
		$markers = null;
		if (!empty($lista)) {
			foreach ($lista as $k => $li) {
				if (!empty($li["guincho_latitude"]) && !empty($li["guincho_longitude"])) {
					$markers[$k][0] = $li["guincho_razao_social"] . "<br>" . $li["guincho_endereco"] . " - " . $li["guincho_cidade"] . " - " . $li["guincho_uf"] . "<br>" . $li["guincho_atendimento"];
					$markers[$k][1] = $li["guincho_latitude"];
					$markers[$k][2] = $li["guincho_longitude"];
					$markers[$k][3] = $li["guincho_id"];
					$markers[$k][4] = $li["guincho_credenciado"];
				}
			}
		}
		die(json_encode($markers));
		break;

	case "selecionarEmpresaGuincho":
		die(json_encode($monitoramento->selectGuinchoPorPosicao($Dados['latitude'], $Dados['longitude'])));
		break;

	case "selecionarVeiculos":
		die(json_encode($monitoramento->selectVeiculosCliente($Dados['id_cliente'], $Dados['nivel'])));
		break;

	case "adicionarCliente":
		$id = $monitoramento->insert("monitoramento_clientes", array("mc_nome" => $Dados['nome_cliente'], "mc_data" => date("Y-m-d H:i:s")));
		die(json_encode(array("result" => $id)));
		break;

	case "adicionarVeiculo":
		$veiculo = null;
		$Dados['nivel'] == 1 ? $veiculo["mvc_cliente_ra"] = $Dados['cliente'] : $veiculo["mvc_cliente"] = $Dados['cliente'];
		$veiculo["mvc_placa"] 	= isset($Dados['placa']) 	? $Dados['placa'] 	: "";
		$veiculo["mvc_marca"] 	= isset($Dados['marca']) 	? $Dados['marca'] 	: "";
		$veiculo["mvc_modelo"] 	= isset($Dados['modelo']) 	? $Dados['modelo'] 	: "";
		$veiculo["mvc_ano"] 	= isset($Dados['ano']) 		? $Dados['ano'] 	: "";

		$id = $monitoramento->insert("monitoramento_clientes_veiculos", $veiculo);
		die(json_encode(array("result" => $id)));
		break;

	case "salvarAssitencia":

		$Dados['assistencia_data'] = !empty($Dados['assistencia_data']) ? Funcoes::FormatadataSql($Dados['assistencia_data']) : "";

		$cliente = explode("_", $Dados['dados']);

		if ($cliente[2] == 1) {
			$Dados['assistencia_ra'] = $cliente[1];
			$Dados['assistencia_id_veiculo'] = $cliente[0];
		} else {
			$Dados['assistencia_cliente'] = $cliente[1];
			$Dados['assistencia_veiculo'] = $cliente[0];
		}

		unset($Dados['dados']);

		$id = $Dados['assistencia_id'];

		if (empty($id))
			$id = $monitoramento->insert("assistencia", $Dados);
		else
			$monitoramento->updateAssistencia($Dados);

		header("Location: ../../../../index.php?pg=49#lista");
		break;

	case "finalizarAssistencia":
		$monitoramento->updateAssistencia(array("assistencia_id" => $Dados['id'], "assistencia_status" => 2, "assistencia_finalizacao" => date("Y-m-d H:i:s")));
		header("Location: ../../../../index.php?pg=49#lista");
		break;

	case "salvarSisitro":

		$Dados['sinistro_data'] = !empty($Dados['sinistro_data']) ? Funcoes::FormatadataSql($Dados['sinistro_data']) : "";
		$Dados['sinistro_data_acao'] = !empty($Dados['sinistro_data_acao']) ? Funcoes::FormatadataSql($Dados['sinistro_data_acao']) : "";
		$Dados['sinistro_data_recuperacao'] = !empty($Dados['sinistro_data_recuperacao']) ? Funcoes::FormatadataSql($Dados['sinistro_data_recuperacao']) : "";

		$cliente = explode("_", $Dados['dados']);

		if ($cliente[2] == 1) {
			$Dados['sinistro_ra'] = $cliente[1];
			$Dados['sinistro_id_veiculo'] = $cliente[0];
		} else {
			$Dados['sinistro_cliente'] = $cliente[1];
			$Dados['sinistro_veiculo'] = $cliente[0];
		}

		unset($Dados['dados']);

		$Dados['sinistro_resgate'] = !empty($Dados['sinistro_resgate']) ? implode("-", $Dados['sinistro_resgate']) : "";

		if (empty($Dados['sinistro_id']))
			$monitoramento->insert("sinistros", $Dados);
		else $monitoramento->updateSinistro($Dados);

		header("Location: ../../../../index.php?pg=51#lista");
		break;

	case "excluirSinistro":
		$monitoramento->deleteSinistro($Dados['id']);
		header("Location: ../../../../index.php?pg=51#lista");
		break;

	case "finalizarSinistro":
		$monitoramento->updateSinistro(array("sinistro_id" => $Dados['id'], "sinistro_status" => 2));
		header("Location: ../../../../index.php?pg=51#lista");
		break;

	case "excluirGuincho":

		$valide = 0;

		$monitoramento->selectAssistenciaPorGuincho($Dados['id']);

		if ($monitoramento->Read()->getRowCount() == 0) {
			$valide = 1;
			$monitoramento->deleteGuincho($Dados['id']);
		}
		die(json_encode(array("result" => $valide)));
		break;

	case "excluirAssistencia":
		$monitoramento->deleteAssistencia($Dados['id']);
		header("Location: ../../../../index.php?pg=49");
		break;

	case "buscarCliente":
		$clientes = $monitoramento->selectClientes($Dados['nome']);
		die(json_encode($clientes));
		break;

	case "selecionarGuinchosProximos":
		$guinchos = $monitoramento->selectGuinchosProximos($Dados['latitude'], $Dados['longitude']);
		die(json_encode($guinchos));
		break;

	case "buscarPlaca":
		$lista = $monitoramento->buscaVeiculos($Dados['placa']);
		die(json_encode($lista));
		break;
}

*/