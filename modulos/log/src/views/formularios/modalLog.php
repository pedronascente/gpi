<?php
include_once '../../../../../Config.inc.php';

$log = new Log();

$id_log = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

$log->select($id_log);

?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">LOG</h4>
        </div>			
        <div class="modal-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>Data:</label>
                        <input type="text" value="<?=$log->get("log_data");?>" disabled="disabled" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>Descrição:</label>
                        <input type="text"  value="<?=$log->get("log_descricao");?>"  class="form-control" disabled="disabled">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>Usuário:</label>
                        <input type="text"  value="<?=$log->get("log_nome_usuario");?>"  class="form-control" disabled>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>Texto:</label>
                        <textarea  class="form-control" rows="6" class="form-control" disabled="disabled"><?=$log->get("log_texto");?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        	<a href="fpdf/log/index.php?id=<?=$id_log;?>" class="btn btn-primary">Imprimir</a>
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>
</div>

