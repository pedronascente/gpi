<?php $id = filter_input(INPUT_GET, 'id_pcf', FILTER_VALIDATE_INT); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Rerpovar Planilha</h4>
        </div>			
        <!-- /modal-header -->
        <div class="modal-body">
            <form action="modulos/pedidoComissao/src/controllers/pedido_comissao.php" name="form-reprovar-planilha" method="post" class="loadForm">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Motivo:</label>
                            <textarea name="motivo" id="motivo" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-actions">
                            <input type="hidden" name="acao" id="acao" value="reprovarPlanilha">
                            <input type="hidden" name="id" id="id" value="<?=$id?>">
                            <button type="submit" class="btn btn-danger botaoLoadForm">Reprovar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>