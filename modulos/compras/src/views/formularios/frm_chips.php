<div class="panel panel-primary">
    <div class="panel-heading ">Dados Chip</div>
    <div class="panel-body">
        <form action="modulos/compras/src/controllers/compras.php" method="POST">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                    <div class="form-group">
                    	<label>Status:</label>
                    	<select name="chip_status" class="form-control" disabled="disabled">
                    		<option value="1" <?=($chip->get("chip_status", true) == '1' || $chip->get("chip_status", true) == NULL) ? 'selected' : '';?>>Novo</option>
                    	</select>
                    </div>
                 </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                    	<label>Linha:</label>
                    	<input type="text" name="chip_linha" class="form-control mask_telefone" value="<?=$chip->get("chip_linha");?>" required="required" <?=Funcoes::Disable($acao);?> id="verificarChip">
                    </div>
                 </div>
            </div>
            <div class="row">
           		 <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Operadora:</label>
                        <select name="chip_operadora" class="form-control" <?=Funcoes::Disable($acao);?>>
                            <option value="">Selecione :</option>
                            <option value="Claro" 		<?=$chip->get("chip_operadora") == "Claro" 		? "selected" : "";?>>Claro</option>
                            <option value="OI" 			<?=$chip->get("chip_operadora") == "OI" 		? "selected" : "";?>>OI</option>
                            <option value="Tim" 		<?=$chip->get("chip_operadora") == "Tim" 		? "selected" : "";?>>Tim</option>
                            <option value="Vivo" 		<?=$chip->get("chip_operadora") == "Vivo" 		? "selected" : "";?>>Vivo </option>
                            <option value="Vivo-VPN" 	<?=$chip->get("chip_operadora") == "Vivo-VPN" 	? "selected" : "";?>>Vivo-VPN</option>
                        </select>
                    </div>
                </div>
           		 <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>VPN:</label>
                        <select name="chip_vpn" class="form-control" <?=Funcoes::Disable($acao);?>>
                            <option value="1" <?=$chip->get("chip_vpn") == "Dentro" ? "selected" : "";?>>Dentro</option>
                            <option value="2" <?=$chip->get("chip_vpn") == "Fora" 		? "selected" : "";?>>Fora</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                    	<label>ICCID:</label>
                    	<input type="text" name="chip_iccid" class="form-control" value="<?=$chip->get("chip_iccid");?>" <?=Funcoes::Disable($acao);?>>
                    </div>
                 </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                    	<label>Puk:</label>
                    	<input type="text" name="chip_puk" class="form-control" value="<?=$chip->get("chip_puk");?>" <?=Funcoes::Disable($acao);?>>
                    </div>
                 </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                    	<label>Puk2:</label>
                    	<input type="text" name="chip_puk2" class="form-control" value="<?=$chip->get("chip_puk2");?>" <?=Funcoes::Disable($acao);?>>
                    </div>
                 </div>
            </div>
            <?php if($chip->get("chip_pim") != null){?>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                    	<label>PIM:</label>
                    	<input type="text"  class="form-control" value="<?=$chip->get("chip_pim");?>" readonly="readonly">
                    </div>
                 </div>
            </div>
            <?php }?>
            <div class="row">
		        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
		            <div class="form-actions">
		                <input type="hidden" name="acao" value="salvarChip">
		                <input type="hidden" name="chip_id" value="<?=$chip->get("chip_id");?>">
		                <input type="submit" value="Salvar" class="btn btn-primary">
		                <a href="index.php?pg=46" class="btn btn-default">Voltar</a>
		            </div>
		        </div>
		    </div>
        </form>
     </div>
 </div>
