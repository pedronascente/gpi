<?php

//namespace C:\wamp\www\gpi\modulos\captacao\src\controllers\captacao.php
include_once ("../../../../Config.inc.php");
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$Dados = filter_input_array(INPUT_POST);
unset($Dados ['x'], $Dados ['y']);
if (empty($Dados)) {
    $Dados = filter_input_array(INPUT_GET);
}
if (!empty($Dados) && isset($Dados)) {
    $acao = $Dados ['acao'];
    $id = !empty($Dados ['id_cliente']) ? $Dados ['id_cliente'] : '';
    $idVeiculo = filter_input(INPUT_GET, 'idVeiculo', FILTER_VALIDATE_INT);
    $id_contrato_antigo = filter_input(INPUT_GET, 'id_cliente_contrato', FILTER_VALIDATE_INT);
    unset($Dados['acao']);
}
$captacao = new Captacao;
$contrato = new Contratos;
$cliente = new Clientes;
$usuario = new Usuarios;
$veiculo = new Veiculos;
$anexos = new Anexos;
$regiao = new Regiao;
$sms = new Sms;
$funcoes = new Funcoes;
$pcf = new PedidoComissaoFuncionario;
$pc = new PedidoComissao;
$planilhaCommissoes = new PlanilhaComissoes;
$forma_pagamento = new FormaDePagamento;
$phpmailer = new PHPMailer;
$logs = new Log;
if (empty($acao)) {
    header("Location:../../../../index.php");
}

/*
 * ..............................................
 * CONSULTA SPC / SERASA :  
 * Atencao : é aqui que é realizado o cadastro do novo cliente 
 * .............................................
 */
switch ($acao) :

    case "consultaSPCSERASA" :
        $tipoFrm = $Dados ['tipoFrm'];
        $AprovarReprovar = isset($Dados ['radioApRp']) ? $Dados ['radioApRp'] : null;
        $redirect = $Dados ['redirect'];
        $id_captacao = !empty($_POST["id_captacao"]) ? $_POST["id_captacao"] : 0;
        $header = ($redirect == 'redirect') ? "Location: ../../../../index.php?pg=12&redirect=on&id=" . $id_captacao : "Location: ../../../index.php?pg=12";
        $motivo_reprovacao = isset($Dados['motivo_reprovacao_cliente']) ? $Dados['motivo_reprovacao_cliente'] : null;
        unset($Dados['motivo_reprovacao_cliente'], $Dados['id_captacao']);
        unset($Dados['tipoFrm'], $Dados['radioApRp'], $Dados['redirect']);
        $Dados['id_status'] = 1;
        if ($AprovarReprovar == "aprovado") {
            $Dados['id_status'] = 2;
            $retorno = 'aprovado';
        } elseif ($AprovarReprovar == "reprovado") {
            $Dados['id_status'] = 3;
            $retorno = 'reprovado';
        }
        date_default_timezone_set('America/Sao_Paulo');
        $Dados['data_solicitacao_cliente'] = date("Y-m-d H:i:s");
        $Dados['motivo_reprovacao_cliente'] = $motivo_reprovacao;
        $Dados['id_captacao'] = $id_captacao;
        $Dados['forma_pagamento'] = "";
        $Dados['email_cliente'] = "";
        $Dados['logradouro_cliente'] = "";
        $Dados['bairro_cliente'] = "";
        $Dados['cidade_cliente'] = "";
        $Dados['uf_cliente'] = "";
        $Dados['cep_cliente'] = "";
        $Dados['data_pagamento'] = "";
        //VERIFICA SE EXISTE CPF JÁ CADASTRADO:
        if ($cliente->ja_e_cliente($Dados['cnpjcpf_cliente'])) {
            $Dados['ja_e_cliente'] = "Sim";
        } else {
            $Dados['ja_e_cliente'] = "NÃO";
        }
        //PERSISTE DADOS NA TABELA (clientes) :
        $retornoInsert = $cliente->insert("clientes", $Dados);
        if ($tipoFrm == 'aprovar') :
            switch ($retorno) :
                case 'aprovado': echo '  <script type="text/javascript">  alert("Cliente Aprovado com sucesso!"); location.href="../../../../index.php?pg=12&acao=ex";  </script>';
                    break;
                case 'reprovado': echo ' <script type="text/javascript">  alert("Cliente Reprovado com sucesso!");location.href="../../../../index.php?pg=12&acao=ex"; </script>';
                    break;
            endswitch;
        else:
            header($header);
        endif;
        break;


    // BUSCA CPF/CNPJ CLIENTE:
    case "buscarCPF":
        $cpf = $cliente->buscarCPF($Dados['cpf']);
        $cliente = isset($cpf['id_cliente']) ? $cpf['id_cliente'] . "_" . $cpf['nome_cliente'] : 0;
        echo $cliente;
        break;

    // APROVA CONSULTA SPC / SERASA:
    case "AprovarConsulta" :
        $cliente->updateCliente("clientes", $Dados);
        header("Location: ../../../../index.php?pg=14");
        break;

    // REPROVA CONSULTA SPC / SERASA:
    case "reprovaConsulta" :
        $Dados ['id_status'] = 3;
        $cliente->updateCliente("clientes", $Dados);
        header("Location: ../../../../index.php?pg=14");
        break;

    // DELETE CONSULTA SPC / SERASA:
    case "deletarConsulta" :
        $id = $Dados['id_cliente'];
        $result = $cliente->verificarContratosClientes($id);
        if (empty($result)) {
            $cliente->deleteCliente("clientes", $id);
            $cliente->deleteEnderecoCobranca("cliente_endereco_cobranca", $id);
        }
        $anexosClientes = $anexos->selectAnexosClientes($Dados['id_cliente_contrato']);
        foreach ($anexosClientes as $a) {
            if (file_exists("anexos/clientes/{$a['nome_anexo']}")) {
                unlink("anexos/clientes/{$a['nome_anexo']}");
            }
            $anexos->deleteAnexos($a['id_anexo']);
        }
        $cliente->deleteCliente("clientes", $Dados['id_cliente_contrato']);
        //delete contrato do cliente
        $veiculo->deleteVeiculoPorContrato($Dados['id_cliente_contrato']);
        header("Location: ../../../../index.php?pg=12");
        break;

    //RESPONSAVEL POR CADASTRAR DE CLIENTE NA BD :
    case "cadastroCliente" :
        $id_cliente = $Dados['CLIENTE']['id_cliente'];
        $statusCadastro = $Dados['CLIENTE']['status_cadastro']; // se status = 0 -> novo cliente  // se status = 1 -> cliente ja cadastrado.    

        if (isset($Dados ['cod_municipio'])) {
            $Dados ['cod_municipio'] = preg_replace("/[^0-9]/", "", $Dados['CLIENTE']['cod_municipio']);
        }
        //UPDATE FORMA DE PAGAMENTO:
        if (isset($Dados['FORMADEPAGAMENTO'])) {
            for ($i = 0; $i < count($Dados ['FORMADEPAGAMENTO']); $i++) {
                $Dados['FORMADEPAGAMENTO'][$i]['id_cliente'] = $Dados['id_cliente'];
                $forma_pagamento->updateFormaDePagamento($Dados ['FORMADEPAGAMENTO'][$i]);
            }
        }
        if ($statusCadastro != 2) {
            $Dados['CLIENTE']['status_cadastro'] = 1;
        }

        //CLIENTE:
        $cliente->updateCliente("clientes", $Dados['CLIENTE']);

        for ($i = 0; $i <= 1; $i++) {
            $Dados['ENDERECO'][$i]['id_cliente'] = $Dados['CLIENTE']['id_cliente'];
        }
        //ENDEREÇO :
        $cliente->updateEndereco('endereco_cobranca', $Dados['ENDERECO']);
        //CONTATO:
        if (!isset($Dados['CONTATO'][1]['nome_contato']) && !isset($Dados['CONTATO'][1]['email_contato']) && !isset($Dados['CONTATO'][1]['telefone1_contato']) && !isset($Dados['CONTATO'][1]['telefone2_contato'])) {
            unset($Dados['CONTATO'][1]);
        }
        $cliente->selecContatoCliente("contato_cliente", $Dados['CLIENTE']['id_cliente']);
        $total = $cliente->Read()->getRowCount();
        if ($total >= 1):
            $cliente->updateContatoCliente('contato_cliente', $Dados['CONTATO']);
        else :
            $cliente->insertContatoCliente("contato_cliente", $Dados['CONTATO']);
        endif;
        header("Location:../../../../index.php?pg=15&id=" . $Dados['id'] . "&id_cliente_contrato=" . $id_cliente);
        break;
    //INSERT VEICULOS :
    case "InsertVeiculo" :
        $id = !empty($Dados['id']) ? $Dados['id'] : $Dados['id_cliente'];
        isset($Dados ['taxa_instalacao']) ? $Dados ['taxa_instalacao'] = Funcoes::formataMoedaSql($Dados ['taxa_instalacao']) : null;
        isset($Dados ['taxa_monitoramento']) ? $Dados ['taxa_monitoramento'] = Funcoes::formataMoedaSql($Dados ['taxa_monitoramento']) : null;
        isset($Dados ['valor_equipamento']) ? $Dados ['valor_equipamento'] = Funcoes::formataMoedaSql($Dados ['valor_equipamento']) : null;
        isset($Dados ['valor_protecao']) ? $Dados ['valor_protecao'] = Funcoes::formataMoedaSql($Dados ['valor_protecao']) : null;
        isset($Dados ['valor_protecao_assistencial']) ? $Dados ['valor_protecao_assistencial'] = Funcoes::formataMoedaSql($Dados ['valor_protecao_assistencial']) : null;
        isset($Dados ['placa']) ? $Dados ['placa'] = strtoupper($Dados ['placa']) : "";
        $Dados ['cliente_ra'] = $Dados['id'];
        if ($Dados['tipo_seguro'] == 'null') {
            unset($Dados['tipo_seguro']);
        }
        unset($Dados['id']);
        // registra os veiculos :
        $ultimoId = $veiculo->insert($Dados);
        header("Location: ../../../../index.php?pg=15&id={$id}&tipoCadastro=VENDA&id_cliente_contrato={$Dados['id_cliente']}#veiculos");
        break;

    // UPDATE VEICULOS :
    case "EditarVeiculo" :
        $id_veiculo = $Dados ['id_veiculo'];
        isset($Dados ['taxa_instalacao']) ? $Dados ['taxa_instalacao'] = Funcoes::formataMoedaSql($Dados ['taxa_instalacao']) : null;
        isset($Dados ['taxa_monitoramento']) ? $Dados ['taxa_monitoramento'] = Funcoes::formataMoedaSql($Dados ['taxa_monitoramento']) : null;
        isset($Dados ['valor_equipamento']) ? $Dados ['valor_equipamento'] = Funcoes::formataMoedaSql($Dados ['valor_equipamento']) : null;
        isset($Dados ['valor_protecao']) ? $Dados ['valor_protecao'] = Funcoes::formataMoedaSql($Dados ['valor_protecao']) : null;
        isset($Dados ['valor_protecao_assistencial']) ? $Dados ['valor_protecao_assistencial'] = Funcoes::formataMoedaSql($Dados ['valor_protecao_assistencial']) : null;
        isset($Dados ['placa']) ? $Dados ['placa'] = strtoupper($Dados ['placa']) : "";
        $PlanoAssistencil ['tags_planoAssistencia'] = !empty($Dados ['tags_planoAssistencia']) ? $Dados ['tags_planoAssistencia'] : '';
        $id = $Dados['id_cliente'];
        if ($PlanoAssistencil ['tags_planoAssistencia'] == "s") {
            $PlanoAssistencil ['status_planoAssistencia'] = "SIM";
        } else if ($PlanoAssistencil ['tags_planoAssistencia'] == "n") {
            $PlanoAssistencil ['status_planoAssistencia'] = "NÃO";
        } else {
            $PlanoAssistencil ['status_planoAssistencia'] = 'Isento';
        }
        if ($Dados['tipo_seguro'] == 'null') {
            unset($Dados['tipo_seguro']);
        }
        unset($Dados ['tags_planoAssistencia'], $Dados ['valor'], $Dados['id_cliente']);
        $veiculo->updateVeiculo($Dados);
        header("Location: ../../../../index.php?pg=15&id={$id}&id_cliente_contrato={$id}#veiculos");
        break;
    // DELETE VEICULO :
    case "DeleteVeiculo" :
        $veiculo->deleteVeiculo($idVeiculo);
        header("Location: ../../../../index.php?pg=15&id=" . $id . "&id_cliente_contrato=" . $id_contrato_antigo . "#veiculos");
        break;

    //QUE BUSCA O CODIGO IBGE DO MUNICIPIO (invocado por js/funcoes.js) :
    case "consultarCodCidade" :
        $municipio = new Municipio ();
        $codigo = $municipio->consultarCodCidade($Dados ['cidade'], $Dados ['uf']);
        if (isset($codigo ['id'])) {
            $codigo = (int) $codigo ['id'];
        } else {
            $codigo = 0;
        }
        die(json_encode(array("cod" => $codigo)));
        break;

    // DELETE ENDERECO COBRANCA :    
    case "DeleteEnderecoCobranca" :
        $cliente->deleteEnderecoCobranca($id);
        die(json_encode(array(
            'type' => 'success'
        )));
        break;

    // DELETE CONTRATO:
    case "DeleteContrato" :
        $id_contrato = $Dados ['id_contrato'];
        $id = $Dados['id_cliente'];
        $result = $cliente->verificarContratosClientes($id, $id_contrato);
        if ($result < 1) {
            $cliente->deleteCliente("clientes", $id);
            $cliente->deleteEnderecoCobranca("cliente_endereco_cobranca", $id);
        }
        $anexosClientes = $anexos->selectAnexosClientes($Dados['id_cliente_contrato']);
        foreach ($anexosClientes as $a) {
            if (file_exists("anexos/clientes/{$a['nome_anexo']}"))
                unlink("anexos/clientes/{$a['nome_anexo']}");
            $anexos->deleteAnexos($a['id_anexo']);
        }
        $cliente->deleteCliente("clientes", $Dados['id_cliente_contrato']);
        //delete contrato do cliente
        $contrato->deleteContrato($id_contrato);
        // delete veiculos:
        $veiculo->deleteVeiculoPorContrato($id_contrato);
        header("Location:../../../../index.php?pg=15#settings");
        break;

    // REPROVA CONTRATO:
    case "reprovaContrato" :
        if (!empty($Dados['camposCliente'])) {
            foreach ($Dados['camposCliente'] as $cc) {
                $cliente->insertCamposContrato(
                        array(
                            "cr_campo" => $cc,
                            "cr_cliente" => $Dados['id_cliente']
                ));
            }
        }

        if (!empty($Dados['camposVeiculos'])) {
            foreach ($Dados['camposVeiculos'] as $cv) {
                $data = explode("_", $cv);
                $cliente->insertCamposContrato(
                        array(
                            "cr_campo" => $data[0],
                            "cr_cliente" => $Dados['id_cliente'],
                            "cr_veiculo" => $data[1]
                ));
            }
        }

        unset(
                $Dados['camposCliente'], $Dados['camposVeiculos']
        );

        $cont = $cliente->selectClienteEnderecoCobrancaContrato($Dados['id_cliente']);

        $cliente->updateStatusCadastro($Dados['id_cliente'], 2);

        $contrato->updateContratos($Dados);

        //Gravar Logs:
        $vendedor = $cont['vendedor'];

        unset(
                $cont['vendedor'], $cont['motivo_reprovacao'], $cont['id_status'], $cont['status_cadastro'], $cont['id_usuario'], $cont['tipo_cadastro'], $cont['idCliente'], $cont['data_cadastro_senha_segunaca'], $cont['cliente_ra'], $cont['cliente_edit'], $cont['cliente_ativo'], $cont['tipo_pessoa'], $cont['data_solicitacao_cliente'], $cont['motivo_reprovacao'], $cont['senha_seguranca'], $cont['contra_senha_seguranca'], $cont['vigencia'], $cont['id_endereco_cobranca'], $cont['id_contrato'], $cont['contato_cobranca'], $cont['cli_cod_municipio']
        );
        $cont = array(
            "motivo" => $Dados['observacoes_contrato'],
            "id" => $Dados['id_cliente'],
            "Vendedor" => $vendedor,
            " \nContrato" => "") + $cont;
        Funcoes::gerarLogCadastro($logs, "Contrato Reprovado", $cont, 6);
        //Redirecionar página:
        header("Location: ../../../../index.php?pg=17");
        break;
    // ADICIONAR  NIVEIS DE CAPTACAO :
    case "InsertNivelCaptacaoUsuario" :
        // VERIFICA SE O USUARIO  TEM ESTE NIVEL
        $regra ['id_usuario'] = $Dados ['captacao_niveis_usuarios_id_usuario'];
        $regra ['captacao_niveis_usuarios_captacao_niveis_id'] = $Dados ['captacao_niveis_usuarios_captacao_niveis_id'];
        if (isset($Dados ['captacao_niveis_usuarios_regra_id']) && !empty($Dados ['captacao_niveis_usuarios_regra_id']))
            $regra ['captacao_niveis_regra'] = $Dados ['captacao_niveis_usuarios_regra_id'];
        $totalNivel = $usuario->validarNivelCaptacao($regra);
        if (empty($totalNivel)) :
            // INSERE NIVEIS DE CAPTAO:
            if ($captacao->insertNiveisCaptacaoUsuario($Dados)) :
                //cadastra o log 
                $log['id'] = $Dados ['captacao_niveis_usuarios_id_usuario'];
                $log['usuario'] = $usuario->selUsuario($Dados ['captacao_niveis_usuarios_id_usuario'])['nome'];
                $log['nivel'] = $captacao->selectDescricaoNivel($Dados ['captacao_niveis_usuarios_captacao_niveis_id'])['captacao_niveis_ra_desc'];
                if (isset($Dados ['captacao_niveis_usuarios_regra_id']) && !empty($Dados ['captacao_niveis_usuarios_regra_id']))
                    $log['regra'] = $captacao->selectDescricaoRegra($Dados ['captacao_niveis_usuarios_regra_id'])['captacao_niveis_regras_desc'];
                Funcoes::gerarLogCadastro(new Log, "Cadastro nivel permissão", $log, 7);
                header("Location: ../../../../index.php?pg=2#tabs-2");
            endif;
        else :
            header("Location: ../../../../index.php?pg=2#tabs-2");
        endif;
        break;

    // CADASTRAR REGRAS DOS NIVEIS DE CAPTACAO :
    case "cadastrarRegraNivelCaptacao" :
        if ($Dados['captacao_niveis_regras_nivel'] == 2) {
            $operacao = $Dados['relacao'] . "_" . $Dados['ddd1'] . "_" . $Dados['ddd2'];
            $Dados['captacao_niveis_regras_operacao'] = $operacao;
            unset($Dados['relacao'], $Dados['ddd1'], $Dados['ddd2']);
        } else {
            $Dados['captacao_niveis_regras_operacao'] = $Dados['ddd'];
            unset($Dados['ddd'], $Dados['slct_filtroDDD']);
        }
        $captacao->insertNivelCaptacaoRegra($Dados);
        header("Location: ../../../../index.php?pg=2#tabs-2");
        break;

    // CADASTRAR INTERESSES DOS NIVEIS DE CAPTACAO :    
    case "cadastrarInteresseNivelCaptacao" :
        $captacao->insertNivelCaptacaoInteresse($Dados);
        header("Location: ../../../../index.php?pg=2#tabs-2");
        break;

    // DELETAR OS NIVEIS DE CAPTACAO:
    case "DedeteNivelCaptacao" :
        $nivelUsuario = $captacao->selectNivelUsuario($Dados['captacao_niveis_usuarios_id']);
        $usuario->deletarDDDsUsuario($Dados['id_usuario']);
        $captacao->deleteNivelCaptacao($Dados['captacao_niveis_usuarios_id']);
        //cadastra o log
        $log['id'] = $nivelUsuario ['id'];
        $log['usuario'] = $nivelUsuario['nome'];
        $log['nivel'] = $nivelUsuario['captacao_niveis_ra_desc'];
        if (isset($nivelUsuario ['captacao_niveis_usuarios_regra_id']) && !empty($nivelUsuario ['captacao_niveis_usuarios_regra_id']))
            $log['regra'] = $nivelUsuario['captacao_niveis_regras_desc'];

        Funcoes::gerarLogCadastro(new Log, "Exclusão nivel permissão", $log, 7);

        die(json_encode(array("type" => 1)));
        break;

    // CONSULTA FILTRO DE DDD DO VENDEDOR:
    case "verificarFiltro_ddd" :
        $id_usuario = $_POST ['idu'];
        $list_ddd = $usuario->selecionarDddsUsuarioString($id_usuario);
        $list_ddd = $list_ddd == "" ? - 1 : $list_ddd;
        die(json_encode(array("result" => $list_ddd)));
        break;

    // ATRIBUIR FILTROS:
    case "atribuirFiltroDDD" :
        $id_usuario = $_POST ['idu'];
        $dddsUsuario = $usuario->selecionarDddsUsuario(array(
            "id_usuario" => $id_usuario
        ));
        $verificados = $Dados ['ddds'];
        $verificados = array_unique($verificados);
        if (!empty($dddsUsuario)) {
            $teste = null;
            foreach ($dddsUsuario as $dUser) {
                $teste = (int) Funcoes::arraySearch($dUser ['regiao_ddd'], $verificados);
                if ($teste == - 1)
                    $usuario->deletarDDDUsuario($id_usuario, $dUser ['regiao_id']);
                else
                    unset($verificados [$teste]);
            }
        }
        $data = date('Y-m-d H:i');
        // insere novas regioes
        foreach ($verificados as $d) {
            $dddCod = $regiao->buscarCodigo($d);
            $arr = array(
                "ddds_usuario_id_usuario" => $id_usuario,
                "ddds_usuario_id_regiao" => $dddCod,
                "ddds_usuario_data_inclusao" => $data,
                "ddds_usuario_status_fila" => "off"
            );
            $usuario->inserirDDDUsuario($arr);
        }
        die(json_encode(array(
            'type' => 'success'
        )));
        break;

    // EXCLUIR FILTROS DDD :
    case "excluir_filtro_ddd" :
        $id = $Dados ['idu'];
        $usuario->deletarDDDsUsuario($id);
        die(json_encode(array('type' => 'success')));
        break;
    // REALOCAR CAPTACAO PARA OUTRO VENDEDOR:
    case "up_captacao" :
        $captacao->updateCaptacao($Dados);
        die(json_encode(array("type" => 1)));
        break;
    case "editaCaptacao" :
        if ($Dados['captacao_imovel_acesso_vigiado'] == 'não') {
            $Dados['captacao_imovel_tipo_servico_vigiado'] = '';
            $Dados['captacao_imovel_tipo_servico_vigiado_horario'] = '';
        }
        if ($Dados['captacao_imovel_registro_ocorrencia_local'] == 'não') {
            $Dados['captacao_imovel_descricao_ocorrencia_local'] = '';
        }
        if ($Dados['captacao_imovel_registro_ocorrencia_vizinhanca'] == 'não') {
            $Dados['captacao_imovel_descricao_ocorrencia_vizinhanca'] = '';
        }
        if ($Dados['captacao_aderencia_possui'] == 'sim') {
            $Dados['captacao_aderencia_motivo'] = '';
        }
        $voltar = $Dados['voltar'];
        $pg = $Dados['pg'];
        unset($Dados['voltar'], $Dados['pg']);
        $captacao->updateCaptacao($Dados);
        if ($pg == '56') {
            $pg = 55;
        }
        header("Location:../../../../index.php?pg=" . $pg . "&id=" . $Dados['captacao_id'] . "&acao=visualizar&voltar=" . $voltar . "#tabs-1");
        break;

    // DELETE CAPTACAO:
    case "DeleteCaptacao" :
        $cap = $captacao->selCaptacaoId($Dados ['id_captacao']);
        $id = $Dados ['id_captacao'];
        $captacao->deleteCaptacao($id);
        $captacao->insertCaptacaoDeletada($cap);
        $cap['id'] = $Dados ['id_captacao'];
        Funcoes::gerarLogCadastro($logs, "Exclusão Captação", $cap, 5);
        header("Location:../../../../index.php?pg=2#tabs-1");
        break;
    // DELETE ANEXOS:
    case "DeleteAnexos" :
        $id_anexo = $Dados ['id_anexo'];
        // seleciona o nome do arquivo;
        $anexo = $anexos->select($id_anexo);
        $pasta = '../../../../../_MIDIAS_/anexosContrato/clientes/' . $anexo['nome_anexo'];
        if (file_exists($pasta))
            unlink($pasta);
        $anexos->deleteAnexos($id_anexo);
        header("Location:../../../../index.php?pg=15&id={$Dados['id_cliente']}&id_cliente_contrato={$Dados['id']}#anexos");
        break;

    // ENVIAR CONTRATO :
    case "EnviarContrato" :
        $clienteContrato = $cliente->selectClienteContrato($Dados['id_cliente']);
        $id = '';
        if (empty($Dados['id_contrato']))
            $Dados['id_contrato'] = $contrato->insert(
                    array(
                        'id_cliente' => $clienteContrato['id_cliente'],
                        'id_usuario' => $clienteContrato['id_usuario'],
                        'cliente_ra' => $clienteContrato['cliente_ra'],
                        'tipo_contrato' => 'novo',
                        'status_contrato' => 1,
                        'observacoes_contrato' => 'ok',
                        'data_contrato_gerado' => date("Y-m-d H:i:s"),
                        'data_envio' => date("Y-m-d H:i:s")
            ));
        else
            $contrato->updateContratos(array("id_contrato" => $Dados['id_contrato'], "observacoes_contrato" => "ok", 'data_envio' => date("Y-m-d H:i:s")));
        $cliente->deleteCamposContratoReprovados($Dados['id_cliente']);
        $cliente->updateStatusCadastro($Dados['id_cliente'], 1);
        header("Location:../../../../index.php?pg=15#settings");
        break;
    //FINALIZA O CONTRATO:
    case "finalizarContrato" :
        $id_usuario = $_SESSION['user_info']['id_usuario'];
        $id_cliente = $Dados['id_cliente'];
        $id_contrato = $Dados['id_contrato'];
        $cliente_ra = $Dados['cliente_ra'];
        unset($Dados['cliente_ra']);
        #Se Danfe estiver selecionado
        $Dados['danfe'] = 1;
        $Dados['cor_status'] = 'a_cor_cinza';
        $DadosContrato = $contrato->select($id_contrato);
        $Dados ['status_contrato'] = 3;
        if (empty($DadosContrato['data_finalizacao_contrato'])) {
            $Dados['data_finalizacao_contrato'] = date("Y-m-d H:i:s");
        }
        #Atualiza o contrato
        $contrato->updateContratos($Dados);
        $cliente->updateCliente("clientes", array("id_cliente" => $cliente_ra, "status_cadastro" => 3));
        header("location: ../../../../index.php?pg=17");
        break;

    case "Agendar" :
        $agenda = new AgendaContato;
        $agenda->selectAgendaProximaData($Dados['agenda_contato_proxima_data'], $Dados['agenda_contato_hora'], $Dados['agenda_contato_id_usuario']);
        $result = null;
        if ($agenda->Read()->getRowCount() >= 1) {
            $result = 2;
        } else {
            unset($Dados['$agenda_contato_id']);
            $agenda->insertAgenda($Dados);
            $result = 1;
        }
        die(json_encode(array("type" => $result)));
        break;

    case "Reagendar" :
        $agenda = new AgendaContato;
        $agenda->selectAgendaProximaData($Dados['agenda_contato_proxima_data'], $Dados['agenda_contato_hora'], $Dados['agenda_contato_id_usuario']);
        $result = null;
        if ($agenda->Read()->getRowCount() >= 1) {
            $result = 2;
        } else {
            $agenda->updateAgendaPorID(array("agenda_contato_status" => 1, "agenda_contato_id" => $Dados['agenda_contato_id']));
            unset($Dados['agenda_contato_id']);
            $agenda->insertAgenda($Dados);
            $result = 1;
        }
        die(json_encode(array("type" => $result)));
        break;

    case "cadastrarNivelCaptacao" :
        $captacao->insertNiveisCaptacao($Dados);
        header("Location: ../../../../index.php?pg=2#tabs-2");
        break;
    case "updateStatusAgenda":
        $agenda = new AgendaContato;
        $Dados['agenda_contato_status'] = 1;
        $agenda->updateAgendaPorID($Dados);
        echo 1;
        break;

    case "alterarStatusCaptacao":
        $Dados ['captacao_id'] = $Dados ['id_captacao'];
        unset($Dados ['id_captacao']);
        $captacao->updateCaptacao($Dados);
        echo 1;
        break;

    case "alterarStatusNivelVendedor":
        $nivelUsuario = $captacao->selectNivelUsuario($Dados['captacao_niveis_usuarios_id']);
        $captacao->updateCaptacaoNivelUsuario($Dados);
        //cadastra o log
        $log['id'] = $Dados['captacao_niveis_usuarios_id_usuario'];
        $log['usuario'] = $nivelUsuario['nome'];
        $log['nivel'] = $nivelUsuario['captacao_niveis_ra_desc'];
        if (isset($nivelUsuario ['captacao_niveis_usuarios_regra_id']) && !empty($nivelUsuario ['captacao_niveis_usuarios_regra_id']))
            $log['regra'] = $nivelUsuario['captacao_niveis_regras_desc'];

        $desc = $Dados['captacao_niveis_usuarios_ativo'] == 2 ? "Desativado" : "Ativado";
        Funcoes::gerarLogCadastro(new Log, "{$desc} nivel permissão", $log, 7);
        header("location: ../../../../index.php?pg=2#tabs-2");
        break;

    case "exportarRelatorioCaptacao":
        $dataInicial = $Dados['dt_inicial'];
        $dataFinal = $Dados['dt_final'];
        $Dados['dt_inicial'] = Funcoes::FormatadataSql($Dados['dt_inicial']);
        $Dados['dt_final'] = Funcoes::FormatadataSql($Dados['dt_final']);
        $relatorioCaptacao = new RelatorioCaptacao ();

        $lista = $relatorioCaptacao->consultar($Dados, null);

        $html = '<table width="100%" cellpadding="0" cellspacing="0" border="1">
        <caption><h2>Relat&oacute;rio Capta&ccedil;&otilde;es de ' . $dataInicial . ' at&eacute; ' . $dataFinal . '</h2></caption>
        <thead>
        <tr>
        <th>Data/Hora</th>
        <th>Origem</th>
        <th>Servi&ccedil;o</th>
        <th>Cadastro</th>
        <th>Consultor</th>
        <th>Cliente</th>
        <th>Cidade/UF</th>
        <th>DDD</th>
        <th>Status</th>
        <th>Obs</th>
        <th>Indicador</th>
        </tr>
        </thead>
        <tbody>';
        foreach ($lista as $k => $dados) {
            $origem = !empty($dados ['origem']) ? $dados ['origem'] : "";
            $captacao_status = !empty($dados ['captacao_status']) ? $dados ['captacao_status'] : "";
            $captacao_cidade = !empty($dados ['captacao_cidade']) ? $dados ['captacao_cidade'] : "";
            $captacao_uf = !empty($dados ['captacao_uf']) ? $dados ['captacao_uf'] : "";
            $captacao_data_criacao = !empty($dados ['captacao_data_criacao']) ? $dados ['captacao_data_criacao'] : "";
            $nome_consultor = !empty($dados ['nome_consultor']) ? $dados ['nome_consultor'] : "";
            $captacao_cliente = !empty($dados ['captacao_cliente']) ? $dados ['captacao_cliente'] : "";
            $captacao_ddd = !empty($dados ['captacao_ddd']) ? $dados ['captacao_ddd'] : "";
            $captacao_nivel_prioridade = !empty($dados ['captacao_nivel_prioridade']) ? $dados ['captacao_nivel_prioridade'] : "";
            $usuarioCadastro = !empty($dados['usuarioCadastro']) ? $dados['usuarioCadastro'] : "";
            $captacao_servico = !empty($dados['captacao_interesse']) ? ucwords($dados['captacao_interesse']) : "";
            $captacao_indicador = !empty($dados['captacao_indicador']) ? ucwords($dados['captacao_indicador']) : "";
            $motivo_finalizacao = !empty($dados['motivo']) ? ucwords($dados['motivo']) : "";
            //BLOCO QUE CONCATENA A CIDADE COM A UF, CASO EXISTA:
            $cidade = $captacao_cidade;
            if (($captacao_cidade) && ($captacao_uf)) {
                $cidade = $captacao_cidade . "/" . $captacao_uf;
            }
            if ((!$captacao_cidade) && ($captacao_uf)) {
                $cidade = $captacao_uf;
            }
            //BLOCO QUE FORMATA DATA PRA EXIBIR NO RELATORIO:
            $dataHora = explode(' ', $captacao_data_criacao);
            $data = Funcoes::formataData($captacao_data_criacao);
            if ($motivo_finalizacao == 'Off') {
                $motivo_finalizacao = '';
            } else {
                $motivo_finalizacao = utf8_encode($motivo_finalizacao);
            }
            $html .= "<tr>
                        <td align='center'>" . $data . " " . $dataHora [1] . "</td>
                        <td>" . utf8_encode($origem) . "</td>
                        <td>" . utf8_encode($captacao_servico) . "</td>
                        <td>" . utf8_encode($usuarioCadastro) . "</td>
                        <td>" . utf8_encode($nome_consultor) . "</td>
                        <td>" . utf8_encode($captacao_cliente) . "</td>
                        <td>" . utf8_encode($cidade) . "</td>
                        <td align='center'>" . $captacao_ddd . "</td>
                        <td>" . ucwords($captacao_status) . "</td>
                        <td>" . $motivo_finalizacao . "</td>
                        <td>" . utf8_encode($captacao_indicador) . "</td>
                </tr>";
        }
        $html .= "</tbody></table>";
        Funcoes::exportExel($html, "Planilha_Captacaoes.xls");
        break;
    case "form_grupoVolpato":
        $ac_cliente = isset($_POST['nome']) ? mysql_escape_string($_POST['nome']) : '';
        $ac_email = isset($_POST['email']) ? mysql_escape_string(strtolower(trim($_POST['email']))) : '';
        $ac_interesse = $_POST['interesse'];
        $ac_nivel_prioridade = "normal";
        $ac_qtdV = 5;
        $ac_obs = $_POST['mensagem'];
        $ac_operador1 = $_POST['operadora'];
        $ac_operador2 = $_POST['operadora2'];
        $tipo_form = $_POST['tipo_form'];
        $origem = $_POST['origem'];
        $telefone1 = "(" . $_POST['ddd'] . ")" . $_POST['telefone'];
        $telefone2 = "(" . $_POST['dddc'] . ")" . $_POST['celular'];
        if ($_POST['origem'] == 'form-modal'):
            if ($tipo_form == 'grupovolpato.com/web/index.php?option=com_content&view=article&id=54&Itemid=59'):
                $origemDb = 'grupovolpato.com/contato';
            else:
                $origemDb = $tipo_form;
            endif;
        else:
            $origemDb = $origem;
        endif;
        $Dados = array(
            'captacao_interesse' => $ac_interesse,
            'captacao_qtd_veiculo' => $ac_qtdV,
            'captacao_cliente' => $ac_cliente,
            'captacao_email' => $ac_email,
            'captacao_indicador' => $ac_indicador,
            'captacao_nivel_prioridade' => $ac_nivel_prioridade,
            'captacao_obs' => $ac_obs,
            'captacao_telefone1' => $telefone1,
            'captacao_telefone2' => $telefone2,
            'captacao_operadora1' => $ac_operador1,
            'captacao_operadora2' => $ac_operador2,
            'origem' => $origemDb
        );

        $ddd = $_POST['ddd'];

        include("captacaoComplemento.php");

        if ($tipo_form == "r") {
            header('Location: http://www.grupovolpato.com/rastreamento/novosite/?r=ok');
        } else {
            if ($origem == "liigue-11-3522-1111.com.br" || $origem == "http://www.grupovolpato.com/residencial" || $origem == "volpatorastreamento-modal" || $origem == "form-modal"):
                die('
					<div align="center" style="font-family:Tahoma, Geneva, sans-serif;">
						<br /><br /><br /><br /><br /><br /><br /><br /><br />
						<strong><font color="#003366">ENVIADO COM SUCESSO</font></strong><br /><br />
						Obrigado pela prefer&ecirc;ncia.<br />
						Em breve um de nossos consultores entrar&aacute; em contato. <br /><br />
						Grupo Volpato
					</div>
				');
            else:
                header("Location: http://{$origem}?r=ok");
            endif;
        }

        die('
				<div align="center" style="font-family:Tahoma, Geneva, sans-serif;">
					<strong><font color="#003366">ENVIADO COM SUCESSO</font></strong><br /><br />
					Obrigado pela prefer&ecirc;ncia.<br />
					Em breve um de nossos consultores entrar&aacute; em contato. <br /><br />
					Grupo Volpato
				</div>
			');
        break;

    // NSERIR CAPTACAO:
    case "InsertCaptacao" :
        //VARIAVEIS DE ENTRADA:
        @session_start();
        $nivelPermissao = null;
        $verifica = FALSE;
        $totalVendedores = 0;
        $ddd = substr($Dados ['captacao_telefone1'], 1, 2); //PEGAR O DDD DO TELEFONE :
        //RESPONSAVEL POR DISTRIBUIR AS CAPTACOES:
        include_once("captacaoComplemento.php");
        //RETORNA O ULTIMO ID DA CAPTACAO INSERIDA NA BASE DE DADOS:
        $ultimo_id = $captacao->Create()->getResult();
        if (!empty($ultimo_id)) :
            $DadosSms ['id'] = $ultimo_id;
            $DadosSms ['celular'] = $Dados ['captacao_telefone1'];
            include("../../../../application/models/classes/api_sms/HumanClientMain.php");
            $RESPOSTA = 0;
            try {
                $captacao_telefone1 = explode(')', $Dados['captacao_telefone1']);
                $total_captacao_telefone1 = strlen($captacao_telefone1[1]);
                if ($total_captacao_telefone1 >= 10) {
                    $sms_captacao_telefone1 = "(51)" . substr($captacao_telefone1[1], 1);
                } else {
                    $sms_captacao_telefone1 = $Dados['captacao_telefone1'];
                }
                #  SMS PARA O CLIENTE :
                Funcoes::enviaSMS(array(
                    'id_captacao' => $ultimo_id,
                    'mensagem' => 'Obrigado pela preferencia. Em breve um de nossos consultores entrara em contato.  Volpato', 'telefone' => $sms_captacao_telefone1), new Sms, new HumanMultipleSend("volpatoapipos", "bmHvfLRFlr"
                ));
                #  E-MAIL PARA O CLIENTE :
                if (isset($Dados['captacao_email']) && !empty($Dados['captacao_email'])) {
                    $msgCliente = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Obrigado pela prefer&amp;circ;ncia.</title>
                    </head>			
                    <body  style=" color:#1D3E69; font-size:16px; font-family:Arial, Helvetica, sans-serif">
                        <p> Ol&aacute;,</p>
                        <p style="font-size:16px"> Obrigado pela prefer&ecirc;ncia.</p>
                        <p style="font-size:16px">Em breve um de nossos consultores entrar&aacute; em contato.</p>
                        <p style="font-size:16px">Atenciosamente,<br>
                        Grupo Volpato</p>
                        <p style="font-size:16px"><img src="http://revendavolpato.com/saudacoes_gpi/obrigado%20pela%20preferencia%20rodape.png"  width="789" height="94" alt="" border="0"></p>			
                    </body>
                    </html>';
                    $seja = "Seja Bem Vindo à Volpato";
                    $DadosEmail ['asssunto'] = utf8_decode($seja);
                    $DadosEmail ['emailRementente'] = 'revendavolpato@revendavolpato.com';
                    $DadosEmail ['remetente'] = 'Grupo Volpato';
                    $DadosEmail ['emailDestino'] = $Dados ['captacao_email'];
                    $DadosEmail ['nome'] = $Dados ['captacao_cliente'];
                    $DadosEmail ['emailResposta'] = 'volpato@grupovolpato.com';
                    $DadosEmail ['nomeEmailResposta'] = "GRUPO VOLPATO";
                    $DadosEmail ['Body'] = $msgCliente;
                    $RESPOSTA = (Funcoes::EnviarEmail($DadosEmail, $phpmailer)) ? 1 : 0;
                }
                $Dados['id'] = $ultimo_id;
                # GERAR LOG  :
                Funcoes::gerarLogCadastro($logs, "Cadastro Captação Interno", $Dados, 5);
            } catch (Exception $e) {
                $RESPOSTA = 0;
            }
        else :
            die('Error ao cadastrar uma captacao');
        endif;
        $RESPOSTA = 1;
        if ($Dados ['origem'] == 'monitoramento') {
            header('location:../../../../index.php?pg=1&r=' . $RESPOSTA);
        }
        break;

    case 'editarContrato':
        $contrato->updateContratos(array(
            'id_contrato' => $Dados['idContrato'],
            'data_contrato_gerado' => funcoes::FormatadataSql($Dados['data']),
            'tipo_assinatura' => $Dados['tipo_assinatura']
        ));
        $cliente->updateCliente("clientes", array(
            "id_cliente" => $Dados['id_cliente'],
            "vigencia" => $Dados['vigencia'],
            "tipo_cadastro" => $Dados['tipo_cadastro'],
        ));
        header('location:../../../../index.php?pg=17');
        break;

endswitch;
