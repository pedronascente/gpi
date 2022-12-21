<?php
/**
 * Created by PhpStorm.
 * User: desenvolvimento02
 * Date: 08/11/2017
 * Time: 09:35
 */
?>
<div class="modal fade" id="enviarEmail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" method="POST" action="modulos/certificados/src/controllers/Certificados.php">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Enviar Email</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="acao" value="enviarEmailArquivo">
                <input type="hidden" id="urlArquivo" name="email[urlArquivo]" value="">
                <input type="hidden" id="nomeEmpresa" name="email[nome]" value="">
                <div class="row">

                    <div class="col-md-12 form-horizontal">
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email destino</label>
                            <div class="col-sm-10">
                                <input class="form form-control" type="email" required name="email[destino][]">
                            </div>
                        </div>
                    </div>
                    <div class="input_fields_wrap">
                    </div>
                    <div class="col-md-12 form-horizontal">
                        <button class="add_field_button btn btn-default btn-xs pull-right"><span
                                    class="glyphicon glyphicon-plus"></span> Adiconar Email
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Enviar</button>
                <button type="button" data-dismiss="modal" class="btn btn-danger">Cancelar</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    var max_fields = 5; //maximum input boxes allowed
    var wrapper = $(".input_fields_wrap"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID
    var inputsCount = 1; //initlal text box count

    $('#enviarEmail').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var url = button.data('urlarquivo');
        var empresa = button.data('empresa');
        var modal = $(this);

        modal.find("#urlArquivo").val(url);
        modal.find("#nomeEmpresa").val(empresa);

        $('.input_fields_wrap').empty();
        inputsCount = 1;
    });

    $(add_button).click(function (e) { //on add input button click
        e.preventDefault();
        if (inputsCount < max_fields) { //max input box allowed
            inputsCount++; //text box increment
            $(wrapper).append('' +
                '<div class="col-md-12 form-horizontal">' +
                '   <div class="form-group">' +
                '       <label for="email" class="col-sm-2 control-label">Email destino</label>' +
                '       <div class="col-sm-9">' +
                '           <input class="form form-control" type="email" required name="email[destino][]">' +
                '       </div>' +
                '       <div class="col-sm-1">' +
                '          <a href="#" class="btn btn-danger btn-block remove_field"><span class="glyphicon glyphicon-remove"></span></a>' +
                '       </div>' +
                '   </div>' +
                '</div>' +
                ''); //add input box
        }
    });

    $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
        e.preventDefault();
        $(this).parent('div').parent('div').parent('div').remove();
        inputsCount--;
    });
</script>
