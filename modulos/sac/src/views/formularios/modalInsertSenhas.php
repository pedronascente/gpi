<?php 

include_once "../../../../../Config.inc.php";

$cliente = new Clientes;

$id 		= filter_input(INPUT_GET, "id");
$id_cliente = filter_input(INPUT_GET, "id_cliente");
$acao		= filter_input(INPUT_GET, "acao");

$login = !empty($id) ? $cliente->selectLogin($id) : null;

?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Login</h4>
        </div>			
        <div class="modal-body">
            <form method="post" action="modulos/sac/src/controllers/sac.php"> 
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Login do Sistema:</label>
                            <input type="text" name="login_sistema" value="<?=isset($login['login_sistema']) ? $login['login_sistema'] : null;?>" class="form-control"  required="required"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Senha do Sistema:</label>
                            <input type="text" name="senha_sistema"	value="<?=isset($login['senha_sistema']) ? $login['senha_sistema'] : null;?>" class="form-control"  required="required"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-actions">
                            <input type="hidden" name="id_cliente" value="<?=$id_cliente;?>">
                            <input type="hidden" name="id" value="<?=$id;?>">
                            <input type="hidden" name="acao" value="<?=$acao;?>">
                            <input type="submit" value="Salvar" class="btn btn-primary">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
              </form>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript" src="modulos/sac/public/js/min/sac.js"></script>
