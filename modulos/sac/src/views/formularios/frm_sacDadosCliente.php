<form action="modulos/sac/src/controllers/sac.php" method="post">
    <div class="panel panel-primary">
        <div class="panel-heading "> Dados do Cliente</div>
        <div class="panel-body">
        	<?php $cliente_ativo = isset($dadosCliente['cliente_ativo']) ? $dadosCliente['cliente_ativo'] : null; ?>
        	<?php if($cliente_ativo != NULL){?>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                    <div class="form-group">
                        <h2><label>
                                Status .:  <?= $cliente_ativo ? 'Ativo' : 'Inativo'; ?></label></h2>
                    </div>
                </div>
            </div>
            <?php }?>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
                    <div class="form-group">
                        <label>Status</label>
                        <select name="cliente_ativo"class="form-control" <?=Funcoes::Disable($p);?>>
                            <option value="on"<?= ($cliente_ativo == 'on' ) ? "selected" : ''; ?>>Ativo</option>
                            <option value="off"<?= ($cliente_ativo == 'off' ) ? "selected" : ''; ?>>Inativo</option>
                        </select>
                    </div>    
                </div>
            </div>
            <div class="row">
                <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                    <div class="form-group">
                        <label>Nome / Razão Social :</label>
                        <input type="text" name="nome_cliente" class="form-control" value="<?= isset($dadosCliente['nome_cliente']) ? $dadosCliente['nome_cliente'] : null; ?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>
            </div>
            <div class="row">
            	 <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"> 
                    <div class="form-group">
                    <?php if($contrato){ ?>
                        <label>CPF / CNPJ:</label>
                    <?php } else {?>
                    	 <label>
                            <ul class="nav nav-pills">
                                <li role="presentation" class="<?=$tipoPessoa == NULL ? "active" : ($tipoPessoa == "f" ? "active" : null);?> tipoPessoa" id="f"><a>CPF</a></li>
                                <li role="presentation" class="<?=$tipoPessoa == "j"  ? "active" : null;?>tipoPessoa" id="j"><a>CNPJ</a></li>
                            </ul>
                        </label>	
                    <?php }?>
                        <input type="text" name="cnpjcpf_cliente" id="cpf_cnpj" class="form-control <?= $tipoPessoa == "j" ? "mask_cnpj" : "mask_cpf"; ?>" value="<?= isset($dadosCliente['cnpjcpf_cliente']) ? $dadosCliente['cnpjcpf_cliente'] : ""; ?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" <?=!$contrato ? 'style="margin-top: 24px;"' : '';?>>
                    <div class="form-group">
                        <label>Telefone:</label>
                        <input type="text" name="telefone_cliente" value="<?= isset($dadosCliente['telefone_cliente']) ? $dadosCliente['telefone_cliente'] : ""; ?>" class=" mask_telefone form-control" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>  
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" <?=!$contrato ? 'style="margin-top: 24px;"' : '';?>>
                    <div class="form-group">
                        <label>Celular:</label>
                        <input type="text" name="celular_cliente" value="<?= isset($dadosCliente['celular_cliente']) ? $dadosCliente['celular_cliente'] : ""; ?>" class=" mask_telefone form-control" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>  
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" <?=!$contrato ? 'style="margin-top: 24px;"' : '';?>>
                    <div class="form-group">
                        <label>Contato:</label> 
                        <input type="text" name="contato_cliente" value="<?= isset($dadosCliente['contato_cliente']) ? $dadosCliente['contato_cliente'] : ""; ?>" class="form-control" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>  
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="text" name="email_cliente" id="txt_email" value="<?= isset($dadosCliente['email_cliente']) ? $dadosCliente['email_cliente'] : ""; ?>" class="form-control" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>  
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
                    <div class="form-group">	  
                        <label>CEP:</label>
                        <div class="input-group">
                            <input type="text" name="cep_cliente"class="mask_cep form-control _cep" value="<?= isset($dadosCliente['cep_cliente']) ? $dadosCliente['cep_cliente'] : null; ?>" <?=Funcoes::Disable($p);?>/>
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
                        <input type="text" name="uf_cliente" id="txt_uf"class="_uf  mask_uf form-control" value="<?= isset($dadosCliente['uf_cliente']) ? $dadosCliente['uf_cliente'] : null; ?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div> 
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"> 
                    <div class="form-group">	 
                        <label>Cidade:</label>
                        <input type="text" name="cidade_cliente" class="_cidade form-control" value="<?= isset($dadosCliente['cidade_cliente']) ? $dadosCliente['cidade_cliente'] : null; ?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"> 
                    <div class="form-group">	 
                        <label>Bairro:</label>
                        <input type="text" name="bairro_cliente" class="_bairro form-control" value="<?= isset($dadosCliente['bairro_cliente']) ? $dadosCliente['bairro_cliente'] : null; ?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>  
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
                    <div class="form-group">	 
                        <label>Complemento:</label>
                        <input type="text" name="complemento_cliente" class="form-control" value="<?= isset($dadosCliente['complemento_cliente']) ? $dadosCliente['complemento_cliente'] : null; ?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div> 

                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"> 
                    <div class="form-group">	 
                        <label>N°.:</label>
                        <input type="text" name="numero_cliente" class="form-control" value="<?= isset($dadosCliente['numero_cliente']) ? $dadosCliente['numero_cliente'] : null; ?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div> 
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                    <div class="form-group">
                        <label>Logradouro:</label>
                        <input type="text" name="logradouro_cliente" class="_rua form-control" value="<?= isset($dadosCliente['logradouro_cliente']) ? $dadosCliente['logradouro_cliente'] : null; ?>" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                    <div class="form-group">
                        <label>Senha de Segurança:</label>
                        <input type="text" name="senha_seguranca" value="<?= isset($dadosCliente['senha_seguranca']) ? $dadosCliente['senha_seguranca'] : null; ?>" class="form-control" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                    <div class="form-group">
                        <label>Contra-Senha de Segurança:</label>
                        <input type="text" name="contra_senha_seguranca" value="<?= isset($dadosCliente['contra_senha_seguranca']) ? $dadosCliente['contra_senha_seguranca'] : null; ?>" class="form-control" <?=Funcoes::Disable($p);?>/>
                    </div>
                </div>
            </div>
            <?php if(empty($p)){?>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                    <div class="form-actions">
                        <input type="hidden" name="acao" value="EditarCliente" /> 
                        <input type="hidden" name="tipo_pessoa" value="<?=$tipoPessoa;?>" id="textoTipoPessoa">
                        <input type="hidden" name="id_cliente" value="<?= $id ?>" /> 
                        <button type="submit" class="btn btn-primary botaoLoadForm">
                            Salvar
                        </button>
                    </div>
                </div>
            </div>
          <?php }?>
        </div>
    </div>
</form>
