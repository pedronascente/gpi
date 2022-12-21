$(function(){
	$("#selectDeslocamento").change(function(){
		if($("#selectDeslocamento").val() == 2)
			$("#divDeslocamento").attr("style", "display:none;")
		else
			$("#divDeslocamento").removeAttr("style");
	});
	
	$("#adicionarEquipamento").click(function(){
		
		var equipamento = $("#textoEquipamento").val();
		
		$.ajax({
	        url: 'modulos/sac/src/controllers/sac.php',
	        dataType: 'json',
	        type: 'post',
	        data: {
	            acao: 'cadastrarEquipamentos',
	            equipamentos_sac_desc: equipamento
	        },
	        success: function (json) {
	            $("#listaEquipamentos").append('<div class="checkbox" id="div'+json.result+'"><label><input type="checkbox" name="equipamentos[]" value="'+json.result+'"  class="markCheck">'+equipamento+'</label><a id="'+json.result+'" class="excluirEquipamento"><span class="glyphicon glyphicon-remove pull-right"></span></a></div>');
	            $("#"+json.result).on("click",function () {excluirEquipamento(json.result);});
	        }, error: function () {
	            alert("Erro ao enviar requisição!");
	        }
	    });
		
	});
	
	$(".excluirEquipamento").click(function(){
		
		var id = $(this).attr("id");
		
		excluirEquipamento(id);
		
		
	});
	
});

$("#selectChip").change(function(){
	var id = $(this).val();
	
	if(id != ""){
		$.ajax({
	        url: 'modulos/sac/src/controllers/sac.php',
	        dataType: 'json',
	        type: 'post',
	        data: {
	            acao: 'pegarModuloChip',
	            id: id
	        },
	        success: function (json) {
	           $("#moduloChip").val(json.result);
	        }, error: function () {
	            alert("Erro ao enviar requisição!");
	        }
	    });
	}
	
});

$("#cpf_cnpj").focusout(function(){
	
	var cpf_cnpj = $(this).val();

    if(cpf_cnpj != ""){
    	 $.ajax({
 	        url: "modulos/sac/src/controllers/sac.php",
 	        dataType: 'json',
 	        data: {cpf_cnpj: cpf_cnpj, acao: "verificarCPFCNPJ"},
 	        type: 'post',
 	        success: function (obj) {
 	        	if(obj.result >=1) {
	 	        	alert("Esse cliente já está cadstrado!");
	 	        	location.href = "index.php?pg=10&selectFiltro=cpf_cnpj&campo_pesquisa="+cpf_cnpj+"&acao=Pesquisar#listarClientes";
 	        	}
 	        },
 	        error: function () {
	            alert("Erro ao enviar requisição!");
	        }
    	 });
    }
});

$("#statusVeiculo").change(function(){
	var status = $(this).val();
	var id_cliente = $("#raCliente").val();
	location.href = "index.php?pg=10&id="+id_cliente+"&acao=ListarCliente&status_veiculo="+status+"#veiculos";
});

$(".deletarVeiculo").click(function(){
	var id = $(this).attr("id");
	
	$.ajax({
		url: 'modulos/sac/src/controllers/sac.php',
		dataType: 'json',
		type: 'post',
		data: {
			acao: 'excluirVeiculo',
			id: id
		},
		success: function (result) {
			if(result.result == 1) {
				window.location.reload();
			} else
				alert("Não é possível excluir esse véiculo porque há os relacionadas á ele!");
			
		}, error: function () {
			alert("Erro ao enviar requisição!");
		}
	});
});

function excluirEquipamento(id){
	
	$.ajax({
		url: 'modulos/sac/src/controllers/sac.php',
		dataType: 'json',
		type: 'post',
		data: {
			acao: 'excluirEquipamento',
			id: id
		},
		success: function (result) {
			
			if(result.result == 1) {
				$("#div"+id).remove();
			} else
				alert("Não é possível excluir esse equipamento porque há clientes relacionados com ele!");
			
		}, error: function () {
			alert("Erro ao enviar requisição!");
		}
	});
	
}


