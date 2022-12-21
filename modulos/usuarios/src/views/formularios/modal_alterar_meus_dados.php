<?php
include ("../../../../../Config.inc.php");
@session_start();
$id_usuario_sessao = $_SESSION['user_info']['id_usuario'];
$u = new Usuarios ();
$usuario = $u->findUserById($id_usuario_sessao);
?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Alterar meus dados</h4>
        </div>			
        <div class="modal-body">
           <form id="form_Usuario" method="post" action="modulos/usuarios/src/controllers/usuarios.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nome:</label>
                            <input type="text" name="nome" class="form-control" value="<?php echo $usuario['nome'];?>"  required="required">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>E-mail:</label>
                            <input type="text" name="usuario_email" class="form-control"  value="<?php echo $usuario['usuario_email'];?>" required="required">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>RG:</label>
                            <input type="text" name="rg"  class="form-control" value="<?php echo $usuario['rg'];?>" required="required">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>CPF:</label>
                            <input type="text" name="cpf" class="form-control"  value="<?php echo $usuario['cpf'];?>" required="required">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Usuário:</label>
                            <input type="text" name="usuario"  class="form-control" value="<?php echo $usuario['usuario'];?>" required="required">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Senha:</label>
                            <input type="text" name="senha" class="form-control"  value="" >
                        </div>
                    </div>
                </div>
                <br>
                <!--
                
                <div class="row">
                    <div class="row text-center">
                          <div class="col-xs-12  col-md-12">
                              <label>Assinaturas</label> 
                          </div> 
                    </div> 
                </div>
                <br><br>
                <div class="row">
                    <div class="col-xs-12  col-md-12"> 
                       <div class="form-group">
                           <label>Contrato:</label>
                           <label class="custom-file">
                                <input type="file" id="file" class="custom-file-input" >
                                <span class="custom-file-control"></span>
                          </label>
                       </div> 
                    </div>
                    <div class="col-xs-12  col-md-12"> 
                       <div class="form-group">
                           <label>Email:</label>
                          <label class="custom-file">
                                <input type="file" id="file" class="custom-file-input">
                                <span class="custom-file-control"></span>
                          </label>
                       </div> 
                    </div>
                </div><HR>
                
                -->   
                <div class="row">
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary botaoLoadForm"> Salvar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            <input type="hidden" name="id"  value="<?=$_SESSION['user_info']['id_usuario'];?>" >
                            <input type="hidden" name="acao"  value="editar_meus_dados" >
                        </div>
                    </div>
                    <br>
                    <br>
                </div>  
            </form>
        </div>
    </div>
</div>


<?PHP
//var_dump($_SESSION);

?>