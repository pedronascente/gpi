<div class="panel panel-primary">
    <div class="panel-heading"></div>
    <div class="panel-body">
        <form method="POST" action="modulos/monitoramento/src/controllers/monitoramento.php">
            <div class="panel panel-primary">
                <div class="panel-heading">Dados Emmpresa:</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-lg-3  col-md-4 col-sm-5">
                            <div class="form-group">
                                <label>Tipo Guincho:</label>
                                <select name="guincho_credenciado" class="form-control">
                                	<option value="1" <?= $monitoramento->get("guincho_credenciado") == 1 ? "selected" : ""; ?>>Sim</option>
                                	<option value="2" <?= $monitoramento->get("guincho_credenciado") == 2 ? "selected" : ""; ?>>Não</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-lg-6  col-md-8 col-sm-8">
                            <div class="form-group">
                                <label>Razão Social:</label>
                                <input type="text" name="guincho_razao_social" class="form-control" value="<?= $monitoramento->get("guincho_razao_social"); ?>" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-lg-6  col-md-8 col-sm-8">
                            <div class="form-group">
                                <label>Responsável:</label>
                                <input type="text" name="guincho_responsavel" class="form-control" value="<?= $monitoramento->get("guincho_responsavel"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-lg-2  col-md-3 col-sm-6">
                            <div class="form-group">
                                <label>Atendimento:</label>
                                <input type="text" name="guincho_atendimento" class="form-control" value="<?= $monitoramento->get("guincho_atendimento"); ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-4  col-md-5 col-sm-6">
                            <div class="form-group">
                                <label>CEP:</label>
                                <div class="input-group">
                                    <input type="text" name="guincho_cep" class="form-control mask_cep _cep" maxlength="9" value="<?= $monitoramento->get("guincho_cep"); ?>">
                                    <div class="input-group-btn">
                                        <a href="javascript:void(0);" class="btn btn-default buscaCEP"> 
                                            <span class="glyphicon glyphicon-search"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-lg-2  col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>UF:</label>
                                <input type="text" name="guincho_uf" class="form-control mask_uf  _uf" value="<?= $monitoramento->get("guincho_uf"); ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-4  col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Cidade:</label>
                                <input type="text" name="guincho_cidade" class="form-control _cidade" value="<?= $monitoramento->get("guincho_cidade"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-lg-6  col-md-8 col-sm-8">
                            <div class="form-group">
                                <label>Endereço:</label>
                                <input type="text" name="guincho_endereco" class="form-control _rua" value="<?= $monitoramento->get("guincho_endereco"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-lg-6  col-md-8 col-sm-8">
                            <div class="form-group">
                                <label>OBS:</label>
                                <textarea name="guincho_obs" class="form-control"><?= $monitoramento->get("guincho_obs"); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">Localização Empresa:</div>
                <div class="panel-body">
                    <div id="mapa2">
                        <div class="row">
                            <div class="col-xs-12 col-lg-6  col-md-8 col-sm-8">
                                <div class="form-group">
                                    <label>Mapa:</label> 
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1"><img src="public/img/blue_MarkerL.png" height="20"></span>
                                        <input type="text" class="form-control" name="guincho_local" value="<?= $monitoramento->get("guincho_local"); ?>" id="mapa_address"/> 
                                    </div>
                                    <input type="hidden" name="guincho_latitude" id="mapa_lat" value="<?= $monitoramento->get("guincho_latitude"); ?>"/>
                                    <input type="hidden" name="guincho_longitude" id="mapa_lon" value="<?= $monitoramento->get("guincho_longitude"); ?>"/><br>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-lg-6  col-md-8 col-sm-8">
                                <div style="display: block;width: 100%;height: 400px;" id="mapa"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="mapaMsg" style="display:none;">
                        <div class="col-xs-12 col-lg-12 col-sm-12 col-md-12">
                            <div class="alert alert-danger"><span class="glyphicon glyphicon-remove" style="font-size:18px;"></span> 
                                <label style="color:#000;">SERVIÇO INDISPONÍVEL, NÃO FOI POSSÍVEL ESTABELECER UMA CONEXÃO COM A INTERNET!</label></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($monitoramento->get("guincho_id") != null) { ?>
                <div class="panel panel-primary">
                    <div class="panel-heading">Preços e Condições Emmpresa:</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-lg-6  col-md-8 col-sm-8">
                                <div class="form-group">
                                    <label>Tipo de Veículo:</label>
                                    <input type="text" id="gpr_tipo_veiculos" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-lg-6  col-md-8 col-sm-8">
                                <div class="form-group">
                                    <label>Condição:</label>
                                    <input type="text" id="gpr_condicao" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-lg-6  col-md-8 col-sm-8">
                                <div class="form-actions">
                                    <a class="btn btn-primary" id="adicionarCond">Add</a>
                                </div>
                            </div>
                        </div>
                        <br>
                        <table class="table table-bordered table-hover table-striped" id="tabelaC">
                            <?php if (!empty($listaPrecos)) {
                                foreach ($listaPrecos as $l) {
                                    ?>
                                    <tr>
                                        <td><?= $l->get("gpr_tipo_veiculos"); ?></td>
                                        <td><?= $l->get("gpr_condicao"); ?></td>
                                        <td width="5%" align="center"><a class="btn btn-danger" href="modulos/monitoramento/src/controllers/monitoramento.php?id=<?= $l->get("gpr_id"); ?>&guincho_id=<?= $id; ?>&acao=excluirCondicao">Excluir</a></td>
                                    </tr>
                            <?php }
                        } ?>
                        </table>
    <?= $objPaginacao2->MontaPaginacao(); ?>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Contatos:</div>
                    <div class="panel-body">
                        <a id="modulos/sac/src/views/formularios/modalInsertContato.php?id_cliente=<?= $id; ?>&acao=add&nivel=3"  class="modalOpen btn btn-default" data-target="#modal">
                            Adicionar Contato
                        </a>
                        <br><br>
    <?php if (!empty($listaContatos)) { ?>	
                            <table class="table table-bordered table-hover table-striped">
                                <tr>
                                    <th>Contato</th>
                                    <th>Telefone 1</th>
                                    <th>Telefone 2</th>
                                    <th>Telefone 3</th>
                                    <th>E-mail</th>
                                    <th></th>
                                </tr>
        <?php foreach ($listaContatos as $c) { ?>
                                    <tr>
                                        <td><?= $c['contato_nome']; ?></td>
                                        <td><?= $c['contato_telefone1']; ?></td>
                                        <td><?= $c['contato_telefone2']; ?></td>
                                        <td><?= $c['contato_telefone3']; ?></td>
                                        <td><?= $c['contato_email1']; ?></td>
                                        <td width="5%">
                                            <table width="150px">
                                            <tr>
                                                <td>
                                                    <a id="modulos/sac/src/views/formularios/modalInsertContato.php?id=<?= $c["contato_id"]; ?>&acao=EditarContato&nivel=3" class="modalOpen botaoLoad btn btn-info" data-target="#modal"> 
                                                        Editar
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="modulos/sac/src/controllers/sac.php?id=<?= $c["contato_id"]; ?>&id_cliente=<?= $id; ?>&acao=DeleteContato&contato_nivel=3" class="btn btn-danger botaoLoad"> 
                                                        Deletar
                                                    </a>
                                                </td>
                                               </tr>
                                            </table>
                                        </td>
                                    </tr>
                            <?php } ?>
                            </table>
                <?php } ?>
                    </div>
                </div>
<?php } ?>
            <div class="row">
                <div class="col-xs-12 col-lg-6  col-md-8 col-sm-8">
                    <div class="form-actions">
                        <input type="hidden" name="acao" value="cadastrarGuincho">
                        <input type="hidden" name="guincho_id" value="<?= $monitoramento->get("guincho_id"); ?>" id="guincho_id">
                        <button class="btn btn-primary" type="submit" id="salvarGuincho">Salvar</button>
                        <?php if($monitoramento->get("guincho_id") != null){?>
                        <a class="btn btn-info" href="index.php?pg=48">Voltar</a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script language="javascript" type="text/javascript" src="modulos/monitoramento/public/js/mapa.js"></script>