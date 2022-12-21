<div class="panel panel-primary">
    <div class="panel-heading">Cadastra Serviços</div>
    <div class="panel-body"> 
        <form method="post" name="" class="form_addPedidoComissao loadForm" action="modulos/portaria/src/controllers/condominio.php">
            <div class="rows">
               <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                   <div class="form-group">
                        <label class="">
                            <input type="radio" name="radio" class="optionsRadiosServicos"value="s" checked="true"   <?=$_disabledCampoDofrm_cadastraServico ;?> >Selecione um Serviço :
                         </label>
                       <select name="pcs_ps_id" id="pcs_ps_id" class="form-control" <?=$_disabledCampoDofrm_cadastraServico ;?> >
                             <option value="" >...</option>
                            <?php foreach($listaServicoSelect as $dados){
                                $portariaservico->sets($dados); 
                                $_select  = ($portariaservico->getPsTipoServico()==$portariaCondominioServico->getPcspsTipoServico()) ?  'selected="selected"' :'';?>
                                <option value="<?=$portariaservico->getPsId();?> " <?=$_select;?>><?=$portariaservico->getPsTipoServico();?></option>
                            <?php }?>
                        </select>
                   </div>
               </div>  
               <div class="col-xs-12 col-sm-4  col-md-4 col-lg-4 ">
                   <div class="form-group">
                        <label class="">
                            <input type="radio"  name="radio" value="n"  class="optionsRadiosServicos" <?=$_disabledCampoDofrm_cadastraServico ;?>> Digite um Serviço:
                        </label>
                        <input name="ps_tipoServico" id="ps_tipoServico"  class="form-control" value=""  disabled="true"  type="text" <?=$_disabledCampoDofrm_cadastraServico ;?>>
                   </div>
               </div>
            </div>
            <div class="rows">
               <div class="col-xs-12 col-sm-8    col-md-8 col-lg-8 ">
                   <div class="form-group">
                       <label>Responsavel:</label>
                       <input required="required"   name="pcs_responsavel"  class="form-control" value="<?=$portariaCondominioServico->getPcsResponsavel();?>" type="text">
                   </div>
               </div>  
            </div>
            <div class="rows">
                <div class="col-xs-12 col-sm-4  col-md-4 col-lg-4 ">
                   <div class="form-group">
                       <label>Telefone | Celular :</label>
                       <div class="input-group">
                           <span class="input-group-addon">
                               <span class="glyphicon glyphicon-earphone"></span>
                           </span>
                           <input  maxlength="14" name="pcs_telefone"  class="mask_telefone form-control" placeholder="Telefone" type="text" value="<?=$portariaCondominioServico->getPcsTelefone();?>">
                       </div>
                   </div>
               </div>
            </div>
            <div class="rows">
                 <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                     <div class="form-group">
                         <input name="acao" value="<?=$acao_Dofrm_cadastraServico;?>" type="hidden">
                         <?php if(!empty($idCondominio)){echo  "<input name=\"pcs_pc_id\" value=\"{$idCondominio}\" type=\"hidden\">"; } ?>
                         <?php if(!empty($idPCSservico)){echo  "<input name=\"pcs_id\" value=\"{$idPCSservico}\" type=\"hidden\">"; } ?>
                         <input  class="btn btn-primary" type="submit" value="<?=$submit_Dofrm;?>">
                     </div>
                 </div>
            </div> 
        </form>
    </div><!--panel-body-->
</div><!--panel-primary-->