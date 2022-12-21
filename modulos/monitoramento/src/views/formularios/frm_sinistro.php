<form method="POST" action="modulos/monitoramento/src/controllers/monitoramento.php">
    <div class="panel panel-info">
        <div class="panel-heading">Dados Cliente</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-lg-3 col-sm-8 col-md-6">
                    <div class="form-group">
                        <label>Coordenador:</label>
                        <input type="text" name="sinistro_coordenador" class="form-control" value="<?= $monitoramento->get("sinistro_coordenador"); ?>" <?= Funcoes::Disable($acao); ?> required="required"> 
                    </div>
                </div>
                <div class="col-xs-12 col-lg-3 col-sm-8 col-md-6">
                    <div class="form-group">
                        <label>Operador:</label>
                        <input type="text" class="form-control" required="required" value="<?= $monitoramento->get("a_nome_responsavel") == null ? $_SESSION['user_info']['nome'] : $monitoramento->get("a_nome_responsavel"); ?>" disabled="disabled">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-lg-3 col-sm-8 col-md-6">
                    <div class="form-group">
                        <label>Telefone:</label>
                        <input type="text" name="sinistro_telefone" class="form-control mask_telefone" value="<?= $monitoramento->get("sinistro_telefone"); ?>" <?= Funcoes::Disable($acao); ?> required="required">
                    </div>
                </div>
            </div>
            <?php if ($monitoramento->get("sinistro_id") == null) { ?>
                <div id="veiculo">
                    <div class="row">
                        <div class="col-xs-12 col-lg-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Busca Placa:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="placaVeiculoBusca">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" id="buscarVeiculo"><span class="glyphicon glyphicon-search"></span></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-lg-6 col-sm-6 col-md-6" id="naoEncontradoV" style="display:none;">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label class="checkbox"><input type="checkbox" value="1" id="veiculoNaoEncontrado"><strong>Veículo Não Foi Encontrado?</strong></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-lg-6 col-sm-6 col-md-6" id="veiculoMensagem" style="display:none;">
                            <div class="well well-sm"><strong>Nenhum veículo foi encontrado!</strong></div>
                        </div>
                    </div>
                    <div class="row" id="mostraVeiculos" style="display:none;">
                        <div class="col-xs-12 col-lg-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="form-control" name="dados" id="veiculos" size="5" required="required">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="cliente" style="display:none;">
                    <div class="row">
                        <div class="col-xs-12 col-lg-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Busca Cliente:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nomeBuscaCliente">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" id="buscarCliente"><span class="glyphicon glyphicon-search"></span></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-lg-6 col-sm-6 col-md-6" id="naoEncontrado" style="display:none;">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label class="checkbox"><input type="checkbox" value="1" id="clienteNaoEncontrado"><strong>Cliente Não Foi Encontrado?</strong></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-lg-6 col-sm-6 col-md-6" id="cadastroCliente" style="display:none;">
                            <div class="form-group">
                                <label>Adicionar Novo Cliente:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nomeCliente">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" type="button" id="btnCadastrarCliente">Adicionar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-lg-6 col-sm-6 col-md-6" id="clienteMensagem" style="display:none;">
                            <div class="well well-sm"><strong>Nenhum cliente foi encontrado!</strong></div>
                        </div>
                    </div>
                    <div class="row" id="mostraClientes" style="display:none;">
                        <div class="col-xs-12 col-lg-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="form-control" id="clientes" size="5">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-primary" id="cadastroVeiculo" style="display:none;">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12 col-lg-3 col-sm-8 col-md-4">
                                    <div class="form-group">
                                        <label>Placa:</label>
                                        <input type="text" class="form-control mask_placa" id="placaVeiculo">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-3 col-sm-8 col-md-4">
                                    <div class="form-group">
                                        <label>Modelo:</label>
                                        <input type="text" class="form-control" id="modeloVeiculo">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-lg-3 col-sm-8 col-md-4">
                                    <div class="form-group">
                                        <label>Marca:</label>
                                        <input type="text" class="form-control" id="marcaVeiculo">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-2 col-sm-8 col-md-2">
                                    <div class="form-group">
                                        <label>Cor:</label>
                                        <input type="text" class="form-control" id="corVeiculo">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-1 col-sm-8 col-md-2">
                                    <div class="form-group">
                                        <label>Ano:</label>
                                        <input type="text" class="form-control" id="anoVeiculo">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-lg-3 col-sm-8 col-md-4">
                                    <div class="form-actions">
                                        <a class="btn btn-primary" id="btnCadastrarVeiculo">Salvar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col-xs-12 col-lg-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>Cliente:</label>
                            <input type="text" class="form-control" value="<?= $monitoramento->get("a_nome_cliente"); ?>" disabled="disabled">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>Veículo:</label>
                            <input type="text" class="form-control" value="<?= $monitoramento->get("a_placa_veiculo"); ?>" disabled="disabled">
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
     </div>
        <div class="panel panel-info">
            <div class="panel-heading">Descrição do Evento</div>
            <div class="panel-body">	
                <div class="row">
                    <div class="col-xs-12 col-lg-3 col-sm-8 col-md-6">
                        <div class="form-group">
                            <label>Evento:</label>
                            <select class="form-control" name="sinistro_evento" id="selectEvento" <?= Funcoes::Disable($acao); ?>>
                                <option value="1" <?= $monitoramento->get("sinistro_evento", true) == 1 ? "selected" : ""; ?>>Furto</option>
                                <option value="2" <?= $monitoramento->get("sinistro_evento", true) == 2 ? "selected" : ""; ?>>Roubo</option>
                                <option value="3" <?= $monitoramento->get("sinistro_evento", true) == 3 ? "selected" : ""; ?>>Outro</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-3 col-sm-8 col-md-6">
                        <div class="form-group">
                            <label>Atendimento:</label>
                            <select class="form-control" name="sinistro_atendimento" <?= Funcoes::Disable($acao); ?>>
                                <option value="1" <?= $monitoramento->get("sinistro_atendimento", true) == 1 ? "selected" : ""; ?>>0800 646 5551</option>
                                <option value="2" <?= $monitoramento->get("sinistro_atendimento", true) == 2 ? "selected" : ""; ?>>Central Monitoramento 24h</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-6 col-sm-8 col-md-6" id="texto_evento" style="display:none;">
                        <div class="form-group">
                            <label>Se Evento "Outro", preencher:</label>
                            <input class="form-control" name="sinistro_outro" value="<?= $monitoramento->get("sinistro_outro"); ?>" <?= Funcoes::Disable($acao); ?>>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-6 col-sm-8 col-md-6">
                        <div class="form-group">
                            <label>Comunicante:</label>
                            <input class="form-control" name="sinistro_comunicante" value="<?= $monitoramento->get("sinistro_comunicante"); ?>" <?= Funcoes::Disable($acao); ?> required="required">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-6 col-sm-8 col-md-6">
                        <div class="form-group">
                            <label>Confirmação de Senha e Contra-Senha:</label>
                            <label class="radio-inline"><input type="radio" name="sinistro_confirmacao_senha" value="1" <?= $monitoramento->get("sinistro_confirmacao_senha") == 1 ? "checked" : ""; ?> <?= Funcoes::Disable($acao); ?>>Sim</label>
                            <label class="radio-inline"><input type="radio" name="sinistro_confirmacao_senha" value="2" <?= $monitoramento->get("sinistro_confirmacao_senha") == 2 ? "checked" : ""; ?> <?= Funcoes::Disable($acao); ?>>Não</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-2 col-sm-8 col-md-2">
                        <div class="form-group">
                            <label>Data:</label>
                            <div class="input-group input-append date datepicker">
                                <input type="text" name="sinistro_data" class="form-control" value="<?= $monitoramento->get("sinistro_data"); ?>" <?= Funcoes::Disable($acao); ?> required="required">
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-2 col-sm-8 col-md-2">
                        <div class="form-group">
                            <label>Hora:</label>
                            <input type="text" name="sinistro_hora" class="form-control mask_hora" value="<?= $monitoramento->get("sinistro_hora"); ?>" <?= Funcoes::Disable($acao); ?> required="required">
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-2 col-sm-8 col-md-2">
                        <div class="form-group">
                            <label>UF:</label>
                            <input type="text" name="sinistro_uf" class="form-control mask_uf" value="<?= $monitoramento->get("sinistro_uf"); ?>" <?= Funcoes::Disable($acao); ?> required="required">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-info">
            <div class="panel-heading">Descrição das Ações com os devidos horários</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-lg-6 col-sm-8 col-md-6">
                        <div class="form-group">
                            <label>Endereço - Local do Evento:</label>
                            <input class="form-control" name="sinistro_local_evento"  value="<?= $monitoramento->get("sinistro_local_evento"); ?>" <?= Funcoes::Disable($acao); ?> required="required">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-2 col-sm-8 col-md-2">
                        <div class="form-group">
                            <label>Data - Evento:</label>
                            <div class="input-group input-append date datepicker">
                                <input type="text" name="sinistro_data_acao" class="form-control" value="<?= $monitoramento->get("sinistro_data_recuperacao"); ?>" <?= Funcoes::Disable($acao); ?> required="required">
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>

                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-2 col-sm-8 col-md-2">
                        <div class="form-group">
                            <label>Hora - Evento:</label>
                            <input type="text" name="sinistro_hora_acao" class="form-control mask_hora" value="<?= $monitoramento->get("sinistro_hora_recuperacao"); ?>" <?= Funcoes::Disable($acao); ?> required="required">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-6 col-sm-8 col-md-6">
                        <div class="form-group">
                            <label>O veículo foi bloqueado?:</label>
                            <label class="radio-inline"><input type="radio" name="sinistro_bloqueio" value="1" class="bloqueio" <?= $monitoramento->get("sinistro_bloqueio") == 2 ? "checked" : ""; ?> <?= Funcoes::Disable($acao); ?>>Sim</label>
                            <label class="radio-inline"><input type="radio" name="sinistro_bloqueio" value="2" class="bloqueio" <?= $monitoramento->get("sinistro_bloqueio") == 2 ? "checked" : ""; ?> <?= Funcoes::Disable($acao); ?>>Não</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-6 col-sm-8 col-md-6" id="texto_bloqueio" style="display:none;">
                        <div class="form-group">
                            <label>Descreva o porquê?</label>
                            <input class="form-control" name="sinistro_bloqueio_obs" value="<?= $monitoramento->get("sinistro_bloqueio_obs"); ?>" <?= Funcoes::Disable($acao); ?>>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-6 col-sm-8 col-md-6">
                        <div class="form-group">
                            <label>Assinale quem foi acionado para o resgate:</label>
                            <div class="checkbox">
                                <label class="checkbox"><input type="checkbox" value="1"   name="sinistro_resgate[]" <?= $monitoramento->get("sinistro_resgate") != null && in_array(1, $monitoramento->get("sinistro_resgate")) ? "checked" : ""; ?> <?= Funcoes::Disable($acao); ?>>Unidades Volantes Volpato</label>
                            </div>
                            <div class="checkbox">
                                <label class="checkbox"><input type="checkbox" value="2"  name="sinistro_resgate[]" <?= $monitoramento->get("sinistro_resgate") != null && in_array(2, $monitoramento->get("sinistro_resgate")) ? "checked" : ""; ?> <?= Funcoes::Disable($acao); ?>>Unidades Tercerizadas</label>
                            </div>
                            <div class="checkbox">
                                <label class="checkbox"><input type="checkbox" value="3"  name="sinistro_resgate[]" <?= $monitoramento->get("sinistro_resgate") != null && in_array(3, $monitoramento->get("sinistro_resgate")) ? "checked" : ""; ?> <?= Funcoes::Disable($acao); ?>>Policia Militar</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-6 col-sm-8 col-md-6">
                        <div class="form-group">
                            <label>Houve registro de ocorrência?</label>
                            <label class="radio-inline"><input type="radio" name="sinistro_ocorrencia" value="1" class="ocorrencia" <?= $monitoramento->get("sinistro_ocorrencia") == 1 ? "checked" : ""; ?> <?= Funcoes::Disable($acao); ?>>Sim</label>
                            <label class="radio-inline"><input type="radio" name="sinistro_ocorrencia" value="2" class="ocorrencia" <?= $monitoramento->get("sinistro_ocorrencia") == 2 ? "checked" : ""; ?> <?= Funcoes::Disable($acao); ?>>Não</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-6 col-sm-8 col-md-6" id="texto_ocorrencia" style="display:none;">
                        <div class="form-group">
                            <label>Número do B.O.?</label>
                            <input class="form-control" name="sinistro_bo" value="<?= $monitoramento->get("sinistro_bo"); ?>" <?= Funcoes::Disable($acao); ?>>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-6 col-sm-8 col-md-6">
                        <div class="form-group">
                            <label>Houve contato posterior à recuperação com  o Cliente?</label>
                            <label class="radio-inline"><input type="radio" name="sinistro_contato" value="1" <?= $monitoramento->get("sinistro_contato") == 1 ? "checked" : ""; ?> <?= Funcoes::Disable($acao); ?>>Sim</label>
                            <label class="radio-inline"><input type="radio" name="sinistro_contato" value="2" <?= $monitoramento->get("sinistro_contato") == 2 ? "checked" : ""; ?> <?= Funcoes::Disable($acao); ?>>Não</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-6 col-sm-8 col-md-6">
                        <div class="form-group">
                            <label>Endereço - Recuperação:</label>
                            <input class="form-control" name="sinistro_endereco_recuperacao" value="<?= $monitoramento->get("sinistro_endereco_recuperacao"); ?>" <?= Funcoes::Disable($acao); ?>>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-2 col-sm-8 col-md-2">
                        <div class="form-group">
                            <label>Data - Recuperação:</label>
                            <div class="input-group input-append date datepicker">
                                <input type="text" name="sinistro_data_recuperacao" class="form-control" value="<?= $monitoramento->get("sinistro_data_recuperacao"); ?>" <?= Funcoes::Disable($acao); ?>>
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>

                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-2 col-sm-8 col-md-2">
                        <div class="form-group">
                            <label>Hora - Recuperação:</label>
                            <input type="text" name="sinistro_hora_recuperacao" class="form-control mask_hora" value="<?= $monitoramento->get("sinistro_hora_recuperacao"); ?>" <?= Funcoes::Disable($acao); ?>>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-6 col-sm-8 col-md-6">
                        <div class="form-group">
                            <label>Houve registro de fotos?</label>
                            <label class="radio-inline"><input type="radio" name="sinistro_fotos" value="1" <?= $monitoramento->get("sinistro_fotos") == 1 ? "checked" : ""; ?> <?= Funcoes::Disable($acao); ?>>Sim</label>
                            <label class="radio-inline"><input type="radio" name="sinistro_fotos" value="2" <?= $monitoramento->get("sinistro_fotos") == 2 ? "checked" : ""; ?> <?= Funcoes::Disable($acao); ?>>Não</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-6 col-sm-8 col-md-6">
                        <div class="form-group">
                            <label>Como ocorreu o evento? (Detalhes dos fatos)</label>
                            <textarea rows="20" class="form-control" name="sinistro_obs" <?= Funcoes::Disable($acao); ?>><?= $monitoramento->get("sinistro_obs"); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-6 col-sm-8 col-md-6">
                <div class="form-actions">
                    <?php if ($monitoramento->get("sinistro_status") == 1 || $monitoramento->get("sinistro_id") == null) { ?>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <input type="hidden" name="acao" value="salvarSisitro">
                        <input type="hidden" name="sinistro_operador" value="<?= $monitoramento->get("sinistro_operador") == null ? $_SESSION['user_info']['id_usuario'] : $monitoramento->get("sinistro_operador"); ?>">
                        <input type="hidden" name="sinistro_id" value="<?= $monitoramento->get("sinistro_id"); ?>">
                        <?php if ($monitoramento->get("sinistro_id") != null) { ?>
                            <a class="btn btn-success" href="modulos/monitoramento/src/controllers/monitoramento.php?acao=finalizarSinistro&id=<?= $monitoramento->get("sinistro_id"); ?>">Finalizar</a>
                            <a class="btn btn-default" href="fpdf/sinistros/index.php?id=<?=$monitoramento->get("sinistro_id");?>">Imprimir</a>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($monitoramento->get("sinistro_id") != null) { ?>
                        <a class="btn btn-info" href="index.php?pg=51">Voltar</a>
                    <?php } ?>
                </div>
            </div>
        </div>
</form>
