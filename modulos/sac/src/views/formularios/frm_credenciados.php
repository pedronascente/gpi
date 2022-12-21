<form method="POST" action="modulos/sac/src/controllers/sac.php">
    <div class="panel panel-primary">
        <div class="panel-heading "> Dados do Credenciado</div>
        <div class="panel-body">
        <?php if($result == 1){?>
	    	<div class="alert alert-success">Registro salvo com sucesso!</div>
	    <?php }?> 
            <div class="row">
                <div class="col-xs-12 xol-sm-5 col-lg-3 col-md-5">
                    <div class="form-group">
                        <label>Data:</label>
                        <input type="text" class="form-control" name="credenciado_data_cadastro" value="<?=$credenciado->get("credenciado_data_cadastro") == NULL ?  date("d/m/Y") : $credenciado->get("credenciado_data_cadastro");?>" readonly="readonly">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 xol-sm-5 col-lg-3 col-md-5">
                    <div class="form-group">
                        <label>Status:</label>
                        <select class="form-control" name="credenciado_status" <?=Funcoes::Disable($p);?>>
                            <option value="1" <?=$credenciado->get("credenciado_status") == "Ativo" ? "selected" : null;?>>Ativo</option>
                            <option value="2" <?=$credenciado->get("credenciado_status") == "Inativo" ? "selected" : null;?>>Inativo</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 xol-sm-6 col-lg-6 col-md-6">
                    <div class="form-group">
                        <label>Razão Social:</label>
                        <input type="text" class="form-control" name="credenciado_razao_social" value="<?=$credenciado->get("credenciado_razao_social");?>" required <?=Funcoes::Disable($p);?>>
                    </div>
                </div>
                <div class="col-xs-12 xol-sm-6 col-lg-6 col-md-6">
                    <div class="form-group">
                        <label>Nome Fantasia:</label>
                        <input type="text" class="form-control" name="credenciado_nome_fantasia" value="<?=$credenciado->get("credenciado_nome_fantasia");?>" required <?=Funcoes::Disable($p);?>>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>
                            <ul class="nav nav-pills">
                                <li role="presentation" class="<?=$credenciado->get("credenciado_tipo_pessoa") == NULL ? "active" : ($credenciado->get("credenciado_tipo_pessoa") == "f" ? "active" : null);?> tipoPessoa" id="f"><a>CPF</a></li>
                                <li role="presentation" class="<?=$credenciado->get("credenciado_tipo_pessoa") == "j" ? "active" : null;?>tipoPessoa" id="j"><a>CNPJ</a></li>
                            </ul>
                        </label>	
                        <input type="text" name="credenciado_cpfcnpj" class="form-control mask_cpf" id="cpf_cnpj" value="<?=$credenciado->get("credenciado_cpfcnpj");?>" <?=Funcoes::Disable($p);?>>
                    </div>
                </div>
                <div class="col-xs-12 xol-sm-6 col-lg-6 col-md-6" style="margin-top: 24px;">
                    <div class="form-group">
                        <label>I.E./RG:</label>
                        <input type="text" class="form-control" name="credenciado_rg" value="<?=$credenciado->get("credenciado_rg");?>" <?=Funcoes::Disable($p);?>>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
                    <div class="form-group">	  
                        <label>CEP:</label>
                        <div class="input-group">
                            <input type="text" name="credenciado_cep"class="mask_cep form-control _cep" value="<?=$credenciado->get("credenciado_cep");?>" / <?=Funcoes::Disable($p);?>>
                            <div class="input-group-btn buscaCEP">
                                <a href="javascript:void(0)" class="btn btn-default">
                                    <span class="glyphicon glyphicon-search"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2"> 
                    <div class="form-group">	 
                        <label>UF:</label>
                        <input type="text" name="credenciado_uf" id="txt_uf"class="_uf  mask_uf form-control"  value="<?=$credenciado->get("credenciado_uf");?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div> 
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"> 
                    <div class="form-group">	 
                        <label>Cidade:</label>
                        <input type="text" name="credenciado_cidade" class="_cidade form-control"  value="<?=$credenciado->get("credenciado_cidade");?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"> 
                    <div class="form-group">	 
                        <label>Bairro:</label>
                        <input type="text" name="credenciado_bairro" class="_bairro form-control"  value="<?=$credenciado->get("credenciado_bairro");?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>  
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
                    <div class="form-group">	 
                        <label>Complemento:</label>
                        <input type="text" name="credenciado_complemento" class="form-control"  value="<?=$credenciado->get("credenciado_complemento");?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div> 
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"> 
                    <div class="form-group">	 
                        <label>N°.:</label>
                        <input type="text" name="credenciado_numero" class="form-control"  value="<?=$credenciado->get("credenciado_numero");?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div> 
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                    <div class="form-group">
                        <label>Logradouro:</label>
                        <input type="text" name="credenciado_logradouro" class="_rua form-control"  value="<?=$credenciado->get("credenciado_logradouro");?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"> 
                    <div class="form-group">	 
                        <label>Valor Instalação:</label>
                        <input type="text" name="credenciado_instalacao"  value="<?=$credenciado->get("credenciado_instalacao");?>" class="form-control mask_real" <?=Funcoes::Disable($p);?>>
                    </div>
                </div> 
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"> 
                    <div class="form-group">	 
                        <label>Valor Manutenção:</label>
                        <input type="text" name="credenciado_manutencao"  value="<?=$credenciado->get("credenciado_manutencao");?>" class="form-control mask_real" <?=Funcoes::Disable($p);?>>
                    </div>
                </div> 
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"> 
                    <div class="form-group">	 
                        <label>Deslocamento:</label>
                        <select name="credenciado_deslocamento" class="form-control" id="selectDeslocamento" <?=Funcoes::Disable($p);?>>
                            <option value="2" <?=$credenciado->get("credenciado_deslocamento") == 2 ? "selected" : null;?>>Não</option>
                            <option value="1" <?=$credenciado->get("credenciado_deslocamento") == 1 ? "selected" : null;?>>Sim</option>
                        </select>
                    </div>
                </div> 
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" <?=$credenciado->get("credenciado_deslocamento") == 2 || $credenciado->get("credenciado_deslocamento") == NULL ? "style='display:none'" : null;?> id="divDeslocamento"> 
                    <div class="form-group">	 
                        <label>Valor(km):</label>
                        <input type="text" name="credenciado_km"  value="<?=$credenciado->get("credenciado_km");?>" class="form-control mask_real" <?=Funcoes::Disable($p);?>>
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                    <div class="form-group">
                        <label>Obs:</label>
                        <textarea class="form-control" name="credenciado_obs" <?=Funcoes::Disable($p);?>><?=$credenciado->get("credenciado_obs");?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading "> Dados Financeiros</div>
        <div class="panel-body"> 
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">	 
                        <label>Banco</label>
                        <input type="text" name="credenciado_banco" class="form-control"  value="<?=$credenciado->get("credenciado_banco");?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">	 
                        <label>Agência</label>
                        <input type="text" name="credenciado_agencia" class="form-control"  value="<?=$credenciado->get("credenciado_agencia");?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">	 
                        <label>Conta:</label>
                        <input type="text" name="credenciado_conta" class="form-control"  value="<?=$credenciado->get("credenciado_conta");?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                    <div class="form-group">
                        <label>Número do Banco:</label>
                        <input type="text" name="credenciando_numero_banco" class="form-control"  value="<?=$credenciado->get("credenciando_numero_banco");?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                 </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                    <div class="form-group">
                        <label>Favorecida:</label>
                        <input type="text" name="credenciado_favorecida" class="form-control"  value="<?=$credenciado->get("credenciado_favorecida");?>" <?=Funcoes::Disable($p);?>/>
                    </div>
               </div>
        	</div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-actions">
                <input type="hidden" name="acao" value="salvarCredenciado">
                <input type="hidden" name="credenciado_id" value="<?=$credenciado->get("credenciado_id");?>">
                <input type="hidden" name="credenciado_tipo_pessoa" value="" id="textoTipoPessoa">
                <input type="<?=$p == "visualizar" ? "hidden" : "submit";?>" value="Salvar" class="btn btn-primary">
                <a href="index.php?pg=38" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </div>
</form>
<br>


