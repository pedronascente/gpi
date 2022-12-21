var login = {};
login.init = function () {
    $(window).load(login.VerificaLogarSistema);
    $("#esqueceu").click(function(){$(".logar").hide();});
    $("#esqueceuUsuario").change(login.esqueceuUsuario);
    $("#btn_esqueceu").click(login.esqueceu);
}

$(login.init);

//AUTENTICA USUARIO LOGADO:
login.VerificaLogarSistema = function () {
    $("#txt_usuario").keypress(function (e) {
        if (e.keyCode == 13){
            $("#txt_senha").focus();
        }
    }).focus();
    $("#txt_senha").keypress(function (e) {
        if (e.keyCode == 13){
            login.LogarSistema();
        }
    });
    $('#btn_logar').click(login.LogarSistema);
}
login.LogarSistema = function () {
    var  url  = 'http://' + window.location.host; //pega URL atual.
    if(url == 'http://gpi_local.com'){
        url  = "/";
    }else{
        url ='/gpi/';
    }
    $.ajax({
        url: url+'application/controllers/logar.php',
        dataType: 'json',
        data: 'txt_usuario=' + escape($('#txt_usuario').val()) + '&txt_senha='
                + escape($('#txt_senha').val()) + '&act=1',
        type: 'post',
        clearForm: true,
        success: function (obj) {
            if (obj.type == 1) {
                location.href = url+"index.php?pg=0";
            } else {
                alert(obj.msg);
                $('#txt_usuario').val("");
                $('#txt_senha').val("");
                window.location.reload();
                $('#txt_usuario').focus();
            }
        }, error: function () {
            alert("Erro ao enviar requisição!");
        }
    })
    return false;
};
login.esqueceuUsuario = function(){
    if($(this).is(":checked")){
        $(".emailEsqueceu").removeAttr("style");
    $("#usuario").attr("disabled", true);
    } else {
        $(".emailEsqueceu").attr("style", "display:none;");
        $("#usuario").attr("disabled", false);
    }
};
login.esqueceu = function(){
	var usuario = $("#usuario").val();
	var email = $("#email").val();
	var nome = $("#nome").val();
	var setor = $("#setor").val();
	var verifica = false;
        if($("#esqueceuUsuario").is(":checked") && (email == "" || setor == "" || setor == "")){
            verifica = true;
        }else if (!$("#esqueceuUsuario").is(":checked") && usuario == ""){
            verifica = true;
        }	
	if(verifica){
            alert("Você deve preencher o formulário antes de fazer a solicitação!");
        }else{
            var acao = 3;
            if($("#esqueceuUsuario").is(":checked")){
                acao = 4;
            }
            var  url  = 'http://' + window.location.host; //pega URL atual.
	    if(url == "http://localhost"){
	        url ='/git/gpi/';
	    }else if(url == 'http://gpi_local.com'){
	        url  = "/";
	    }else{
	        url ='/gpi/';
	    }
            $.ajax({
                url: url+'application/controllers/logar.php',
                dataType: 'json',
                data: {act: acao, usuario:usuario, email:email, nome:nome, setor:setor},
                type: 'post',
                clearForm: true,
                success: function (obj) {
                    if(obj.result == 0){
                        alert("Solicitação de recuperação de usuário enviada ao desenvolvimento!");
                    }else if (obj.result == 2){
                        alert("Erro ao enviar solicitação, por favor tente novamente mais tarde!");
                    }else{
                        alert("Usuário não encontrado!");
                    }
                    window.location.reload();
                }, error: function () {
                    alert("Solicitação de recuperação de usuário enviada ao desenvolvimento!");
                    window.location.reload();
                }
            });	
        }		
};

