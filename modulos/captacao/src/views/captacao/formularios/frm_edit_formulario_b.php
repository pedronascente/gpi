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
                <input type="text" name="captacao_telefone2" id="captacao_telefone2"  value="<?=trim($captacao_telefone2); ?>" class="mask_telefone form-control" placeholder="Telefone" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="form-group">
                <label>Indicador:</label>
                <select name="captacao_indicador" class="form-control" required="">
                     <?php
                        $array_options = [
                            'campanha_primaria'=>'Campanha Primária',
                            'campanha_secundaria'=>'Campanha Secundária',
                            'indicacao'=>'Indicação',
                            'whatsApp'=>'WhatsApp',
                            'facebook'=>'Facebook',
                            'outros'=>'Outros',
                        ];
                        foreach ($array_options as $key => $value) {
                            if( $captacao_indicador ==  $key){
                                $_sel =  'selected=""';
                            }else{
                                $_sel ='';
                            }
                            echo "<option value=\"{$key}\" {$_sel}  >{$value}</option>";
                        }
                     ?>   
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>Observações:</label>
                <textarea name="captacao_obs" rows="5" id="captacao_obs"  class="form-control"><?= $captacao_obs; ?></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-actions">
                <input type="hidden" name="acao" value="editaCaptacao"> 
                <input type="hidden" name="captacao_id" value="<?= $id_captacao; ?>"> 
                <input type="hidden" name="voltar" value="<?= @$_GET['voltar']; ?>"> 
                <input type="hidden" name="pg" value="<?= @$_GET['pg']; ?>">
                <button type="submit" class="btn btn-danger "> Salvar</button>
                <a href="index.php?pg=<?= @$_GET['voltar']; ?>" class="btn btn-default"  title="Voltar"> Voltar </a>
            </div>
        </div>
    </div>
</form>