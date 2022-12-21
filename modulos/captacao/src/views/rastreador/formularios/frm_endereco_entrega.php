<div class="panel panel-primary">
        <div class="panel-heading">
             Endereço Entrega
        </div>
        <div class=" panel-body" >
            <div class="row">
            <div class=" col-md-12">
               <div class="alert alert-danger"><span class="glyphicon  glyphicon-alert"></span> Preencher somente se o Endereço de Entrega, for diferente do Endereço Residêncial  .</div>
            </div>
        </div>
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3">
            <div class="form-group">
                <label>CEP:</label>
                <div class="input-group">
                    <input type="text"   id="_cep_endereco_entrega"   name="ENDERECO[1][cep_cobranca]" class="form-control mask_cep "  maxlength="9" value="<?= (!empty($ENDERECO_ENTREGA['cep_cobranca'])) ? $ENDERECO_ENTREGA['cep_cobranca'] : '' ?>" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "endereco_entrega_cep") : ""; ?> />
                    <div class="input-group-btn">
                        <a href="javascript:void(0);" id="_busca_cep_endereco_entrega" class=" btn btn-default">
                            <span class="glyphicon glyphicon-search"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-1 col-md-1">
            <label>UF:</label>
            <input type="text" name="ENDERECO[1][uf_cobranca]"  id="_uf_endereco_entrega"  maxlength="2" class="mask_uf   form-control " value="<?= (!empty($ENDERECO_ENTREGA['uf_cobranca'])) ? $ENDERECO_ENTREGA['uf_cobranca'] : ''; ?>"    <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "endereco_entrega_uf") : ""; ?>            />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-10 col-md-10 ">
            <div class="form-group">
                <label>Endereço:</label>
                <input name="ENDERECO[1][logradouro_cobranca]"  id="_rua_endereco_entrega"  type="text" class="form-control  " value="<?= !empty($ENDERECO_ENTREGA['logradouro_cobranca']) ? $ENDERECO_ENTREGA['logradouro_cobranca'] : ""; ?>"    <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "endereco_entrega_logradouro") : ""; ?>  />
            </div>
        </div>
        <div class="col-xs-12 col-sm-2 col-md-2">
            <div class="form-group">
                <label>Numero:</label>
                <input name="ENDERECO[1][numero_cobranca]"   maxlength="5" class="form-control"   type="text" value="<?= (!empty($ENDERECO_ENTREGA['numero_cobranca'])) ? $ENDERECO_ENTREGA['numero_cobranca'] : ''; ?>"  <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "endereco_entrega_numero") : ""; ?> />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Cidade:</label>
                <input type="text" name="ENDERECO[1][cidade_cobranca]" id="_cidade_endereco_entrega" value="<?= (!empty($ENDERECO_ENTREGA['cidade_cobranca'])) ? $ENDERECO_ENTREGA['cidade_cobranca'] : ""; ?>" class="form-control"   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "endereco_entrega_cidade") : ""; ?> />
            </div>
        </div>
        <div class="col-xs-12  col-sm-4 col-md-4">
            <div class="form-group">
                <label>Bairro:</label>
                <input type="text" name="ENDERECO[1][bairro_cobranca]"  id="_bairro_endereco_entrega"  class="form-control"  value="<?= (!empty($ENDERECO_ENTREGA['bairro_cobranca'])) ? $ENDERECO_ENTREGA['bairro_cobranca'] : ""; ?>"     <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "endereco_entrega_bairro") : ""; ?>  />
            </div>
        </div>
        <div class="col-xs-12  col-sm-4 col-md-4">
            <div class="form-group">
                <label>Complemento:</label>
                <input name="ENDERECO[1][complemento_cobranca]" type="text" class="form-control " value="<?= (!empty($ENDERECO_ENTREGA['complemento_cobranca'])) ? $ENDERECO_ENTREGA['complemento_cobranca'] : ""; ?>"   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "endereco_entrega_complemento") : ""; ?> />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12  col-sm-4 col-md-4">
            <div class="form-group">
                <label>Aos cuidados De :</label>
                <input type="text" name="ENDERECO[1][contato_cobranca]" value="<?= (!empty($ENDERECO_ENTREGA['contato_cobranca'])) ? $ENDERECO_ENTREGA['contato_cobranca'] : ""; ?>" class="form-control"    <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "endereco_entrega_aos_cuidados_de") : ""; ?> />
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="form-group">
                <label>Telefone:</label>
                <input type="text" name="ENDERECO[1][telefone_cobranca]" value="<?= (!empty($ENDERECO_ENTREGA['telefone_cobranca'])) ? $ENDERECO_ENTREGA['telefone_cobranca'] : ""; ?>" class="form-control mask_telefone  " <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "endereco_entrega_telefone1") : ""; ?>  />
            </div>
        </div>
        <div class="col-xs-12  col-sm-4 col-md-4">
            <div class="form-group">
                <label>Telefone:</label>
                <input type="text" name="ENDERECO[1][celular_cobranca]" value="<?= (!empty($ENDERECO_ENTREGA['celular_cobranca'])) ? $ENDERECO_ENTREGA['celular_cobranca'] : ""; ?>" class="form-control mask_telefone  "   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "endereco_entrega_telefone2") : ""; ?>  />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12  col-sm-8 col-md-12">
            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="ENDERECO[1][email_cobranca]" value="<?= (!empty($ENDERECO_ENTREGA['email_cobranca'])) ? $ENDERECO_ENTREGA['email_cobranca'] : ""; ?>" class="form-control " <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "endereco_entrega_email") : ""; ?> />
            </div>
        </div>
    </div>
</div> 
<input type="hidden" name="ENDERECO[1][tipo_endereco]" value="endereco_entrega" />

</div>
    