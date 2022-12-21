<?php
include ("../../../../../Config.inc.php");
$usuario = new Usuarios ();
$lista_usuario = $usuario->selecionarTodos(null, true);
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Resetar Senha Usuário</h4>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
            <form action="modulos/usuarios/src/controllers/usuarios.php" name="form_reseta_senha" method="post">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Usuário:</label>
                            <select name="id" id="id" class="form-control selectpicker" required>
                                <option value="">Selecione um usuario</option>
                                <?php
                                if ($lista_usuario) :
                                    foreach ($lista_usuario as $li_user) :
                                        ?>
                                        <option value="<?php echo $li_user['id']; ?>"> <?php echo $li_user['usuario']; ?> </option>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Nova Senha:</label>
                            <input type="text" name="senha" id="senha" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-actions">
                            <input type="hidden" name="acao" value="resetSenha"/>

                            <button type="submit" class="btn btn-primary botaoLoadForm">
                                Resetar
                            </button>

                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
$(function(){
	$(".selectpicker").selectpicker({"liveSearch" : true, "showIcon": true, "size": 10});
});
</script>
