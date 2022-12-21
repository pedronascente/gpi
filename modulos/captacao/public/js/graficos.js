$(function(){
	
	$("#gerarGrafico").submit(function(){
		
		var indice = $("#indiceGrafico").val();
		var dt_incial = $("#dt_inicial").val();
		var dt_final = $("#dt_final").val();
		
		var img = new Image();
		img.src = 'modulos/captacao/src/views/graficos/geralGrafico.php?dt_inicial='+dt_incial+'&dt_final='+dt_final;
		
		$(img).load(function(){
		    $(this).appendTo('.img-container');
		    $('#props').text("Largura: " + 600+" - "+"Altura: " + $(this).height())
		});
		
		$("#mostraGrafico").removeAttr("style");
		
		
		return false;
		
	});
	
})