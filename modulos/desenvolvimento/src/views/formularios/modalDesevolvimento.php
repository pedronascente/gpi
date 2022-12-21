<?php
include_once '../../../../../Config.inc.php';

$desenvolvimento = new Desenvolvimento;

$id_log = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

$log = $desenvolvimento->selectLog($id_log);
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">LOG</h4>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>Data:</label>
                        <input type="text" value="<?= isset($log['log_data']) ? Funcoes::formataDataComHora($log['log_data']) : null ?>" disabled="disabled" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>Descrição:</label>
                        <input type="text"  value="<?= isset($log['log_descricao']) ? $log['log_descricao'] : null; ?>"  class="form-control" disabled="disabled">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>Usuário:</label>
                        <input type="text"  value="<?= isset($log['usuario']) ? $log['usuario'] : null; ?>"  class="form-control" disabled>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>Texto:</label>
                        <textarea  class="form-control" rows="6" class="form-control" disabled="disabled"><?= isset($log['log_texto']) ? $log['log_texto'] : "" ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default modalClose">Fechar</button>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
  $(function () {
	  $(".modalClose").click(function(){
		  $("#modalDesenvolvimento").modal("hide");
		});
	});
</script>
