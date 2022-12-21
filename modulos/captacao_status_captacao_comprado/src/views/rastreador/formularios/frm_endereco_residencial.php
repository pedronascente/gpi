<div class="panel panel-primary">
    <div class="panel-heading">
        Endereço Residêncial
    </div>
    <div class=" panel-body">
        <div class="row">
            <div class="col-xs-12 col-md-3 ">
                <div class="form-group">
                    <label>CEP:</label>
                    <div class="input-group">
                        <input type="text" name="CLIENTE[cep_cliente]" class="form-control  mask_cep _cep" maxlength="9" placeholder="CEP" value="<?= isset($cliente['cep_cliente']) ? $cliente['cep_cliente'] : ""; ?>" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cep_cliente") : ""; ?>/>
                        <div class="input-group-btn">
                            <a href="javascript:void(0);"   class="btn btn-default buscaCEP">
                                <span class="glyphicon glyphicon-search"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12  col-md-1 ">
                <div class="form-group">
                    <label>UF:</label>
                    <input type="text" name="CLIENTE[uf_cliente]"  maxlength="2" class="form-control mask_uf  _uf" value="<?= isset($cliente['uf_cliente']) ? $cliente['uf_cliente'] : ""; ?>" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "uf_cliente") : ""; ?>/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    <label>Endereço:</label>
                    <input type="text" name="CLIENTE[logradouro_cliente]" value="<?= isset($cliente['logradouro_cliente']) ? $cliente['logradouro_cliente'] : ""; ?>" class="form-control _rua" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "logradouro_cliente") : ""; ?>/>
                </div>
            </div>
            <div class=" col-md-2 ">
                <div class="form-group">
                    <label>Numero:</label>
                    <input type="text" name="CLIENTE[numero_cliente]"  maxlength="5" value="<?= isset($cliente['numero_cliente']) ? $cliente['numero_cliente'] : ""; ?>" class="form-control" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "numero_cliente") : ""; ?>/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="form-group">
                    <label>Cidade:</label>
                    <input type="text" name="CLIENTE[cidade_cliente]" value="<?= isset($cliente['cidade_cliente']) ? $cliente['cidade_cliente'] : ""; ?>" class="form-control _cidade" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cidade_cliente") : ""; ?>/>
                </div>
            </div>
            <div class="col-xs-12  col-sm-4 col-md-4">
                <div class="form-group">
                    <label>Bairro:</label>
                    <input type="text" name="CLIENTE[bairro_cliente]" value="<?= isset($cliente['bairro_cliente']) ? $cliente['bairro_cliente'] : ""; ?>" class="form-control _bairro" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "bairro_cliente") : ""; ?>/>
                </div>
            </div>
            <div class="col-xs-12  col-sm-4 col-md-4">
                <div class="form-group">
                    <label>Complemento:</label>
                    <input type="text" name="CLIENTE[complemento_cliente]" value="<?= isset($cliente['complemento_cliente']) ? $cliente['complemento_cliente'] : ""; ?>" class="form-control" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "complemento_cliente") : ""; ?>/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12  col-md-12">
                <div class="form-group">
                    <label>Observação:</label>
                    <textarea name="CLIENTE[obs_clientes]"  rows="5" class=" form-control" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "obs_clientes") : ""; ?>><?= isset($cliente['obs_clientes']) ? $cliente['obs_clientes'] : ""; ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
