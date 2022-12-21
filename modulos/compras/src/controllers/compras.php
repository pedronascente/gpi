<?php


header('Content-Type: text/html; charset=utf-8');
include_once ("../../../../Config.inc.php");

$Dados = isset($_POST['acao']) ? filter_input_array(INPUT_POST) : filter_input_array(INPUT_GET);

$acao = isset($Dados ['acao']) ? $Dados ['acao'] : $_GET['acao'];
unset($Dados ['acao']);

$id = filter_input(INPUT_GET, "id");

$modulo = new Modulo;
$chip = new Chip;
$logs = new Log;
$veiculo = new Veiculos;
$cliente = new Clientes;
$produtos = new Produtos;

switch ($acao) {

    /*
     * ********************************
     * ********* SALVAR MÓDULO ********
     * ********************************
     */


    case 'salvarModulo':

        if (!empty($Dados['modulo_id']))
            $modulo->atualizar($Dados);
        else
            $Dados['modulo_id'] = $modulo->insert($Dados);

        header("Location:../../../../index.php?pg=46&result=1&id={$Dados['modulo_id']}#cadastroModulos");
        break;


    /*
     * ********************************
     * ********* EXCLUIR MÓDULO *******
     * ********************************
     */

    case "deleteModulo":
        $modulo->deleteModulo($id);
        header("Location:../../../../index.php?pg=46");
        break;

    /*
     * ********************************
     * ********* SALVAR CHIP **********
     * ********************************
     */


    case "salvarChip":

        $anterior = !empty($Dados["chip_id"]) ? $chip->selectArray($Dados["chip_id"]) : null;

        $TOTAL = empty($Dados["chip_id"]);

        if (empty($Dados["chip_id"]))
            $Dados['chip_id'] = $chip->insert($Dados);
        else
            $chip->atualizar($Dados);

        $id = $Dados["chip_id"];

        $Dados['id'] = $Dados['chip_id'];

        unset($Dados['chip_id'], $Dados['chip_data_criacao']);

        header("Location: ../../../../index.php?pg=46&id_chip={$id}&result=1#cadastrarChips");
        break;

    /*
     * ******************************
     * ********* EXCLUIR CHIP *******
     * ******************************
     */

    case "deleteChip":
        $chip->deleteChip($id);
        header("Location:../../../../index.php?pg=46");
        break;

    /*
     * **********************************************
     * ********* SELECIONA OS DADOS DO MÒDULO *******
     * *********************************************
     */

    case "selecionarModulo":
    	$status = filter_input(INPUT_POST, "status");
        $dados = $modulo->selectArrayModulo($Dados['modulo'], $status);
        unset($dados['modulo_status']);
        die(json_encode($dados));
        break;

    /*
     * **********************************************
     * ********* SELECIONA OS DADOS DO CHIP *********
     * *********************************************
     */
    case "selecionarChip":
    	$status = filter_input(INPUT_POST, "status");
        $dados = $chip->selectArrayChip($Dados['chip'], $status);
        if(!empty($dados))
       	 $dados['chip_pim'] = !empty($dados['chip_linha']) ? substr($dados['chip_linha'], -4) : "";
        unset($dados['chip_status']);
        die(json_encode($dados));
        break;

    /*
     * **********************************************
     * ********* FAZ A PROGRAMAÇÃO DO CHIP **********
     * **********************************************
     */

    case "programarChip":
    	
        if (!empty($Dados['chip_id']))
            $chip->select($Dados['chip_id']);

        $chip->atualizar($Dados);

        if ($chip->get("chip_modulo") != $Dados['chip_modulo'] && $chip->get("chip_modulo") != NULL)
            $modulo->atualizar(array("modulo_id" => $chip->get("chip_modulo"), "modulo_status" => 1));

        $modulo->atualizar(array("modulo_id" => $Dados['chip_modulo'], "modulo_status" => 3));

        $Dados = array_merge($chip->selectArray($Dados['chip_id']), $Dados);

        if (!empty($Dados['modulo_id']))
            $Dados = array_merge($modulo->selectArray($Dados['modulo_id']));

        $Dados['id'] = $Dados['chip_id'];

        if ($Dados['chip_status'] == 3)
            Funcoes::gerarLogCadastro(new Log, "Programação Chip", $Dados, 3);

        header("Location:../../../../index.php?pg=46&id_programacao={$Dados['chip_id']}#programacao");
        break;


    /*
     * *****************************************************
     * ********* SELECIONA OS VEÍCULOS DO CLIENTE **********
     * *****************************************************
     */

    case "selecionaVeiculosCliente":
        $veiculos = $veiculo->selectVeiculosPorCliente($Dados['id']);
        die(json_encode(array("result" => $veiculos)));
        break;

    /*
     * **********************************************
     * ********* VINCULA O VEÍCULO AO CHIP **********
     * **********************************************
     */

    case "vincularCliente":


        $id_cliente = $Dados['id_cliente'];

        unset($Dados['id_cliente']);

        //VERIFICA SE O CLIENTE JÁ TEM UM EQUIPAMENTO CADASTRO NESSE VEÍCULO
        $veiculo->selectEquipamentos($Dados['veiculos_equipamentos_id_veiculo']);

        //VERIFICA SE O CHIP JÁ FOI ATRIBUÍDO A ALGUM CLIENTE
        $validarChip = $chip->validarChip($Dados['chip_id']);
        
        //LIMPA O CHIP EQUIPAMENTO DO VEÍCULO ATRIBUIDO ANTERIORMENTE
        if (!empty($validarChip))
            $veiculo->updateEquipamento(array("veiculos_equipamentos_id" => $validarChip['veiculos_equipamentos_id'], "veiculos_equipamentos_id_chip" => "0", "veiculos_equipamentos_id_veiculo" => $validarChip['veiculos_equipamentos_id_veiculo']));

        $Dados['veiculos_equipamentos_id_chip'] = $Dados['chip_id'];

        unset($Dados['chip_id'], $Dados['chip_modulo']);

        $TOTAL = $veiculo->Read()->getRowCount();

        if (empty($TOTAL))
            $Dados ['veiculos_equipamentos_id'] = $veiculo->insertEquipamento($Dados);
        else
            $veiculo->updateEquipamento($Dados);

    
        
        if (!empty($validarChip))
            $Dados['anterior'] = $veiculo->select($validarChip['veiculos_equipamentos_id_veiculo'])['placa'];

        $Dados['placa'] = $veiculo->select($Dados['veiculos_equipamentos_id_veiculo'])['placa'];
        $Dados['cliente'] = $cliente->select($id_cliente)['nome_cliente'] . "/" . $cliente->select($id_cliente)['cnpjcpf_cliente'];
        
        

        $Dados = array_merge($Dados, $chip->selectArray($Dados['veiculos_equipamentos_id_chip']));
        
        $chip->atualizar(array("chip_id"=>$Dados['veiculos_equipamentos_id_chip'], "chip_status"=>5));

        $Dados['id'] = $id_cliente;

        Funcoes::gerarLogCadastro(new Log, "Vincular Cliente ao Chip", $Dados, 3);

        $Dados['id'] = $Dados['veiculos_equipamentos_id_chip'];

        Funcoes::gerarLogCadastro(new Log, "Vincular Cliente ao Chip", $Dados, 3);
        
        header("Location:../../../../index.php?pg=46&id_programacao={$Dados['veiculos_equipamentos_id_chip']}#programacao");
        break;

    /*
     * **********************************************
     * ********* DESVINCULA O CHIP DO MÓDULO ********
     * **********************************************
     */
    case "desvincular":
        $chip->atualizar(array("chip_id" => $Dados['id_chip'], "chip_modulo" => "0", "chip_status" => 1));
        if (!empty($Dados['id_modulo']))
            $modulo->atualizar(array("modulo_id" => $Dados['id_modulo'], "modulo_status" => 1));
        header("Location:../../../../index.php?pg=46");
        break;


    /*
     * ***********************************************************
     * ********* MUDA O STATUS DO MÒDULO PARA COM DEFEITO ********
     * ***********************************************************
     */
    case "statusDefeito":
        $chip->atualizar(array("chip_id" => $Dados['id_chip'], "chip_modulo" => "0", "chip_status" => 1));
        if (!empty($Dados['id_modulo']))
            $modulo->atualizar(array("modulo_id" => $Dados['id_modulo'], "modulo_status" => 2, "modulo_obs_defeito"=>$Dados['modulo_obs_defeito']));
        header("Location:../../../../index.php?pg=46");
        break;


    /*
     * *****************************************
     * ********* ADICIONA UMA CATEGORIA ********
     * *****************************************
     */

    case "adicionarCategoria":
        $id = $produtos->insertCategoria($Dados);
        die(json_encode(array("id" => $id)));
        break;

    /*
     * ***************************************
     * ********* ADICIONA UMA UNIDADE ********
     * ***************************************
     */

    case "adicionarUnidade":
        $id = $produtos->insertUnidade($Dados);
        die(json_encode(array("id" => $id)));
        break;


    /*
     * *********************************
     * ********* SALVAR PRODUTO ********
     * *********************************
     */
    case "salvarProduto":

        $Dados['produto_data_cadastro'] = !empty($Dados['produto_data_cadastro']) ? Funcoes::formataDataComHoraSQL($Dados['produto_data_cadastro']) : "";
        $Dados['produto_estoque_min'] = !empty($Dados['produto_estoque_min']) ? Funcoes::formataMoedaSql($Dados['produto_estoque_min']) : 0;

        if (!empty($Dados['produto_id']))
            $produtos->atualizar($Dados);
        else
            $Dados['produto_id'] = $produtos->insert($Dados);

        header("Location:../../../../index.php?pg=47&id={$Dados['produto_id']}");
        break;

    /*
     * ************************************
     * ********* SALVAR REQUISIÇÃO ********
     * ************************************
     */
    case "salvarRequisicao":
        $Dados['produto_requisicao_data'] = !empty($Dados['produto_requisicao_data']) ? Funcoes::FormatadataSql($Dados['produto_requisicao_data']) : "";
        $Dados['produto_requisicao_data_criacao'] = !empty($Dados['produto_requisicao_data_criacao']) ? Funcoes::formataDataComHoraSQL($Dados['produto_requisicao_data_criacao']) : "";
        $Dados['produto_requisicao_quantidade'] = !empty($Dados['produto_requisicao_quantidade']) ? Funcoes::formataMoedaSql($Dados['produto_requisicao_quantidade']) : 0;
        $Dados['produto_requisicao_setor'] = !isset($Dados['produto_requisicao_setor']) ? $Dados['setorUsuario'] : $Dados['produto_requisicao_setor'];

        unset($Dados['setorUsuario']);

        $Dados['produto_requisicao_id'] = $produtos->insertRequisicao($Dados);


        if ($Dados['produto_requisicao_tipo'] == "saida")
            $produtos->atualizarQuantidade($Dados['produto_requisicao_produto'], $Dados['produto_requisicao_quantidade'], "-");
        else
            $produtos->atualizarQuantidade($Dados['produto_requisicao_produto'], $Dados['produto_requisicao_quantidade'], "+");

        header("Location:../../../../index.php?pg=47#requisicao");
        break;

    /*
     * *************************************
     * ********* DELETAR REQUISIÇÃO ********
     * *************************************
     */
    case "deletarRequisicao":
        $id = filter_input(INPUT_GET, "id");
        $produtos->selectRequisicao($id);
        $produtos->deleteRequisicao($id);
        $operacao = $produtos->get("produto_requisicao_tipo", true) == "entrada" ? "-" : "+";
        $produtos->atualizarQuantidade($produtos->get("produto_requisicao_produto"), $produtos->get("produto_requisicao_quantidade", true), $operacao);
        header("Location:../../../../index.php?pg=47#requisicao");
        break;

    /*
     * ***************************************************
     * ********* PEGA A QUANTIDA ATUAL DO PRODUTO ********
     * ***************************************************
     */
    case "pegarQuantidadeProduto":
        $id = filter_input(INPUT_POST, "id");
        $produtos->selectDadosProduto($id);
        die(json_encode(array("quantidade" => $produtos->get("produto_quantidade"), "minimo" => $produtos->get("produto_estoque_min", true), "unidade" => $produtos->get("produto_unidade_desc"))));
        break;

    /*
     * ***************************************************
     * ********* LISTA OS PRODUTOS DA REQUISIÇÃO *********
     * ***************************************************
     */
    case "pegarProdutosRequisicao":
        $tipo = filter_input(INPUT_POST, "tipo");
        $listaProdutos = $produtos->selectProdutosDisponiveis($tipo);
        die(json_encode($listaProdutos));
        break;
}