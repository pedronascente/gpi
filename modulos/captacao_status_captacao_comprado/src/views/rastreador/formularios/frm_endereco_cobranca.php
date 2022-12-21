<div class="panel panel-primary">
    <div class="panel-heading">
        Endereço de Cobrança
    </div>
    <div class=" panel-body">
        <div class="row">
            <div class=" col-md-12">
                <div class="alert alert-danger"><span class="glyphicon  glyphicon-alert"></span> Preencher somente se o Endereço de Cobrança, for diferente do Endereço Residêncial  .</div>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-3">
                <div class="form-group">
                    <label>CEP:</label>
                    <div class="input-group">
                        <input type="text" name="ENDERECO[0][cep_cobranca]"  id="_cep_endereco_cobranca" class="form-control mask_cep  "  maxlength="9" value="<?= (!empty($ENDERECO_COBRANCA['cep_cobranca'])) ? $ENDERECO_COBRANCA['cep_cobranca'] : ''; ?>" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cep_cobranca") : ""; ?> />
                        <div class="input-group-btn">
                            <a href="javascript:void(0);" id="_busca_cep_endereco_cobranca" class=" btn btn-default">
                                <span class="glyphicon glyphicon-search"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-1 col-md-1 ">
                <label>UF:</label>
                <input type="text" name="ENDERECO[0][uf_cobranca]" id="_uf_endereco_cobranca"  maxlength="2" class="mask_uf   cobranca form-control" value="<?= (!empty($ENDERECO_COBRANCA['uf_cobranca'])) ? $ENDERECO_COBRANCA['uf_cobranca'] : ''; ?>"    <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "uf_cobranca") : ""; ?>   />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-10 ">
                <div class="form-group">
                    <label>Endereço:</label>
                    <input name="ENDERECO[0][logradouro_cobranca]" type="text" id="_rua_endereco_cobranca"  class="form-control  cobranca " value="<?= (!empty($ENDERECO_COBRANCA['logradouro_cobranca'])) ? $ENDERECO_COBRANCA['logradouro_cobranca'] : ''; ?>"     <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "logradouro_cobranca") : ""; ?> />
                </div>
            </div>
            <div class="col-xs-12 col-sm-2 col-md-2 ">
                <div class="form-group">
                    <label>Numero:</label>
                    <input name="ENDERECO[0][numero_cobranca]"   maxlength="5"   type="text" value="<?= (!empty($ENDERECO_COBRANCA['numero_cobranca'])) ? $ENDERECO_COBRANCA['numero_cobranca'] : ""; ?>" class="form-control cobranca "  <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "numero_cobranca") : ""; ?>  />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <label>Cidade:</label>
                    <input type="text" name="ENDERECO[0][cidade_cobranca]" id="_cidade_endereco_cobranca" value="<?= (!empty($ENDERECO_COBRANCA['cidade_cobranca'])) ? $ENDERECO_COBRANCA['cidade_cobranca'] : ''; ?>" class="form-control _cidadeE cobranca " <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cidade_cobranca") : ""; ?>   />
                </div>
            </div>
            <div class="col-xs-12  col-sm-4 col-md-4">
                <div class="form-group">
                    <label>Bairro:</label>
                    <input type="text" name="ENDERECO[0][bairro_cobranca]" id="_bairro_endereco_cobranca"   value="<?= (!empty($ENDERECO_COBRANCA['bairro_cobranca'])) ? $ENDERECO_COBRANCA['bairro_cobranca'] : ""; ?>" class="form-control  cobranca "   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "bairro_cobranca") : ""; ?> />
                </div>
            </div>
            <div class="col-xs-12  col-sm-4 col-md-4">
                <div class="form-group">
                    <label>Complemento:</label>
                    <input name="ENDERECO[0][complemento_cobranca]"type="text" class="form-control cobranca" value="<?= (!empty($ENDERECO_COBRANCA['complemento_cobranca'])) ? $ENDERECO_COBRANCA['complemento_cobranca'] : ""; ?>"   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "complemento_cobranca") : ""; ?>  />
                </div>
            </div>
        </div>
        <input type="hidden" name="ENDERECO[0][tipo_endereco]" value="endereco_cobranca" />
    </div>
</div>