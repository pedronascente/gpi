var arquivo = {};
arquivo.init = function () {

    if ($(".linhaPlacas").length == 0 && $("#acao").val() != "editar")
        $("#arquivo").hide();


    if ($("#cnpjcpf_cliente").prop("disabled") == false)
        $("#arquivoVeiculos").hide();


    if ($("#acao").val() != "editar")
        $('#radio1').attr("checked", true);

    /*
     ************************************************************* 
     ********** MUDA TIPO DE PESSOA(FISICA OU JURIDICA ***********
     ************************************************************* 
     */

    $(".tipoPessoa").click(arquivo.SelTipoPessoa);

    /*
     **************************************
     ********** SALVA O CLIENTE ***********
     **************************************
     */

    $("#formArquivoCliente").submit(arquivo.salvarCliente);

    /*
     *******************************************************
     ********** VERIFICA SE O CPF/CNPJ JA EXISTE ***********
     *******************************************************
     */
    $("#cnpjcpf_cliente").focusout(arquivo.vericarCPFCNPF);

    /*
     **************************************
     ********** EXCLUI A PLACA ************
     **************************************
     */

    $(".deletarPlaca").click(arquivo.deletarPlaca);

    /*
     **************************************
     ********** EXCLUI A ARQUIVO **********
     **************************************
     */
    $(".deletarArquivo").click(arquivo.deletarArquivo);

    /*
     *****************************************
     ********** ADICIONA UM ARQUIVO **********
     *****************************************
     */
    $("#adicionarArquivo").click(arquivo.adicionarArquivo);


    /*
     *****************************************
     ********** ADICIONA UMA GAVETA **********
     *****************************************
     */
    $("#adicionarGaveta").click(arquivo.adicionarGaveta);

    /*
     **************************************************
     ********** SELECIONA GAVETAS DO ARQUIVO **********
     **************************************************
     */
    $("#selectA").change(arquivo.mudarGavetas);

    /*
     *****************************************
     ********** DELETA UM ARMARIO ************
     *****************************************
     */
    $(".deleteArmario").click(arquivo.deletarArmario);

    /*
     *****************************************
     ********** DELETA UMA GAVETA ************
     *****************************************
     */
    $(".deleteGaveta").click(arquivo.deletarGaveta);

    $("#addPlaca").click(arquivo.cadastrarVeiculo);

    urlArquivo = "modulos/arquivo/src/controllers/arquivo.php";
    checked = 'f';
    
};

$(arquivo.init);

var checked = "f";

arquivo.SelTipoPessoa = function () {
    $(".tipoPessoa").removeClass("active");
    $(this).addClass("active");
    $("#textoTipoPessoa").val($(this).attr("id"));

    checked = $(this).attr("id");

    if ($(this).attr("id") == "f") {
        $('#title_nome').text('Nome:');
        $('#cnpjcpf_cliente').mask("000.000.000-00");

    } else {
        $('#title_nome').text('Razão Social:');
        $('#cnpjcpf_cliente').removeClass('mask_cpf').mask("00.000.000/0000-00");
    }
};

arquivo.salvarCliente = function (e) {

    $(".botaoLoadForm").attr("disabled", true);

    var cpf_cnpj = $("#cnpjcpf_cliente").val();

    if (checked == "f") {
        if (!validarCPF(cpf_cnpj)) {
            $(".botaoLoadForm").attr("disabled", false);
            alert("Por favor digite um cpf válido!");
            return false;
        }

    } else {

        if (!validarCNPJ(cpf_cnpj)) {
            $(".botaoLoadForm").attr("disabled", false);
            alert("Por favor digite um cnpj válido!");
            return false;
        }
    }
    $(".botaoLoadForm").hide();

};


arquivo.vericarCPFCNPF = function () {

    var cpf_cnpj = $(this).val();

    if (cpf_cnpj != "") {
        $.ajax({
            url: urlArquivo,
            dataType: 'json',
            data: {cpf_cnpj: cpf_cnpj, acao: "verificarCPFCNPJ"},
            type: 'post',
            success: function (obj) {
                if (obj.count >= 1) {
                    var cliente = obj.cliente;
                    var veiculos = obj.veiculos;

                    if (cliente['arquivo_id'] != 0) {
                        alert("Já existe um arquivo com esse CPF/CNPJ!");
                        location.href = "index.php?pg=24&filtro=cpfcnpj&texto=" + cpf_cnpj;
                    } else {
                        $("#nome_cliente").val(cliente['nome_cliente']);
                        $("#nome_cliente").attr("disabled", true);
                        $(this).attr("disabled", true);
                        $("#idCliente").val(cliente['id_cliente']);
                        $("#arquivo_placas_cliente").val(cliente['id_cliente']);
                        $("#btnSalvarCliente").hide();
                        $("#formAddPlaca").hide();
                        $("#tablePlacas body tr").remove();

                        var placas = '';

                        $.each(veiculos, function (key, value) {
                        	var status =  value['veiculo_status'] == 1 ? "Ativo" : "Inativo";
                            placas += "<tr style='background:#FFFFFF' align='center'>" +
                            			"<td>" + value['id_veiculo'] + "</td>" +
                            			"<td>" + value['placa'] + "</td>" +
                            			"<td id='statusDesc'>" + status + "</td></tr>";
                            
                        });

                        $("#tablePlacas tbody").append(placas);
                        $("#arquivoVeiculos").show();
                        $("#arquivo").show();

                    }
                }
            }, error: function () {
                alert("Erro ao enviar requisição!");
            }
        })
    }
};

arquivo.deletarPlaca = function () {
    if (confirmarDelete()) {
        var dados = $(this).attr("id");
        var dados = dados.split("_");
        var id = dados[0];
        var desc = dados[1];
        var id_arquivo = dados[2];
        $.ajax({
            url: urlArquivo,
            dataType: 'json',
            data: {id: id, acao: "deletarPlaca", desc: desc, id_arquivo: id_arquivo},
            type: 'post',
            success: function (obj) {
                if (obj.type >= 1)
                    alert("Esse veículo não pode ser excluído pois existe um contrato vinculado a ele.");
                else
                    window.location.reload();
            }, error: function () {
                alert("Erro ao enviar requisição!");
            }
        });
    }
};

arquivo.deletarArquivo = function () {
    var id_arquivo = $(this).attr("id");

    if (confirmarDelete()) {
        $.ajax({
            url: urlArquivo,
            dataType: 'json',
            data: {acao: "deletarArquivo", id_arquivo: id_arquivo},
            type: 'post',
            success: function (obj) {
                $(this).attr("disabled", false);
                if (obj.type == 0)
                    location.href = "index.php?pg=24"
                else
                    alert("Esse arquivo contêm logs cadastrados, não pode ser excluído, somente alterado!")
            }, error: function () {
                alert("Erro ao enviar requisição!");
            }
        })
    }
};

arquivo.adicionarArquivo = function () {
    var texto = $("#texto_arquivo").val();
    if (texto != "") {
        $.ajax({
            url: urlArquivo,
            dataType: 'json',
            data: {texto: texto, acao: "adicionarArquivo"},
            type: 'post',
            success: function (obj) {
                $(this).attr("disabled", false);
                if (obj.type >= 1)
                    $('#selectA').append('<option value="' + obj.type + '_' + texto + '">' + texto + '</option>');
                else
                	alert("Esse arquivo já foi cadastrado!");
                $("#texto_arquivo").val("");
            }, error: function () {
                alert("Erro ao enviar requisição!");
            }
        })
    }
};

arquivo.adicionarGaveta = function () {
    var texto = $("#texto_gaveta").val();
    var id = $('#selectA').val();
    if (id != null) {
        id = id.split("_")[0];
        if (id != "" && texto != "") {
            $.ajax({
                url: urlArquivo,
                dataType: 'json',
                data: {id: id, texto: texto, acao: "adicionarGaveta"},
                type: 'post',
                success: function (obj) {
                    $(this).attr("disabled", false);
                    if (obj.type >= 1)
                        $('#selectG').append('<option value="' + obj.type + '_' + texto + '">' + texto + '</option>');
                    else
                    	alert("Essa gaveta já foi cadastrada!");
                    $("#texto_gaveta").val("");
                }, error: function () {
                    alert("Erro ao enviar requisição!");
                }
            })
        }
    } else {
        alert("Selecione um armário primeiro!");
    }
};

arquivo.mudarGavetas = function () {
    var id = $("#selectA").val();
    id = id.split("_");
    id = id [0];
    var tela = $(this).hasClass("listaArquivo") ? "listar" : "cadastrar";
    $.ajax({
        url: urlArquivo,
        dataType: 'json',
        data: {id: id, acao: "selecionarGavetas", tela: tela},
        type: 'post',
        success: function (data) {
            $('#selectG').empty();
            $(".optionVazio").append('<option value="-1"></option>');
            $('#selectG').append(data.options);
        }, error: function () {
            alert("Erro ao enviar requisição!");
        }
    })
};

arquivo.deletarArmario = function () {
    var id = $('#selectA').val();
    var id = id != null ? id.split("_")[0] : "";
    var texto = $('#selectArquivo :selected').text();
    if (id != "") {
        $.ajax({
            url: urlArquivo,
            dataType: 'json',
            data: {id: id, acao: "deletarArmario"},
            type: 'post',
            success: function (obj) {
                $(this).attr("disabled", false);
                if (obj.type != 0)
                    alert("Não é possível deletar esse arquivo porque existem clientes relacionados com ele!");
                else {
                    $("#selectA option[value='" + id + "_" + texto + "']").remove();
                    $("#selectG option").remove();
                    arquivo.mudarGavetas();
                }
            }, error: function () {
                alert("Erro ao enviar requisição!");
            }
        })
    }
};

arquivo.deletarGaveta = function () {
    var id = $('#selectG').val();
    var id = id != null ? id.split("_")[0] : "";
    var texto = $('#selectG :selected').text();
    if (id != "") {
        $.ajax({
            url: urlArquivo,
            dataType: 'json',
            data: {id: id, acao: "deletarGaveta"},
            type: 'post',
            success: function (obj) {
                if (obj.type != 0)
                    alert("Não é possível deletar essa gaveta porque existem clientes relacionados com ele!");
                else
                    $("#selectG option[value='" + id + "_" + texto + "']").remove();
            }, error: function () {
                alert("Erro ao enviar requisição!");
            }
        })
    }
};

arquivo.cadastrarVeiculo = function () {
    var formulario = $("#formArquivoVeiculos").serialize();

    $.ajax({
        url: urlArquivo,
        dataType: 'json',
        data: formulario,
        type: 'post',
        success: function (obj) {
            if (obj.type == 1){
            	var caminho = "modulos/arquivo/src/views/formularios/modalPlacasDesativadas.php?placa="+obj.placa;
            	$("#modal").html('');
            	$("#modal").load(caminho);
            	$("#modal").modal();
            }
            else {
            	if(location.href.search("id") != -1)
            		window.location.reload();
            	else
            		location.href = "index.php?pg=24&id=" + obj.id + "#cadastro";
            }
        }, error: function () {
            alert("Erro ao enviar requisição!");
        }
    })
};

