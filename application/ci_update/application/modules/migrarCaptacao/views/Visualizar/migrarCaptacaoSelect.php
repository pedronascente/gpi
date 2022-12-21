<div class="panel panel-primary">
    <div class="panel-heading">
        <strong><?=$registro['mensagem'];?></strong></div>
    <div class="panel-body"> 
        <div class="row">
             <div class="col-md-2">
                    <form   action="<?=base_url('migrarcaptacaosave') ?>" method="post" >   
                        <input type="hidden" name="migrar[id_vendedor_receptor]" value="<?=$filtro['id_vendedor_receptor'];?>">
                        <input type="hidden" name="migrar[id_vendedor_doador]" value="<?=$filtro['id_vendedor_doador'];?>">
                        <input type="hidden" name="migrar[data_inicial]" value="<?=$filtro['data_inicial'];?>"> 
                        <input type="hidden" name="migrar[data_fim]" value="<?=$filtro['data_fim'];?>"> 
                        <input type="hidden" name="total" value="<?=$registro['total']?>"> 
                        <?php  if($registro['total'] >0) { ?>
                                    <input type="submit" value="Migrar Captação" class=" btn btn-danger">
                        <?php }?>
                        <a href="<?=base_url('migrarcaptacao');?>" class="btn btn-primary"> << Voltar</a>
                    </form>
                </div>           
            </div>
        </div>
    </div>
</div>