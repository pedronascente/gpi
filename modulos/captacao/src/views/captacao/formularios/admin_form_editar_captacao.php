<?php
$dados = filter_input_array(INPUT_POST);
$id_captacao = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$tp = filter_input(INPUT_GET, 'tp', FILTER_VALIDATE_INT);
$id_cpv = filter_input(INPUT_GET, 'id_cpv', FILTER_VALIDATE_INT);
$acaoSessao = (isset($_GET['acao'])) ? $_SESSION['acao'] = $_GET['acao'] : (isset($_SESSION['acao']) ? $_SESSION['acao'] : null);
$_SESSION['acao'] = '';
$error = NULL;
$cpv_descricao_veiculo = null;
$cpv_qtd_veiculo = null;
$objeto_captacao = new Captacao;
//RESPONSAVEL POR LISTAR DADOS DO CLIENTE
$captacao = $objeto_captacao->selCaptacao($id_captacao);
$captacao_cliente = isset($captacao ['captacao_cliente']) ? $captacao ['captacao_cliente'] : NULL;
$captacao_nivel_prioridade = isset($captacao ['captacao_nivel_prioridade']) ? $captacao ['captacao_nivel_prioridade'] : NULL;
$captacao_email = isset($captacao ['captacao_email']) ? $captacao ['captacao_email'] : NULL;
$captacao_endereco = isset($captacao ['captacao_endereco']) ? $captacao ['captacao_endereco'] : NULL;
$captacao_numero = isset($captacao ['captacao_numero']) ? $captacao ['captacao_numero'] : NULL;
$captacao_complemento = isset($captacao ['captacao_complemento']) ? $captacao ['captacao_complemento'] : NULL;
$captacao_bairro = isset($captacao ['captacao_bairro']) ? $captacao ['captacao_bairro'] : NULL;
$captacao_uf = isset($captacao ['captacao_uf']) ? $captacao ['captacao_uf'] : NULL;
$captacao_cidade = isset($captacao ['captacao_cidade']) ? $captacao ['captacao_cidade'] : NULL;
$captacao_cep = isset($captacao ['captacao_cep']) ? $captacao ['captacao_cep'] : NULL;
$captacao_telefone1 = isset($captacao ['captacao_telefone1']) ? $captacao ['captacao_telefone1'] : NULL;
$captacao_telefone2 = isset($captacao ['captacao_telefone2']) ? $captacao ['captacao_telefone2'] : NULL;
$captacao_telefone3 = isset($captacao ['captacao_telefone3']) ? $captacao ['captacao_telefone3'] : NULL;
$captacao_operadora1 = isset($captacao ['captacao_operadora1']) ? $captacao ['captacao_operadora1'] : NULL;
$captacao_operadora2 = isset($captacao ['captacao_operadora2']) ? $captacao ['captacao_operadora2'] : NULL;
$captacao_operadora3 = isset($captacao ['captacao_operadora3']) ? $captacao ['captacao_operadora3'] : NULL;
$captacao_interesse = isset($captacao ['interesse']) ? $captacao ['interesse'] : NULL;
$captacao_indicador = isset($captacao ['captacao_indicador']) ? $captacao ['captacao_indicador'] : NULL;
$captacao_vendedor = isset($captacao ['vendedor']) ? $captacao ['vendedor'] : NULL;
$captacao_cadastro = isset($captacao ['cadastro']) ? $captacao ['cadastro'] : NULL;
$captacao_hora_fora_horario = isset($captacao ['captacao_hora_fora_horario']) ? $captacao ['captacao_hora_fora_horario'] : NULL;
$motivo_finalizacao = isset($captacao ['motivo_finalizacao']) ? $captacao ['motivo_finalizacao'] : NULL;
$captacao_obs = isset($captacao ['captacao_obs']) ? $captacao ['captacao_obs'] : NULL;
$captacao_status = isset($captacao ['captacao_status']) ? ucwords(str_replace("_", " ", $captacao ['captacao_status'])) : NULL;
$captacao_data_nascimento = isset($captacao ['captacao_data_nascimento']) ? $captacao ['captacao_data_nascimento'] : NULL;
$captacao_data_criacao = isset($captacao ['captacao_data_criacao']) ? $captacao ['captacao_data_criacao'] : NULL;
$captacao_responsavel = isset($captacao ['captacao_responsavel']) ? $captacao ['captacao_responsavel'] : NULL;
$captacao_ja_e_cliente = isset($captacao ['captacao_ja_e_cliente']) ? $captacao ['captacao_ja_e_cliente'] : NULL;
$captacao_data_nascimento = isset($captacao ['captacao_data_nascimento']) ? $captacao ['captacao_data_nascimento'] : NULL;
$captacao_tipo_servico = isset($captacao ['captacao_tipo_servico']) ? $captacao ['captacao_tipo_servico'] : NULL;
$captacao_imovel_acesso_vigiado = isset($captacao ['captacao_imovel_acesso_vigiado']) ? $captacao ['captacao_imovel_acesso_vigiado'] : NULL;
$captacao_imovel_tipo_imovel = isset($captacao ['captacao_imovel_tipo_imovel']) ? $captacao ['captacao_imovel_tipo_imovel'] : NULL;
$captacao_imovel_atividade_principal = isset($captacao ['captacao_imovel_atividade_principal']) ? $captacao ['captacao_imovel_atividade_principal'] : NULL;
$captacao_imovel_ao_lado_de = isset($captacao ['captacao_imovel_ao_lado_de']) ? $captacao ['captacao_imovel_ao_lado_de'] : NULL;
$captacao_imovel_metragem = isset($captacao ['captacao_imovel_metragem']) ? $captacao ['captacao_imovel_metragem'] : NULL;
$captacao_imovel_area = isset($captacao ['captacao_imovel_area']) ? $captacao ['captacao_imovel_area'] : NULL;
$captacao_imovel_pisos = isset($captacao ['captacao_imovel_pisos']) ? $captacao ['captacao_imovel_pisos'] : NULL;
$captacao_imovel_descricao_da_ares = isset($captacao ['captacao_imovel_descricao_da_ares']) ? $captacao ['captacao_imovel_descricao_da_ares'] : NULL;
$captacao_imovel_estado = isset($captacao ['captacao_imovel_estado']) ? $captacao ['captacao_imovel_estado'] : NULL;
$captacao_imovel_acesso_vigiado = isset($captacao ['captacao_imovel_acesso_vigiado']) ? $captacao ['captacao_imovel_acesso_vigiado'] : NULL;

$captacao_observacao_adicional = isset($captacao ['captacao_observacao_adicional']) ? $captacao ['captacao_observacao_adicional'] : NULL;

$captacao_imovel_registro_ocorrencia_local = isset($captacao ['captacao_imovel_registro_ocorrencia_local']) ? $captacao ['captacao_imovel_registro_ocorrencia_local'] : NULL;
$captacao_imovel_descricao_ocorrencia_local = isset($captacao ['captacao_imovel_descricao_ocorrencia_local']) ? $captacao ['captacao_imovel_descricao_ocorrencia_local'] : NULL;
$captacao_imovel_registro_ocorrencia_vizinhanca = isset($captacao ['captacao_imovel_registro_ocorrencia_vizinhanca']) ? $captacao ['captacao_imovel_registro_ocorrencia_vizinhanca'] : NULL;
$captacao_imovel_descricao_ocorrencia_vizinhanca = isset($captacao ['captacao_imovel_descricao_ocorrencia_vizinhanca']) ? $captacao ['captacao_imovel_descricao_ocorrencia_vizinhanca'] : NULL;
$captacao_aderencia_possui = isset($captacao ['captacao_aderencia_possui']) ? $captacao ['captacao_aderencia_possui'] : NULL;
$captacao_aderencia_motivo = isset($captacao ['captacao_aderencia_motivo']) ? $captacao ['captacao_aderencia_motivo'] : NULL;
$captacao_data_agenda = isset($captacao ['captacao_data_agenda']) ? $captacao ['captacao_data_agenda'] : NULL;
$captacao_consultor = isset($captacao ['captacao_consultor']) ? $captacao ['captacao_consultor'] : NULL;
$captacao_tipo_de_cliente = isset($captacao ['captacao_tipo_de_cliente']) ? $captacao ['captacao_tipo_de_cliente'] : NULL;
if ($captacao_data_criacao) {
    $formatar_data = explode(' ', $captacao_data_criacao);
    $data_cadastro = date('d/m/Y', strtotime($formatar_data[0]));
    $horario = $formatar_data[1];
}
$vendedor = 'sim';
?>
<ul class="nav nav-tabs">
    <li><a data-toggle="tab " href="#tabs-1">Editar Captação</a></li>
</ul>
<div id="my-tab-content" class="tab-content">
    <div id="tabs-1" class="tab-pane fade active">
        <div class="panel panel-info">
            <div class="panel-body">         
                <?php
                if (!empty($captacao)) {
                    if ($captacao['captacao_formulario'] == 'formulario_a') {
                        include_once 'frm_edit_formulario_a.php';
                    } else {
                        include_once 'frm_edit_formulario_b.php';
                    }
                } else {
                    echo '<div class="alert alert-warning"><span class="glyphicon  glyphicon-alert"></span>  Nenhum registro encontrado.</div>';
                }
                ?>
            </div>
        </div>
    </div>
