$(function () {

    url = "modulos/pedidoComissao/src/controllers/pedido_comissao.php";
    var tela = $("#tela").val();

    var idPCF = $("#idPlanilha").val();

    var id = $(this).attr('id');

    $('.enviarPlanilha').click(function () {
        enviarPlanilha(1);
    });

    $(".statusInconsistencia").click(function () {

        var id = $(this).attr('id');

        var id = id.split("_");

        var id_usuario = $("#usuarioInconsistencia").val();

        if ($(this).hasClass("listar")) {
            $.post(url, {acao: "updateStatusInconsistencia", id_usuario: id_usuario, situacao: id[1], id_comissao: id[0], inconsistencia: id[2], tela: 1, id_planilha: $("#idPlanilha").val()}, function (data) {
                $("#" + id[0]).remove();
                if ($(".trInconsistencia :visible").length == 0){
                    $("#divInconsistencia").hide();
                    $("#mensagem").removeAttr("style");
                    $("#tutorial").hide();
                }
                $("#tabelaMostraInconsistencias").hide();
            }, "text");
        } else {
            $.post(url, {acao: "updateStatusInconsistencia", id_usuario: id_usuario, situacao: id[1], id_comissao: id[0], inconsistencia: id[2], tela: 1}, function (data) {
                id[1] == 2 ? $("#situacao" + id[0]).text("Liberada") : $("#situacao" + id[0]).text("Reprovada");
            }, "json");
        }

    });

    $(".verInconsistencias").click(function () {
        var dados = $(this).attr("id");
        var conta_placa = dados.split("///")[0];
        var id = dados.split("///")[1];
        $.post(url, {acao: "getInconsistenciasPlanilha", id: id, conta_placa: conta_placa}, function (data) {
            $("#titulo").text("Inconsistências na Conta/Placa: " + conta_placa);
            $("#incosistenciasTabela tbody tr").remove();
            $("#incosistenciasTabela").append(data.inconsistencias);
            $("#tabelaMostraInconsistencias").removeAttr("style");
            
        }, "json");
    });

    function enviarPlanilha(tela) {
        
        var confir = confirm('Você deseja Enviar  esta Planilha ?');
        if (confir == true) {
            $.post(url, {acao: 'enviar_dados', id: idPCF}, function (data) {
                alert('Planilha enviada com sucesso.');
                    location.href = "index.php?pg=5";
            }, "json");
        }
    };
    
});