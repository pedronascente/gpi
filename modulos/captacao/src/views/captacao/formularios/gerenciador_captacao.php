<?php
// namespace C:\wamp\www\gpi\modulos\captacao\src\views\captacao\formularios\gerenciador_captacao.php
$dados = filter_input_array(INPUT_POST);
$id_captacao = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$tp = filter_input(INPUT_GET, 'tp', FILTER_VALIDATE_INT);
$id_cpv = filter_input(INPUT_GET, 'id_cpv', FILTER_VALIDATE_INT);
$acaoSessao = (isset($_GET['acao'])) ? $_SESSION['acao'] = $_GET['acao'] : (isset($_SESSION['acao']) ? $_SESSION['acao'] : null);
$_SESSION['acao'] = '';
$error = NULL;
$cpv_descricao_veiculo = null;
$cpv_qtd_veiculo = null;
$agendaContato = new AgendaContato;
$objeto_captacao = new Captacao;
//RESPONSAVEL POR LISTAR DADOS DO CLIENTE :
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
$captacao_status = isset($captacao ['captacao_status']) ?  ucwords(str_replace("_", " ", $captacao ['captacao_status'])) : NULL;
$captacao_data_nascimento = isset($captacao ['captacao_data_nascimento']) ? $captacao ['captacao_data_nascimento'] : NULL;
$captacao_data_criacao= isset($captacao ['captacao_data_criacao'])?$captacao ['captacao_data_criacao']:NULL;
$captacao_pendencias_financeiras= isset($captacao ['captacao_pendencias_financeiras'])?$captacao ['captacao_pendencias_financeiras']:NULL;
$captacao_cliente_desde = isset($captacao ['captacao_cliente_desde '])?$captacao ['captacao_cliente_desde ']:NULL;
$captacao_imovel_registro_ocorrencia_local  = isset($captacao ['captacao_imovel_registro_ocorrencia_local'])?$captacao ['captacao_imovel_registro_ocorrencia_local']:NULL;
$captacao_imovel_descricao_ocorrencia_local  = isset($captacao ['captacao_imovel_descricao_ocorrencia_local'])?$captacao ['captacao_imovel_descricao_ocorrencia_local']:NULL;
$captacao_imovel_registro_ocorrencia_vizinhanca = isset($captacao ['captacao_imovel_registro_ocorrencia_vizinhanca'])?$captacao ['captacao_imovel_registro_ocorrencia_vizinhanca']:NULL;
$captacao_imovel_descricao_ocorrencia_vizinhanca  = isset($captacao ['captacao_imovel_descricao_ocorrencia_vizinhanca'])?$captacao ['captacao_imovel_descricao_ocorrencia_vizinhanca']:NULL;
$captacao_imovel_tipo_imovel = isset($captacao ['captacao_imovel_tipo_imovel'])?$captacao ['captacao_imovel_tipo_imovel']:NULL;
$captacao_imovel_atividade_principal = isset($captacao ['captacao_imovel_atividade_principal'])?$captacao ['captacao_imovel_atividade_principal']:NULL;
$captacao_imovel_descricao_da_ares  = isset($captacao ['captacao_imovel_descricao_da_ares'])?$captacao ['captacao_imovel_descricao_da_ares']:NULL;
$captacao_imovel_acesso_vigiado = isset($captacao ['captacao_imovel_acesso_vigiado'])?$captacao ['captacao_imovel_acesso_vigiado']:NULL;
$captacao_acoes = isset($captacao ['captacao_acoes'])?$captacao ['captacao_acoes']:NULL;
$captacao_responsavel = isset($captacao ['captacao_responsavel'])?$captacao ['captacao_responsavel']:NULL;
$captacao_ja_e_cliente = isset($captacao ['captacao_ja_e_cliente'])?$captacao ['captacao_ja_e_cliente']:NULL;
$captacao_tipo_servico = isset($captacao ['captacao_tipo_servico'])?$captacao ['captacao_tipo_servico']:NULL;
$captacao_tipo_servico_desc_outros = isset($captacao ['captacao_tipo_servico_desc_outros'])?$captacao ['captacao_tipo_servico_desc_outros']:NULL;
$captacao_conceito  = isset($captacao ['captacao_conceito'])?$captacao ['captacao_conceito']:NULL;
$captacao_imovel_ao_lado_de = isset($captacao ['captacao_imovel_ao_lado_de'])?$captacao ['captacao_imovel_ao_lado_de']:NULL;
$captacao_imovel_metragem  = isset($captacao ['captacao_imovel_metragem'])?$captacao ['captacao_imovel_metragem']:NULL;
$captacao_imovel_area  = isset($captacao ['captacao_imovel_area'])?$captacao ['captacao_imovel_area']:NULL;
$captacao_imovel_estado  = isset($captacao ['captacao_imovel_estado'])?$captacao ['captacao_imovel_estado']:NULL;
$captacao_imovel_pisos = isset($captacao ['captacao_imovel_pisos'])?$captacao ['captacao_imovel_pisos']:NULL;
$captacao_localizacao_do_servico_atual = isset($captacao ['captacao_localizacao_do_servico_atual'])?$captacao ['captacao_localizacao_do_servico_atual']:NULL;
$captacao_tipo_de_cliente  = isset($captacao ['captacao_tipo_de_cliente'])?$captacao ['captacao_tipo_de_cliente']:NULL;
$captacao_imovel_tipo_servico_vigiado = isset($captacao ['captacao_imovel_tipo_servico_vigiado'])?$captacao ['captacao_imovel_tipo_servico_vigiado']:NULL;
$captacao_imovel_tipo_servico_vigiado_horario = isset($captacao ['captacao_imovel_tipo_servico_vigiado_horario'])?$captacao ['captacao_imovel_tipo_servico_vigiado_horario']:NULL;
$captacao_aderencia_possui = isset($captacao ['captacao_aderencia_possui'])?$captacao ['captacao_aderencia_possui']:NULL;
$captacao_aderencia_motivo = isset($captacao ['captacao_aderencia_motivo'])?$captacao ['captacao_aderencia_motivo']:NULL;
$captacao_data_agenda = isset($captacao ['captacao_data_agenda'])?$captacao ['captacao_data_agenda']:NULL;
$captacao_consultor = isset($captacao ['captacao_consultor'])?$captacao ['captacao_consultor']:NULL;
$captacao_quem_cadastro = isset($captacao ['cadastro']) ? $captacao ['cadastro'] : NULL;
$captacao_origem = isset($captacao ['origem'])?$captacao ['origem']:NULL;
$captacao_indicador = isset($captacao ['captacao_indicador'])?$captacao ['captacao_indicador']:NULL;



if($captacao_data_criacao){
    $formatar_data = explode(' ', $captacao_data_criacao );
    $data_cadastro = date('d/m/Y',  strtotime($formatar_data[0]));
    $horario = $formatar_data[1];
}
$vendedor = 'sim';
?>
<ul class="nav nav-tabs">
    <li><a data-toggle="tab" href="#tabs-1"><?=($_GET['acao']=='editar')?"Editar Captação":" Dados Cliente";?></a></li>
    <li><a data-toggle="tab" href="#tabs-2">Proposta Comercial</a></li>
    <li><a data-toggle="tab" href="#tabs-3">Histórico Agenda</a></li>
</ul>
<div id="my-tab-content" class="tab-content">
    <div id="tabs-1" class="tab-pane fade">
        <div class="panel panel-info">
            <div class="panel-body">  
                <?php
                     if(!empty($captacao)){
                        if(isset($_GET['acao']) && $_GET['acao']=='visualizar' ){
                            if($captacao['captacao_formulario']=='formulario_a'){ 
                                include_once 'visualizar_dados_formulario_a.php';
                            } else{ 
                                include_once 'visualizar_dados_formulario_b.php';
                            }
                        }else if(isset($_GET['acao']) && $_GET['acao']=='editar' ){
                            if($captacao['captacao_formulario']=='formulario_a'){ 
                              include_once 'frm_edit_formulario_a.php';
                            } else{ 
                                include_once 'frm_edit_formulario_b.php';
                            }
                        }  
                    }else{
                        echo '<div class="alert alert-warning"><span class="glyphicon  glyphicon-alert"></span>  Nenhum registro encontrado.</div>';
                    }                                  
                ?>
            </div>
        </div>
    </div>
    <div id="tabs-2" class="tab-pane fade">
        <div class="panel panel-info">
            <div class="panel-body">
                <?php   include_once ("frm_enviarProposta.php");?>
            </div>
        </div>
    </div>
    <div id="tabs-3" class="tab-pane fade">
        <div class="panel panel-info">
            <div class="panel-body">
                <?php
                //RETORNA O TOTAL DE REGISTRO NO BANCO.
                $agendaContato->selectPorCaptacao(array("id_captacao" => $id_captacao));
                $totalPaginacao = $agendaContato->Read()->getRowCount();
                //REALIZA PAGINAÇÃO.
                $objPaginacao = new paginacao(10, $totalPaginacao, PAG, 10);
                $objPaginacao->_pagina = PAGINA . "&id={$id_captacao}";
                $objPaginacao->setTabs("#tabs-3");
                $limite = $objPaginacao->limit();
                //RESPONSAVEL POR LISTAR O HISTORICO DOS AGENDAMENTOS DA CAPTAÇÃO :
                $lista_historico = $agendaContato->selectPorCaptacao(array("id_captacao" => $id_captacao, "limite" => $limite));
                $total = $agendaContato->Read()->getRowCount();
                $a = !empty($acaoSessao) ? "visualizar" : "";
                if (!empty($lista_historico)) :
                    ?>
                    <table class="table table-bordered table-hover table-striped">
                        <tr>
                            <th>Data Criação</th>
                            <th>Data Agendada</th>
                            <th>Cliente</th>
                            <th>Motivo</th>
                            <th>Situação</th>
                            <th width="2%">Ação</th>
                        </tr>
                        <tbody align="center">
                            <?php
                            foreach ($lista_historico as $k => $list) {
                                $situacao = $list['agenda_contato_status'] == 1 ? "Finalizado" : "Aberto";
                                $data_criacao = !empty($list ['agenda_contato_data_criacao']) ? Funcoes::formataData($list ['agenda_contato_data_criacao'])  : "";
                                $data_agendada = !empty($list ['agenda_contato_proxima_data']) ? Funcoes::formataData($list ['agenda_contato_proxima_data']) . " " . $list['agenda_contato_hora'] : "";
                                $cor = $list['agenda_contato_status'] != 1 ? 'style="color:#F00"' : null;
                                $cliente = $list['agenda_contato_cliente'] == " " || empty($list['agenda_contato_cliente']) ?  $list['captacao_cliente'] : $list['agenda_contato_cliente'];
                                ?>
                                <tr>
                                    <td <?= $cor; ?>><?= $data_criacao; ?></td>
                                    <td <?= $cor; ?>><?= $data_agendada; ?></td>
                                    <td <?= $cor; ?>><?= $cliente ?></td>
                                    <td <?= $cor; ?>><?= $list['agenda_contato_motivo']; ?></td>
                                    <td <?= $cor; ?>><?= $situacao; ?></td>
                                    <td align="center">
                                        <a id="modulos/captacao/src/views/captacao/formularios/modal_captacaoAgenda.php?agenda_contato_id=<?= $list['agenda_contato_id']; ?>&id_captacao=<?= $list['agenda_contato_captacao_id']; ?>&acaoTela=<?=$a;?>&acao=<?=$acaoSessao;?>" class="botaoLoad modalOpen btn btn-sm btn-success" data-target="#modal"> 
                                            <span class="glyphicon glyphicon-eye-open"></span>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr><td colspan="6">(<?= $total; ?>) Registros encontrados</td></tr>
                        </tfoot>
                    </table>
                    <?php
                    $objPaginacao->MontaPaginacao();
                else :
                    Funcoes::Nregistro();
                endif;
                ?>
            </div>
        </div>
    </div>
</div>