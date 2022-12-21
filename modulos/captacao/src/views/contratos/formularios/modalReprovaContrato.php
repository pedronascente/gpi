<?php
include_once '../../../../../../Config.inc.php';
$id = filter_input(INPUT_GET, 'id_cliente', FILTER_VALIDATE_INT);
$id_contrato = filter_input(INPUT_GET, 'id_contrato', FILTER_VALIDATE_INT);

$cliente = new Clientes;
$campos = $cliente->selectCamposContrato(1);
$veiculos = (new Veiculos)->selectPorContrato($id);
$camposVeiculos = $cliente->selectCamposContrato(2);
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?= $cliente->getNomeCliente($id); ?></h4>
        </div>
        <div class="modal-body">
            <form action="modulos/captacao/src/controllers/captacao.php" name="" method="post">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Motivo</label>
                            <textarea name="observacoes_contrato" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <br>
                <?php if (!empty($campos)) { ?>
                    <div class="scrollbar_2">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th colspan="2" align="center">Campos</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>Campo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($campos as $c) {
                                        $descricao = !empty($c['campos_contrato_desc']) ? $c['campos_contrato_desc'] : ucwords(str_replace("_", " ", str_replace("cobranca", "cobrança", str_replace("_cliente", "", $c['campos_contrato_name']))));
                                        ?>
                                     <tr>
                                        <td width="2%"><input type="checkbox" name="camposCliente[]" value="<?= $c['campos_contrato_id']; ?>"></td>
                                        <td><?= $descricao; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                <?php } ?>
                <?php if (!empty($veiculos) && !empty($camposVeiculos)) { ?>
                    <div class="scrollbar_2">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr><th colspan="2">Veículos</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($veiculos as $v) { ?>
                                    <tr><td colspan="2"><?= $v['placa']; ?></td></tr>
                                    <?php
                                    foreach ($camposVeiculos as $cv) {
                                        $descricao = !empty($cv['campos_contrato_desc']) ? $cv['campos_contrato_desc'] : ucwords(str_replace("_", " ", str_replace("cobranca", "cobrança", str_replace("_cliente", "", $cv['campos_contrato_name']))));
                                        ?>
                                        <tr>
                                            <td width="2%"><input type="checkbox" name="camposVeiculos[]" value="<?= $cv['campos_contrato_id'] . "_" . $v['id_veiculo']; ?>"></td>
                                            <td><?= $descricao; ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <br>
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-actions">
                            <input type="hidden" name="id_cliente" value="<?= $id; ?>" />
                            <input type="hidden" name="id_contrato" value="<?= $id_contrato; ?>" />
                            <input type="hidden" name="status_contrato" value="2"/>
                            <input type="hidden" name="acao" id="acao" value="reprovaContrato">
                            <button type="submit" class="btn btn-danger botaoLoadForm">
                                Reprovar
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>