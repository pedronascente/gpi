<?php
/**
 * Created by PhpStorm.
 * User: desenvolvimento02
 * Date: 08/11/2017
 * Time: 09:35
 */
?>
<div class="modal fade" id="confirmarExclusao" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" action="modulos/certificados/src/controllers/Certificados.php">
                            <div class="alert alert-danger" role="alert"> <strong>Atenção!</strong> Deseja realmente excuir <strong><span id="empresa"></span></strong></div>
                            <input type="hidden" name="id_certificado" id="id_certificado" value="NULL">
                            <input type="hidden" name="urlArquivo" id="urlArquivo" value="NULL">
                            <input type="hidden" name="acao" value="remove">
                            <button type="submit" class="btn btn-success">Sim</button>
                            <button type="button" data-dismiss="modal" class="btn btn-danger">Não</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#confirmarExclusao').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        var id = button.data('idcertificado');
        var url = button.data('urlarquivo');
        var empresa = button.data('empresa');

        var modal = $(this);
        modal.find("#id_certificado").val(id);
        modal.find("#urlArquivo").val(url);
        modal.find("#empresa").text(empresa);
    })
</script>
