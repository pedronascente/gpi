var ramal = {};
ramal.init = function () {
    
    /*
     **************************************
     ********** ZEBRAR A TABELA **********
     **************************************
     */

    $('.listaRamal tr:even').css('background', '#F0EEEF');
    $('.listaRamal tr:odd').css('background', '#E2E0E2');

    /*
     ************************************************
     ********** ESCONDE A DIV DO RELATORIO **********
     ************************************************
     */

    $('#li_retornoRamal').hide();

    /*
     ************************************
     ********** DELETA O RAMAL **********
     ************************************
     */

    $(".deletarRamal").click(ramal.deletarRamal);
    
};

$(ramal.init);



ramal.deletarRamal = function () {

    var id = $(this).attr("id");

    if (confirmarDelete()) {
        $.ajax({
            url: "modulos/ramal/src/controllers/ramal.php",
            data: {acao: "deletarRamal", id: id},
            dataType: 'json',
            type: 'POST',
            success: function () {
                window.location.reload();
            }
        });
    }
};