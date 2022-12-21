$(function () {
    $.getJSON("modulos/captacao/public/js/m_reprovarCliente.json", function (json) {
        var options = "";
        $.each(json, function (key, value) {
            options += '<option value="' + value.m_tag + '" >' + value.m_valor + '</option>';
        });
        $(".m_reprovarConsultaSPC").html(options);
    });
});
