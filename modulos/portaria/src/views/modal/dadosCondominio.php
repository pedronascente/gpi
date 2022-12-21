 <div class="panel panel-primary">
    <div class="panel-heading ">
    </div>
    <div class="panel-body">
        <form>
            <div class="form-group">    
                <label><strong>Cód:</strong></label>
                <input type="text" name="pc_razaoSocial" class="form-control" value="<?=$portariaCondominio->getPcCodigo();?>" disabled="true">    
            </div>
            <div class="form-group">    
                <label><strong>RazãoSocial:</strong></label>
                <input type="text" name="pc_razaoSocial" class="form-control" value="<?=$portariaCondominio->getPcRazaoSocial();?>" disabled="true">    
            </div>
            <div class="form-group">  
                <label><strong>cep:</strong></label>
                <input  maxlength="9" name="pc_cep" id="captacao_cep" class="mask_cep _cep form-control" placeholder="CEP" type="text"   value="<?=$portariaCondominio->getPcCep();?>" disabled="true">
            </div>
            <div class="form-group">  
                <label>UF:</label>
                <input  maxlength="2" name="pc_uf" class="mask_uf  _uf form-control" type="text" value="<?=$portariaCondominio->getPcUF();?>" disabled="true">
            </div>
            <div class="form-group">      
                <label>Endereco:</label>
                <input name="pc_endereco"  class=" _rua form-control" type="text" value="<?=$portariaCondominio->getPcEndereco();?>"  disabled="true">
            </div>
            <div class="form-group">      
                <label>Numero:</label>
                <input name="pc_numero" class="form-control" type="text" value="<?=$portariaCondominio->getPcNumero();?>" disabled="true">
            </div>
            <div class="form-group">      
                <label>Numero:</label>
                <input name="pc_numero" class="form-control" type="text" value="<?=$portariaCondominio->getPcNumero();?>" disabled="true">
            </div>
            <div class="form-group">      
                <label>Bairro:</label>
                <input name="pc_bairro"  class=" form-control  _bairro" type="text" value="<?=$portariaCondominio->getPcBairro();?>" disabled="true">
            </div>
            <div class="form-group">      
                <label>Complemento:</label>
                <input name="pc_complemento" class="form-control" type="text" value="<?=$portariaCondominio->getPcComplemento();?>" disabled="true">
            </div>    
        </form>    
    </div><!--panel-body-->     
</div><!--panel-primary-->