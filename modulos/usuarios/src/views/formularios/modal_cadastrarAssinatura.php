<?php
include ("../../../../../Config.inc.php");

$usuario = new Usuarios();
$lista = $usuario->selecionarTodos(null, true);
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Assinatura Digital</h4>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
            <form name="formulario_assinatura" id="formulario_assinatura" action="modulos/usuarios/src/controllers/usuarios.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Usuário:</label>
                            <select name="id" id="id_usuario" class="form-control selectpicker" required>
                                <option value="">Selecione um Usuario</option>
                                <?php
                                foreach ($lista as $li)
                                    echo "<option value=\"{$li['id']}\">{$li['usuario']}</option>";
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Assinatura Digital:</label>
                            <div class="input-group">
                                <input type="text" name="assinatura" id="assinatura" class="form-control file-caption  kv-fileinput-caption fileBar" required/>
                                <span class="input-group-btn">
                                    <button class="btn btn-default selectFile" type="button"><span class="glyphicon glyphicon-open"></span></button>
                                </span>
                            </div>
                            <input type="file" name="assinatura" class="imagemAssinatura" accept="image/*"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-actions">
                            <input type="hidden" name="acao" value="cadastrar_assinatura" />

                            <button type="submit" class="btn btn-primary botaoLoadForm" id="formAnexaAssinaturasBTN">
                                Anexar
                            </button>

                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {

        var imageFile = $('.selectFile');
        var inputFile = $('input:file').hide();
        var campoFile = $('.fileBar');


        imageFile.click(function () {
            inputFile.click().change(function () {
                campoFile.val($(this).val());
            });
        });

        $("#formulario_assinatura").submit(function () {
            var extensao = false;

            if ($("#assinatura").val() != "") {

                if ($("#assinatura").val().search('jpg') == -1) {
                    extensao = true;

                } else if ($("#assinatura").val().search('jpeg') == -1) {
                    extenao = true;
                }
            }

            if (extensao) {
                alert("Você deve selecionar uma imagem jpeg!");
                return false;
            }
        });

        $(".selectpicker").selectpicker({"liveSearch" : true, "showIcon": true, "size": 10});
    });
</script>
