<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>			
        <div class="modal-body">
            <form action="fpdf/pedido_comissao/index.php" method="get">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label> Nome Funcionario :</label>
                            <input type="text" class="form-control"   name="nomeFuncionario"   value=""  required>
                        </div>
                   </div>
                </div>
                <div class="row">
                    <div class="col-sm-5 col-md-5">
                        <div class="form-group">
                            <label> Matricula :</label>
                            <input type="text"   name="matricula" class="form-control"  value="" required>
                        </div>
                    </div>
                    <div class="col-sm-5 col-md-5">
                        <div class="form-group">
                            <label> CTPS :</label>
                            <input type="text"   name="ctps" class="form-control"   required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            <label> Valor Total :</label>
                            <input type="text"   name="_vtotal" class="form-control mask_real" value="" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        <div class="form-group"> 
                            <input type="hidden" name="periodo" value="<?= $_GET['periodo'];?>">
                            <input type="hidden" name="ano" value="<?=date('Y');?>">
                            <input type="hidden" name="id_s" value="<?=$_GET['id_s'];?>">
                            <input type="hidden" name="id_u" value="<?=$_GET['id_u'];?>">
                            <input type="hidden" name="acao" value="92399880">
                            <input type="submit" class="btn btn-danger" value="Imprimir">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>    
</div> 
         
<script type="text/javascript" >
  $(function(){
    $(".mask_real").priceFormat({
        prefix : 'R$ ',
        centsSeparator : ',',
        thousandsSeparator : '.'
    });  
  });
</script>       