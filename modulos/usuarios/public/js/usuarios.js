var usuarios = {};

usuarios.init = function () {
    $('#campoUsuario').focusout(usuarios.validarUsuario);

    /*
     *************************************************************************************
     ***************** MOSTRA OU OCULTA AS REGIÃ•ES DE ACORDO COM O SETOR ***************** 
     *************************************************************************************
    */

    $("#rg").mask("0000000000");

    /*
     ****************************************************************************
     ************ RESPONSÃ�VEL POR VALIDAR O FORMULÃ�RIO DE USUÃ�RIOS **************
     ****************************************************************************	
     */
    
    $("#form_Usuario").submit(usuarios.validarFormulario);
    
    $("#statusUsuario").change(usuarios.mudarStatus);
    
    $("#nomeUsuario").focusout(usuarios.criarUsuario);


};
$(usuarios.init);

usuarios.validarUsuario = function () {
    usuario = $(this).val();
    usuarioAntigo = $("#usuarioAntigo").val();
    if(usuario != usuarioAntigo){
	    $.ajax({
	        url: 'modulos/usuarios/src/controllers/usuarios.php',
	        dataType: 'json',
	        type: 'post',
	        data: {
	            acao: 'verDuplicidade',
	            usuario: usuario
	        },
	        success: function (json) {
	            if (json.type == 0) {
	                alert('Usuario já cadastrado na base de dados\n favor insira outro nome !');
	                $(this).focus();
	            }
	        }, error: function () {
	            alert("Erro ao enviar requisição!");
	        }
	    });
	}
};

usuarios.validarFormulario = function () {
	
	$(".botaoLoadForm").attr("disabled", true);
	
    var setor = "Vendas";
    var setorEscolhido = $("#mostraRegioes option:selected");
    var teste = true;

    if (setor.toLowerCase() == setorEscolhido.text().toLowerCase()) {
        var extensao = false;

        var valida = false;
        var acao = $('#acao').val();

        if ($(".imagemAssinatura").val() != "") {

            if ($(".imagemAssinatura").val().search('jpg') == -1) {
                extensao = true;

            } else if ($(".imagemAssinatura").val().search('jpeg') == -1) {
                extenao = true;
            }

        }


        if (extensao) {
            alert("Voce deve selecionar uma imagem do tipo jpg!");
            teste = false;
        }
    }

    var rg = $("#rg").val();
    if (rg != "") {
        rg = rg.replace(/[^0-9]/g, '');
        rg = rg.trim();

        if (rg.length < 10 || rg.length > 10) {
            alert("Voce deve digitar um RG válido!");
            teste = false;
        }
    }

    var cpf = $("#cpf").val();
    if (cpf != "") {
        cpf = cpf.replace(/[^0-9]/g, '');
        cpf = cpf.trim();

        if (cpf.length < 11) {
            alert("Voce deve digitar um CPF válido!");
            teste = false;
        }
    }

	$(".botaoLoadForm").attr("disabled", false);
	
    return teste;
};

usuarios.mudarStatus = function(){
	location.href="index.php?pg=4&ativo="+$(this).val();
}

usuarios.criarUsuario = function(){
	 var nomeUsuario = $("#nomeUsuario").val();
     if (nomeUsuario != "") {
         nomeUsuario = nomeUsuario.split(" ");

         var usuario = null;

         if (nomeUsuario.length > 1)
             usuario = (nomeUsuario[0] + "." + nomeUsuario[nomeUsuario.length - 1]).toLowerCase();

         $.ajax({
             url: 'modulos/usuarios/src/controllers/usuarios.php',
             dataType: 'json',
             type: 'post',
             data: {
                 acao: 'verDuplicidade',
                 usuario: usuario
             },
             success: function (json) {
                 if (json.type != 0) {
                     $("#campoUsuario").val(usuario);
                     $("#senha").val(usuario);
                 }
             }
         });

     }
}

