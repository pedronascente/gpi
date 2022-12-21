<?php
include ("../../../../../Config.inc.php");

$id = filter_input(INPUT_GET, 'id_u', FILTER_VALIDATE_INT);
$tela = filter_input(INPUT_GET, 'tela');
$usuario = new Usuarios ();

//SELECIONA TODOS OS USUÁRIOS ATIVOS
$lista_usuario = $usuario->selecionarAtivos();

$permissao = new Permissao ();

//LISTA AS PERMISSÕES
$lista_permissao = $permissao->select();

//LISTA GRUPO DE PERMISSÕES
$listaGruposPermissao = $permissao->selectGrupoPermissao();

//SELECIONA O GRUPO DO USUÁRIO
$grupoUsuario = !empty($id) ? $usuario->selectGrupoPermissao($id) : null;
$grupoUsuario = isset($grupoUsuario['id_permissao_grupo']) ? $grupoUsuario['id_permissao_grupo'] : null;

$permissoesUsuario = !empty($id) ? $usuario->selectPermissoesIndividuais($id) : null;
?>
<!--
************************************************************
********** ATRIBUIR PERMISSÕES PARA O USUARIO 'X' **********
************************************************************
-->
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Permissões</h4>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
            <ul class="nav nav-tabs" id="tabs"  data-tabs="tabs">
                <li><a a data-toggle="tab" href="#tabs-1">Atribuir Permissão Usuário</a></li>
               
                <li><a data-toggle="tab" href="#tabs-3">Criar Permissão</a></li>
            </ul>
            <div class="tab-content" id="my-tab-content">
                <div id="tabs-1" class="tab-pane fade">
                    <div class="panel panel-primary">
                    	 <div class="panel-heading"></div>
                        <div class="panel-body">
                            <form  id="form_cadPermissao">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Usuário:</label>
                                            <?php
                                            echo '<select name="usuario" id="usuario"  class="form-control" required>';
                                            foreach ($lista_usuario as $li) :
                                                echo '<option value="'. $li ['id'] .'" ';
                                                if ($li ['id'] == $id) :
                                                    echo "selected";

                                                endif;
                                                echo '>' . $li ['usuario'];
                                                echo '</option>';
                                            endforeach
                                            ;
                                            echo '</select>';
                                            ?>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Permissões:</label>
                                            <div class="scrollbar">
                                                <ul class="list-group">
                                                    <?php
                                                    foreach ($lista_permissao as $li) :
                                                        ?>
                                                        <li class="list-group-item">
                                                            <?php $verifica = !empty($permissoesUsuario) ? in_array(array("id_permissaouser" => $li['id_permissao']), $permissoesUsuario) : false; ?>
                                                            <div class="checkbox"><label><input type="checkbox" name="id_permissaouser[]" value="<?= $li['id_permissao']; ?>" id="pUser<?= $li['id_permissao'] ?>"  <?= $verifica ? "checked" : null; ?>  class="markCheck"><?= $li['tipo_permissao']; ?></label></div>
                                                        </li>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                        <div class="form-actions">
                                            <input type="hidden" name="tela" value="<?= $tela; ?>" id="tela"> 
                                            <input type="hidden" name="idUsuario" value="<?= $id; ?>" id="idUsuario"> 
                                            <input type="hidden" name="acao" id="acao" value="atribuirPermissaoUsuario"> 
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
                <div id="tabs-3" class="tab-pane fade">
                    <div class="panel panel-primary">
                    	<div class="panel-heading"></div>
                        <div class="panel-body">
                            <div class="row">
                                <form method="post" id="formAddPermissao">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Permissao:</label>
                                            <div class="input-group">
                                                <input type="text" name="tipo_permissao" id="nomePermissao" class="form-control" required="required">
                                                <div class="input-group-btn">
                                                    <button type="submit" class="btn btn-primary botaoLoad">
                                                        Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="acao" value="insertPermissao"> 
                                </form>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Permissões</label>
                                        <div class="scrollbar">
                                            <ul class="list-group" id="listaPermissao">
                                                <?php
                                                foreach ($lista_permissao as $li) :
                                                    ?>

                                                    <li class="list-group-item"><?= $li['tipo_permissao']; ?></li>

                                                    <?php
                                                endforeach;
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--

<script language="javascript" type="text/javascript" src="modulos/usuarios/public/js/min/modal.js"></script>
-->

<script language="javascript" type="text/javascript" src="modulos/usuarios/public/js/modal.js"></script>