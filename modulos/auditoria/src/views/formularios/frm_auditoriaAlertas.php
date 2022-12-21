<div class="panel panel-primary">
    <div class="panel-heading "></div>
    <div class="panel-body">
        <form action="" method="GET">
            <div class="row">
            	<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                    	<label>Vendedor:</label>
                    	<select name="id" class="form-control">
                    		<option value="0">Todos</option>
                    		<?php if(!empty($lista_usuario)){
                    				foreach ($lista_usuario as $u){?>
                    			<option value="<?=$u['id'];?>" <?=$vendedor == $u['id'] ? "selected" : "";?>><?=$u['nome'];?></option>
                    		<?php }}?>
                    	</select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                    	<label>Status:</label>
                    	<select name="agenda_contato_status" class="form-control">
                    		<option value="-1">Todos</option>
                    		<option value="0" <?=$status == 0 ? "selected" : "";?>>Abertos</option>
                    		<option value="1" <?=$status == 1 ? "selected" : "";?>>Finalizados</option>
                    	</select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label>Período:</label>
                        <div class="input-group input-append date datepicker">
                            <input type="text" name="dt_inicial" id="dt_inicial" class="form-control" value="<?=$dt_inicial;?>"/>
                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label>até</label>
                        <div class="input-group input-append date datepicker">
                            <input type="text" name="dt_final" class="form-control" id="dt_final" value="<?=$dt_final;?>"/>
                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-actions">
                        <br>
                        <input type="hidden" name="pg" value="52">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
