$(function(){

    //FORMATA CAMPO TELEFONE:
    $(".mask_telefone").mask("(00)00000-0090");

    //ATUALIZA O RAMAL 
    $('#formularioRamal').submit(function () {
        var dados = $(this).serialize();
        $.post("modulos/ramal/src/controllers/ramal.php", dados, function (result) {
            alert(result.msg);
            if(result.type != 1)
            	window.location.reload();
        }, "json");
        return false;
    });

    var dadosAntigos = null;
    
    $(".atualizarRamal").click(function(){
    	 var dados = $("#formularioRamal").serialize();
    	 $.ajax({
             url: "modulos/ramal/src/controllers/ramal.php",
             data: dados,
             type: 'POST',
             dataType: 'json',
             success: function (resultado) {
            	 dadosAntigos = resultado.dadosAntigos;
            	 $.each(resultado['atualizacao'], function (key, value) {
            		 $("#"+key).val(value);
            		 $("#"+key).css("color", "#FF0000");
            	 });
            	 
            	 $.each(resultado['dadosAtualizacao'], function (key, value) {
            		 $("#"+key).text(value);
            	 });
            	 
            	 $("#atualizacaoDiv").removeAttr("style");
            	 $("#voltarAtualizacao").removeAttr("style");
             }
         });
    });
    
  //SELECT COM BUSCA
	$(".selectpicker").selectpicker({"liveSearch" : true, "showIcon": true});
    
    $("#voltarAtualizacao").click(function(){
    	$.each(dadosAntigos, function (key, value) {
	   		 $("#"+key).val(value);
	   		 $("#"+key).removeAttr("style");
   	 	});
    	$("#voltarAtualizacao").attr("style","display:none;");
    	$("#atualizacaoDiv").attr("style","display:none;");
    });
    
    $("#formSetor").submit(function(e){
    	e.preventDefault();
    	
    	var form = $(this).serialize();
    	
    	$.ajax({
            url: "modulos/usuarios/src/controllers/usuarios.php",
            data: form,
            type: 'POST',
            dataType: 'json',
            success: function (resultado) {
           	 	$("#listaSetores").append('<li class="list-group-item">'+resultado.texto+'</li>');
            }
        });
    });
    
    $("#formBase").submit(function(e){
    	e.preventDefault();
    	
    	var form = $(this).serialize();
    	
    	$.ajax({
    		url: "modulos/usuarios/src/controllers/usuarios.php",
    		data: form,
    		type: 'POST',
    		dataType: 'json',
    		success: function (resultado) {
    			$("#listaBases").append('<li class="list-group-item">'+resultado.texto+'</li>');
    		}
    	});
    });
    
});