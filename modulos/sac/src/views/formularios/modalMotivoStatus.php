<?php
$id = filter_input(INPUT_GET, 'id_veiculo', FILTER_VALIDATE_INT);
$status = filter_input(INPUT_GET, 'status', FILTER_VALIDATE_INT);
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
            <form action="modulos/sac/src/controllers/sac.php" name="" method="post">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Motivo Troca Status:</label>
                            <textarea name="observacoes_troca" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-actions">
                            <input type="hidden" name="id_veiculo" value="<?= $id; ?>" />
                            <input type="hidden" name="status" value="<?= $status;?>" />
                            <input type="hidden" name="acao" id="acao" value="trocarStatusVeiculo">

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

