<script type="text/javascript">
    $(function () {
        /*
         * -----------------------------------------------------------------
         * ENVIA UM EMAIL PRO CLIENTE EFETUAR O checkout: EM USO
         * ----------------------------------------------------------------- 
         */
        $('#btn-enviarPagamento').click(function () {
          if(validarForm()){
                var _url ="/gpi/modulos/integracaoPagSeguro/application/controller/CheckoutController.php";
                var _dadosForm = $('#formPagSeguro').serialize();
                $('#btn-enviarPagamento,#btn-sairModal').hide();
                $('#btn-sairModal').hide();
                $('#_error').show();

                $.ajax({
                    type:'POST',
                    url:_url,
                    dataType:'JSON',
                    cache:false,
                    data:_dadosForm,
                })
                .done(function(ret){
                    if(ret.type=='true'){
                        $('#_error').hide();
                        $('#_alertModaPagSeguro').addClass('alert-success'); 
                        $('#_alertModaPagSeguro').text('Enviado com Sucesso!');
                        $('#_alertModaPagSeguro,#btn-sairModal').show();
                    }
                })
                .fail(function(){
                    $('#_error').hide();
                    $('#_alertModaPagSeguro').addClass(' alert-danger'); 
                    $('#_alertModaPagSeguro').text('Error ao Enviar, Tente novamente!');
                    $('#_alertModaPagSeguro,#btn-sairModal').show();
                });          
            }
        });        
        
        $('#btn-sairModal').click(function(){
            location.reload();
        });
    });
    
    function validarForm(){
        var _email_clinete  = $("#_email_clinete"); 
        var _cliente        = $("#_cliente"); 
        var _valor          = $("#_valor"); 
        var _descricao      = $("#_descricao"); 

        if(_email_clinete.val()==='' && _cliente.val()==='' && _valor.val()==='' && _descricao.val()===''){
            $("#span-email,#span-cliente,#span-valor,#span-descricao").show();
            return false;
        }else if(_email_clinete.val()===''){
            $("#span-email").show();
            _email_clinete.focus();
            return false;
        }else if(_cliente.val()===''){
            $("#span-cliente").show();
            _cliente.focus();
            return false;
        }else if(_valor.val()===''){
            $("#span-valor").show();
            _valor.focus();
            return false;
        }else if(_descricao.val()===''){
            $("#span-descricao").show();
            _descricao.focus();
            return false;
        }else{
            return true;
        } 
    };
    
    function IsEmail(email){
        var exclude='/[^@-.w]|^[_@.-]|[._-]{2}|[@.]{2}|(@)[^@]*1/';
        var check='/@[w-]+./';
        var checkend='/.[a-zA-Z]{2,3}$/';
        if(((email.search(exclude) != -1)||(email.search(check)) == -1)||(email.search(checkend) == -1)){return false;}
        else {return true;}
    };
    
    function modalEnviaPagamento(ids){
        var _ids = ids;
        $('#_reference').val(_ids);
    };
    
    /*
     * --------------------------------------------------------------------
     * Descrição :Responsavel por retornar os seguintes dados: 
     * @ id (log)
     * @ dataDoUltimoEvento (log)
     * @ codigoIdentificadorDaTransacao (log)
     * @ transacao_significado (transacao)
     * @ meio_pagamento_sgnificado (meio_pagamento)
     * @ valorBrutoDaTransacao (log)
     * -------------------------------------------------------------------- 
    */
    function visualizarLogs(id){
        var _tab ="";
        var _id = id;
        var _url="/gpi/modulos/integracaoPagSeguro/application/controller/WSController.php";
        $("#_listarLogs").html('<tr><td colspan="5">Nenhu registro encontrado!</td></tr>');
        $.ajax({
            type:"POST",
            url:_url,
            dataType:"JSON",
            cache:false,
            data:{acao:"visualizarLogs",id:_id}
        })
        .done(function(_json){
            if(_json.erro== 2){
                $("#_listarLogs").html(_json.msgerro);
            }
            $.each(_json.dadosLog,function( index, element ) {
                _tab += "<tr>"
                   +"<td>"+element.dataDoUltimoEvento +"</td>"
                   +"<td>"+element.transacao_significado+"</td>"
                   +"<td>"+element.meio_pagamento_sgnificado+"</td>"
                   +"<td>"+element.valorBrutoDaTransacao+"</td>"
               +"</tr>";
            });
            $("#_listarLogs").html(_tab);
        })
        .fail(function(){
            alert('Não foi possivel realizar sua Requisição');
        });   
    };
</script>