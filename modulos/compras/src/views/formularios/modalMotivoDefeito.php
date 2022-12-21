<?php
$id = filter_input(INPUT_GET, 'id_modulo', FILTER_VALIDATE_INT);
$id_chip = filter_input(INPUT_GET, 'id_chip', FILTER_VALIDATE_INT);
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
            <form action="modulos/compras/src/controllers/compras.php" name="" method="post">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Motivo Defeito:</label>
                            <textarea name="modulo_obs_defeito" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-actions">
                            <input type="hidden" name="id_modulo" value="<?= $id; ?>" />
                            <input type="hidden" name="id_chip" value="<?=$id_chip;?>" />
                            <input type="hidden" name="acao" id="acao" value="statusDefeito">

                            <button type="submit" class="btn btn-primary botaoLoadForm">
                                Salvar
                            </button>

                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

