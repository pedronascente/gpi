<div class="panel panel-primary">
    <div class="panel-heading"></div>
    <div class="panel-body"> 
        <form method="post" name="" class=" " action="modulos/portaria/src/controllers/antena.php">
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label><strong>CÓDIGO:</strong></label>
                        <input type="text" name="pa_codigo"  maxlength="4"  class="form-control" value="<?=$portariaAntena->getPa_codigo();?>" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label><strong>Nome Cliente:</strong></label>
                        <input type="text" name="pa_cliente" class="form-control"  maxlength="50" value="<?=$portariaAntena->getPa_cliente();?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                    <div class="form-group">
                        <label>Longitude:</label>
                        <input name="pa_longitude"  class="  form-control mask_latlong" type="text" value="<?=$portariaAntena->getPa_longitude();?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                    <div class="form-group">
                        <label>Latitude:</label>
                        <input name="pa_latitude" class="form-control mask_latlong"   type="text" value="<?=$portariaAntena->getPa_latitude();?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6  col-md-6 col-lg-6 ">
                    <div class="form-group">
                        <label>Hostname:</label>
                        <input name="pa_hostname"  class=" form-control" type="text" value="<?=$portariaAntena->getPa_hostname();?>">
                    </div>
                </div>
            </div>
            <?php 
                if(isset($listaIP)):
                    foreach ($listaIP as $k => $ip):
                        $ipAntena->sets($ip);
                        if(!$k==0){
                            $TITLEIP= 'IP-II';
                        }else{
                            $TITLEIP= 'IP-I';
                        }
                        ?>
                        <div class="row">
                              <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                                  <div class="form-group">
                                      <label><?=$TITLEIP;?> :</label>
                                      <input name="pia_ip[]" class="pia_ip form-control" type="text" value="<?=$ipAntena->getPia_ip();?>">
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                                  <div class="form-group">
                                      <label><?=$TITLEIP;?> / Mask:</label>
                                      <input name="pia_mask[]" class="form-control pia_ip" type="text" value="<?=$ipAntena->getPia_mask();?>">
                                  </div>
                              </div>
                               <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                                  <div class="form-group">
                                      <label><?=$TITLEIP;?> / Gateway:</label>
                                      <input name="pia_gateway[]" class="form-control pia_ip" type="text" value="<?=$ipAntena->getPia_gateway();?>">
                                  </div>
                              </div> 
                               <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                                  <div class="form-group">
                                      <input name="pia_id[]" class="form-control" type="hidden" value="<?=$ipAntena->getPia_id();?>">
                                  </div>
                              </div> 
                              
                          </div>
                         <?php 
                    endforeach;
                else: 
                    for($i=1;$i<=2;$i++):
                        if($i==1){
                            $TITLEIP= 'IP-I';
                        }else{
                            $TITLEIP= 'IP-II';
                        }?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                                <div class="form-group">
                                    <label><?=$TITLEIP;?> :</label>
                                    <input name="pia_ip[]"  class="pia_ip form-control" type="text" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                                <div class="form-group">
                                    <label><?=$TITLEIP;?> / Mask:</label>
                                    <input name="pia_mask[]" class="form-control pia_ip" type="text" value="">
                                </div>
                            </div>
                             <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                                <div class="form-group">
                                    <label><?=$TITLEIP;?> / Gateway:</label>
                                    <input name="pia_gateway[]" class="form-control pia_ip" type="text" value="">
                                </div>
                            </div> 
                        </div>
                         <?php
                    endfor;
                endif;    
            ?>
            <div class="row">
                <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                    <div class="form-group">
                        <label>Tipo Conexão Antena:</label>
                        <select name="pa_tipo_conexao" class="form-control" >
                            <option value="">...</option>
                            <option value="Bridge"   <?=($portariaAntena->getPa_tipo_conexao()=='Bridge')? 'selected' : '';?> >Bridge</option>
                            <option value="Roteador" <?=($portariaAntena->getPa_tipo_conexao()=='Roteador')? 'selected' : '';?> >Roteador</option>
                        </select>
                    </div>
                </div>
                 <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                    <div class="form-group">
                        <label>Tipo Antena:</label>
                        <select name="pa_tipo_antena" class="form-control" >
                            <option value="">....</option>
                            <option value="BaseStation" <?=($portariaAntena->getPa_tipo_antena()=='BaseStation')? 'selected' : '';?>>BaseStation</option>
                            <option value="Bridge" <?=($portariaAntena->getPa_tipo_antena()=='Bridge')? 'selected' : '';?>>Bridge</option>
                            <option value="Cliente"<?=($portariaAntena->getPa_tipo_antena()=='Cliente')? 'selected' : '';?>>Cliente</option>
                        </select>
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                    <div class="form-group">
                        <label>Wireless Name:</label>
                        <input name="pa_wireless"  class="form-control" type="text"   maxlength="30"  value="<?=$portariaAntena->getPa_wireless();?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                    <div class="form-group">
                        <label>Security:</label>
                        <input name="pa_security"  class="  form-control" type="text" value="<?=$portariaAntena->getPa_security();?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                    <div class="form-group">
                        <label>Encrypt:</label>
                        <input name="pa_encrypt"  class="  form-control" type="text" value="<?=$portariaAntena->getPa_encrypt();?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-3  col-md-4 col-lg-4 ">
                     <div class="form-group">
                        <label> Password: </label>
                        <div class="input-group">
                            <input name="pa_password" class="form-control" type="text" id="senha" value="<?=$portariaAntena->getPa_password();?>">
                            <span class="input-group-btn">
                                <a href="javascript:void(0)" class="btn  btn-primary  btn-md" id="geraSenha">
                                    <span class="glyphicon glyphicon-repeat"></span>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                 <div class="col-xs-12 col-sm-3  col-md-3 col-lg-3 ">
                     <div class="form-group">
                         <input name="acao" value="<?=$acao_Dofrm_cadastraAntena?>" type="hidden">
                         <?php if(!empty($idAntena)){echo  "<input name=\"pa_id\" value=\"{$idAntena}\" type=\"hidden\">"; } ?>
                         <input  class="btn btn-primary" type="submit" value="<?=$submit_Dofrm;?>">
                         <?php if($acao =='editarA'):?> 
                           <a href="index.php?pg=45" class="btn btn-danger">Cadastrar Nova Antena ?</a>
                        <?php endif;?>    
                     </div>
                 </div>
            </div> 
        </form>
    </div><!--panel-body-->
</div><!--panel-primary-->
<!--SCRIPT-->
<script type="text/javascript"> 
    
    $('#geraSenha').click(function(){ $.post("modulos/portaria/src/controllers/antena.php",{acao: "gerasenha"},function(data){ $('#senha').val(data);});}); 

</script>

