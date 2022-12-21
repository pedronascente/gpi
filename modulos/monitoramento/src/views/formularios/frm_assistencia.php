<script type="text/javascript">
    $(function () {

        var hash = window.location.hash;
        var url = window.location.href;

        if (!(typeof google === 'object' && typeof google.maps === 'object') && url.indexOf("conexao=false") == -1) {
            url = url.replace(hash, "");
            location.href = url + "&conexao=false" + hash;
        }

        $(window).keydown(function (e) {
            var url = window.location.href;
            url = url.replace("&conexao=false", "");
            url = url.replace("#cadastro", "");

            if (e.keyCode == 116) {
                e.preventDefault();
                location.href = url;
            }
        });

    });
</script>
<form method="POST" action="modulos/monitoramento/src/controllers/monitoramento.php" id="formAssistencia">
    <div class="panel panel-primary">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="panel panel-info">
                <div class="panel-heading">Acionamento</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-lg-3 col-sm-8 col-md-6">
                            <div class="form-group">
                                <label>Protocolo:</label>
                                <input type="text" name="assistencia_protocolo" value="<?= $monitoramento->get("assistencia_protocolo") == null ? date("YmdHiszu") : $monitoramento->get("assistencia_protocolo"); ?>" readonly="readonly" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-3 col-sm-4 col-md-3">
                            <div class="form-group">
                                <label>Data:</label>
                                <input type="text" name="assistencia_data" value="<?= $monitoramento->get("assistencia_data") == null ? date("d/m/Y") : $monitoramento->get("assistencia_data"); ?>" readonly="readonly" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-3 col-sm-4 col-md-3">
                            <div class="form-group">
                                <label>Hora:</label>
                                <input type="text" name="assistencia_hora" value="<?= $monitoramento->get("assistencia_hora") == null ? date("H:i:s") : $monitoramento->get("assistencia_hora"); ?>" readonly="readonly" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-3 col-sm-4 col-md-3">
                            <div class="form-group">
                                <label>Finalização:</label>
                                <input type="text" name="assistencia_finalizacao" value="<?= $monitoramento->get("assistencia_finalizacao"); ?>" readonly="readonly" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-lg-6 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Local do Evento:</label>
                                <div class="input-group">
                                    <span class="input-group-addon" id="focarLocal"><img src="public/img/blue_MarkerL.png" height="20"></span>
                                    <input type="text" name="assistencia_local" class="form-control" id="mapa_address" required="required" value="<?= $monitoramento->get("assistencia_local"); ?>" <?= Funcoes::Disable($acao); ?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($conexao) { ?>
                        <div class="row">
                            <div class="col-xs-12 col-lg-7 col-sm-12 col-md-7">
                                <div class="well well-sm">
                                    <img src="public/img/blue_MarkerL.png" height="20"/> Local do Evento &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <img src="public/img/marker.png" height="20"/> Guinchos Não Credenciados &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <img src="public/img/marker-orange.png" height="20"/> Guinchos Credenciados &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <img src="public/img/yellow-marker.png" height="20"/> Guinchos Próximos ao Evento &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <img src="public/img/green_MarkerG.png" height="20"/> Guincho Selecionado
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-lg-7 col-sm-12 col-md-7">
                                <div id="mapa2" style="display: block;width: 100%;height: 400px;"></div>
                            </div>
                            <div class="col-xs-12 col-lg-5 col-sm-12 col-md-5">
                                <div class="form-group">
                                    <?php if ($monitoramento->get("guincho_latitude") != null) { ?>
                                        <img src="public/img/green_MarkerG.png" id="focarGuincho"/>&nbsp;
                                    <?php } ?>
                                    <h2><label id="razaoSocial"></label></h2>
                                    <label id="endereco"></label><br>
                                    <label id="atendimento"></label><br>
                                    <label id="latitude"><?= $monitoramento->get("guincho_latitude"); ?></label><br>
                                    <label id="longitude"><?= $monitoramento->get("guincho_longitude"); ?></label><br>
                                    <label id="contato"></label><br>
                                    <a id="linkGuincho" style="display:none;" class="btn btn-success">Visualizar</a>
                                    <input type="hidden" name="assistencia_guincho" id="assistencia_guincho" value="<?= $monitoramento->get("assistencia_guincho"); ?>" required="required">
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row" id="mapaMsg">
                            <div class="col-xs-12 col-lg-12 col-sm-12 col-md-12">
                                <div class="alert alert-danger"><span class="glyphicon glyphicon-remove" style="font-size:18px;"></span> 
                                    <label style="color:#000;">SERVIÇO INDISPONÍVEL, NÃO FOI POSSÍVEL ESTABELECER UMA CONEXÃO COM A INTERNET!</label></div>
                            </div>
                        </div>
                        <div class="scrollbar table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <?php if ($acao != "visualizar") { ?>
                                            <th></th>
                                        <?php } ?>
                                        <th>Razão Social</th>
                                        <th>Endereço</th>
                                        <th>Atendimento</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($guinchos as $g) { ?>
                                        <tr>
                                            <?php if ($acao != "visualizar") { ?>
                                                <td width="2%"><input type="radio" name="assistencia_guincho" value="<?= $g->get("guincho_id"); ?>" <?= $g->get("guincho_id") == $monitoramento->get("assistencia_guincho") ? "checked" : null; ?>></td>
                                            <?php } ?>
                                            <td><?= $g->get("guincho_razao_social"); ?></td>
                                            <td><?= $g->get("guincho_uf"); ?> - <?= $g->get("guincho_cidade"); ?> - <?= $g->get("guincho_endereco"); ?></td>
                                            <td><?= $g->get("guincho_atendimento"); ?></td>
                                            <td width="2%"><a class="btn btn-sm btn-success" href="index.php?pg=48&id=<?= $g->get("guincho_id"); ?>#cadastro" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-lg-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Responsável:</label>
                                <input type="text" value="<?= $monitoramento->get("a_nome_responsavel") == null ? $_SESSION['user_info']['nome'] : $monitoramento->get("a_nome_responsavel"); ?>" disabled="disabled" class="form-control" <?= Funcoes::Disable($acao); ?> required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-lg-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Solicitação:</label>
                                <select name="assistencia_solicitacao" class="form-control" <?= Funcoes::Disable($acao); ?>>
                                    <option value="1" <?= $monitoramento->get("assistencia_solicitacao", true) == 1 ? "selected" : ""; ?>>Socorro Mecânico</option>
                                    <option value="2" <?= $monitoramento->get("assistencia_solicitacao", true) == 2 ? "selected" : ""; ?>>Reboque</option>
                                    <option value="3" <?= $monitoramento->get("assistencia_solicitacao", true) == 3 ? "selected" : ""; ?>>Taxi</option>
                                    <option value="4" <?= $monitoramento->get("assistencia_solicitacao", true) == 4 ? "selected" : ""; ?>>Chaveiro</option>
                                    <option value="5" <?= $monitoramento->get("assistencia_solicitacao", true) == 5 ? "selected" : ""; ?>>Troca de Pneu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">Cliente</div>
                <div class="panel-body">
                    <?php if ($monitoramento->get("assistencia_id") == null) { ?>
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
                            <div class="row">
                                <div class="col-xs-12 col-lg-6 col-sm-6 col-md-6" id="cadastroVeiculo" style="display:none;">
                                    <div class="form-group">
                                        <label>Cadastrar Placa:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mask_placa" id="placaVeiculo">
                                            <div class="input-group-btn">
                                                <button class="btn btn-default" type="button"  id="btnCadastrarVeiculo">Adicionar</button>
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
                    <div class="row">
                        <div class="col-xs-12 col-lg-6 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Solicitante:</label>
                                <input type="text" name="assistencia_solicitante" class="form-control"  required="required" value="<?= $monitoramento->get("assistencia_solicitante"); ?>" <?= Funcoes::Disable($acao); ?>>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">Pagamento</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-lg-6 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Recebedor:</label>
                                <select class="form-control" name="assistencia_pagamento" <?= Funcoes::Disable($acao); ?>>
                                    <option value="1" <?= $monitoramento->get("assistencia_pagamento", true) == 1 ? "selected" : ""; ?>>Empresa Acionada</option>
                                    <option value="2" <?= $monitoramento->get("assistencia_pagamento", true) == 2 ? "selected" : ""; ?>>Cliente</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-6 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Forma Pagamento:</label>
                                <select class="form-control" name="assistencia_forma_pagamento" id="formaPagamento" <?= Funcoes::Disable($acao); ?>>
                                    <option value="1" <?= $monitoramento->get("assistencia_forma_pagamento", true) == 1 ? "selected" : ""; ?>>Boleto</option>
                                    <option value="2" <?= $monitoramento->get("assistencia_forma_pagamento", true) == 2 ? "selected" : ""; ?>>Deposito Bancário</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php if ($monitoramento->get("assistencia_forma_pagamento", true) == 1 || $monitoramento->get("assistencia_forma_pagamento", true) == null) { ?>
                        <div class="row pagamento">
                            <div class="col-xs-12 col-lg-6 col-sm-12 col-md-6" style="margin-top: 24px;">
                                <div class="form-group">
                                    <label>Titular:</label>
                                    <input class="form-control" name="assistencia_pagamento_titular" value="<?= $monitoramento->get("assistencia_pagamento_titular"); ?>" <?= Funcoes::Disable($acao); ?>>
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-6 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>
                                        <ul class="nav nav-pills">
                                            <li role="presentation" class="<?= $monitoramento->get("assistencia_tipo_pessoa") == 'f' || $monitoramento->get("assistencia_tipo_pessoa") == null ? "active" : ""; ?> tipoPessoa" id="f"><a>CPF</a></li>
                                            <li role="presentation" class="<?= $monitoramento->get("assistencia_tipo_pessoa") == 'j' ? "active" : ""; ?> tipoPessoa" id="j"><a>CNPJ</a></li>
                                        </ul>
                                    </label>	
                                    <input type="text" name="assistencia_cpfcnpj" class="form-control mask_cpf" id="cpf_cnpj" value="<?= $monitoramento->get("assistencia_cpfcnpj"); ?>" <?= Funcoes::Disable($acao); ?>>                                
                                </div>
                            </div>
                        </div>
                        <div class="row pagamento">
                            <div class="col-xs-12 col-lg-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label>Banco:</label>
                                    <input class="form-control" name="assistencia_pagamento_banco" value="<?= $monitoramento->get("assistencia_pagamento_banco"); ?>" <?= Funcoes::Disable($acao); ?>>
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label>Agência:</label>
                                    <input class="form-control" name="assistencia_pagamento_agencia" value="<?= $monitoramento->get("assistencia_pagamento_agencia"); ?>" <?= Funcoes::Disable($acao); ?>>
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label>Conta:</label>
                                    <input class="form-control" name="assistencia_pagamento_conta" value="<?= $monitoramento->get("assistencia_pagamento_conta"); ?>" <?= Funcoes::Disable($acao); ?>>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">Observações</div>
                <div class="panel-body">
                    <div class="col-xs-12 col-lg-12 col-sm-12 col-md-12">
                        <label>Observações:</label>
                        <textarea class="form-control" rows="15" name="assistencia_obs" <?= Funcoes::Disable($acao); ?>><?= $monitoramento->get("assistencia_obs"); ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-lg-4 col-sm-4 col-md-4">
                    <div class="form-actions">
                        <input type="hidden" name="acao" value="salvarAssitencia">
                        <input type="hidden" name="assistencia_id" value="<?= $monitoramento->get("assistencia_id"); ?>">
                        <input type="hidden" name="assistencia_responsavel" value="<?= $monitoramento->get("assistencia_responsavel") == null ? $_SESSION['user_info']['id_usuario'] : $monitoramento->get("assistencia_responsavel"); ?>">
                        <input type="hidden" name="assistencia_tipo_pessoa" value="f" id="textoTipoPessoa">
                        <input type="hidden" value="<?= $monitoramento->get("assistencia_status", true); ?>" id="status">
                        <input type="hidden" name="assistencia_local_lat" value="<?= $monitoramento->get("assistencia_local_lat"); ?>" id="assistencia_local_lat">
                        <input type="hidden" name="assistencia_local_long" value="<?= $monitoramento->get("assistencia_local_long"); ?>" id="assistencia_local_long">
                        <?php if ($acao != "visualizar") { ?>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        <?php } if ($monitoramento->get("assistencia_id") != null && $monitoramento->get("assistencia_status", true) != 2 && $conexao) { ?>
                            <a class="btn btn-success finalizarAssistencia" id="modulos/monitoramento/src/controllers/monitoramento.php?id=<?= $monitoramento->get("assistencia_id"); ?>&acao=finalizarAssistencia">Finalizar</a>
                        <?php } ?>
                        <?php if ($monitoramento->get("assistencia_id") != null) { ?>
                            <a class="btn btn-info" href="index.php?pg=49">Voltar</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php if ($conexao) { ?>
    <script language="javascript" type="text/javascript" src="modulos/monitoramento/public/js/mapaGuinchos.js"></script>
    <?php
}?>