<div class="panel panel-primary">
    <div class="panel-heading"></div>
    <div class="panel-body"> 
        <form method="post" name="" class="form_addPedidoComissao loadForm" action="modulos/portaria/src/controllers/condominio.php">
            <div class="rows">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label><strong>CÓDIGO:</strong></label>
                        <input type="text" name="pc_codigo" class="form-control" value="<?=$portariaCondominio->getPcCodigo();?>" required>
                    </div>
                </div>
             </div>
            <div class="rows">
                <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                    <div class="form-group">
                        <label><strong>RazãoSocial:</strong></label>
                        <input type="text" name="pc_razaoSocial" class="form-control" value="<?=$portariaCondominio->getPcRazaoSocial();?>">
                    </div>
                </div>
            </div>
            <div class="rows">
                <div class="col-xs-12 col-sm-6  col-md-6 col-lg-6">
                    <div class="form-group">
                         <label>CEP:</label>
                         <div class="input-group">
                             <input  maxlength="9" name="pc_cep" id="captacao_cep" class="mask_cep _cep form-control" placeholder="CEP" type="text" value="<?=$portariaCondominio->getPcCep();?>">
                            <div class="input-group-btn buscaCEP">
                                <a href="javascript:void(0)" class="btn btn-default">
                                    <span class="glyphicon glyphicon-search"></span>
                                </a>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="col-xs-12 col-sm-2  col-md-2 col-lg-2">
                    <div class="form-group">
                        <label>UF:</label>
                        <input  maxlength="2" name="pc_uf" class="mask_uf  _uf form-control" type="text" value="<?=$portariaCondominio->getPcUF();?>">
                    </div>
                </div>
            </div>
            <div class="rows">
                <div class="col-xs-12 col-sm-9  col-md-9 col-lg-9 ">
                    <div class="form-group">
                        <label>Endereco:</label>
                        <input name="pc_endereco"  class=" _rua form-control" type="text" value="<?=$portariaCondominio->getPcEndereco();?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                    <div class="form-group">
                        <label>Numero:</label>
                        <input name="pc_numero" class="form-control" type="text" value="<?=$portariaCondominio->getPcNumero();?>">
                    </div>
                </div>
            </div>
            <div class="rows">
                <div class="col-xs-12 col-sm-4  col-md-4 col-lg-4 ">
                    <div class="form-group">
                        <label>Cidade:</label>
                        <input name="pc_cidade"  class="form-control _cidade" type="text" value="<?=$portariaCondominio->getPcCidade();?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4  col-md-4 col-lg-4 ">
                    <div class="form-group">
                        <label>Bairro:</label>
                        <input name="pc_bairro"  class=" form-control  _bairro" type="text" value="<?=$portariaCondominio->getPcBairro();?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 ">
                    <div class="form-group">
                        <label>Complemento:</label>
                        <input name="pc_complemento" class="form-control" type="text" value="<?=$portariaCondominio->getPcComplemento();?>">
                    </div>
                </div>
            </div>
            <div class="rows">
                 <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                     <div class="form-group">
                         <input name="acao" value="<?=$acao_Dofrm_cadastraCondominio;?>" type="hidden">
                         <?php if(!empty($idCondominio)){echo  "<input name=\"pc_id\" value=\"{$idCondominio}\" type=\"hidden\">"; } ?>
                         <?php if(!empty($idServico)){echo  "<input name=\"ps_id\" value=\"{$idServico}\" type=\"hidden\">"; } ?>
                         <input  class="btn btn-primary" type="submit" value="<?=$submit_Dofrm;?>">
                         <?php if($acao =='editarC'):?> 
                           <a href="index.php?pg=42" class="btn btn-danger">Cadastrar Novo Condominio ?</a>
                        <?php endif;?>    
                     </div>
                 </div>
            </div> 
        </form>
    </div><!--panel-body-->
</div><!--panel-primary-->