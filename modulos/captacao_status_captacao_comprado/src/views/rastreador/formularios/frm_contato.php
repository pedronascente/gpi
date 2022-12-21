<div class="panel panel-primary">
    <div class=" panel-body">
        <div class="row">
            <div class=" col-md-12" >
                <div class="form-group">
                    <label>Contato</label>
                    <input type="text" name="CONTATO[0][nome_contato]" value="<?= (!empty($CONTATO1['nome_contato'])) ? $CONTATO1['nome_contato'] : NULL ?>" class="form-control"  <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "contato1_nome") : ""; ?>  required="" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" name="CONTATO[0][email_contato]" id="txt_email"    value="<?= (!empty($CONTATO1['email_contato'])) ? $CONTATO1['email_contato'] : '' ?>" class="form-control"   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "contato1_email") : ""; ?> />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Telefone:</label>
                    <input type="text" name="CONTATO[0][telefone1_contato]" value="<?= (!empty($CONTATO1['telefone1_contato'])) ? $CONTATO1['telefone1_contato'] : '' ?>" class=" mask_telefone form-control"   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "contato1_telefone") : ""; ?>   required="" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Telefone:</label>
                    <input type="text" name="CONTATO[0][telefone2_contato]" value="<?= (!empty($CONTATO1['telefone2_contato'])) ? $CONTATO1['telefone2_contato'] : '' ?>" class=" mask_telefone form-control"   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "contato1_telefone2") : ""; ?> />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Telefone:</label>
                    <input type="text" name="CONTATO[0][telefone3_contato]" value="<?= (!empty($CONTATO1['telefone3_contato'])) ? $CONTATO1['telefone3_contato'] : '' ?>" class=" mask_telefone form-control"  <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "contato1_telefone3") : ""; ?>  />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-primary">
    <div class=" panel-body">
        <div class="row">
            <div class=" col-md-12">
               <div class="alert alert-danger"><span class="glyphicon  glyphicon-alert"></span> Preencher somente se existir mais de um contato .</div>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-12">
                <div class="form-group">
                    <label>Contato 02:</label>
                    <input type="text" name="CONTATO[1][nome_contato]" value="<?= (!empty($CONTATO2['nome_contato'])) ? $CONTATO2['nome_contato'] : '' ?>" class="form-control"   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "contato2_nome") : ""; ?> />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" name="CONTATO[1][email_contato]" id="txt_email" value="<?= (!empty($CONTATO2['email_contato'])) ? $CONTATO2['email_contato'] : '' ?>" class="form-control"   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "contato2_email") : ""; ?> />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Telefone:</label>
                    <input type="text" name="CONTATO[1][telefone1_contato]" value="<?= (!empty($CONTATO2['telefone1_contato'])) ? $CONTATO2['telefone1_contato'] : '' ?>" class=" mask_telefone form-control"   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "contato2_telefone") : ""; ?> />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Telefone:</label>
                    <input type="text" name="CONTATO[1][telefone2_contato]" value="<?= (!empty($CONTATO2['telefone2_contato'])) ? $CONTATO2['telefone2_contato'] : '' ?>" class=" mask_telefone form-control"   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "contato2_telefone2") : ""; ?> />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Telefone:</label>
                    <input type="text" name="CONTATO[1][telefone3_contato]" value="<?= (!empty($CONTATO2['telefone3_contato'])) ? $CONTATO2['telefone3_contato'] : '' ?>" class=" mask_telefone form-control"   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "contato2_telefone3") : ""; ?> />
                </div>
            </div>
        </div>
    </div>
</div>