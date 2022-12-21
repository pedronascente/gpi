<div class="panel panel-primary">
    <div class="panel-body"> 
        <form action="modulos/compras/src/controllers/compras.php" method="POST">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label>Status:</label>
                        <select name="modulo_status" class="form-control" <?= $modulo->get("modulo_status", true) != '2' ? 'disabled' : ''; ?>>
                            <option value="">Selecione...</option>
                            <option value="1" <?= ($modulo->get("modulo_status", true) == '1' || $modulo->get("modulo_status", true) == NULL) ? 'selected' : ''; ?>>Novo</option>
                            <option value="2" <?= ($modulo->get("modulo_status", true) == '2') ? 'selected' : ''; ?>>Com Defeito</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">
                    <div class="form-group">
                        <label>Serial:</label>
                        <input type="text" name="modulo_serial" class="form-control" value="<?= $modulo->get("modulo_serial"); ?>" <?= Funcoes::Disable($acao); ?> required="required" id="verificarSerial">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">
                    <div class="form-group">
                        <label>Modelo:</label>
                        <input type="text" name="modulo_modelo" class="form-control" value="<?= $modulo->get("modulo_modelo"); ?>" <?= Funcoes::Disable($acao); ?>>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">
                    <div class="form-group">
                        <label>OBS:</label>
                        <textarea class="form-control" name="modulo_obs" <?= Funcoes::Disable($acao); ?>><?= $modulo->get("modulo_obs"); ?></textarea>
                    </div>
                </div>
            </div>
            <?php if ($modulo->get("modulo_status", true) == 2) { ?>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">
                    <div class="form-group">
                        <label>Defeito:</label>
                        <textarea class="form-control"><?= $modulo->get("modulo_obs_defeito"); ?></textarea>
                    </div>
                </div>
            </div>
            <?php }?>
            <?php if ($acao != "visualizar") { ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">
                        <div class="form-actions">
                            <input type="hidden" name="modulo_id" value="<?= $modulo->get("modulo_id"); ?>">
                            <?php if ($modulo->get("modulo_status", true) == NULL) { ?>
                                <input type="hidden" name="modulo_status" value="1">
                            <?php } ?>
                            <input type="hidden" name="acao" value="salvarModulo">
                            <button class="btn btn-primary" type="submit">Salvar</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </form>
    </div>
</div>