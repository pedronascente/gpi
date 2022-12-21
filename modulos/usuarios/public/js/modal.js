$(function () {

    /*
     * *******************************
     * ********* PERMISSÕES **********
     * ********************************
     */

    $("#novoGrupo").hide().attr("disabled", true);
    $("#usuario").trigger('change');

    //SELECIONA AS PERMISSÕES DO GRUPO
    $("#grupoPermissao").change(function () {
        var id_grupo = $(this).val();
        $.ajax({
            url: 'modulos/usuarios/src/controllers/usuarios.php',
            dataType: 'json',
            type: 'post',
            data: {
                acao: 'selecionarPermissoesGrupos',
                id_grupo: id_grupo
            },
            beforeSend: function () {
                $(".markCheck2").prop("checked", false);
            },
            success: function (permissoes) {

                $.each(permissoes, function (key, value) {
                    if (value != 0)
                        $("#permissao" + value['id_permissao']).prop("checked", true);
                });

            }, error: function (xhr, ajaxOptions, thrownError) {
                alert("Erro ao enviar requisição!");
            }
        });
    });


    //ADICONAR NOVO GRUPO NO SELECT
    $(".adicionarGrupo").click(function () {
        trocarModo();
    });

    //CADASTRAR EDITAR GRUPO PERMISSÃO
    $("#formAddGrupo").submit(function (e) {
        e.preventDefault();
        
        if ($(".markCheck2:checked").length != 0) {
            var formulario = $(this).serialize();
            $.ajax({
                url: 'modulos/usuarios/src/controllers/usuarios.php',
                dataType: 'json',
                type: 'post',
                data: formulario,
                success: function (data) {
                	
                	$(".botaoLoadForm2").attr("disabled", true);
                	
                    var id = data.id;

                    var acao = data.type;

                    if (id != "") {
                        if (acao == 1) {
                            $("#grupo" + id).attr("selected", true);
                            $("#grupoPermissao").trigger('change');
                        } else {
                            $('#grupoPermissao').append('<option value="' + id + '" id="grupo' + id + '">' + $("#nomeGrupo").val() + '</option>');
                            $("#grupo" + id).attr("selected", true);
                            $("#grupoPermissao").trigger('change');
                            $("#nomeGrupo").val("");
                            trocarModo();
                        }
                    }
                    
                    $(".botaoLoadForm2").attr("disabled", false);
                    
                }, error: function (xhr, ajaxOptions, thrownError) {
                    alert("Erro ao enviar requisição!");
                }
            });
        } else {
            alert("Selecione ao menos uma permissão!")
        }
    });

    $("#form_cadPermissao").submit(function (e){
        e.preventDefault();
        var formulario = $(this).serialize();

        $.ajax({
            url: 'modulos/usuarios/src/controllers/usuarios.php',
            dataType: 'json',
            type: 'post',
            data: formulario,
            success: function (data){
                console.log(data);
                if(data.tipo===null){
                    alert('Não foi possivel Atribuir suas permissões!');
                    location.reload();
                }else{
                    alert('Permissão Atribuida com sucesso!');
                    location.reload();
                }
            }, error: function (xhr, ajaxOptions, thrownError) {
                alert("Erro ao enviar requisição!");
            }
        });
    });

    $("#usuario").change(function () {
        var id = $(this).val();
        $.ajax({
            url: 'modulos/usuarios/src/controllers/usuarios.php',
            dataType: 'json',
            type: 'post',
            data: {acao: "selecionarPemissoesUsuario", id: id},
            beforeSend: function () {
                $(".markCheck").prop("checked", false);
                $("#gpPermissao").val("");
            },
            success: function (permissoes) {
            	
            	$("#gpPermissao").val(permissoes['grupo']);
	        	
	            $.each(permissoes, function (key, value) {
	                if (value != 0)
	                    $("#pUser" + value['id_permissaouser']).prop("checked", true);
	            });
                
            }, error: function (xhr, ajaxOptions, thrownError) {
                alert("Erro ao enviar requisição!");
            }
        });
    });

    $("#formAddPermissao").submit(
            function (e) {
                e.preventDefault();
                var formulario = $(this).serialize();
                var nomePermissao = $("#nomePermissao").val();

                $.ajax({
                    url: 'modulos/usuarios/src/controllers/usuarios.php',
                    dataType: 'json',
                    type: 'post',
                    data: formulario,
                    success: function (data) {

                    	$(".botaoLoadForm3").attr("disabled", true);
                    	
                        $("#listaPermissao").append(
                                "<li class='list-group-item'>" + nomePermissao + "</li>");
                        
                        $("#nomePermissao").val("");
                        $(".botaoLoadForm3").attr("disabled", false);
                        
                    }, error: function (xhr, ajaxOptions, thrownError) {
                        alert("Erro ao enviar requisição!");
                    }
                });
            });

    function trocarModo() {

        $(".markCheck").prop("checked", false);

        if ($("#selectGrupo").is(":visible")) {
            $("#novoGrupo").show();
            $("#selectGrupo").hide();
            $("#nomeGrupo").attr("disabled", false).attr("required", true);
            $("#grupoPermissao").attr("disabled", true);
            $(".adicionarGrupo").removeClass("btn-default");
            $(".adicionarGrupo").addClass("btn-primary");

        } else {
            $("#novoGrupo").hide();
            $("#selectGrupo").show();
            $("#grupoPermissao").attr("disabled", false).attr("required", true);
            $("#nomeGrupo").attr("disabled", true);
            $(".adicionarGrupo").removeClass("btn-primary");
            $(".adicionarGrupo").addClass("btn-default");
        }
    }
});

/*
 * ******************************************
 * ********** MANTER TABS NO RELOAD *********
 * ******************************************
 */

var hash = window.location.hash;

if(hash == "")
	$('.nav-tabs a:first').tab('show')
else
	hash && $('ul.nav a[href="' + hash + '"]').tab('show');
	
$('.nav-tabs a').click(function (e) {
  $(this).tab('show');
  var scrollmem = $('body').scrollTop();
  window.location.hash = this.hash;
});