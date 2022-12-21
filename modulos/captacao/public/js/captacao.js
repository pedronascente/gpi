//C:\wamp\www\gpi\modulos\captacao\public\js\captacao.js

var captacao = {};
captacao.init = function () {
    $('#captacao_atendimento').change(captacao.selHorario);
    $("input[type=radio]").click(captacao.SelTipoPessoa);
    $('#btn_addMais_tel1').click(captacao.addMaisTell);
    $('#btn_addMais_tel2').click(captacao.addMaisTel2);
    $('#btn_addMenos_tel2').click(captacao.addMenosTel2);
    $('#btn_addMenos_tel3').click(captacao.addMenosTel3);
    $('#btn_visualizar_proposta').click(captacao.visualizarProposta);
    $('#btn_busca_total_captacao').click(captacao.busc);
    $('#btn_filtroddd').click(captacao.atribuirFiltroDDD);
    $('#btn_addMais_veic').click(captacao.addMaisVelc);
    $('#captacaostatus').change(captacao.buscCap);
    $('select[name=cidu]').change(captacao.up);
    $('select[name=captacao_ativar]').change(captacao.PermissaoCaptacao);
    $('#slct_filtroDDD2').change(captacao.txt_ddd_adiciona);
    $('#slct_filtroDDD1').change(captacao.txt_ddd_adiciona);
    $('#ck_filtrarDDD').change(captacao.manutencaoFiltroDDD);
    /*MONTA FILTRO*/
    $('#filtrar-captacao-filtro').change(captacao.filtrarPor);
    $("#nivelSwitch").trigger("change");
    $('#captacao_idu3').change(captacao.verificarFiltro_ddd);
    $(".deleteCaptacao").click(captacao.deletarCaptacao);
    $(".form-exclui-captacao").submit(captacao.verificarDelete);
    $("#nivelSwitch").change(captacao.switchNivel);    
    $("#td_filtrarDDD").hide();
    $("#filtroDeDDD").hide();
    $("#indiceGrafico").change(captacao.mudarCampos);
    $('#box_horario').hide();
    $("#interesseCaptacao").hide();
    $("#gerarGrafico").submit(captacao.gerarGrafico);
    $("#formAcionamento").submit(captacao.validarFormularioAcionamento);
};
$(captacao.init);

//LIBERA CAMPO DE PESQUISA:
captacao.filtrarPor = function () {
    var filtro = $(this).val();
    switch (filtro) {
        case '1':
            $("#filtrar-captacao-data").fadeIn('slow');
            $("#filtrar-captacao-input-data").attr('required', true);
            $("#filtrar-captacao-cliente,#filtrar-captacao-status").hide();
            $('#filtrar-captacao-input-cliente,#filtrar-captacao-input-status').removeAttr('required');
            break;
        case '2':
            $("#filtrar-captacao-cliente").fadeIn('slow');
            $("#filtrar-captacao-input-cliente").attr('required', true);
            $('#filtrar-captacao-input-data,#filtrar-captacao-input-status').removeAttr('required');
            $("#filtrar-captacao-data,#filtrar-captacao-status").hide();
            break;
        case '3':
            $("#filtrar-captacao-status").fadeIn('slow');
            $("#filtrar-captacao-input-status").attr('required', true);
            $('#filtrar-captacao-input-data,#filtrar-captacao-input-cliente').removeAttr('required');
            $("#filtrar-captacao-cliente,#filtrar-captacao-data").hide();
            break;
        case '4':
            $('#filtrar-captacao-input-data,#filtrar-captacao-input-cliente,#filtrar-captacao-input-status').removeAttr('required');
            $("#filtrar-captacao-cliente,#filtrar-captacao-data,#filtrar-captacao-status").hide();
            break;
    }
};


captacao.selHorario = function () {
    var dado = $(this).val();
    if (dado == 'Fora do Horário')
        $('#box_horario').slideDown();
    else
        $('#box_horario').slideUp();
};

captacao.visualizarProposta = function () {
    $('.visualizar_proposta').slideDown();
};

captacao.busc = function () {
    var id = $('#captacao_id_usuario').val();
    var status = $('#captacao_status').val();
    $.ajax({
        url: 'modulos/captacao/src/controllers/captacao.php',
        type: 'POST',
        dataType: 'json',
        data: {id: id, acao: 'b', status: status},
        success: function (json) {
            $(' #lista').html('<b>Nome .: </b>' + json.nome + '<br><b>Status .:</b>' + json.captacao_status + '<br><b>Total .:' + json.total + '</b>');
        }, error: function () {
            alert("Erro ao enviar requisição!");
        }
    });
};


/*
 ****************************************************************************
 ********* RESPONSAVEL POR REALOCAR A CAPTAÇÃO PARA OUTRO VENDEDOR **********
 ****************************************************************************
 */
captacao.up = function () {
    var myString = $(this).val();
    var setor = myString.split(",");
    var captacao_id_usuario = setor[0];
    var captacao_id = setor[1];
    var captacao_status = $('#captacao_status').val();
    $.ajax({
        url: 'modulos/captacao/src/controllers/captacao.php',
        dataType: 'json',
        type: 'post',
        data: {
            acao: 'up_captacao',
            captacao_id: captacao_id,
            captacao_id_usuario: captacao_id_usuario,
            captacao_status: captacao_status
        }, success: function (text) {
            if (text.type == 1)
                window.location.reload();
        }, error: function () {
            alert("Erro ao enviar requisição!");
        }
    });
};
captacao.PermissaoCaptacao = function () {
    var ativar = $(this).val();
    var id_usuario = $(this).attr('id');
    $.ajax({
        url: 'modulos/captacao/src/controllers/captacao.php',
        dataType: 'json',
        type: 'post',
        data: {
            acao: 'permissao_captacao',
            ativar: ativar,
            idu: id_usuario
        }, success: function (json) {
            if (json.type == 'success')
                window.location.reload();
        }, error: function () {
            alert("Erro ao enviar requisição!");
        }
    });
};

captacao.atribuirFiltroDDD = function () {
    var idu = $('#captacao_idu3').val();
    //VERIFICA SE FOI SELECIONADO UM VENDEDOR
    if (idu == '') {
        alert('selecione um vendedor');
        return false;
    }
    ;
    var ddds = $("#txt_filtroDDD1").val();
    ddds = $.trim(ddds);
    if (ddds == "") {
        alert('O Preenchimento de DDD é Obrigatório!');
        return false;
    }
    ;

    ddds = ddds.split(",");

    $.ajax({
        url: 'modulos/captacao/src/controllers/captacao.php',
        dataType: 'json',
        type: 'post',
        data: {acao: 'atribuirFiltroDDD', idu: idu, ddds: ddds},
        success: function (texto) {
            window.location.reload();
        }, error: function () {
            alert("Erro ao enviar requisição!");
        }
    });
};
//MANUTENÇÃO DE FILTRO DE DDD - PRIMEIRA AÇÃO OBRIGA SELECIONAR UM VENDEDOR 
captacao.verificarFiltro_ddd = function () {
    var idu = $(this).val();
    //VERIFICA SE VENDEDOR TEM FILTRO DE DDD
    var idu = $(this).val();
    //VERIFICA SE VENDEDOR TEM FILTRO DE DDD
    if (idu != '') {
        $.ajax({
            url: 'modulos/captacao/src/controllers/captacao.php',
            dataType: 'json',
            type: 'post',
            data: {acao: 'verificarFiltro_ddd', idu: idu},
            success: function (texto) {
                var listDDD = texto.result;
                if (listDDD != -1) {
                    listDDD = listDDD.replace('"', '');
                    listDDD.trim();
                    listDDD = listDDD.substring(0, (listDDD.length - 1));
                    //SE VENDEDOR TEM FILTRO DE DDD, EXIBE CHECK BOX "COM FILTRO DDD"
                    //Atribui ao campo do formulario a lista de DDD cadastrados do vendedor	
                    $("#txt_filtroDDD1").val(listDDD);
                    $("input[type=checkbox][name='ck_filtrarDDD']").attr("checked", false);
                    $("#filtroDeDDD").show();
                } else {
                    //SE VENDEDOR NÃO TEM FILTRO DE DDD, EXIBE CHECK BOX SELECIONADO "SEM FILTRO DDD"
                    $("#txt_filtroDDD1").val("");
                    $("input[type=checkbox][name='ck_filtrarDDD']").attr("checked", true);
                    $("#filtroDeDDD").hide();
                }
                $("#td_filtrarDDD").show();
            }, error: function () {
                alert("Erro ao enviar requisição!");
            }
        });
    }
};

captacao.manutencaoFiltroDDD = function () {
    var idu = $('#captacao_idu3').val();
    //VERIFICA SE FOI SELECIONADO UM VENDEDOR
    if (idu == '') {
        alert('selecione um vendedor');
        return false;
    }
    //SE NÃO CHEKCADO, INDICA QUE O VENDEDOR VAI RECEBER CAPAÇÃO DE RGIÕES ESPECIFICAS (filtro de ddd)
    var ck_filtrarDDD = $("input[type=checkbox][name='ck_filtrarDDD']:checked").val();

    //SE MARCAR PARA "NAO TRABALHAR COM FILTRO DE DDD" DEVE ATUALIZAR NA BASE O FILTRO DO VENDEDOR
    if (ck_filtrarDDD) {
        $(captacao.excluirFiltroDDD(idu));
    } else {
        $("#filtroDeDDD").show();
    }
};
captacao.excluirFiltroDDD = function (id) {
    var idu = $('#captacao_idu3').val();
    //if(confirm("Confirma Desabilitar o filtro de DDD?")) {
    $("#lable_ckFiltroddd").addClass("emExecucao");
    //EXCLUI O FILTRO DE DDD DO VENDEDOR	
    $.ajax({
        url: 'modulos/captacao/src/controllers/captacao.php',
        dataType: 'json',
        type: 'post',
        data: {acao: 'excluir_filtro_ddd', idu: idu},
        success: function (texto) {
            window.location.reload();
        }, error: function () {
            alert("Erro ao enviar requisição!");
        }
    });
    return true;
};
captacao.txt_ddd_adiciona = function () {

    var id = $(this).attr("id");

    var dddlist = $("#" + id + ' option:selected').text();

    var tamanho = id.length;

    id = id.substring(tamanho - 1, tamanho);
    var texto = ("#txt_filtroDDD" + id);

    var txt_filtroDDD = $(texto).val();
    txt_filtroDDD += (txt_filtroDDD == "") ? dddlist : "," + dddlist;
    $(texto).val(txt_filtroDDD);
};
/*
 ************************************************************************
 ********** funcao verifica o tipo de peesoa Fisica / Juridica **********
 ************************************************************************
 */
captacao.SelTipoPessoa = function () {
    var radio = $("input[type=radio][name=tipo_pessoa]:checked").val();
    if (radio == 'f') {
        $('#title_nome').text('Nome:');
        $('#title_cpf').text('CPF:');
        $('input[name="cnpjcpf_cliente"]').mask("000.000.000-00");
    }
    if (radio == 'j') {
        $('#title_nome').text('Razão Social:');
        $('#title_cpf').text('CNPJ:');
        $('input[name="cnpjcpf_cliente"]').removeClass('mask_cpf').mask("00.000.000/0000-00");
    }
};

captacao.deletarCaptacao = function () {
    if (confirmarDelete()) {
        var id = $(this).attr("id");
        var ids = id.split("_");
        var idCaptacao = ids[0];
        var idUsuario = ids[1];
        $.ajax({
            url: 'modulos/captacao/src/controllers/captacao.php',
            dataType: 'json',
            type: 'post',
            data: {acao: 'DedeteNivelCaptacao', captacao_niveis_usuarios_id: idCaptacao, id_usuario: idUsuario},
            success: function (text) {
                window.location.reload();
            }, error: function () {
                alert("Erro ao enviar requisição!");
            }
        });
    }
};

captacao.verificarDelete = function () {
    confirmarDelete();
};


captacao.switchNivel = function () {
    if ($(this).val() == 1)
        $("#regraSwitch").attr("disabled", true);
    else
        $("#regraSwitch").attr("disabled", false);
}


captacao.mudarCampos = function(){
	var indice = $(this).val();
	
	switch(indice){
	
		case "interesses":
			$("#interesseCaptacao").hide();
			$("#statusCaptacao").show();
			$("#vendedor").show();
			break;
			
		case "vendedores":
			$("#vendedor").hide();
			$("#interesseCaptacao").show();
			$("#statusCaptacao").show();
			break;
			
		case "estados":
			$("#vendedor").show();
			$("#interesseCaptacao").show();
			$("#statusCaptacao").show();
			break;
			
		case "status":
			$("#vendedor").show();
			$("#statusCaptacao").hide();
			$("#interesseCaptacao").show();
			break;
	}
}

captacao.gerarGrafico = function() {
	
	var formulario = $(this).serialize();
	
	//var titulo = "CAPTAÇÃO "+ $("#indiceGrafico").val().toUpperCase();
	var titulo = "Captação "+  $("#indiceGrafico option:selected").text();
	var periodo = "De " + $("#dt_inicial_grafico").val() + " até " + $("#dt_final_grafico").val();
	
	 $.ajax({
         url: 'modulos/captacao/src/controllers/captacao.php',
         dataType: 'json',
         type: 'post',
         data: formulario,
         success: function (dados) {
            
        	 if(dados != null){
        		 $("#grafico").removeAttr("style");
        		 
        		 var tipo = $("#tipoGrafico").val();
        		 
        		 var estilo = $("#estiloGrafico").val();
        		 
        		 var tipo = tipo != 'line' ? tipo+estilo : tipo;
        		 
        		 var revenueChart = new FusionCharts({
        		        type: tipo,
        		        renderAt: 'chart-container',
        		        width: '1000',
        		        height: '650',
        		        dataFormat: 'json',
        		        dataSource: {
        		            "chart": {
        		                "caption": titulo,
        		                "subCaption": periodo,
        		                "theme": "fint",
        		                "placevaluesInside": "1",
        		                "showBorder": "0",
        		                "bgColor": "#FFFFFF",
        		                "rotatevalues": "1",
        		                "formatNumberScale":'0',
        		                "legendPosition": "right",
        		                "showPercentValues" :'1',
        		                "showPercentInToolTip" :'1',
        		                "exportEnabled": "1",
        		                "showLegend": "1",
        		                "decimals": "2"
        		                //Adding canvas background angle

        		            },
        		            "data": dados
        		        },
        		    }).render();
        		 
        	 }
        	 
         }, error: function () {
             alert("Erro ao enviar requisição!");
         }
     });
	 
	return false;
}


captacao.validarFormularioAcionamento = function(){
	
		if($(":radio:checked").length != 6){
			alert("Você deve responder todas as perguntas!");
			return false;
		}
		
	
}
