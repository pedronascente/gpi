<?php

include_once("../../../../Config.inc.php");
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$Dados = filter_input_array(INPUT_POST);

if (empty($Dados)) {
    $Dados = filter_input_array(INPUT_GET);
}

if (!empty($Dados) && isset($Dados)) {
    $acao = $Dados['acao'];
    $id = !empty($Dados['id_cliente']) ? $Dados['id_cliente'] : '';
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

switch ($acao):
    case "delete_captacao_ajax":
        foreach ($Dados['data'] as $key => $value) {
            $cap = $captacao->selCaptacaoId($value);
            $id = intval($value);
            $captacao->deleteCaptacao($id);
        }
        break;

    case "consultaSPCSERASA":
        $tipoFrm = $Dados['tipoFrm'];
        $AprovarReprovar = isset($Dados['radioApRp']) ? $Dados['radioApRp'] : null;
        $redirect = $Dados['redirect'];
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
            switch ($retorno):
                case 'aprovado':
                    echo '  <script type="text/javascript">  alert("Cliente Aprovado com sucesso!"); location.href="../../../../index.php?pg=12&acao=ex";  </script>';
                    break;
                case 'reprovado':
                    echo ' <script type="text/javascript">  alert("Cliente Reprovado com sucesso!");location.href="../../../../index.php?pg=12&acao=ex"; </script>';
                    break;
            endswitch;
        else :
            header($header);
        endif;
        break;

        /**
         * 
         * BUSCA CPF/CNPJ CLIENTE :
         *  
         **/
    case "buscarCPF":
        $cpf = $cliente->buscarCPF($Dados['cpf']);
        $cliente = isset($cpf['id_cliente']) ? $cpf['id_cliente'] . "_" . $cpf['nome_cliente'] : 0;
        echo $cliente;
        break;

        /**
         * 
         * APROVA CONSULTA SPC / SERASA:
         *  
         **/
    case "AprovarConsulta":
        $cliente->updateCliente("clientes", $Dados);
        header("Location: ../../../../index.php?pg=14");
        break;

        /**
         * 
         * REPROVA CONSULTA SPC / SERASA:
         *  
         **/
    case "reprovaConsulta":
        $Dados['id_status'] = 3;
        $cliente->updateCliente("clientes", $Dados);
        header("Location: ../../../../index.php?pg=14");
        break;

        /**
         * 
         * DELETE CONSULTA SPC / SERASA:
         *  
         **/
    case "deletarConsulta":
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
    case "cadastroCliente":

        $id_cliente = $Dados['CLIENTE']['id_cliente'];
        $statusCadastro = $Dados['CLIENTE']['status_cadastro']; // se status = 0 -> novo cliente  // se status = 1 -> cliente ja cadastrado.    

        if (isset($Dados['cod_municipio'])) {
            $Dados['cod_municipio'] = preg_replace("/[^0-9]/", "", $Dados['CLIENTE']['cod_municipio']);
        }
        //UPDATE FORMA DE PAGAMENTO:
        if (isset($Dados['FORMADEPAGAMENTO'])) {
            for ($i = 0; $i < count($Dados['FORMADEPAGAMENTO']); $i++) {
                $Dados['FORMADEPAGAMENTO'][$i]['id_cliente'] = $Dados['id_cliente'];
                $forma_pagamento->updateFormaDePagamento($Dados['FORMADEPAGAMENTO'][$i]);
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
        if (
            !isset($Dados['CONTATO'][1]['nome_contato']) &&
            !isset($Dados['CONTATO'][1]['email_contato']) &&
            !isset($Dados['CONTATO'][1]['telefone1_contato']) &&
            !isset($Dados['CONTATO'][1]['telefone2_contato'])
        ) {
            unset($Dados['CONTATO'][1]);
        }

        $cliente->selecContatoCliente("contato_cliente", $Dados['CLIENTE']['id_cliente']);

        $total = $cliente->Read()->getRowCount();

        if ($total >= 1) :
            $cliente->updateContatoCliente('contato_cliente', $Dados['CONTATO']);
        else :
            $cliente->insertContatoCliente("contato_cliente", $Dados['CONTATO']);
        endif;

        header("Location:../../../../index.php?pg=15&id=" . $Dados['id'] . "&id_cliente_contrato=" . $id_cliente);
        break;

        //INSERT VEICULOS :
    case "InsertVeiculo":
        $id = !empty($Dados['id']) ? $Dados['id'] : $Dados['id_cliente'];
        $Dados['cliente_ra'] = $id;
        $Dados['id_cliente'] = $Dados['id_cliente'];
        $Dados['taxa_instalacao'] = !empty($Dados['taxa_instalacao']) ? floatval(Funcoes::formataMoedaSql($Dados['taxa_instalacao'])) : 0.0;
        $Dados['taxa_monitoramento'] = !empty($Dados['taxa_monitoramento']) ? floatval(Funcoes::formataMoedaSql($Dados['taxa_monitoramento'])) : 0.0;;
        $Dados['valor_equipamento'] = !empty($Dados['valor_equipamento']) ? floatval(Funcoes::formataMoedaSql($Dados['valor_equipamento'])) : 0.0;
        $Dados['valor_protecao'] = !empty($Dados['valor_protecao']) ? floatval(Funcoes::formataMoedaSql($Dados['valor_protecao'])) : 0.0;
        $Dados['valor_protecao_assistencial'] = !empty($Dados['valor_protecao_assistencial']) ? floatval(Funcoes::formataMoedaSql($Dados['valor_protecao_assistencial'])) : 0.0;
        $Dados['placa'] = strtoupper($Dados['placa']);

        if ($Dados['tipo_seguro'] == 'null') {
            unset($Dados['tipo_seguro']);
        }
        unset($Dados['id']);

        $ultimoId = $veiculo->insert($Dados);
        header("Location: ../../../../index.php?pg=15&id={$id}&tipoCadastro=VENDA&id_cliente_contrato={$Dados['id_cliente']}#veiculos");
        break;

        /**
         * 
         * UPDATE VEICULOS:
         *  
         **/
    case "EditarVeiculo":

        $id_veiculo = $Dados['id_veiculo'];
        $id = $Dados['id_cliente'];

        if (empty($Dados['placa'])) {
            unset($Dados['placa']);
        } else {
            $Dados['placa'] = Funcoes::formataMoedaSql($Dados['placa']);
        }
        if (empty($Dados['valor_equipamento'])) {
            unset($Dados['valor_equipamento']);
        } else {
            $Dados['valor_equipamento'] = Funcoes::formataMoedaSql($Dados['valor_equipamento']);
        }
        if (empty($Dados['taxa_monitoramento'])) {
            unset($Dados['taxa_monitoramento']);
        } else {
            $Dados['taxa_monitoramento'] = Funcoes::formataMoedaSql($Dados['taxa_monitoramento']);
        }
        if (empty($Dados['taxa_instalacao'])) {
            unset($Dados['taxa_instalacao']);
        } else {
            $Dados['taxa_instalacao'] = Funcoes::formataMoedaSql($Dados['taxa_instalacao']);
        }
        if (empty($Dados['valor_protecao'])) {
            unset($Dados['valor_protecao']);
        } else {
            $Dados['valor_protecao'] = Funcoes::formataMoedaSql($Dados['valor_protecao']);
        }
        if (empty($Dados['valor_protecao_assistencial'])) {
            unset($Dados['valor_protecao_assistencial']);
        } else {
            $Dados['valor_protecao_assistencial'] = Funcoes::formataMoedaSql($Dados['valor_protecao_assistencial']);
        }


        if (!empty($Dados['tags_planoAssistencia'])) {
            if ($PlanoAssistencil['tags_planoAssistencia'] == "s") {
                $PlanoAssistencil['status_planoAssistencia'] = "SIM";
            } else if ($PlanoAssistencil['tags_planoAssistencia'] == "n") {
                $PlanoAssistencil['status_planoAssistencia'] = "NÃO";
            } else {
                $PlanoAssistencil['status_planoAssistencia'] = 'Isento';
            }
        }

        if ($Dados['tipo_seguro'] == 'null') {
            unset($Dados['tipo_seguro']);
        }

        unset($Dados['tags_planoAssistencia'], $Dados['valor'], $Dados['id_cliente']);

        $Dados['id_veiculo']  = intval($Dados['id_veiculo']);

        if ($veiculo->updateVeiculo($Dados)) {
            header("Location: ../../../../index.php?pg=15&id={$id}&id_cliente_contrato={$id}#veiculos");
        } else {
            die('Não foi possivel atualizar este veiculos, por favor contacte a TI :(');
        }
        break;

        /**
         * 
         * DELETE VEICULO :
         *  
         **/
    case "DeleteVeiculo":
        $veiculo->deleteVeiculo($idVeiculo);
        header("Location: ../../../../index.php?pg=15&id=" . $id . "&id_cliente_contrato=" . $id_contrato_antigo . "#veiculos");
        break;

        //QUE BUSCA O CODIGO IBGE DO MUNICIPIO (invocado por js/funcoes.js) :
    case "consultarCodCidade":
        $municipio = new Municipio();
        $codigo = $municipio->consultarCodCidade($Dados['cidade'], $Dados['uf']);
        if (isset($codigo['id'])) {
            $codigo = (int) $codigo['id'];
        } else {
            $codigo = 0;
        }
        die(json_encode(array("cod" => $codigo)));
        break;
        // DELETE ENDERECO COBRANCA :    
    case "DeleteEnderecoCobranca":
        $cliente->deleteEnderecoCobranca($id);
        die(json_encode(array(
            'type' => 'success'
        )));
        break;
        // DELETE CONTRATO:
    case "DeleteContrato":
        $id_contrato = $Dados['id_contrato'];
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
    case "reprovaContrato":
        if (!empty($Dados['camposCliente'])) {
            foreach ($Dados['camposCliente'] as $cc) {
                $cliente->insertCamposContrato(
                    array(
                        "cr_campo" => $cc,
                        "cr_cliente" => $Dados['id_cliente']
                    )
                );
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
                    )
                );
            }
        }
        unset(
            $Dados['camposCliente'],
            $Dados['camposVeiculos']
        );

        $cont = $cliente->selectClienteEnderecoCobrancaContrato($Dados['id_cliente']);
        $cliente->updateStatusCadastro($Dados['id_cliente'], 2);
        $contrato->updateContratos($Dados);
        //Gravar Logs:
        $vendedor = $cont['vendedor'];
        unset(
            $cont['vendedor'],
            $cont['motivo_reprovacao'],
            $cont['id_status'],
            $cont['status_cadastro'],
            $cont['id_usuario'],
            $cont['tipo_cadastro'],
            $cont['idCliente'],
            $cont['data_cadastro_senha_segunaca'],
            $cont['cliente_ra'],
            $cont['cliente_edit'],
            $cont['cliente_ativo'],
            $cont['tipo_pessoa'],
            $cont['data_solicitacao_cliente'],
            $cont['motivo_reprovacao'],
            $cont['senha_seguranca'],
            $cont['contra_senha_seguranca'],
            $cont['vigencia'],
            $cont['id_endereco_cobranca'],
            $cont['id_contrato'],
            $cont['contato_cobranca'],
            $cont['cli_cod_municipio']
        );
        $cont = array(
            "motivo" => $Dados['observacoes_contrato'],
            "id" => $Dados['id_cliente'],
            "Vendedor" => $vendedor,
            " \nContrato" => ""
        ) + $cont;
        Funcoes::gerarLogCadastro($logs, "Contrato Reprovado", $cont, 6);
        //Redirecionar página:
        header("Location: ../../../../index.php?pg=17");
        break;
        // ADICIONAR  NIVEIS DE CAPTACAO :
    case "InsertNivelCaptacaoUsuario":
        // VERIFICA SE O USUARIO  TEM ESTE NIVEL
        $regra['id_usuario'] = $Dados['captacao_niveis_usuarios_id_usuario'];
        $regra['captacao_niveis_usuarios_captacao_niveis_id'] = $Dados['captacao_niveis_usuarios_captacao_niveis_id'];
        if (isset($Dados['captacao_niveis_usuarios_regra_id']) && !empty($Dados['captacao_niveis_usuarios_regra_id']))
            $regra['captacao_niveis_regra'] = $Dados['captacao_niveis_usuarios_regra_id'];
        $totalNivel = $usuario->validarNivelCaptacao($regra);
        if (empty($totalNivel)) :
            // INSERE NIVEIS DE CAPTAO:
            if ($captacao->insertNiveisCaptacaoUsuario($Dados)) :
                //cadastra o log 
                $log['id'] = $Dados['captacao_niveis_usuarios_id_usuario'];
                $log['usuario'] = $usuario->selUsuario($Dados['captacao_niveis_usuarios_id_usuario'])['nome'];
                $log['nivel'] = $captacao->selectDescricaoNivel($Dados['captacao_niveis_usuarios_captacao_niveis_id'])['captacao_niveis_ra_desc'];
                if (isset($Dados['captacao_niveis_usuarios_regra_id']) && !empty($Dados['captacao_niveis_usuarios_regra_id']))
                    $log['regra'] = $captacao->selectDescricaoRegra($Dados['captacao_niveis_usuarios_regra_id'])['captacao_niveis_regras_desc'];
                Funcoes::gerarLogCadastro(new Log, "Cadastro nivel permissão", $log, 7);
                header("Location: ../../../../index.php?pg=2#tabs-2");
            endif;
        else :
            header("Location: ../../../../index.php?pg=2#tabs-2");
        endif;
        break;
        // CADASTRAR REGRAS DOS NIVEIS DE CAPTACAO :
    case "cadastrarRegraNivelCaptacao":
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
    case "cadastrarInteresseNivelCaptacao":
        $captacao->insertNivelCaptacaoInteresse($Dados);
        header("Location: ../../../../index.php?pg=2#tabs-2");
        break;
        // DELETAR OS NIVEIS DE CAPTACAO:
    case "DedeteNivelCaptacao":
        $nivelUsuario = $captacao->selectNivelUsuario($Dados['captacao_niveis_usuarios_id']);
        $usuario->deletarDDDsUsuario($Dados['id_usuario']);
        $captacao->deleteNivelCaptacao($Dados['captacao_niveis_usuarios_id']);
        //cadastra o log
        $log['id'] = $nivelUsuario['id'];
        $log['usuario'] = $nivelUsuario['nome'];
        $log['nivel'] = $nivelUsuario['captacao_niveis_ra_desc'];
        if (isset($nivelUsuario['captacao_niveis_usuarios_regra_id']) && !empty($nivelUsuario['captacao_niveis_usuarios_regra_id']))
            $log['regra'] = $nivelUsuario['captacao_niveis_regras_desc'];

        Funcoes::gerarLogCadastro(new Log, "Exclusão nivel permissão", $log, 7);

        die(json_encode(array("type" => 1)));
        break;
        // CONSULTA FILTRO DE DDD DO VENDEDOR:
    case "verificarFiltro_ddd":
        $id_usuario = $_POST['idu'];
        $list_ddd = $usuario->selecionarDddsUsuarioString($id_usuario);
        $list_ddd = $list_ddd == "" ? -1 : $list_ddd;
        die(json_encode(array("result" => $list_ddd)));
        break;
        // ATRIBUIR FILTROS:
    case "atribuirFiltroDDD":
        $id_usuario = $_POST['idu'];
        $dddsUsuario = $usuario->selecionarDddsUsuario(array(
            "id_usuario" => $id_usuario
        ));
        $verificados = $Dados['ddds'];
        $verificados = array_unique($verificados);
        if (!empty($dddsUsuario)) {
            $teste = null;
            foreach ($dddsUsuario as $dUser) {
                $teste = (int) Funcoes::arraySearch($dUser['regiao_ddd'], $verificados);
                if ($teste == -1)
                    $usuario->deletarDDDUsuario($id_usuario, $dUser['regiao_id']);
                else
                    unset($verificados[$teste]);
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
    case "excluir_filtro_ddd":
        $id = $Dados['idu'];
        $usuario->deletarDDDsUsuario($id);
        die(json_encode(array('type' => 'success')));
        break;

        // REALOCAR CAPTACAO PARA OUTRO VENDEDOR:
    case "up_captacao":
        $captacao->updateCaptacao($Dados);
        die(json_encode(array("type" => 1)));
        break;

    case "editaCaptacao":
        $Dados['captacao_id'] = intval($Dados['captacao_id']);
        if ($Dados['captacao_imovel_acesso_vigiado'] == 'não') {
            $Dados['captacao_imovel_tipo_servico_vigiado'] = null;
            $Dados['captacao_imovel_tipo_servico_vigiado_horario'] = null;
        }
        if ($Dados['captacao_imovel_registro_ocorrencia_local'] == 'não') {
            $Dados['captacao_imovel_descricao_ocorrencia_local'] = null;
        }
        if ($Dados['captacao_imovel_registro_ocorrencia_vizinhanca'] == 'não') {
            $Dados['captacao_imovel_descricao_ocorrencia_vizinhanca'] = null;
        }
        if ($Dados['captacao_aderencia_possui'] == 'sim') {
            $Dados['captacao_aderencia_motivo'] = null;
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

    case "editar-frm_edit_formulario_a":
        $Dados['captacao_id'] = intval($Dados['captacao_id']);
        if (empty(trim($Dados['captacao_numero']))) {
            $Dados['captacao_numero'] = null;
        }
        if (empty(trim($Dados['captacao_endereco']))) {
            $Dados['captacao_endereco'] = null;
        }
        if (empty(trim($Dados['captacao_cidade']))) {
            $Dados['captacao_cidade'] = null;
        }
        if (empty(trim($Dados['captacao_bairro']))) {
            $Dados['captacao_bairro'] = null;
        }
        if (empty(trim($Dados['captacao_complemento']))) {
            $Dados['captacao_complemento'] = null;
        }
        if (empty(trim($Dados['captacao_imovel_atividade_principal']))) {
            $Dados['captacao_imovel_atividade_principal'] = null;
        }
        if (empty(trim($Dados['captacao_imovel_ao_lado_de']))) {
            $Dados['captacao_imovel_ao_lado_de'] = null;
        }
        if (empty(trim($Dados['captacao_imovel_metragem']))) {
            $Dados['captacao_imovel_metragem']  = null;
        }
        if (empty(trim($Dados['captacao_imovel_area']))) {
            $Dados['captacao_imovel_area'] = null;
        }
        if (empty(trim($Dados['captacao_imovel_pisos']))) {
            $Dados['captacao_imovel_pisos'] = null;
        }
        if (empty(trim($Dados['captacao_imovel_descricao_da_ares']))) {
            $Dados['captacao_imovel_descricao_da_ares'] = null;
        }
        if (empty(trim($Dados['captacao_imovel_acesso_vigiado']))) {
            $Dados['captacao_imovel_acesso_vigiado'] = null;
        }
        if (empty(trim($Dados['captacao_imovel_registro_ocorrencia_local']))) {
            $Dados['captacao_imovel_registro_ocorrencia_local'] = null;
        }
        if (empty(trim($Dados['captacao_imovel_descricao_ocorrencia_local']))) {
            $Dados['captacao_imovel_descricao_ocorrencia_local'] = null;
        }
        if (empty(trim($Dados['captacao_imovel_registro_ocorrencia_vizinhanca']))) {
            $Dados['captacao_imovel_registro_ocorrencia_vizinhanca'] = null;
        }
        if (empty(trim($Dados['captacao_imovel_descricao_ocorrencia_vizinhanca']))) {
            $Dados['captacao_imovel_descricao_ocorrencia_vizinhanca'] = null;
        }
        if (empty(trim($Dados['captacao_aderencia_possui']))) {
            $Dados['captacao_aderencia_possui'] = null;
        }
        if (empty(trim($Dados['captacao_aderencia_motivo']))) {
            $Dados['captacao_aderencia_motivo'] = null;
        }
        if (empty(trim($Dados['captacao_data_agenda']))) {
            $Dados['captacao_data_agenda'] = null;
        }
        if (empty(trim($Dados['captacao_consultor']))) {
            $Dados['captacao_consultor'] = null;
        }
        if (empty(trim($Dados['captacao_indicador']))) {
            $Dados['captacao_indicador'] = null;
        }
        if (empty(trim($Dados['captacao_operadora1']))) {
            $Dados['captacao_operadora1'] = null;
        }
        if (empty(trim($Dados['captacao_tipo_servico']))) {
            $Dados['captacao_tipo_servico'] = null;
        }
        if (empty(trim($Dados['captacao_tipo_servico_desc_outros']))) {
            $Dados['captacao_tipo_servico_desc_outros'] = null;
        }
        if (empty(trim($Dados['captacao_data_nascimento']))) {
            $Dados['captacao_data_nascimento'] = null;
        }
        if (empty(trim($Dados['captacao_observacao_adicional']))) {
            $Dados['captacao_observacao_adicional'] = null;
        }

        if ($Dados['captacao_imovel_acesso_vigiado'] == 'não') {
            $Dados['captacao_imovel_tipo_servico_vigiado'] = null;
            $Dados['captacao_imovel_tipo_servico_vigiado_horario'] = null;
        }
        if ($Dados['captacao_imovel_registro_ocorrencia_local'] == 'não') {
            $Dados['captacao_imovel_descricao_ocorrencia_local'] = null;
        }
        if ($Dados['captacao_imovel_registro_ocorrencia_vizinhanca'] == 'não') {
            $Dados['captacao_imovel_descricao_ocorrencia_vizinhanca'] = null;
        }
        if ($Dados['captacao_aderencia_possui'] == 'sim') {
            $Dados['captacao_aderencia_motivo'] = null;
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
    case "DeleteCaptacao":
        $id_captacao = intval($Dados['id_captacao']);
        $cap = $captacao->selCaptacaoEDEDED($id_captacao);
        $captacao->deleteCaptacao($id_captacao);
        $captacao->insertCaptacaoDeletada($cap);
        $cap['id'] = $id_captacao;
        Funcoes::gerarLogCadastro($logs, "Exclusão Captação", $cap, 5);
        header("Location:../../../../index.php?pg=2#tabs-1");
        break;

        // DELETE ANEXOS:
    case "DeleteAnexos":
        $id_anexo = $Dados['id_anexo'];
        // seleciona o nome do arquivo;
        $anexo = $anexos->select($id_anexo);
        $pasta = '../../../../../_MIDIAS_/anexosContrato/clientes/' . $anexo['nome_anexo'];
        if (file_exists($pasta))
            unlink($pasta);
        $anexos->deleteAnexos($id_anexo);
        header("Location:../../../../index.php?pg=15&id={$Dados['id_cliente']}&id_cliente_contrato={$Dados['id']}#anexos");
        break;

        // ENVIAR CONTRATO :
    case "EnviarContrato":

        $id_contrato = isset($Dados['id_contrato']) ? intval($Dados['id_contrato']) : null;
        $id_cliente = isset($Dados['id_cliente']) ? intval($Dados['id_cliente']) : null;
        $clienteContrato = $cliente->selectClienteContrato($id_cliente);

        $data = array(
            'id_cliente' => intval($clienteContrato['id_cliente']),
            'id_usuario' => intval($clienteContrato['id_usuario']),
            'cliente_ra' => intval($clienteContrato['cliente_ra']),
            'tipo_contrato' => 'novo',
            'status_contrato' => 1,
            'observacoes_contrato' => 'ok',
            'data_contrato_gerado' => date("Y-m-d H:i:s"),
            'data_envio' => date("Y-m-d H:i:s")
        );

        if (empty($id_contrato)) {
            $Dados['id_contrato'] = $contrato->insert($data);
        } else {
            $id_captacao = intval($clienteContrato['id_captacao']);
            $data_updateContratos = [
                "id_contrato" => $id_contrato,
                "observacoes_contrato" => "ok",
                'data_envio' => date("Y-m-d H:i:s")
            ];

            $data_updateCaptacao = [
                'captacao_status' => 'finalizado',
                'captacao_id' => $id_captacao
            ];
            $contrato->updateContratos($data_updateContratos);
            $cliente->deleteCamposContratoReprovados($id_cliente);
            $cliente->updateStatusCadastro($id_cliente, 1);
            $captacao->updateCaptacao($data_updateCaptacao);
        }
        header("Location:../../../../index.php?pg=15#settings");
        break;

        //FINALIZA O CONTRATO:
    case "finalizarContrato":
        $id_usuario = $_SESSION['user_info']['id_usuario'];
        $id_cliente = $Dados['id_cliente'];
        $id_contrato = $Dados['id_contrato'];
        $cliente_ra = $Dados['cliente_ra'];
        unset($Dados['cliente_ra']);
        $Dados['danfe'] = 1;
        $Dados['cor_status'] = 'a_cor_cinza';
        $DadosContrato = $contrato->select($id_contrato);
        $Dados['status_contrato'] = 3;
        if (empty($DadosContrato['data_finalizacao_contrato'])) {
            $Dados['data_finalizacao_contrato'] = date("Y-m-d H:i:s");
        }
        $contrato->updateContratos($Dados);
        $cliente->updateCliente("clientes", array("id_cliente" => $cliente_ra, "status_cadastro" => 3));
        header("location: ../../../../index.php?pg=17");
        break;
    case "Agendar":
        $agenda = new AgendaContato;
        $agenda->selectAgendaProximaData($Dados['agenda_contato_proxima_data'], $Dados['agenda_contato_hora'], $Dados['agenda_contato_id_usuario']);
        $result = null;
        if ($agenda->Read()->getRowCount() >= 1) {
            $result = 2;
        } else {
            $Dados['agenda_contato_id'] = 0;
            $Dados['agenda_contato_proposta_id'] = (empty($Dados['agenda_contato_proposta_id'])) ? 0 : $Dados['agenda_contato_proposta_id'];
            $agenda->insertAgenda($Dados);
            $result = 1;
        }
        die(json_encode(array("type" => $result)));
        break;
    case "Reagendar":
        $agenda = new AgendaContato;
        $agenda->selectAgendaProximaData($Dados['agenda_contato_proxima_data'], $Dados['agenda_contato_hora'], $Dados['agenda_contato_id_usuario']);
        $result = null;
        if ($agenda->Read()->getRowCount() >= 1) {
            $result = 2;
        } else {
            $agenda->updateAgendaPorID(array("agenda_contato_status" => 1, "agenda_contato_id" => $Dados['agenda_contato_id']));
            $Dados['agenda_contato_id'] = 0;
            $Dados['agenda_contato_proposta_id'] = (empty($Dados['agenda_contato_proposta_id'])) ? 0 : $Dados['agenda_contato_proposta_id'];
            $agenda->insertAgenda($Dados);
            $result = 1;
        }
        die(json_encode(array("type" => $result)));
        break;
    case "cadastrarNivelCaptacao":
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
        $Dados['captacao_id'] = $Dados['id_captacao'];
        unset($Dados['id_captacao']);
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
        if (isset($nivelUsuario['captacao_niveis_usuarios_regra_id']) && !empty($nivelUsuario['captacao_niveis_usuarios_regra_id']))
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
        $relatorioCaptacao = new RelatorioCaptacao();
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
<th>Telefone</th>
<th>Status</th>
<th>Obs</th>
<th>Indicador</th>
</tr>
</thead>
<tbody>';
        foreach ($lista as $k => $dados) {
            $origem = !empty($dados['origem']) ? $dados['origem'] : "";
            $captacao_status = !empty($dados['captacao_status']) ? $dados['captacao_status'] : "";
            $captacao_cidade = !empty($dados['captacao_cidade']) ? $dados['captacao_cidade'] : "";
            $captacao_uf = !empty($dados['captacao_uf']) ? $dados['captacao_uf'] : "";
            $captacao_data_criacao = !empty($dados['captacao_data_criacao']) ? $dados['captacao_data_criacao'] : "";
            $nome_consultor = !empty($dados['nome_consultor']) ? $dados['nome_consultor'] : "";
            $captacao_cliente = !empty($dados['captacao_cliente']) ? $dados['captacao_cliente'] : "";
            $captacao_ddd = !empty($dados['captacao_ddd']) ? $dados['captacao_ddd'] : "";
            $captacao_nivel_prioridade = !empty($dados['captacao_nivel_prioridade']) ? $dados['captacao_nivel_prioridade'] : "";
            $usuarioCadastro = !empty($dados['usuarioCadastro']) ? $dados['usuarioCadastro'] : "";
            $captacao_servico = !empty($dados['captacao_interesse']) ? ucwords($dados['captacao_interesse']) : "";
            $captacao_indicador = !empty($dados['captacao_indicador']) ? ucwords($dados['captacao_indicador']) : "";
            $captacao_telefone1 = !empty($dados['captacao_telefone1']) ? ucwords($dados['captacao_telefone1']) : "";
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
    <td align='center'>" . $data . " " . $dataHora[1] . "</td>
    <td>" . utf8_encode($origem) . "</td>
    <td>" . utf8_encode($captacao_servico) . "</td>
    <td>" . utf8_encode($usuarioCadastro) . "</td>
    <td>" . utf8_encode($nome_consultor) . "</td>
    <td>" . utf8_encode($captacao_cliente) . "</td>
    <td>" . utf8_encode($cidade) . "</td>
    <td align='center'>" . $captacao_ddd . "</td>
    <td align='center'>" . $captacao_telefone1 . "</td>


    <td>" . ucwords($captacao_status) . "</td>
    <td>" . $motivo_finalizacao . "</td>
    <td>" . utf8_encode($captacao_indicador) . "</td>
    </tr>";
        }
        $html .= "</tbody></table>";
        Funcoes::exportExel($html, "Planilha_Captacaoes.xls");
        break;
    case "form_grupoVolpato":
        include_once("captacaoComplemento.php");
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
        // NSERIR CAPTACAO:
    case "InsertCaptacao":
        include_once("captacaoComplemento.php");
        break;

    case "cadastro_cliente_seguro":
        /*
       
        var_dump($Dados);
        die;*/

        $id_cliente = $Dados['CLIENTE']['id_cliente'];

        //CLIENTE:
        $cliente->updateCliente("clientes", $Dados['CLIENTE']);

        //CONTATO:
        if (
            !isset($Dados['CONTATO'][1]['nome_contato']) &&
            !isset($Dados['CONTATO'][1]['email_contato']) &&
            !isset($Dados['CONTATO'][1]['telefone1_contato']) &&
            !isset($Dados['CONTATO'][1]['telefone2_contato'])
        ) {
            unset($Dados['CONTATO'][1]);
        }

        $cliente->selecContatoCliente("contato_cliente", $Dados['CLIENTE']['id_cliente']);
        $total = $cliente->Read()->getRowCount();

        if ($total >= 1) :
            $cliente->updateContatoCliente('contato_cliente', $Dados['CONTATO']);
        else :
            $cliente->insertContatoCliente("contato_cliente", $Dados['CONTATO']);
        endif;

        header("Location:../../../../index.php?pg=15&id=" . $Dados['id'] . "&id_cliente_contrato=" . $id_cliente);
        break;

    case "insert_veiculo_seguro":
        $Dados['cliente_ra'] = $Dados['id_cliente'];
        $Dados['id_cliente'] = $Dados['id_cliente'];
        $Dados['taxa_instalacao'] = !empty($Dados['taxa_instalacao']) ? floatval(Funcoes::formataMoedaSql($Dados['taxa_instalacao'])) : 0.0;
        $Dados['valor_locacao_equipamento'] = !empty($Dados['valor_locacao_equipamento']) ? floatval(Funcoes::formataMoedaSql($Dados['valor_locacao_equipamento'])) : 0.0;
        $Dados['valor_aluguel_software_rastreamento'] = !empty($Dados['valor_aluguel_software_rastreamento']) ? floatval(Funcoes::formataMoedaSql($Dados['valor_aluguel_software_rastreamento'])) : 0.0;
        $Dados['valor_servico_contratado'] = !empty($Dados['valor_servico_contratado']) ? floatval(Funcoes::formataMoedaSql($Dados['valor_servico_contratado'])) : 0.0;
        $Dados['valor_mensal'] = !empty($Dados['valor_mensal']) ? floatval(Funcoes::formataMoedaSql($Dados['valor_mensal'])) : 0.0;

        $Dados['placa'] = strtoupper($Dados['placa']);
        $ultimoId = $veiculo->insert($Dados);
        header("Location: ../../../../index.php?pg=15&id={$id}&tipoCadastro=VENDA&id_cliente_contrato={$Dados['id_cliente']}#veiculos");
        break;

    case "edit_veiculo_seguro":
        $id_veiculo = $Dados['id_veiculo'];
        $id = $Dados['id_cliente'];

        $Dados['valor_locacao_equipamento'] = Funcoes::formataMoedaSql($Dados['valor_locacao_equipamento']);
        $Dados['valor_aluguel_software_rastreamento'] = Funcoes::formataMoedaSql($Dados['valor_aluguel_software_rastreamento']);
        $Dados['valor_servico_contratado'] = Funcoes::formataMoedaSql($Dados['valor_servico_contratado']);
        $Dados['valor_mensal'] = Funcoes::formataMoedaSql($Dados['valor_mensal']);
        $Dados['taxa_instalacao'] = Funcoes::formataMoedaSql($Dados['taxa_instalacao']);

        if ($veiculo->updateVeiculo($Dados)) {
            header("Location: ../../../../index.php?pg=15&id={$id}&id_cliente_contrato={$id}#veiculos");
        } else {
            die('Não foi possivel atualizar este veiculos, por favor contacte a TI :(');
        }

        break;

endswitch;
