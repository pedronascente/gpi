<?php
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$acao = filter_input(INPUT_GET, 'acao');
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
            <form action="modulos/desenvolvimento/src/controllers/desenvolvimento.php" name="" method="post">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Descreva a situação:</label>
                            <textarea name="motivo" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-actions">
                            <input type="hidden" name="id" value="<?=$id;?>" />
                            <input type="hidden" name="acao" value="<?=$acao;?>">

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

