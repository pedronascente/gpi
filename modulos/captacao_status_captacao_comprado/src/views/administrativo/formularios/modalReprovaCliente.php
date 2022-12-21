<?php
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$tipo = filter_input(INPUT_GET, 'tipoCadastro', FILTER_DEFAULT);
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Reprovar Cliente</h4>
        </div>
        <div class="modal-body">
            <form name="form-reprove" id="" method="post" action="modulos/captacao/src/controllers/captacao.php">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Motivo</label>
                            <select name="motivo_reprovacao_cliente" class="form-control m_reprovarConsultaSPC" required></select> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-actions">
                            <input type="hidden" name="id_cliente" value="<?= $id; ?>" />
                            <input type="hidden" name="tipo_cadastro" value="<?= $tipo; ?>" /> 
                            <input type="hidden" name="acao" value="reprovaConsulta" />
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
    <script language="javascript" type="text/javascript" src="modulos/captacao/public/js/m_reprovarCliente.js"></script>

