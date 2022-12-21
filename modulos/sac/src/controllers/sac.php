<?php

include_once ("../../../../Config.inc.php");
$Dados = filter_input_array(INPUT_POST);
$id = isset($Dados ['id_cliente']) ? $Dados ['id_cliente'] : null;

if (!empty($Dados)) :
    $acao = $Dados ['acao'];
else :
    $acao = filter_input(INPUT_GET, 'acao', FILTER_DEFAULT);
endif;

unset($Dados['acao']);

$cliente = new Clientes ();
$agendaContato = new AgendaContato ();
$veiculo = new Veiculos ();
$credenciado = new Credenciados;
$chip = new Chip;
$logs = new Log;
$equipamento = new Equipamento;



if (!isset($_SESSION['user_info']))
    session_start();

//campos substituidos no log
$campos = array("cliente_ativo"=>"situação","nome_cliente"=>"razão social","cnpjcpf_cliente" => "CPF/CNPJ", "contra_senha_seguranca" =>"contra-senha segurança", "credenciado_cpfcnpj"=>"credenciado_cpfcnpj");

switch ($acao) :
    /*
     * ****************************************************
     * ********* ATUALIZAR DADOS CLIENTE NA BD **********
     * ****************************************************
     */
    case "EditarCliente" :

		if(!empty($id)){
                    $anterior = $cliente->selectClienteEnderecoCobranca($id);
		} else{
                    $Dados['tipo_cadastro'] = "interno";
                    $Dados['data_solicitacao_cliente'] = date("Y-m-d H:a:s");
		}

		if (!empty($id)) {
            $cliente->updateCliente("clientes", $Dados);
        } else {
            $id = $cliente->insert("clientes", $Dados);
            $EnderecoCobranca ['numero_cobranca'] = $Dados ['numero_cliente'];
            $EnderecoCobranca ['logradouro_cobranca'] = $Dados ['logradouro_cliente'];
            $EnderecoCobranca ['bairro_cobranca'] = $Dados ['bairro_cliente'];
            $EnderecoCobranca ['cidade_cobranca'] = $Dados ['cidade_cliente'];
            $EnderecoCobranca ['complemento_cobranca'] = $Dados ['complemento_cliente'];
            $EnderecoCobranca ['telefone_cobranca'] = $Dados ['telefone_cliente'];
            $EnderecoCobranca ['celular_cobranca'] = $Dados ['celular_cliente'];
            $EnderecoCobranca ['contato_cobranca'] = $Dados ['contato_cliente'];
            $EnderecoCobranca ['email_cobranca'] = $Dados ['email_cliente'];
            $EnderecoCobranca ['cep_cobranca'] = $Dados ['cep_cliente'];
            $EnderecoCobranca ['uf_cobranca'] = $Dados ['uf_cliente'];
            $EnderecoCobranca ['id_cliente'] = $id;
            $cliente->insertEnderecoCobranca("cliente_endereco_cobranca", $EnderecoCobranca);
        }

        $Dados['id'] = $id;

        unset($Dados['id_cliente']);
        
        //status cliente
        if (!empty($Dados['cliente_ativo'])) {
        	switch ($Dados['cliente_ativo']) {
        		case "on":
        			$textos['cliente_ativo'] = "Ativo";
        			break;
        		case "off":
        			$textos['cliente_ativo'] = "Inativo";
        			break;
        	}
        }

        if (!empty($Dados['id_cliente'])) {
            Funcoes::gerarLogAlteracao($logs, "Edição Cliente", $Dados, $anterior, 1, array("cliente_ativo"), $campos, $textos);
        } else {
            Funcoes::gerarLogCadastro($logs, "Cadastro Cliente", $Dados, 1, $campos, $textos);
        }

        header("Location: ../../../../index.php?pg=10&id={$id}&acao=ListarCliente#cliente");
        break;
    /*
     * **********************************************
     * ********* INSERIR UM CONTATO NA BD *********
     * **********************************************
     */
    case "InsertContato" :
        unset($Dados ['submit'], $Dados ['acao']);

        $result = $agendaContato->insert($Dados);
        
        $id_cliente = $Dados['contato_id_cliente'];

        $Dados['id'] = $id_cliente;

        $nivel = $Dados['contato_nivel'];

        unset($Dados['contato_id_cliente'], $Dados['contato_nivel']);

        if (!empty($result))
        	Funcoes::gerarLogCadastro($logs, "Cadastro Contato", $Dados, $nivel);


        if ($nivel == 1)
            header("Location: ../../../../index.php?pg=10&id={$id_cliente}&acao=ListarCliente#cliente");
        else if ($nivel == 2)
            header("Location: ../../../../index.php?pg=38&id={$id_cliente}&acao=listarCredenciado#cadastrarCredenciado");
        else 
        	header("Location: ../../../../index.php?pg=48&id={$id_cliente}#cadastro");
        break;

    /*
     * **********************************************
     * ********* ATUALIZAR UM CONTATO NA BD *********
     * **********************************************
     */
    case "EditarContato" :
        unset($Dados ['submit'], $Dados ['acao']);
        $anterior = $agendaContato->selectContato($Dados ['contato_id']);
        $agendaContato->updateContato($Dados);

        $Dados['id'] = $anterior['contato_id_cliente'];

        $nivel = $Dados['contato_nivel'];

        unset($Dados['contato_nivel'], $Dados['contato_nivel']);

        $texto =  "\nAnterior: {$anterior['contato_nome']} \n";
        
        Funcoes::gerarLogAlteracao($logs, "Edição Contato", $Dados, $anterior, $nivel, null, null, null, $texto);

        if ($nivel == 1)
            header("Location: ../../../../index.php?pg=10&id={$Dados['id']}&acao=ListarCliente#cliente");
        else if ($nivel == 2)
            header("Location: ../../../../index.php?pg=38&id={$id_cliente}&acao=listarCredenciado#cadastrarCredenciado");
        else 
        	header("Location: ../../../../index.php?pg=48&id={$id_cliente}#cadastro");

        break;

    /*
     * *******************************************
     * ********* DELETE UM CONTATO NA BD *********
     * *******************************************
     */
    case "DeleteContato" :

        $contato = $agendaContato->selectContato($_GET ['id']);

        $agendaContato->deleteContato($_GET ['id']);

        $id_cliente = filter_input(INPUT_GET, "id_cliente");

        $contato['id'] = $id_cliente;
        
        $nivel = $contato['contato_nivel'];

        unset($contato['contato_id'], $contato['contato_id_cliente'], $contato['contato_nivel']);

        Funcoes::gerarLogCadastro($logs, "Exclusão Contato", $contato, $nivel);

        if (filter_input(INPUT_GET, "contato_nivel") == 1)
            header("Location: ../../../../index.php?pg=10&id={$id_cliente}&acao=ListarCliente#cliente");
        else if ($nivel == 2)
            header("Location: ../../../../index.php?pg=38&id={$id_cliente}&acao=listarCredenciado#cadastrarCredenciado");
        else 
        	header("Location: ../../../../index.php?pg=48&id={$id_cliente}#cadastro");

        break;
    /*
     * ****************************************************
     * ********* ATUALIZAR DADOS DO VEICULO NA BD *********
     * ****************************************************
     */
    case "insertEquipamentosVeiculos" :
        $id_cliente = $Dados['id_cliente'];
        $placa = $Dados['placa'];
        $verificados = $Dados['equipamentos'];
        unset($Dados ['submit'], $Dados['id_cliente'], $Dados['placa'],$Dados['equipamentos']);

        $Dados['veiculos_equipamentos_data_instalacao'] = Funcoes::FormatadataSql($Dados['veiculos_equipamentos_data_instalacao']);

        $anterior = $veiculo->selectEquipamentos($Dados['veiculos_equipamentos_id_veiculo']);

        $veiculo->selectEquipamentos($Dados['veiculos_equipamentos_id_veiculo']);
        
        $TOTAL = $veiculo->Read()->getRowCount();
        
        if (empty($TOTAL))
            $Dados ['veiculos_equipamentos_id'] = $veiculo->insertEquipamento($Dados);
        else
            $veiculo->updateEquipamento($Dados);


        $id_veiculo = $Dados['veiculos_equipamentos_id_veiculo'];

        $Dados['id'] = $id_cliente;
        $Dados['placa'] = $placa;
        $anterior['placa'] = $placa;

        //chip
        if (isset($Dados['veiculos_equipamentos_id_chip']) && (empty($Dados['veiculos_equipamentos_id_chip'])  || $Dados['veiculos_equipamentos_id_chip'] != $anterior['veiculos_equipamentos_id_chip'])){
        	if(isset($anterior['veiculos_equipamentos_id_chip']))
        		$chip->atualizar(array("chip_id"=>$anterior['veiculos_equipamentos_id_chip'], "chip_status"=>4));
        	$chip->atualizar(array("chip_id"=>$Dados['veiculos_equipamentos_id_chip'], "chip_status"=>5));
        	$textos['veiculos_equipamentos_id_chip'] = $chip->get("chip_chip") . "(Cód.{$Dados['veiculos_equipamentos_id_chip']})";
        }
        
        //data instalação
        if (!empty($Dados['veiculos_equipamentos_data_instalacao'])) {
        	$textos['veiculos_equipamentos_data_instalacao'] = Funcoes::formataData($Dados['veiculos_equipamentos_data_instalacao']);
        }
        
        $equipCliente = $equipamento->selectEquipamentosClienteEquipamentos($id_cliente);
        
        if (!empty($equipCliente)) {
        	$teste = null;
        
        	foreach ($equipCliente as $eCli) {
        
        		$teste = (int) Funcoes::arraySearch($eCli ['equipamentos_sac_clientes_equipamento'], $verificados);
        
        		if ($teste == - 1)
        			$equipamento->deletarEquipamentoCliente($id_cliente, $eCli ['equipamentos_sac_clientes_equipamento']);
        		else
        			unset($verificados [$teste]);
        	}
        }
        
        if(!empty($verificados)){
	        foreach ($verificados as $ve){
	        	$equipamento->insert("equipamentos_sac_clientes", array("equipamentos_sac_clientes_cliente"=>$id_cliente, "equipamentos_sac_clientes_equipamento"=>$ve));
	        }
        }
        
        $equipCliente = $equipamento->selectEquipamentosClienteEquipamentosDesc($id_cliente);
        $listaEquipamentos = null;
        
        
        $i = 0;
        foreach ($equipCliente as $eq){
        	foreach ($eq as $k=>$e)
        		$listaEquipamentos[$i] = $e;
        	$i++;
        	        	
        }
        
        $listaEquipamentos['id'] = $id_cliente;
        
        if (!empty($Dados['id']) && empty($TOTAL))
        	Funcoes::gerarLogCadastro($logs, "Cadastro Equipamento", $Dados, 1, null, $textos);
        else
        	Funcoes::gerarLogAlteracao($logs, "Edição Equipamento", $Dados, $anterior, 1, null, null, $textos);
        
        if(!empty($verificados) || (sizeof($equipCliente) != sizeof($verificados)))
        	Funcoes::gerarLogCadastro($logs, "Alteração  Lista Equipamentos Instalados", $listaEquipamentos, 1);
        	

        header("Location: ../../../../index.php?pg=10&id={$id_cliente}&id_veiculo={$id_veiculo}&acao=ListarCliente#veiculos");
        break;
    /*
     * ***************************************
     * ********* INSERT ou update OS *********
     * ***************************************
     */
    case "InsertOs" :

        if (empty($Dados['veiculos_os_id'])) {
            $protocolo = date("Y") . $Dados ['veiculos_os_id_cliente'] . date("mdHis");
            $Dados['veiculos_os_protocolo'] = $protocolo;
        }

        $anterior = !empty($Dados['veiculos_os_id']) ? $veiculo->selectOSVeiculo($Dados['veiculos_os_id']) : null;

        $arrDados = explode('_', $Dados ['placa']);
        $Dados ['placa'] = (!empty($arrDados [0]) ? $arrDados [0] : $Dados ['placa']);
        $Dados ['veiculos_os_id_veiculo'] = (!empty($arrDados [1]) ? $arrDados [1] : $Dados ['veiculos_os_id_veiculo']);
        $Dados ['veiculos_os_id_cliente'] = $Dados['veiculos_os_id_cliente'];
        $veiculos_os_id_cliente = $Dados ['veiculos_os_id_cliente'];


        $placa = $Dados ['placa'];
        unset($Dados ['placa']);

        $TOTAL = empty($Dados['veiculos_os_id']);
        
        if (empty($Dados['veiculos_os_id']))
            $Dados['veiculos_os_id'] = $veiculo->insertOS($Dados);
        else
            $veiculo->updateOS($Dados);

        $Dados ['placa'] = $placa;
        $Dados['id'] = $Dados ['veiculos_os_id_cliente'];

        unset($Dados ['veiculos_os_id_cliente'], $Dados['veiculos_os_id_veiculo'], $Dados['veiculos_os_id']);
        
        //status os
        if (isset($Dados['veiculos_os_status'])) {
        	switch ($Dados['veiculos_os_status']) {
        		case 1:
        			$textos['veiculos_os_status'] = "Aberto";
        			break;
        		case 2:
        			$textos['veiculos_os_status'] = "Finalizado";
        			break;
        		case 3:
        			$textos['veiculos_os_status'] = "Em Andamento";
        			break;
        	}
        }
        
        //tipo os
        if (isset($Dados['veiculos_os_tipo'])) {
        	switch ($Dados['veiculos_os_tipo']) {
        		case 1:
        			$textos['veiculos_os_tipo'] = "Manutenção";
        			break;
        		case 2:
        			$textos['veiculos_os_tipo'] = "Instalação";
        			break;
        		case 3:
        			$textos['veiculos_os_tipo'] = "Reclamação";
        			break;
        	}
        }
        
        //gravidade os
        if (isset($Dados['veiculos_os_gravidade'])) {
        	switch ($Dados['veiculos_os_gravidade']) {
        		case 1:
        			$textos['veiculos_os_gravidade'] = "Baixa";
        			break;
        		case 2:
        			$textos['veiculos_os_gravidade'] = "Média";
        			break;
        		case 3:
        			$textos['veiculos_os_gravidade'] = "Alta";
        			break;
        	}
        }
        
        //credenciado
        if (!empty($Dados['veiculos_os_id_credenciado'])) {
        	$credenciado = new Credenciados;
        	$credenciado->select($Dados['veiculos_os_id_credenciado']);
        	$textos['veiculos_os_id_credenciado'] = $credenciado->get("credenciado_razao_social") . ".Cód({$Dados['veiculos_os_id_credenciado']})";
        }

        if (!empty($Dados['id']) && $TOTAL)
        	Funcoes::gerarLogCadastro($logs, "Cadastro Os", $Dados, 1, null, $textos);
        else
        	Funcoes::gerarLogAlteracao($logs, "Edição Os", $Dados, $anterior, 1, array("veiculos_os_status", "veiculos_os_tipo", "veiculos_os_gravidade"), null, $textos);
        
        header("Location: ../../../../index.php?pg=10&id={$veiculos_os_id_cliente}&acao=ListarCliente#os");
        break;

    /*
     * ***************************************
     * ********* CADASTRA LOGIN **************
     * ***************************************
     */

    case "cadastrarLogin":
        $result = $cliente->insertLogin($Dados);

        $Dados['id'] = $Dados['id_cliente'];

        $id_cliente = $Dados['id_cliente'];

        unset($Dados['id_cliente']);

        if (!empty($result))
        	Funcoes::gerarLogCadastro($logs, "Cadastro Login", $Dados, 1);

        header("Location: ../../../../index.php?pg=10&id={$id_cliente}&acao=ListarCliente#cliente");
        break;


    /*
     * ***************************************
     * ********* EXCLUIR LOGIN ***************
     * ***************************************
     */

    case "excluirLogin":
        $id = filter_input(INPUT_GET, "id");
        $id_cliente = filter_input(INPUT_GET, "id_cliente");

        $login = $cliente->selectLogin($id);

        $cliente->deleteLogin($id);

        $login['id'] = $login['id_cliente'];

        unset($login['id_cliente']);

        Funcoes::gerarLogCadastro($logs, "Exclusão Login", $login, 1);
        
        header("Location: ../../../../index.php?pg=10&id={$id_cliente}&acao=ListarCliente#cliente");
        break;

    /*
     * ***************************************
     * ********* SALVAR CREDENCIADO **********
     * ***************************************
     */

    case "salvarCredenciado":
        $Dados["credenciado_instalacao"] = !empty($Dados['credenciado_instalacao']) ? Funcoes::converterParaDouble($Dados['credenciado_instalacao']) : "";
        $Dados["credenciado_manutencao"] = !empty($Dados['credenciado_manutencao']) ? Funcoes::converterParaDouble($Dados['credenciado_manutencao']) : "";
        $Dados["credenciado_km"] = !empty($Dados['credenciado_km']) ? Funcoes::converterParaDouble($Dados['credenciado_km']) : "";
        $Dados['credenciado_data_cadastro'] = !empty($Dados['credenciado_data_cadastro']) ? Funcoes::FormatadataSql($Dados['credenciado_data_cadastro']) : "";

        $anterior = !empty($Dados["credenciado_id"]) ? $credenciado->selectArray($Dados['credenciado_id']) : null;

        $TOTAL = empty($Dados["credenciado_id"]);
        
        if (empty($Dados["credenciado_id"]))
            $Dados['credenciado_id'] = $credenciado->insert($Dados);
        else
            $credenciado->atualizar($Dados);

        $id = !empty($Dados['credenciado_id']) ? "&acao=listarCredenciado&id={$Dados['credenciado_id']}" : null;

        $Dados['id'] = $Dados['credenciado_id'];

        unset($Dados['credenciado_tipo_pessoa'], $Dados['credenciado_id'], $Dados['credenciado_data_cadastro']);
        
        //status credenciado
        if (!empty($Dados['credenciado_status'])) {
        	switch ($Dados['credenciado_status']) {
        		case 1:
        			$textos['credenciado_status'] = "Ativo";
        			break;
        		case 2:
        			$textos['credenciado_status'] = "Inativo";
        			break;
        	}
        }
        
        //deslocamento
        if (isset($Dados['credenciado_deslocamento'])) {
        	switch ($Dados['credenciado_deslocamento']) {
        		case 1:
        			$textos['credenciado_deslocamento'] = "Sim";
        			break;
        		case 2:
        			$textos['credenciado_deslocamento'] = "Não";
        			break;
        	}
        }
        
        if (!empty($Dados['id']) && $TOTAL)
        	Funcoes::gerarLogCadastro($logs, "Cadastro Credenciado", $Dados, 2, $campos, $textos);
        else
        	Funcoes::gerarLogAlteracao($logs, "Edição Credenciado", $Dados, $anterior, 2, array("credenciado_status"), $campos, $textos);

        header("Location: ../../../../index.php?pg=38{$id}&result=1#cadastrarCredenciado");
        break;


    case "trocarVeiculo":
        $anterior = $veiculo->select($Dados['veiculo_id_antigo']);
        $observacoes_troca = $anterior['observacoes']."\n".$Dados['observacoes_troca'];
        $veiculo->updateVeiculo(array("id_veiculo" => $Dados['veiculo_id_antigo'], "veiculo_status" => 2, "observacoes"=>$observacoes_troca));
        
        unset($Dados['observacoes_troca']);
        
        $id_cliente = $anterior['cliente_ra'];
        $id_veiculo = $Dados['veiculo_id_antigo'];
        
        $Dados['tipo_cadastro'] = 'interno';
        $Dados['cliente_ra'] = $id_cliente;
        
        $Dados['id_veiculo'] = $veiculo->insert($Dados);
        
        $Dados['id'] =  $anterior['cliente_ra'];
        
        unset(
        		$anterior['id_veiculo'], 
        		$anterior['id_cliente'], 
        		$anterior['cliente_ra'], 
        		$anterior['veiculo_status'], 
        		$anterior['obs'], 
        		$anterior['equipamento'], 
        		$anterior['taxa_instalacao'], 
        		$anterior['taxa_monitoramento'],
        		$anterior['valor_equipamento'],
        		$anterior['seguro']);
        
        $antigo = null;
        
        $antigo['motivo_troca'] = $observacoes_troca;
        
        foreach ($anterior as $k=>$as){
        	$antigo[$k."_antigo"] = $as;
        }
        
        $DadosTroca = array_merge(array("\nAnterior"=>""), $antigo, array("\nNovo"=>""),$Dados);
        
        Funcoes::gerarLogCadastro($logs, "Troca de Veículo", $DadosTroca, 1);
        
        header("Location: ../../../../index.php?pg=10&id={$id_cliente}&acao=ListarCliente#veiculos");
        
        break;
        
    case "cadastrarEquipamentos":
    	$result = $equipamento->insert("equipamentos_sac", $Dados);
    	die(json_encode(array("result"=>$result)));
    	break;
    	
    case "excluirEquipamento":
    	
    	$id = filter_input(INPUT_POST, "id");
    	
    	$result = $equipamento->verificaEquipamentoCliente($id);
    	
    	if(empty($result)) {
    		$equipamento->deletarEquipamento($id);
    		$result = 1;
    	} else {
    		$result = 0;
    	}
    	
    	die(json_encode(array("result"=>$result)));
    	
    	break;
    	
    
    case "pegarModuloChip":
    	$id = filter_input(INPUT_POST, "id");
    	$chip->select($id);
    	die(json_encode(array("result"=>$chip->get("modulo_serial"))));
    	break;
    	
    case "cadastrarVeiculo":
    	$veiculo->insert($Dados);
    	$Dados['id'] = $Dados['cliente_ra'];
    	Funcoes::gerarLogCadastro($logs, "Cadastro de Veículo", $Dados, 1);
    	header("Location: ../../../../index.php?pg=10&id={$Dados['cliente_ra']}&acao=ListarCliente#veiculos");
    	break;
    	
    case "editarVeiculo":
    	$anterior = $veiculo->selectVeiculo($Dados['id_veiculo']);
    	$veiculo->updateVeiculo($Dados);
    	$Dados['id'] = $anterior['cliente_ra'];
    	Funcoes::gerarLogAlteracao($logs, "Edição Veículo", $Dados, $anterior, 1);
    	header("Location: ../../../../index.php?pg=10&id={$anterior['cliente_ra']}&id_veiculo={$anterior['id_veiculo']}&acao=ListarCliente#veiculos");
    	break;
    	
    case "verificarCPFCNPJ":
    	$cliente->verificarCliente($Dados['cpf_cnpj']);
    	$total = $cliente->Read()->getRowCount();
    	die(json_encode(array("result"=>$total)));
    	break;
    	
    case "trocarStatusVeiculo":
    	$anterior = $veiculo->selectVeiculo($Dados['id_veiculo']);
    	$observacoes_troca = $anterior['observacoes']."\n".$Dados['observacoes_troca'];
    	$troca = array("id_veiculo"=>$Dados['id_veiculo'], "veiculo_status"=>$Dados['status'], "observacoes"=>$observacoes_troca);
    	$veiculo->updateVeiculo($troca);
    	$status = $Dados['status'] == 1 ? "Ativo" : "Inativo";
    	$troca['id'] = $anterior['cliente_ra'];
    	Funcoes::gerarLogCadastro($logs, "Troca Status Veículo", $troca, 1,null,array("veiculo_status"=>$status));
    	header("Location: ../../../../index.php?pg=10&id={$anterior['cliente_ra']}&acao=ListarCliente#veiculos");
    	break;
    	
    case "excluirVeiculo":
    	$anterior = $veiculo->select($Dados['id']);
    	$veiculo->selecionarOsPorVeiculo($Dados['id']);
    	$result = 0;
    	if($veiculo->Read()->getRowCount() == 0){
    		$veiculo->deleteVeiculo($Dados['id']);
    		$result = 1;
    		$anterior['id'] = $anterior['cliente_ra'];
    		Funcoes::gerarLogCadastro($logs, "Exclusão Veículo", $anterior, 1);
    	}
    	die(json_encode(array("result"=>$result)));
    	break;
endswitch;



