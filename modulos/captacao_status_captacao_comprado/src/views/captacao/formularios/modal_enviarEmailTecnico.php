<?php
//namespaceC:\wamp\www\gpi\modulos\captacao\src\views\captacao\formularios\modal_enviarEmailTecnico.php
session_start(); 
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Enviar Email para o Técnico responsável</h4>
        </div>
        <div class="modal-body">
            <form method="post" id="form_enviar_dados">
                <div class="row">
                    <div class="col-xs-12  col-md-12 ">
                        <div class="form-group">
                            <label>Nome :</label>
                            <input type="text" name="destinatario" required placeholder="Digite o Nome  do destinatário" class="form-control" > 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12  col-md-12 ">
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="email" required placeholder="Digite um E-mail válido" class="form-control"> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12 ">
                        <div class="form-actions">
                            <input type="hidden" name="acao" value="enviar_email"> 
                            <input type="hidden" name="id_captacao" id="id_captacao" value="<?= filter_input(INPUT_GET, 'id_captacao', FILTER_VALIDATE_INT); ?>"> 
                            <input type="hidden" name="id_usuario" id="id_usuario" value="<?= $_SESSION['user_info']['id_usuario']; ?>"> 
                            <button type="submit" class="btn btn-default botaoLoadForm" id="btn_form_envia_email"> 
                                Enviar
                            </button>                            
                             <span id="aguardando_form_envio"> <img src="public/img/ajax-loader.gif" width="128" border="0" id="aguardando_form_envio"></span>
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
    	$("#aguardando_form_envio").hide();
        $('#form_enviar_dados').submit(function (e) {
            e.preventDefault(); 
            var formulario = $('#form_enviar_dados').serialize();
            $.ajax({
                url: "modulos/captacao/src/controllers/enviar_email_tecnica.php",
                dataType: 'json',
                type: 'post',
                data: formulario,
                beforeSend: function () {
                    $("#btn_form_envia_email").fadeOut('slow');
                    $("#aguardando_form_envio").fadeIn('slow');
                },
                success: function (json) {
                    if (json.type == 1) {
                        alert('Email enviada com sucesso!');
                        location.reload();
                    } else if (json.type == "erro") {
                        alert('Não foi possivel enviar este Email, dados do usuário incompletos!');
                        location.reload();
                    } else {
                        alert('Não foi possivel enviar este Email,\n tente novamente mais Tarde!');
                        location.reload();
                    }
                },
            })
        });
    });
</script>