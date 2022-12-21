<?php 
// namespace C:\wamp\www\gpi\modulos\captacao\src\views\captacao\formularios\modal_enviarPropostaEmail.php
session_start();
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Enviar Proposta</h4>
        </div>			
        <div class="modal-body">
            <form method="post" id="form_enviaProposta">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Digite um E-mail válido:</label>
                            <input type="email" name="email" required placeholder="E-mail" class="form-control"> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-actions">
                            <input type="hidden" name="acao" value="enviar_proposta"> 
                            <input type="hidden" name="id_proposta" id="id_proposta" value="<?= filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); ?>"> 
                            <input type="hidden" name="id_captacao" id="id_proposta" value="<?= filter_input(INPUT_GET, 'id_captacao', FILTER_VALIDATE_INT); ?>"> 
                            <input type="hidden" name="id_usuario" id="id_usuario" value="<?= $_SESSION['user_info']['id_usuario']; ?>"> 
                            <button type="submit" class="btn btn-default botaoLoadForm" id="btn_form_enviaProposta"> 
                                Enviar
                            </button>
                             <span id="aguard_form_enviaProposta"> <img src="public/img/ajax-loader.gif" width="128" border="0" id="aguard_form_enviaProposta"></span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<link type="text/css" rel="stylesheet" href="public/css/envio_propostaEmail.css">
<script language="javascript" type="text/javascript">
    $(function () {
    	$("#aguard_form_enviaProposta").hide();
        $('#form_enviaProposta').submit(function (e) {
            e.preventDefault(); 
            var formulario = $('#form_enviaProposta').serialize();
            $.ajax({
                url: "modulos/captacao/src/controllers/proposta.php",
                dataType: 'json',
                type: 'post',
                data: formulario,
                beforeSend: function () {
                    $("#btn_form_enviaProposta").fadeOut('slow');
                    $("#aguard_form_enviaProposta").fadeIn('slow');
                },
                success: function (json) {
                    if (json.type == 1) {
                        alert('Proposta enviada com sucesso!');
                        location.reload();

                    } else if (json.type == "erro") {
                	   	alert('Não foi possivel enviar esta Proposta, dados do usuário incompletos!');
                   		location.reload();

                    } else {
                        alert('Não foi possivel enviar esta Proposta,\n tente novamente mais Tarde!');
                        location.reload();
                    }
                },
            })
        });
    });
</script>