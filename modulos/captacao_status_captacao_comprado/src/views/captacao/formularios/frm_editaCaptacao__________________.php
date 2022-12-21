<?php
// namespace C:\wamp\www\gpi\modulos\captacao\src\views\captacao\formularios\frm_editaCaptacao.php
//DADOS DO FORMULARIO [form_envia_proposta]
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
// pega o tipo de proposta;
$tipoProposta = $objeto_captacao->setTipoProposta($id_captacao);
$id_proposta = isset($tipoProposta ['proposta_id']) ? $tipoProposta ['proposta_id'] : '';
$tipoProposta = isset($tipoProposta ['proposta_tipo_proposta']) ? $tipoProposta ['proposta_tipo_proposta'] : "";
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
$captacao_status = isset($captacao ['captacao_status']) ?  ucwords(str_replace("_", " ", $captacao ['captacao_status'])) : NULL;
?>
<ul class="nav nav-tabs">
    <li><a data-toggle="tab" href="#tabs-1">Dados Cliente</a></li>
    <?php if ($acaoSessao != 'visualizar' && $acaoSessao != 'relatorio') { ?>
    <li><a data-toggle="tab" href="#tabs-2">Proposta Comercial</a></li>
    <?php }?>
    <li><a data-toggle="tab" href="#tabs-3">Histórico Agenda</a></li>
</ul>
<div id="my-tab-content" class="tab-content">
    <div id="tabs-1" class="tab-pane fade">
        <div class="panel panel-info">
            <div class="panel-body">
                <form action="modulos/captacao/src/controllers/captacao.php" method="post">
                    <div class="row">
                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Nivel de Prioridade:</label>
                                <input type="text" name="captacao_nivel_prioridade" value="<?= ucfirst($captacao_nivel_prioridade); ?>" class="form-control" disabled />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Status da Captação:</label>
                                <input type="text" name="captacao_status" value="<?= ucfirst($captacao_status); ?>" class="form-control" disabled />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Horário de Atendimento:</label>
                                <input type="text" name="captacao_hora_fora_horario" id="captacao_hora_fora_horario" value="<?= ucfirst($captacao_hora_fora_horario); ?>" class="form-control mask_hora" disabled="disabled"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Interesse:</label>
                                <input name="captacao_interesse" type="text" class="form-control" id="captacao_interesse" value="<?= ucfirst($captacao_interesse); ?>" disabled="disabled"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Indicador:</label>
                                <input name="captacao_indicador" type="text" class="form-control" id="captacao_indicador" value="<?= ucfirst($captacao_indicador); ?>" disabled="disabled"/>
                            </div>
                        </div>
                    </div>
                    <?php if ($acaoSessao == 'relatorio') { ?>
                    	<div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Origem:</label>
                                <input type="text"  value="<?=$captacao_cadastro;?>" class="form-control" required/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Vendedor:</label>
                                <input type="text"  value="<?=$captacao_vendedor;?>" class="form-control" required/>
                            </div>
                        </div>
                       </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Nome/Razão Social:</label>
                                <input type="text" name="captacao_cliente" value="<?= $captacao_cliente; ?>" class="form-control" required/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>E-mail:</label>
                                <input type="text" name="captacao_email" value="<?= $captacao_email; ?>" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-2  col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>CEP:</label>
                                <div class="input-group">
                                    <input type="text" name="captacao_cep" id="captacao_cep" class="mask_cep _cep form-control" placeholder="CEP" value="<?= $captacao_cep; ?>" />
                                    <div class="input-group-btn buscaCEP">
                                        <a href="javascript:void(0)" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </a>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="col-xs-12 col-sm-1  col-md-1 col-lg-1">
                            <div class="form-group">
                                <label>UF:</label>
                                <input type="text" name="captacao_uf" id="captacao_uf" class="form-control mask_uf  _uf" value="<?= $captacao_uf; ?>" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Cidade:</label>
                                <input type="text" name="captacao_cidade" id="captacao_cidade" class="_cidade form-control" value="<?= $captacao_cidade; ?>" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6  col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Bairro:</label>
                                <input type="text" name="captacao_bairro" id="captacao_bairro" value="<?= $captacao_bairro; ?>" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Endereço:</label>
                                <input type="text" name="captacao_endereco" value="<?= $captacao_endereco; ?>" class="form-control" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                            <div class="form-group">
                                <label>N°:</label>
                                <input type="text" name="captacao_numero" id="captacao_numero" value="<?= $captacao_numero; ?>" class="form-control" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                            <div class="form-group">
                                <label>Complemento:</label>
                                <input type="text" name="captacao_complemento" id="captacao_complemento" value="<?= $captacao_complemento; ?>" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Telefone(1):</label>
                                <input type="text" name="captacao_telefone1" id="captacao_telefone1" value="<?= $captacao_telefone1 ?>" class="form-control mask_telefone" required/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Operadora(1):</label>
                                <?= captacao_operadora($captacao_operadora1, "captacao_operadora1"); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Telefone(2):</label>
                                <input type="text" name="captacao_telefone2" id="captacao_telefone2" value="<?= $captacao_telefone2; ?>" class="form-control mask_telefone" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Operadora(2):</label>
                                <?= captacao_operadora($captacao_operadora2, "captacao_operadora2"); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Telefone(3):</label>
                                <input type="text" name="captacao_telefone3" id="captacao_telefone3" value="<?= $captacao_telefone3; ?>" class="form-control mask_telefone" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Operadora(3):</label>
                                <?= captacao_operadora($captacao_operadora3, "captacao_operadora3"); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Observações:</label>
                                <textarea name="captacao_obs" id="captacao_obs"  class="form-control"><?= $captacao_obs; ?></textarea>
                            </div>
                        </div>
                        <?php if (isset($motivo_finalizacao) && $motivo_finalizacao !== 'off') { ?>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Motivo:</label>
                                    <textarea name="motivo_finalizacao" id="motivo_finalizacao"  class="form-control" disabled><?= $motivo_finalizacao; ?></textarea> 
                                </div>
                            </div>
                        <?php } ?>   
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-actions">
                                <input type="hidden" name="acao" value="editaCaptacao"> 
                                <input type="hidden" name="captacao_id" value="<?= $id_captacao; ?>"> 
                                <?php 
                                    if($acaoSessao != 'relatorio' && $acaoSessao != 'auditoria') {?>
                                        <button type="submit" class="btn btn-primary "> Salvar</button><?php 
                                        if ($acaoSessao != 'visualizar' && $acaoSessao != 'auditoria') { ?>
                                            <a id="modulos/captacao/src/views/captacao/formularios/modal_ConsultaCliente.php?id=<?= $id_captacao; ?>&acao=modal" class="botaoLoad modalOpen btn btn-default" title="Consultar SPC/SERASA" data-target="#modal"> Consultar </a>
                                            <a id="modulos/captacao/src/views/captacao/formularios/modal_captacaoAgenda.php?id_captacao=<?= $id_captacao; ?>" class="botaoLoad modalOpen btn btn-default" title="Agendar um novo contato" data-target="#modal">Agenda</a>
                                            <a id="modulos/captacao/src/views/captacao/formularios/modal_statusCaptacao.php?id_captacao=<?= $id_captacao; ?>" class="botaoLoad modalOpen btn btn-default" title="Alterar Status captação" data-target="#modal">Status </a>
                                            <?php 
                                        } 
                                    }
                                    $pagina = '18';
                                    switch ($acaoSessao){
                                        case "visualizar": $pagina = 2;  break;
                                        case "auditoria":  $pagina = 52;  break;
                                        case "relatorio": $pagina = "44&id=".filter_input(INPUT_GET, "id_cliente_relatorio")."#contrato";break;
                                    }
                                 ?>
                                 <a href="index.php?pg=<?= $pagina; ?>" class="btn btn-info"  title="Voltar" > Voltar </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php if ($acaoSessao != 'visualizar') { ?>
        <div id="tabs-2" class="tab-pane fade">
            <div class="panel panel-info">
                <div class="panel-body">
                    <?php
                    //MONTAR PROPOSTA 
                    include_once ("frm_enviarProposta.php");
                    ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <div id="tabs-3" class="tab-pane fade">
        <div class="panel panel-info">
            <div class="panel-body">
                <?php
                /*
                 * ********************************************************
                 * ********* RETORNA O TOTAL DE REGISTRO NO BANCO. ********
                 * ********************************************************
                 */
                $agendaContato->selectPorCaptacao(array("id_captacao" => $id_captacao));
                $totalPaginacao = $agendaContato->Read()->getRowCount();
                /*
                 * *************************************
                 * ********* REALIZA PAGINAÇÃO. ********
                 * *************************************
                 */
                $objPaginacao = new paginacao(10, $totalPaginacao, PAG, 10);
                $objPaginacao->_pagina = PAGINA . "&id={$id_captacao}";
                $objPaginacao->setTabs("#tabs-3");
                $limite = $objPaginacao->limit();
                /*
                 * ************************************************************************************
                 * ********* RESPONSAVEL POR LISTAR O HISTORICO DOS AGENDAMENTOS DA CAPTAÇÃO **********
                 * ************************************************************************************
                 */
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