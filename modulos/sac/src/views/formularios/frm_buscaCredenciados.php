<div class="panel panel-primary">
    <div class="panel-heading ">Busca Credenciado</div>
    <div class="panel-body"> 
        <form action="index.php?pg=38#listaCredenciados" method="GET">
            <div class="row">
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label>Status:</label>
                            <select name="credenciado_status" class="form-control">
                                <option value="">Selecione...</option>
                                <option value="1" <?= ($selectStatus == 1) ? 'selected' : ''; ?>>Ativo</option>
                                <option value="2" <?= ($selectStatus == 2) ? 'selected' : ''; ?>>Inativo</option>
                            </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Filtro:</label>
                        <select name="filtros" class="form-control">
                            <option value="">Selecione...</option>
                            <option value="credenciado_razao_social" 	<?= ($filtros == "credenciado_razao_social") 		? 'selected' : ''; ?>>Razão Social</option>
                            <option value="credenciado_nome_fantasia"	<?= ($filtros == "credenciado_nome_fantasia") 		? 'selected' : ''; ?>>Nome Fantasia</option>
                            <option value="credenciado_cpfcnpj" 		<?= ($filtros == "credenciado_cpfcnpj") 			? 'selected' : ''; ?>>CPF/CNPJ</option>
                            <option value="credenciado_rg" 				<?= ($filtros == "credenciado_rg") 					? 'selected' : ''; ?>>RG</option>
                            <option value="credenciado_cidade" 			<?= ($filtros == "credenciado_cidade") 				? 'selected' : ''; ?>>Cidade</option>
                            <option value="credenciado_cep" 			<?= ($filtros == "credenciado_cep") 				? 'selected' : ''; ?>>CEP</option>
                            <option value="credenciado_uf" 				<?= ($filtros == "credenciado_uf") 					? 'selected' : ''; ?>>UF</option>
                            <option value="credenciado_obs" 			<?= ($filtros == "credenciado_obs") 				? 'selected' : ''; ?>>OBS</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                    	<label>Busca:</label>
                    	<input type="text" name="busca" class="form-control"  value="<?=$busca;?>">
                    </div>
                 </div>
                 <div class="col-xs-10 col-sm-3 col-md-3 col-lg-3">
                 <br>
                    <div class="form-actions">
                        <input type="hidden" name="acao" value="pesquisar" />
                        <input type="hidden" name="pg" value="<?= $pg; ?>">  

                        <button  type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-search"></span> Pesquisar
                        </button>

                        <button type="reset" class="btn btn-danger limpa">
                            <span class="glyphicon glyphicon-trash"></span> Limpar
                        </button>
                    </div>
                </div>
           </div>
       </form>
    </div>
</div>
