var contrato = {}
contrato.init = function ()
{
    $(".filtrarContratoClick").change(contrato.filtrarContrato);
};

$(contrato.init);

contrato.filtrarContrato = function () {

    $("#filtrarContrato").submit();

}
