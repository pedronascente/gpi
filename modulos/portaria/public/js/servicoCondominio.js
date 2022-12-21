//charset="utf-8"
var servicoCondominio = {};
servicoCondominio.init = function () {
    $('.optionsRadiosServicos').click(function() {
        if ($(this).val() == 's') {
            $('#ps_tipoServico').attr("disabled",true).val('Desabilitado').val('');
            $('#pcs_ps_id').removeAttr("disabled").val('').attr('required','required');
        }else{
            $('#ps_tipoServico').removeAttr("disabled").val('').attr('required','required');
            $('#pcs_ps_id').attr("disabled",true).val('');
        }
    });
};
$(servicoCondominio.init);