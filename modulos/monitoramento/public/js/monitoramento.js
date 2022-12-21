$(function () {

    $("#adicionarCond").click(function () {
        var veiculos = $("#gpr_tipo_veiculos").val();
        var condicao = $("#gpr_condicao").val();
        var id = $("#guincho_id").val();

        if (veiculos == "" || condicao == "")
            alert("Você deve preecher os dois campos!");
        else {
            $.ajax({
                url: 'modulos/monitoramento/src/controllers/monitoramento.php',
                dataType: 'json',
                type: 'post',
                data: {
                    acao: 'salvarCondicao',
                    gpr_tipo_veiculos: veiculos,
                    gpr_condicao: condicao,
                    gpr_guincho: id
                },
                success: function (json) {

                    $("#tabelaC").append("<tr><td>" + veiculos + "</td><td>" + condicao + "</td><td width='5%'><a class='btn btn-danger' href='modulos/monitoramento/src/controllers/monitoramento.php?id=" + json.result + "&acao=excluirCondicao&guincho_id=" + id + "'>Excluir</a></td></tr>");
                    $("#gpr_tipo_veiculos").val("");
                    $("#gpr_condicao").val("");

                }, error: function () {
                    alert("Erro ao enviar requisição!");
                }
            });
        }

    });

    $('#nomeBuscaCliente').keypress(function (e) {
        var key = e.which;
        if (key == 13) {
            $("#buscarCliente").trigger("click");
            return false;
        }
    });
    
    $('#placaVeiculoBusca').keypress(function (e) {
    	var key = e.which;
    	if (key == 13) {
    		$("#buscarVeiculo").trigger("click");
    		return false;
    	}
    });

    $("#clientes").change(function () {

        var id = $(this).val();
        $("#cadastroVeiculo").removeAttr("style");

    });

    $("#veiculosCliente").change(function () {
        if ($(this).val() == -1)
            $("#cadastroVeiculo").removeAttr("style");
        else
            $("#cadastroVeiculo").attr("style", "display:none;");
    });

    $("#btnCadastrarCliente").click(function () {
        var nome_cliente = $("#nomeCliente").val();
        if (nome_cliente != "") {
            $.ajax({
                url: 'modulos/monitoramento/src/controllers/monitoramento.php',
                dataType: 'json',
                type: 'post',
                data: {
                    acao: 'adicionarCliente',
                    nome_cliente: nome_cliente
                },
                success: function (resposta) {
                    $("#clientes").append("<option value='" + resposta['result'] + "_2' id='opAtual'>" + nome_cliente + "</option>");
                    $("#clientes").val(resposta['result'] + "_2");
                    $("#nomeCliente").val("");
                    $("#mostraClientes").removeAttr("style");
                    $("#cadastroVeiculo").removeAttr("style");
                    $("#clienteNaoEncontrado").prop("checked", false);

                }, error: function () {
                    alert("Erro ao enviar requisição!");
                }
            });
        }
    });

    $("#btnCadastrarVeiculo").click(function () {
        var placa = $("#placaVeiculo").val();

        var id = $("#clientes").val().split("_");
        var cor = $("#corVeiculo").val();
        var marca = $("#marcaVeiculo").val();
        var modelo = $("#modeloVeiculo").val();
        var ano = $("#anoVeiculo").val();

        if (placa != "") {
            $.ajax({
                url: 'modulos/monitoramento/src/controllers/monitoramento.php',
                dataType: 'json',
                type: 'get',
                data: {
                    acao: 'adicionarVeiculo',
                    placa: placa,
                    cliente: id[0],
                    nivel: id[1],
                    cor: cor,
                    marca: marca,
                    modelo: modelo,
                    ano: ano
                },
                success: function (resposta) {
                	var cliente = $("#clientes").val();
                	cliente = cliente.split("_");
                	var id_cliente = cliente[0];
                	var nivel = cliente[1]; 
                	var nome_cliente = $("#clientes :selected").text();
                    $("#corVeiculo").val("");
                    $("#marcaVeiculo").val("");
                    $("#modeloVeiculo").val("");
                    $("#anoVeiculo").val("");
                    $("#placaVeiculo").val("");
                    $("#placaVeiculoBusca").val("");
                    limparCampos();
                    console.log('<option value="' + resposta.result + '_' + id_cliente + '_2" >' + placa + ' - ' + nome_cliente + '</option>');
                    $("#veiculos").append('<option value="' + resposta.result + '_' + id_cliente + '_' + nivel + '" >' + placa + ' - ' + nome_cliente + '</option>');
                    $("#veiculos").val(resposta.result + '_' + id_cliente + '_' + nivel);
                    $("#mostraVeiculos").removeAttr("style");

                }, error: function () {
                    alert("Erro ao enviar requisição!");
                }
            });
        }
    });

    $("#formaPagamento").change(function () {
        if ($(this).val() == 2)
            $(".pagamento").hide();
        else
            $(".pagamento").show();
    });

    $("#selectEvento").change(function () {
        if ($(this).val() == 3)
            $("#texto_evento").removeAttr("style");
        else
            $("#texto_evento").attr("style", "display:none;");
    });

    $(".bloqueio").change(function () {

        if ($(".bloqueio:checked").val() == 1)
            $("#texto_bloqueio").removeAttr("style");
        else
            $("#texto_bloqueio").attr("style", "display:none;");
    });

    $(".ocorrencia").change(function () {
        if ($(".ocorrencia:checked").val() == 1)
            $("#texto_ocorrencia").removeAttr("style");
        else
            $("#texto_ocorrencia").attr("style", "display:none;");

    });

    $(".excluirGuincho").click(function () {

        var id = $(this).attr("id");

        $.ajax({
            url: 'modulos/monitoramento/src/controllers/monitoramento.php',
            dataType: 'json',
            type: 'get',
            data: {
                acao: 'excluirGuincho',
                id: id
            },
            success: function (resposta) {

                if (resposta.result != 0)
                    $("#" + id).remove();
                else
                    alert("Não é possível remover esse guincho por que ele está vinculado a assistências!");


            }, error: function () {
                alert("Erro ao enviar requisição!");
            }
        });
    });

    $("#buscarCliente").click(function () {
        var nome = $("#nomeBuscaCliente").val();
        $("#clienteMensagem").attr("style", "display:none;");
        $("#cadastroCliente").attr("style", "display:none;");
        $("#naoEncontrado").attr("style", "display:none;");
        $("#cadastroVeiculo").attr("style", "display:none;");
        $("#clienteNaoEncontrado").prop("checked", false);

        $.ajax({
            url: 'modulos/monitoramento/src/controllers/monitoramento.php',
            dataType: 'json',
            type: 'post',
            data: {
                acao: 'buscarCliente',
                nome: nome
            },
            success: function (resposta) {
                if (resposta.length != 0) {
                    var options = null;
                    $.each(resposta, function (key, value) {
                        options += '<option value="' + value.id + '_' + value.nivel + '" >' + value.nome + '</option>';
                    });

                    $("#naoEncontrado").removeAttr("style");
                    $("#mostraClientes").removeAttr("style");
                    $("#clientes").html(options);

                } else {
                    $("#clienteMensagem").removeAttr("style");
                    $("#cadastroCliente").removeAttr("style");
                }
            }, error: function () {
                alert("Erro ao enviar requisição!");
            }
        });
    });

    $("#clienteNaoEncontrado").click(function () {
        if ($(this).is(":checked")) {
            $("#cadastroCliente").removeAttr("style");
            $("#clientes option").remove();
        }
    });
    
    $("#formAssistencia").submit(function(){
    	
    	if(empty($("#assistencia_guincho").val())){
    		alert("Você deve selecionar um guincho antes de salvar!")
    		return false;
    	}
    	
    });
    
    $("#buscarVeiculo").click(function(){
    	 var placa = $("#placaVeiculoBusca").val();
    	 limparCampos();
    	 
         $.ajax({
             url: 'modulos/monitoramento/src/controllers/monitoramento.php',
             dataType: 'json',
             type: 'post',
             data: {
                 acao: 'buscarPlaca',
                 placa: placa
             },
             success: function (resposta) {
                 if (resposta.length != 0) {
                     var options = "";
                     $.each(resposta, function (key, value) {
                         options += '<option value="' + value.id_veiculo + '_' + value.id_cliente + '_' + value.nivel + '" >' + value.placa + ' - ' + value.nome_cliente + '</option>';
                     });

                     $("#naoEncontradoV").removeAttr("style");
                     $("#mostraVeiculos").removeAttr("style");
                     $("#veiculos").append(options);

                 } else {
                     $("#veiculoMensagem").removeAttr("style");
                     $("#cliente").removeAttr("style");
                 }
             }, error: function () {
                 alert("Erro ao enviar requisição!");
             }
         });
    	 
    });
});

$("#veiculoNaoEncontrado").change(function(){
	 if ($(this).is(":checked")) {
		 $("#cliente").removeAttr("style");
         $("#veiculos option").remove();
     }
});

function limparCampos(){
	 $("#naoEncontrado").attr("style", "display:none;");
     $("#naoEncontradV").attr("style", "display:none;");
     $("#mostraClientes").attr("style", "display:none;");
     $("#clienteMensagem").attr("style", "display:none;");
     $("#veiculoMensagem").attr("style", "display:none;");
     $("#cadastroCliente").attr("style", "display:none;");
     $("#cadastroVeiculo").attr("style", "display:none;");
     $("#mostraVeiculos").attr("style", "display:none;");
     $("#cliente").attr("style", "display:none;");
     $("#veiculoNaoEncontrado").prop("checked", false);
     $("#clienteNaoEncontrado").prop("checked", false);
     $("#veiculos option").remove();
}