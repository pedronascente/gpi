var funcoes = {}
funcoes.init = function () {

    $(".m_estados").change(funcoes.popularCidades);

    $(".m_cidades").change(funcoes.popularCodCidades);

};


/*
 *****************************************************************************************
 ********** POPULA O SELECT COM OS ESTADOS ARQUIVADOS NO ARQUIVO m.estados.josn ********** 
 *****************************************************************************************
 */

function popularEstados() {
    $.getJSON("public/js/m_estados.json", function (json) {
        var options = "";
        options += '<option>Selecione...</option>'
        $.each(json, function (key, value) {
            options += '<option value="' + value.m_tag + '" >' + value.m_valor + '</option>';
        });
        $(".m_estados").html(options);
    });

    $(funcoes.init);
}

/*
 *****************************************************************************************
 ********** POPULA O SELECT COM AS CIDADES ARQUIVADOS NO ARQUIVO m.cidades.josn ********** 
 *****************************************************************************************
 */

funcoes.popularCidades = function () {
    $.getJSON("public/js/m_cidades.json", function (json) {
        var uf = $(".m_estados").val();
        var options = "";
        $.each(json[uf], function (key, value) {
            options += '<option value="' + value + '" >' + value + '</option>';
        });
        $(".m_cidades").html(options);
    });
}


funcoes.popularCodCidades = function () {
    var uf = $(".m_estados");
    var cidade = $(".m_cidades");
    var origem;

    if ($(this).attr("name") == "cidade_cobranca")
        origem = "buscaCepEnderecoCobranca";
    else
        origem = "buscaCEP";
    buscaCodCidade(cidade, uf, origem);

}