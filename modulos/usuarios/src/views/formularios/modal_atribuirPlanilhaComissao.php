<?php
include ("../../../../../Config.inc.php");

$id = filter_input(INPUT_GET, 'id_u', FILTER_VALIDATE_INT);
$planilhasComissao = new PlanilhaComissoes;
$usuario = new Usuarios;
$lista_usuario = $usuario->selectUsuarioPermissaoComissao();
$listar_planilhas = $planilhasComissao->selectPlanilhas();
$tela = $_GET ['tela'];
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Planilhas Comissões</h4>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
            <form action="modulos/usuarios/src/controllers/usuarios.php" name="form_addPlanilhaComissao" method="post">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Usuário: </label>
                            <select name="id" class="form-control selectpicker" required>
                                <option value="" selected="selected">Selecione</option>
                                <?php
                                foreach ($lista_usuario as $li) :
                                    echo '<option value="' . $li ['id'] . '" ';
                                    if ($li ['id'] == $id) :
                                        echo "selected";

                                    endif;
                                    echo '>' . $li ['usuario'];
                                    echo '</option>';
                                endforeach
                                ;
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Planilha de comissão:</label>
                            <select multiple class="form-control" name="id_pc[]">
                                <?php
                                if ($listar_planilhas) :
                                    foreach ($listar_planilhas as $li) :
                                        ?>
                                        <option value="<?= $li['planilha_comissoes_id']; ?>"><?= $li['planilha_comissoes_nome']; ?></option>
                                        <?php
                                    endforeach
                                    ;

                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="forn-actions">
                            <input type="hidden" name="acao" value="atribuirPlanilhaComissao"> 
                            <input type="hidden" name="tela" value="<?= $tela ?>">

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
<script type="text/javascript" language="javascript">
$(function(){
	$(".selectpicker").selectpicker({"liveSearch" : true, "showIcon": true, "size": 10});
});
</script>