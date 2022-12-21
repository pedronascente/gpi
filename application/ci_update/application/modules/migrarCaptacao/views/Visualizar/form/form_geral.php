<form   action="<?=base_url('migrarcaptacaoselect') ?>" method="post" >   
    <div class="row">
        <div class="col-xs-12  col-md-12">
            <div class="form-group">
                <label>1) O Vendedor :</label>
                <select name="id_vendedor_receptor"  class="form-control " required="">
                    <option value=""> :: Selecione :: </option>
                    <?php  for($i=0;$i<count($arrayListUser);$i++) { ?>
                            <option value="<?=$arrayListUser[$i]->id_usuario;?>"><?=$arrayListUser[$i]->nome;?></option>
                    <?php  }  ?>
                </select>
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12  col-md-12">
            <div class="form-group">
                <label>2) Receberá as captações do Vendedor:</label> 
                <select name="id_vendedor_doador"  class="form-control " required="">
                    <option value=""> :: Selecione :: </option>
                    <?php  for($i=0;$i<count($arrayListUser);$i++) { ?>
                            <option value="<?=$arrayListUser[$i]->id_usuario;?>"><?=$arrayListUser[$i]->nome;?></option>
                    <?php  }  ?>
                </select>
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12   col-md-4">
            <div class="form-group">
                <label>3) No periodo dê:</label>
                <input type="text" name="data_inicial" value="" class="form-control _datepicker_data  mask_data" required=""> 
            </div> 
        </div>
        <div class="col-xs-12   col-md-4">
            <div class="form-group">
                <label>até:</label>
                <input type="text" name="data_fim" value="" class="form-control _datepicker_data mask_data" required=""> 
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12  col-md-4">
            <div class="form-group">
                <input type="submit" value="Prosseguir >>" class="form-control  btn btn-danger"> 
            </div> 
        </div>
    </div>    
</form>