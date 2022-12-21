<form  method="post"  name="FORM_ORIGEM"  id="FORM_ORIGEM">     
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label>Status:</label>
                <select name="status" class="form-control select_status">
                    <option value="null"> :: Selecione :: </option>
                </select>
            </div> 
        </div>
        <div class="col-xs-12   col-md-6">
            <div class="form-group">
                <label>UF:</label>
                <select name="uf"  class="form-control  select_uf" >
                    <option value="null"> :: Selecione :: </option>
                </select>
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <div class="form-group">
                <label>Periodo dê:</label>
                <input type="text" name="data_inicial" value="" class="form-control _datepicker_data mask_data" required=""> 
            </div> 
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="form-group">
                <label>até:</label>
                <input type="text" name="data_fim" value="" class="form-control _datepicker_data mask_data"  required=""> 
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12  col-md-4">
            <div class="form-group">
                <label></label>
                <input type="submit" value="Pesquisar" class="form-control  btn btn-danger"> 
            </div> 
        </div>
    </div>    
</form>
<div class="row">
    <div class="col-md-12">
        <hr>
    </div>
</div>