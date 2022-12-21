$(function () {

    //FILTRA A TABELA DE MODULOS POR STATUS
    $(".selectStatus").change(function () {
        var status = $(this).val();
        var name = $(this).attr("name");
        location.href = "index.php?pg=46&" + name + "=" + status;
    });

    $("#cliente").change(function () {
        var id = $(this).val();

        if (id != '') {
            $.ajax({
                url: 'modulos/compras/src/controllers/compras.php',
                dataType: 'json',
                type: 'post',
                data: {
                    acao: 'selecionaVeiculosCliente',
                    id: id
                },
                success: function (json) {

                    $('#veiculos option').remove();

                    jQuery.each(json['result'], function (i, val) {
                        $('#veiculos').append('<option value=' + val.id_veiculo + '>' + val.placa + '</option>');
                    });

                },
                error: function () {
                    alert("Erro ao enviar requisição!");
                }
            });
        }
    });

    //SELECIONA OS DADOS DO MÒDULO
    $("#selectModulo").focusout(function () {
        var modulo = $(this).val();

        if (modulo != '') {

            $.ajax({
                url: 'modulos/compras/src/controllers/compras.php',
                dataType: 'json',
                type: 'post',
                data: {
                    acao: 'selecionarModulo',
                    modulo: modulo,
                    status: 1
                },
                success: function (dadosModulo) {
                    if (dadosModulo.length != 0) {
                    	
                        jQuery.each(dadosModulo, function (i, val) {
                            $("#" + i).val(val);
                        });

                    } else {
                        alert("Esse módulo não está cadastrado no sistema!");
                    }


                },
            });
        }
    });
    
    $("#verificarSerial").focusout(function () {
        var modulo = $(this).val();

        if (modulo != '') {

            $.ajax({
                url: 'modulos/compras/src/controllers/compras.php',
                dataType: 'json',
                type: 'post',
                data: {
                    acao: 'selecionarModulo',
                    modulo: modulo
                },
                success: function (dadosModulo) {
                    if (dadosModulo.length != 0) {
                        alert("Esse módulo já foi cadastrado!");
                        location.href = "index.php?pg=46#listar";
                    } 
                },
            });
        }
    });
    
    $("#verificarChip").focusout(function () {
    	var chip = $(this).val();
    	
    	if (chip != '') {
    		
    		$.ajax({
    			url: 'modulos/compras/src/controllers/compras.php',
    			dataType: 'json',
    			type: 'post',
    			data: {
    				acao: 'selecionarChip',
    				chip: chip
    			},
    			success: function (dadosChip) {
    				if (dadosChip.length != 0) {
    					alert("Esse chip já foi cadastrado!");
    					location.href = "index.php?pg=46#listar";
    				} 
    			},
    		});
    	}
    });
    

    //SELECIONA OS DADOS DO CHIP
    $("#selectChip").focusout(function () {
        var chip = $(this).val();

        if (chip != '') {

            $.ajax({
                url: 'modulos/compras/src/controllers/compras.php',
                dataType: 'json',
                type: 'post',
                data: {
                    acao: 'selecionarChip',
                    chip: chip,
                    status: 1
                },
                success: function (dadosChip) {
                    if (dadosChip.length != 0) {
                    	
                        jQuery.each(dadosChip, function (i, val) {
                            $("#" + i).val(val);
                        });

                    } else {
                        alert("Esse chip não está cadastrado no sistema!");
                    }

                },
                error: function () {
                    alert("Erro ao enviar requisição!");
                }
            });
        }
    });

    //ADICIONA UMA CATEORIA DOS PRODUTOS
    $(".adicionarCategoria").click(function () {
        if ($("#divSelectCategoria").is(":visible")) {
            $("#divSelectCategoria").attr("style", "display:none;")
            $("#divAddCategoria").removeAttr("style");
        } else {
            var nomeCategoria = $("#nomeCategoria").val();

            if (nomeCategoria != "") {
                $.ajax({
                    url: 'modulos/compras/src/controllers/compras.php',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        acao: 'adicionarCategoria',
                        produto_categoria_desc: nomeCategoria
                    },
                    success: function (result) {
                        if (result.id != '') {
                            $("#selectCategoria").append("<option value='" + result.id + "'>" + nomeCategoria + "</option>");
                            $("#selectCategoria").val(result.id);
                        }
                    },
                    error: function () {
                        alert("Erro ao enviar requisição!");
                    }
                });
            }

            $("#divAddCategoria").attr("style", "display:none;")
            $("#divSelectCategoria").removeAttr("style");
        }
    });

    //ADICIONA UMA UNIDADE DOS PRODUTOS
    $(".adicionarUnidade").click(function () {
        if ($("#divSelectUnidade").is(":visible")) {
            $("#divSelectUnidade").attr("style", "display:none;")
            $("#divAddUnidade").removeAttr("style");
        } else {
            var nomeUnidade = $("#nomeUnidade").val();

            if (nomeCategoria != "") {
                $.ajax({
                    url: 'modulos/compras/src/controllers/compras.php',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        acao: 'adicionarUnidade',
                        produto_unidade_desc: nomeUnidade
                    },
                    success: function (result) {
                        if (result.id != '') {
                            $("#selectUnidade").append("<option value='" + result.id + "'>" + nomeUnidade + "</option>");
                            $("#selectUnidade").val(result.id);
                        }
                    },
                    error: function () {
                        alert("Erro ao enviar requisição!");
                    }
                });
            }

            $("#divAddUnidade").attr("style", "display:none;")
            $("#divSelectUnidade").removeAttr("style");
        }
    });


    //SELELCIONA A QUANTIDADE E O ESTOQUE MINIMO DO PRODUTO SELECIONADO
    $("#produtoRequisicao").change(function () {
        var id = $(this).val();

        if (id != '') {
            $.ajax({
                url: 'modulos/compras/src/controllers/compras.php',
                dataType: 'json',
                type: 'post',
                data: {
                    acao: 'pegarQuantidadeProduto',
                    id: id
                },
                success: function (result) {

                    var quantidade = result.quantidade == null ? 0 : result.quantidade;
                    var minimo = result.minimo == null ? 0 : result.minimo;

                    $("#quantidadeAtual").val(formatarNumeroFloat(quantidade));
                    $("#quantidadeAtualizada").val(quantidade);
                    $("#estoqueMinimo").val(minimo);
                    $("#unidade").val(result.unidade);

                },
                error: function () {
                    alert("Erro ao enviar requisição!");
                }
            });
        }

    });

    //ALTERA A LISTA DE PRODUTOS DE ACORDO COM O TIPO DE REQUISIÇÃO
    $("#tipoRequisicao").change(function () {

        $("#produtoRequisicao").empty();
        var tipo = $(this).val();

        if (tipo == "entrada") {
            $("#setorRequisicao").val($("#setorUsuario").val()).attr("disabled", true);
            $("#solicitanteRequiscao").hide();
            $("#solicitante").attr("required", false);
        } else {
            $("#setorRequisicao").val("").removeAttr("disabled");
            $("#solicitanteRequiscao").show();
            $("#solicitante").attr("required", true);
        }

        $.ajax({
            url: 'modulos/compras/src/controllers/compras.php',
            dataType: 'json',
            type: 'post',
            data: {
                acao: 'pegarProdutosRequisicao',
                tipo: tipo
            },
            success: function (result) {

                $("#produtoRequisicao").append('<option value="">Selecione...</option>');

                jQuery.each(result, function (i, val) {
                    $("#produtoRequisicao").append('<option value="' + val.produto_id + '">' + val.produto_descricao + '</option>');
                });

                $("#produtoRequisicao").selectpicker('refresh');

            },
            error: function () {
                alert("Erro ao enviar requisição!");
            }
        });

    });


    //VALIDA A QUANTIDADE DIGITADA
    $("#quantidadeRequisicao").focusout(function () {

        $("#alert").removeClass();
        $("#alert").empty();

        var quantidade = $(this).val();
        var quantidadeAtual = parseFloat($("#quantidadeAtual").val());
        var tipo = $("#tipoRequisicao").val();

        if (quantidade != "") {

            quantidade = formatarNumeroFloat(quantidade);

            if (tipo == "saida") {

                var minimo = $("#estoqueMinimo").val();

                var valida = true;

                if (quantidade > quantidadeAtual) {
                    alert("A quantidade digitada é maior que a do estoque!");
                    valida = false;
                }

                if (valida) {
                    var q = quantidadeAtual - quantidade;

                    if (q == 0) {
                        $("#alert").addClass("alert alert-danger").append(" <strong>Atenção!</strong> Esse produto está zerado!");

                    } else if (q <= minimo) {
                        $("#alert").addClass("alert alert-danger").append("<strong>Atenção!</strong> Esse produto atingiu o estoque minímo!");

                    }
                    q = q.toString();
                    $("#quantidadeAtualizada").val(q.replace(".", ","));

                } else {
                    $(this).val('');
                    $(this).focus();
                }

            } else {
                var q = quantidadeAtual + quantidade;
                q = q.toString();
                $("#quantidadeAtualizada").val(q.replace(".", ","));
            }

        } else {
            $("#quantidadeAtualizada").val(quantidadeAtual.toString().replace(".", ","));
        }

    });

});

//VALIDA OS CAMPOS DE QUANTIDADE
$(".mask_quantidade").focusout(function () {
    if (!validarNumeros($(this).val()))
        $(this).val("");
});


//FUNCÃO QUE VALIDA O NUMERO
function validarNumeros(numero) {
    numero = numero.replace(",", "");
    return $.isNumeric(numero);
}

//FUNÇÃO QUE TRANSFORMA DE STRING PARA FLOAT
function formatarNumeroFloat(numero) {
    numero = numero.replace(".", "");
    numero = numero.replace(",", ".");
    return parseFloat(numero);
}

