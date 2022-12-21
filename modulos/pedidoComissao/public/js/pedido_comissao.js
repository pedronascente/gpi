//charset="utf-8"

var pedido_comissao = {};

pedido_comissao.init = function () {

    url = "modulos/pedidoComissao/src/controllers/pedido_comissao.php";

    //DELETA PEDIDO DE COMISSÃO
    $(".deletePedidoComissao").click(pedido_comissao.checarDelete);

    //VERIFICA SE HÁ INCONSISTÊNCIAS NA PLANILHA
   // $(".verificarComissoes").click(pedido_comissao.verificarComissoes);

    //ENVIA A PLANILHA
    $(".enviarPlanilha").click(pedido_comissao.enviarPlanilha);

    //DELETA A PLANILHA DE COMISSÃO
    $(".delPlanilhaComissao").click(pedido_comissao.excluirPlanilha);

    //LIMPA CAMPO DE DATA
    $(".limpa").click(pedido_comissao.limparCampo);
    
    $(".editarPlanilha").focusout(pedido_comissao.salvarDadosPlanilha);
	
	$(".arquivarPlanilha").click(pedido_comissao.arquivarPlhanilha);

};

$(pedido_comissao.init);


pedido_comissao.checarDelete = function () {

    var url = $(this).attr("id");

    if (confirmarDelete()) {
        if (!$("#total").val() > 1)
            alert("Você precisa ter ao menos um pedido de comissão cadastrado!");
        else
            location.href = url;
    }

};
pedido_comissao.enviarPlanilha = function () {

    var id = $(this).attr("id");

    var confir = confirm('Você deseja Enviar  esta Planilha ?');
    if (confir == true) {
        $.post(url, {acao: 'enviar_dados', id: id}, function (data) {
            alert('Planilha enviada com sucesso.');
            location.href = "index.php?pg=5";
        }, "text");
    }

};

pedido_comissao.excluirPlanilha = function () {
    var idPlanilha = $(this).attr("id");
    if (confirmarDelete()) {
        $.ajax({
            url: 'modulos/pedidoComissao/src/controllers/pedido_comissao.php',
            type: 'POST',
            dataType: 'json',
            data: {id: idPlanilha, acao: "del_funcionario"},
            success: function (json) {
                window.location.reload();
            }, error: function () {
                alert("Erro ao enviar requisição!");
            }
        });
    }

};

pedido_comissao.limparCampo = function () {
    $(".campo_data").attr("value", "");
}

pedido_comissao.salvarDadosPlanilha = function(){
	var campo = $(this).attr("id");
	var texto = $(this).text();
	var id = $(this).closest("tr").attr("id");
	
	$.ajax({
        url: 'modulos/pedidoComissao/src/controllers/pedido_comissao.php',
        type: 'POST',
        dataType: 'json',
        data: {id_pcf: id, acao: "salvarAlteracoesPlanilha", campo:campo, texto:texto},
        success: function (json) {
        	
        }, error: function () {
            alert("Erro ao enviar requisição!");
        }
    });
}


pedido_comissao.arquivarPlhanilha = function(){
     var idPCF = $(this).attr("data-id");
     location.href = url + "?acao=arquivarPlanilha&id=" + idPCF;
}

