  <form action="modulos/captacao/src/controllers/captacao.php" method="post" id="basic_validate_usuario" novalidate="novalidate"> 
            <div class="row">
                <div class="col-xs-12 col-sm-12  col-md-12 " >
                    <div class="form-group">
                        <label>Cliente:</label>
                        <input type="text" name="captacao_cliente" value="<?= $captacao_cliente; ?>" class="form-control" required placeholder="Digite nome do cliente" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12  col-md-12 ">
                    <div class="form-group">
                        <label>E-mail:</label>
                        <input type="email" name="captacao_email" id="captacao_email" class="form-control"  value="<?= $captacao_email; ?>" placeholder="Entre com o email"  >
                    </div>
                </div>
            </div>                
            <div class="row">
                <div class="col-xs-12 col-sm-3  col-md-3 ">
                    <div class="form-group">
                        <label>Telefone 1:</label>
                        <input type="text" name="captacao_telefone1" id="captacao_telefone1" class="mask_telefone form-control"  value="<?= $captacao_telefone1; ?>"  required placeholder="Telefone" />
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3  col-md-3 ">
                    <div class="form-group">
                        <label>Telefone 2:</label>
                        <input type="text" name="captacao_telefone2" id="captacao_telefone2"  value="<?= $captacao_telefone2; ?>" class="mask_telefone form-control" placeholder="Telefone" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Indicador:</label>
                        <select name="captacao_indicador" id="captacao_indicador" class="form-control" required="">
                            <option value="" selected="selected"> -- Como conheceu a empresa? -- </option>
                            <option value="indicacao" <?=($captacao_indicador=="indicacao")?"selected":'';?>   >Indicação</option>
                            <option value="internet" <?=($captacao_indicador=="internet")?"selected":'';?>  >Internet</option>
                            <option value="facebook" <?=($captacao_indicador=="facebook")?"selected":'';?>  >Facebook</option>
                            <option value="jornal" <?=($captacao_indicador=="jornal")?"selected":'';?>  >Jornal</option>
                            <option value="outdoor" <?=($captacao_indicador=="outdoor")?"selected":'';?>  >Outdoor</option>
                            <option value="outros" <?=($captacao_indicador=="outros")?"selected":'';?>  >Outros</option>
                            <option value="placas" <?=($captacao_indicador=="placas")?"selected":'';?>  >Placas</option>
                            <option value="revista" <?=($captacao_indicador=="revista")?"selected":'';?>  >Revista</option>
                            <option value="whatsApp" <?=($captacao_indicador=="whatsApp")?"selected":'';?>  >WhatsApp</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label>Observações:</label>
                        <textarea name="captacao_obs" rows="5" id="captacao_obs"  class="form-control"><?= $captacao_obs;?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-actions">
                        <input type="hidden" name="acao" value="editaCaptacao"> 
                        <input type="hidden" name="captacao_id" value="<?= $id_captacao; ?>"> 
                        <input type="hidden" name="voltar" value="<?= @$_GET['voltar'];?>"> 
                        <input type="hidden" name="pg" value="<?= @$_GET['pg'];?>"> 
                        <button type="submit" class="btn btn-danger "> Salvar</button>
                        <a href="index.php?pg=<?= @$_GET['voltar'];?>" class="btn btn-default"  title="Voltar"> Voltar </a>
                    </div>
                </div>
            </div>
        </form>