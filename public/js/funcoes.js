var funcoes = {};
funcoes.init = function () {
    $(".selectStatusDefaut").change(function () {
        location.href = $(".selectStatusDefaut :selected").attr("id");
    });

    $(".bordaTD").click(function () {
        location.href = $(this).attr("id");
    });

    $("#buscarRamal").keyup(funcoes.buscarRamal);
    $("#buscarRamal").focusout(function () {
        $("#dropBuscaRamal").parent().removeClass('open');
    });

    $(".sidebar-toggle").click(function () {
        var sidebar = !$("body").hasClass("sidebar-collapse") ? "sidebar-collapse" : "";
        document.cookie = "sidebar=" + sidebar + "; expires=Thu, 18 Dec 2400 12:00:00 UTC;";
    });

    //CONFIGURA CURSOR POINTER
    $(".cursorPointer").css("cursor", "pointer");

    $('#placa').change(function () {
        var dados = $(this).val().split('_');
        var placa = dados[0];
        if (placa) {
            $('#textPlaca').text(placa);
        }
    });

    //REALIZAR CONSULTAS EXTERNAS
    $(".radio_AprovaReprova").click(funcoes.AprovaReprova);

    //MANTER TABS NO RELOAD
    var hash = window.location.hash;

    if (hash == ""){
        $('.nav-tabs a:first').tab('show');
    }else{
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');
    }
    $('.nav-tabs a').click(function (e) {
        $(this).tab('show');
        var scrollmem = $('body').scrollTop();
        window.location.hash = this.hash;
    });
    //PESSOA FISICA OU JURIDICA
    var checked = "f";

    $(".tipoPessoa").click(function () {
        $(".tipoPessoa").removeClass("active");
        $(this).addClass("active");
        $("#textoTipoPessoa").val($(this).attr("id"));
        checked = $(this).attr("id");
        if ($(this).attr("id") == "f") {
            $('#title_nome').text('Nome:');
            $('#cpf_cnpj').mask("000.000.000-00");
        } else {
            $('#title_nome').text('Razão Social:');
            $('#cpf_cnpj').removeClass('mask_cpf').mask("00.000.000/0000-00");
        }
    });

    $(".trocarVersao").click(funcoes.trocarVersaoGPI);

    $("#consultarCPF").submit(function () {

        var cpfcnpj = $("#cpf_cnpj").val();

        if (checked == "f") {
            if (!validarCPF(cpfcnpj)) {
                alert("Por favor digite um cpf válido!")
                return false;
            }
        } else {
            if (!validarCNPJ(cpfcnpj)) {
                alert("Por favor digite um cnpj válido!")
                return false;
            }
        }

    });

    $("#tipo_cadastro").change(function () {
        if ($(this).val() == "venda")
            $("#vigencia").hide();
        else
            $("#vigencia").show();
    });

    $("#seuCheckbox").click(function () {
        if ($("#seuCheckbox").is(":checked")) {
            $("#dadosEndereco").collapse("show");
            $(".required").attr("required", true);
            $("#endCobranca").val("ativo");
        } else {
            $("#seuCheckbox").attr("checked", false);
            $("#dadosEndereco").collapse("hide");
            $(".required").attr("required", false);
            $("#endCobranca").val("inativo");
        }
    });

    $("#dadosEndereco").collapse("show");

    $("#formAnexos").submit(function () {
        if ($("#assinatura").val() == "") {
            alert("Por favor selecione um arquivo para inserir!");
            return false;
        }
    });

    //RESPONSAVEL POR FORMATAR AS MASCARAS
    $(".mask_real").priceFormat({
        prefix: 'R$ ',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });

    $(".pia_ip").mask("000.000.000.000");
    $(".mask_uf").mask("SS");
    $(".mask_cep").mask("00000-000");
    $(".mask_ddd").mask("(99)");
    $(".mask_placa").mask("SSS-9999");
    $(".mask_telefone").mask("(00)00000-0090");
    $(".mask_cnpj").mask("00.000.000/0000-00");
    $(".mask_hora").mask('00:00');
    $(".mask_anofab").mask('00/00');
    $(".mask_cpf").mask("000.000.000-00");
    $(".mask_latlong").mask("000.00000");
    $(".modalOpen").click(funcoes.carregarModal);
    $('.dropdown-menu').click(function (e) {
        e.stopPropagation();
        if ($(e.target).is('[data-toggle=modal]')) {
            $($(e.target).data('target')).modal();
        }
    });
    $(".confimarDeleteLink").click(funcoes.confirmaDeleteLink);
    //FUNÇÃO RESPONSAVEL POR GERENCIAR O MODAL DO PANEL PRINCIPAL    
    $('.dialog_Ap').on('click', funcoes.AprovarRequisicoesSPCandSERASA);

    $(funcoes.AcionarBotao);
    $(funcoes.Anexos);
    //RESPONSAVEL POR BUSCAR ENDEREÇOS ATRAVÉZ DO CEP 
    $('.buscaCEP').click(function () {
        var cep = $('._cep');
        var rua = $('._rua');
        var bairro = $('._bairro');
        var cidade = $('._cidade');
        var uf = $('._uf');
        buscaCEPCorreios(cep, rua, bairro, cidade, uf, 'buscaCEP');
    });
    $('.buscaCepEnderecoCobranca').click(
            function () {
                var cep = $('._cepE');
                var rua = $('._ruaE');
                var bairro = $('._bairroE');
                var cidade = $('._cidadeE');
                var uf = $('._ufE');
                buscaCEPCorreios(cep, rua, bairro, cidade, uf, 'buscaCepEnderecoCobranca');
            });
    //DESABILITA BOTÃO APÓS PRIMEIRO CLICK 
    $(".loadForm").submit(funcoes.loadStageForm);
    $(".botaLoad").click(funcoes.loadStage);
    $('#sel_plano_assistencial').change(function () {
        var valor = $(this).val();
        if (valor == 's') {
            $('#valorpla').fadeIn('slow');
        } else if (valor == 'n' || valor == 'i') {
            $('#valorpla').fadeOut('slow');
        }
    });
    $("#select_seguro").change(function () {
        var valor = $(this).val();
        $('#selectSeguro').val(null);
        if (valor == 's') {
            $('#tipo_seguro').fadeIn();
        } else {
            $('#tipo_seguro').fadeOut();
        }
    });
    //validar o campo tipo de seguro 
    $("#frm_proposta").submit(function () {
        if ($("#select_seguro").val() == 's' && $('select[name="tipo_seguro"]').val() == 'null') {
            alert('Informe um Tipo de Seguro.');
            $('select[name="tipo_seguro"]').focus();
            return false;
        }
    });
};
$(funcoes.init);
funcoes.AprovaReprova = function () {
    var valor = $(this).val();
    if (valor == "reprovado") {
        $('#boxMotivoReprovacao').fadeIn('slow');
        $("#selectReprovado").attr("disabled", false);
    } else if (valor == "aprovado") {
        $('#boxMotivoReprovacao').fadeOut('slow');
        $("#selectReprovado").attr("disabled", true);
    }
};
//RESPONSAVEL POR BUSCAR ENDEREÇO ATRAVEZ DO CEP
function buscaCEPCorreios(cep, rua, bairro, cidade, uf, origem) {
    if (cep.val() == "") {
        alert('campo cep obrigatorio');
        cep.focus();
        return false;
    } else {
        rua.val("carregando.....");
        bairro.val("carregando.....");
        cidade.val("carregando.....");
        uf.val("carregando.....");
        var q4 = cep.val();
        $.getScript("http://cep.republicavirtual.com.br/web_cep.php?cep=" + q4 + "&formato=javascript", function () {
            var Rua = unescape(resultadoCEP.logradouro);
            var Bairro = unescape(resultadoCEP.bairro);
            var Cidade = unescape(resultadoCEP.cidade);
            var Uf = unescape(resultadoCEP.uf);
            rua.val(Rua);
            bairro.val(Bairro);
            cidade.val(Cidade);
            uf.val(Uf);
            buscaCodCidade(cidade, uf, origem);
        });
    }
};
function mudarCamposCep(cidade, uf) {
    alert("Não foi identificada uma conexão com a internet.\nPor favor digite os dados manualmente.");
    cidade.replaceWith('<select class="m_cidades inputWidth100" name="' + cidade.attr('name') + '" id="' + cidade.attr('id') + '"></select>');
    uf.replaceWith('<select class="m_estados inputWidth100" name="'   + uf.attr('name') + '" id="' + uf.attr('id') + '"></select>');
    popularEstados();
};
//BUSCA O CODIGO IBGE DO MUNICIPIO 
function buscaCodCidade(cidade, uf, _origem) {
    $.ajax({
        url: 'modulos/captacao/src/controllers/captacao.php',
        dataType: 'json',
        type: 'post',
        data: {
            acao: 'consultarCodCidade',
            cidade: cidade.val(),
            uf: uf.val()
        },
        success: function (codigo) {
            if (codigo.cod == 0) {
                alert("Código não encontrado no sistema dos correios,\nvocê será redirecionado para a página do IBGE onde pode fazer a consulta manualmente!");
                window.open('http://www.ibge.gov.br/home/geociencias/areaterritorial/area.shtm', '_blank');
            } else {

                if (_origem == 'buscaCEP')
                    $('input[name="cod_municipio"]').val(codigo.cod);
                else if (_origem == 'buscaCepEnderecoCobranca')
                    $('input[name="cod_municipio_cobranca"]').val(codigo.cod);
            }
        },
        error: function () {
            alert("Erro ao enviar requisição!");
        }
    });
};
//RSPONSAVEL POR VALIDAR CPF
function validarCPF(strCPF) {
    var cpf = strCPF;
    cpf = cpf.replace('-', "");
    cpf = cpf.replace('.', "");
    strCPF = cpf.replace('.', "");
    var Soma;
    var Resto;
    Soma = 0;
    if (strCPF == "00000000000")
    {
        return false;
    }
    for (i = 1; i <= 9; i++)
        Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;
    if ((Resto == 10) || (Resto == 11))
    {
       Resto = 0;
    }
    if (Resto != parseInt(strCPF.substring(9, 10)))
        return false;
    Soma = 0;
    for (i = 1; i <= 10; i++)
        Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;
    if ((Resto == 10) || (Resto == 11))
        Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11)))
        return false;
    return true;

};

//APROVAR OU REPROVAR UMA CONSULTA SPC SERASA
funcoes.AprovarRequisicoesSPCandSERASA = function () {
    var result = $(this).attr('id').split('_');
    var id = result[0];
    var nome = result[1];
    var tipo = result[2];
    var t = "";
    var acao = "";
    if (tipo == "apRastreador" || tipo == "apAlarme") {
        acao = "APrP";
    } else {
        acao = "RPrP";
    }
    if (tipo == "apRastreador" || tipo == "apAlarme") {
        $.ajax({
            url: 'application/controllers/cliente.php',
            data: {
                acao: acao,
                id: id,
                tipo: tipo
            },
            type: 'POST',
            dataType: 'json',
            success: function (json) {
                if (json.type == 1) {
                    alert(nome + '\n foi Aprovado com sucesso');
                    location.reload();
                }
            },
            error: function () {
                alert('error ao enviar');
            }
        });
    } else {
        $('#id').val(id);
        $('#tipo').val(tipo);
        $('#acao').val(acao);

        if (tipo == "rpRastreador") {
            t = " Rastreado";
        } else {
            t = "Alarme";
        }
        $(".dialog").dialog({
            title: ' Cliente -' + t
        });
    }
};

function deletaAnexos(acao, id_anexo, nome_anexo) {
    if (window.confirm(' Deseja realmente excluir este arquivo  : '+ nome_anexo + '?')) {
        $.ajax({
                url: 'application/controllers/anexos.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    id_anexo: id_anexo,
                    nome_anexo: nome_anexo,
                    acao: acao
                },
                success: function (json) {
                    if (json.type == 'success') {
                        alert('Registro excluido com sucesso!');
                        location.reload();
                    } else {
                        alert('Impossivel excluir este arquivo ! \n verifique se ele possui um usuario ativo');
                        location.reload();
                    }
                }
        });
        return false;
    }
}
;

funcoes.loadStage = function () {
    $(this).prop("disabled", true);
};

funcoes.loadStageForm = function () {
    $(".botaoLoadForm").prop("disabled", true);
};

//VALIDA CNPJ:
function validarCNPJ(texto) {
    var cnpj = texto.replace(/[^\d]+/g, '');
    if (cnpj == '')
        return false;
    if (cnpj.length != 14)
        return false;
    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" || cnpj == "11111111111111"
            || cnpj == "22222222222222" || cnpj == "33333333333333"
            || cnpj == "44444444444444" || cnpj == "55555555555555"
            || cnpj == "66666666666666" || cnpj == "77777777777777"
            || cnpj == "88888888888888" || cnpj == "99999999999999")
        return false;

    // Valida DVs
    tamanho = cnpj.length - 2;
    numeros = cnpj.substring(0, tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
        return false;

    return true;
}
;

funcoes.deleteEnderecoCobranca = function () {
    var id = $('#id_cliente').val();
    $.ajax({
        url: 'application/controllers/captacao/captacao.php',
        type: 'POST',
        dataType: 'json',
        data: {
            id_cliente: id,
            acao: "DeleteEnderecoCobranca"
        },
        success: function (json) {
            if (json.type == 'success')
                location.reload();
        }
    });
};
//CONFIRMA EXCLUSÃO DO DADO :
function confirmarDelete() {
    var r = confirm("Deseja realmente excluir ?");
    return r;
}
;
//RESTRINGE DATA DO DATEPICKER
function formataDataPickerLimitado(anoInicial, anoFinal, mesInicial, mesFinal,diaInicial, diaFinal) {
    var minDate = new Date(anoInicial, mesInicial, diaInicial);
    var maxDate = new Date(anoFinal, mesFinal, diaFinal);
    var minDateString = diaInicial + "/" + mesInicial + "/" + anoInicial;
    var maxDateString = diaFinal + "/" + mesFinal + "/" + anoFinal;
    $('.datepicker_limitado')
            .datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR',
                startDate: minDate,
                endDate: maxDate
            })
            .on(
                    'changeDate',
                    function (selected) {
                        var userDate = new Date(selected.date.valueOf());
                        if (userDate < minDate || userDate > maxDate) {
                            alert("Essa data não tem um período válido, por favor selecione uma date entre os periodos de "
                                    + minDateString + "e " + maxDateString);
                            $('.datepicker_limitado').val(minDate);
                        }
                    });
}
;
funcoes.confirmaDeleteLink = function () {
    var href = $(this).attr("id");
    if (confirmarDelete())
        location.href = href;
};
funcoes.carregarModal = function () {
    
  
    var modal = $(this).attr("data-target");
    var caminho = $(this).attr("id");
    $(modal).html('');
    $(modal).load(caminho);
    $(modal).modal();


};
funcoes.Anexos = function () {
    var imageFile = $('.selectFile');
    var inputFile = $('.imagemAssinatura').hide();
    var campoFile = $('.fileBar');

    imageFile.click(function () {
        inputFile.click().change(function () {
            campoFile.val($(this).val());
        });
    });
};
funcoes.trocarVersaoGPI = function () {
    var id = $(this).attr("id");
    $.ajax({
        url: 'modulos/usuarios/src/controllers/usuarios.php',
        type: 'POST',
        dataType: 'json',
        data: {
            status: id,
            acao: "trocarVersaoGPI"
        },
        success: function (json) {
            window.location.reload();
        }
    });
};
funcoes.buscarRamal = function () {
    var texto = $(this).val();
    if (texto != '') {
        $.ajax({
            url: 'modulos/ramal/src/controllers/ramal.php',
            type: 'POST',
            dataType: 'json',
            data: {
                texto: texto,
                acao: "buscarRamal"
            },
            success: function (resposta) {
                $("#listaRamal li").remove();

                if (resposta.length != 0) {
                    $.each(resposta, function (x, value) {
                        $("#listaRamal").append("<li><a>" + value['ramal_nome_usuario'] + " - <strong>" + value['ramal_ramal'] + "</strong></a></li>");
                    });

                    $("#dropBuscaRamal").dropdown('toggle');
                } else {
                    $("#listaRamal").append("<li><a>Nenhum registro encontrado!</a></li>");
                }
            }
        });
    } else {
        $("#dropBuscaRamal").parent().removeClass('open');
    }
};
function empty(valor) {
    if (valor == null || valor == "" || valor == 0 || valor == "0")
        return true;
};




