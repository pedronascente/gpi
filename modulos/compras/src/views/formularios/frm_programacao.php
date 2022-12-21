<div class="panel panel-primary">
    <div class="panel-heading ">Dados Chip</div>
    <div class="panel-body">
        <form action="modulos/compras/src/controllers/compras.php" method="POST">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                            <?php if($programacao->get("chip_status", true) < 3){?>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Módulo:</label>
                                        <input type="text" id="selectModulo" class="form-control" required="required" <?= $programacao->get("chip_status", true) == 3 ? "disabled" : null; ?> value="<?=$programacao->get("modulo_serial");?>">
                                    </div>
                                </div>
                                <?php }?>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" <?= $programacao->get("modulo_id") == null || $programacao->get("chip_cliente") != null ? "style='display:none'" : ""; ?> id="divDefeito">
                                    <br>
                                    <a id="modulos/compras/src/views/formularios/modalMotivoDefeito.php?id_chip=<?= $programacao->get("chip_id"); ?>&id_modulo=<?= $programacao->get("modulo_id"); ?>" class="botaoLoad btn btn-warning modalOpen" data-target="#modal">
                                        Defeito
                                    </a>
                                </div>
                            </div>
                            <div id="modulo">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Serial:</label>
                                            <input type="text" name="modulo_serial" id="modulo_serial" class="form-control"  disabled value="<?= $programacao->get("modulo_serial"); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Modelo:</label>
                                            <input type="text" name="modulo_modelo"  id="modulo_modelo" class="form-control" disabled value="<?= $programacao->get("modulo_modelo"); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>OBS:</label>
                                            <textarea class="form-control" name="modulo_obs" id="modulo_obs" disabled rows="4"><?= $programacao->get("modulo_obs"); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                        <?php if($programacao->get("chip_status", true) < 2){?>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Chip:</label>
                                        <input type="text" id="selectChip" class="form-control mask_telefone" required="required" <?= $programacao->get("chip_status", true) >=2 ? "disabled" : null; ?> value="<?=$programacao->get("chip_linha");?>">
                                    </div>
                                </div>
                            </div>
                       <?php }?>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Operadora:</label>
                                        <input type="text" name="chip_operadora" id="chip_operadora" class="form-control" disabled value="<?= $programacao->get("chip_operadora"); ?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Linha:</label>
                                        <input type="text" name="chip_linha" id="chip_linha" class="form-control" disabled value="<?= $programacao->get("chip_linha"); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>ICCID:</label>
                                        <input type="text" name="chip_iccid" id="chip_iccid" class="form-control" disabled value="<?= $programacao->get("chip_iccid"); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Puk:</label>
                                        <input type="text" name="chip_puk" id="chip_puk" class="form-control" disabled value="<?= $programacao->get("chip_puk"); ?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Puk 2:</label>
                                        <input type="text" name="chip_puk2" id="chip_puk2" class="form-control" disabled value="<?= $programacao->get("chip_puk2"); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>PIM:</label>
                                        <input type="text" id="chip_pim"  class="form-control"  disabled value="<?= $programacao->get("chip_pim"); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Status:</label>
                        <select class="form-control" name="chip_status" <?= $programacao->get("chip_status", true) > 3 ? "disabled" : null; ?>>
                            <option value="2" <?= $programacao->get("chip_status", true) == 2 || $programacao->get("chip_status", true) == NULL ? "selected" : ""; ?>>Em Andamento</option>
                            <option value="3" <?= $programacao->get("chip_status", true) == 3 ? "selected" : ""; ?>>Programado</option>
                            <?php if ($programacao->get("chip_status", true) == 5) { ?>
                                <option value="5" selected="selected">Vinculado</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php if (($programacao->get("chip_status", true) == 3 || $programacao->get("chip_status", true) == 5) && !$permissaoProgramacao) { ?>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Cliente:</label>
                            <select class="form-control" id="cliente" required="required" name="id_cliente">
                                <option value="">Selecione ...</option>
                                <?php
                                if (!empty($clientes)) {
                                    foreach ($clientes as $cli) {
                                        ?>
                                        <option value="<?= $cli->get("id_cliente"); ?>" <?= $cli->get("id_cliente") == $programacao->get("chip_cliente") ? "selected" : null; ?>><?= $cli->get("nome_cliente") . " / " . $cli->get("cnpjcpf_cliente"); ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Veículos:</label>
                            <select class="form-control" id="veiculos" name="veiculos_equipamentos_id_veiculo" required="required">
                                <?php
                                if (!empty($veiculos)) {
                                    foreach ($veiculos as $ve) {
                                        ?>
                                        <option value="<?= $ve['id_veiculo']; ?>"><?= $ve['placa']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-actions">
                        <input type="hidden" name="acao" value="<?= $programacao->get("chip_status", true) == 3 ? "vincularCliente" : "programarChip"; ?>">
                        <input type="hidden" name="chip_id" value="<?= $programacao->get("chip_id"); ?>" id="chip_id">
                        <input type="hidden" name="chip_modulo" value="<?= $programacao->get("chip_modulo"); ?>" id="modulo_id">
                        <input type="submit" value="Salvar" class="btn btn-primary">
                        <a href="index.php?pg=46" class="btn btn-default">Voltar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
