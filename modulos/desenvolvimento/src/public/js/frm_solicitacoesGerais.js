 $(function(){
	 
    $(".bordaTD").css( 'cursor', 'pointer' );

    $(".excluirSolicitacao").click(function(){
        var url = $(this).attr("id");
        if(confirmarDelete())
           location.href=url;
    });
    
    $(".selectStatus").change(function(){
    	location.href =  $(".selectStatus :selected").attr("id");
    });
});