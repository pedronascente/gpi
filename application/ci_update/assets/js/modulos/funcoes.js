$(function () {
    $('.datepicker').datepicker({format: 'dd/mm/yyyy', language: 'pt-BR'});
    $('.mask_data').mask('99/99/9999');
    $('.mask_cpf').mask('999.999.999-99');
    $(".mask_telefone").mask("(99) 9999-9999");
    jQuery(".mask_cep").mask("99999-999");

    $('._confirmaFinalizar').click(function () {
        if (!confirm("Deseja realmente Finalizar ?")) {
            return false;
        }
    });

    $('._btnExcluir').click(function(){
        var _divAtert;
        var id  = $(this).attr('id');
        var _url = $(location).attr('pathname') + '/excluir';
        if (confirm("Deseja realmente Excluir ?")) {
            $.ajax({
                url: _url,
                dataType: 'json',
                data: {id: id},
                type: 'post',
                success: function (obj) {
                     _divAtert ='<div class="alert alert-danger" role="alert">'
                                +' <span  class="glyphicon glyphicon-exclamation-sign"></span><strong>  Registro excluido com sucesso!</strong>'
                                +' </div>';

                    $('#_alert').html(_divAtert);
                    $('#_totalRegistro').text('Registros encontrados('+obj.total+')');
                    $("._tr"+id).hide('slow');
                }, error: function () {
                    alert("Erro ao enviar requisição!");
                }
            });
        }
    });
});