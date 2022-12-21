<?php

header('Content-Type: text/html; charset=utf-8');
include_once ("../../../../Config.inc.php");

$Dados = isset($_POST['acao']) ? filter_input_array(INPUT_POST) : filter_input_array(INPUT_GET);

$acao = isset($Dados ['acao']) ? $Dados ['acao'] : $_GET['acao'];
unset($Dados ['acao']);

$monitoramento = new Monitoramento;

switch ($acao){
	
	case "cadastrarGuincho":
		
		if(empty($Dados['guincho_latitude']) || empty($Dados['guincho_longitude']))
			unset($Dados['guincho_latitude'], $Dados['guincho_longitude'], $Dados['guincho_local']);
		
		$id = $Dados['guincho_id'];
		
		if(empty($id))
		 	$id = $monitoramento->insert("guinchos", $Dados);
		else 
			$monitoramento->updateGuincho($Dados);
		
		header("Location: ../../../../index.php?pg=48#lista");
		break;
		
	case "salvarCondicao":
		$id = $monitoramento->insert("guinchos_precos", $Dados);
		die(json_encode(array("result"=>$id)));
		break;
		
	case "excluirCondicao":
		$monitoramento->deletarCondicao($Dados['id']);
		header("Location: ../../../../index.php?pg=48&id=".$Dados['guincho_id']."#cadastro");
		break;
		
	case "pegarGuinchos":
		$lista = $monitoramento->listarGuinchosArray();
		$markers = null;
		if(!empty($lista)){
			foreach ($lista as $k=>$li){
				if(!empty($li["guincho_latitude"]) && !empty($li["guincho_longitude"])){
					$markers[$k][0] = $li["guincho_razao_social"]."<br>". $li["guincho_endereco"]." - ".$li["guincho_cidade"]." - ".$li["guincho_uf"]."<br>".$li["guincho_atendimento"];
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
		$id = $monitoramento->insert("monitoramento_clientes", array("mc_nome"=>$Dados['nome_cliente'], "mc_data"=>date("Y-m-d H:i:s")));
		die(json_encode(array("result"=>$id)));
		break;
		
	case "adicionarVeiculo":
		$veiculo = null;
		$Dados['nivel'] == 1 ? $veiculo["mvc_cliente_ra"] = $Dados['cliente'] : $veiculo["mvc_cliente"] = $Dados['cliente'];
		$veiculo["mvc_placa"] 	= isset($Dados['placa']) 	? $Dados['placa'] 	: "";
		$veiculo["mvc_marca"] 	= isset($Dados['marca']) 	? $Dados['marca'] 	: "";
		$veiculo["mvc_modelo"] 	= isset($Dados['modelo']) 	? $Dados['modelo'] 	: "";
		$veiculo["mvc_ano"] 	= isset($Dados['ano']) 		? $Dados['ano'] 	: "";
			
		$id = $monitoramento->insert("monitoramento_clientes_veiculos", $veiculo);
		die(json_encode(array("result"=>$id)));
		break;
		
	case "salvarAssitencia":
		
		$Dados['assistencia_data'] = !empty($Dados['assistencia_data']) ? Funcoes::FormatadataSql($Dados['assistencia_data']) : "";
		
		$cliente = explode("_", $Dados['dados']);
		
		if($cliente[2] == 1){
			$Dados['assistencia_ra'] = $cliente[1];
			$Dados['assistencia_id_veiculo'] = $cliente[0];
		} else {
			$Dados['assistencia_cliente'] = $cliente[1];
			$Dados['assistencia_veiculo'] = $cliente[0];
		}
		
		unset($Dados['dados']);
		
		$id = $Dados['assistencia_id'];
		
		if(empty($id))
			$id = $monitoramento->insert("assistencia", $Dados);
		else 
			$monitoramento->updateAssistencia($Dados);
		
		header("Location: ../../../../index.php?pg=49#lista");
		break;
		
	case "finalizarAssistencia":
		$monitoramento->updateAssistencia(array("assistencia_id"=>$Dados['id'], "assistencia_status"=>2, "assistencia_finalizacao"=>date("Y-m-d H:i:s")));
		header("Location: ../../../../index.php?pg=49#lista");
		break;
		
	case "salvarSisitro":
		
			$Dados['sinistro_data'] = !empty($Dados['sinistro_data']) ? Funcoes::FormatadataSql($Dados['sinistro_data']) : ""; 
			$Dados['sinistro_data_acao'] = !empty($Dados['sinistro_data_acao']) ? Funcoes::FormatadataSql($Dados['sinistro_data_acao']) : ""; 
			$Dados['sinistro_data_recuperacao'] = !empty($Dados['sinistro_data_recuperacao']) ? Funcoes::FormatadataSql($Dados['sinistro_data_recuperacao']) : "";
			
			$cliente = explode("_", $Dados['dados']);
			
			if($cliente[2] == 1){
				$Dados['sinistro_ra'] = $cliente[1];
				$Dados['sinistro_id_veiculo'] = $cliente[0];
			} else {
				$Dados['sinistro_cliente'] = $cliente[1];
				$Dados['sinistro_veiculo'] = $cliente[0];
			}
			
			unset($Dados['dados']);
			
			$Dados['sinistro_resgate'] = !empty($Dados['sinistro_resgate']) ? implode("-",$Dados['sinistro_resgate']) : "";
			
			if(empty($Dados['sinistro_id']))
				$monitoramento->insert("sinistros", $Dados);
			else $monitoramento->updateSinistro($Dados);
			
			header("Location: ../../../../index.php?pg=51#lista");
		break;
		
	case "excluirSinistro":
		$monitoramento->deleteSinistro($Dados['id']);
		header("Location: ../../../../index.php?pg=51#lista");
		break;
		
	case "finalizarSinistro":
		$monitoramento->updateSinistro(array("sinistro_id"=>$Dados['id'], "sinistro_status"=>2));
		header("Location: ../../../../index.php?pg=51#lista");
		break;
		
	case "excluirGuincho":
		
		$valide = 0;
		
		$monitoramento->selectAssistenciaPorGuincho($Dados['id']);
		
		if($monitoramento->Read()->getRowCount() == 0){
			$valide = 1;
			$monitoramento->deleteGuincho($Dados['id']);
		}
		die(json_encode(array("result"=>$valide)));
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