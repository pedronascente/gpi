<?php
include_once '../../../../../Config.inc.php';

$ramal = new Ramal;

$setores = $ramal->listSetor(null, "ditinct");

$bases = $ramal->listBase(null);
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Cadastrar Setor/Base</h4>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
            <form id="formSetor">
                <div class="row">
                    <div class="col-xs-12 col-lg-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>Setor:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" required="required" name="setor_local">
                                <span class="input-group-btn">
                                	<input type="hidden" name="acao" value="cadastrarSetor">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
<?php if (!empty($setores)) { ?>
                <div class="scrollbar_2">
                    <ul class="list-group" id="listaSetores">
    <?php foreach ($setores as $s) { ?>
                            <li class="list-group-item"><?= $s['setor_local']; ?></li>
                        <?php } ?>
                    </ul>
                </div>
<?php } ?>
            <br>
            <form id="formBase">
                <div class="row">
                    <div class="col-xs-12 col-lg-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>Base:</label>
                            <input type="text" class="form-control" required="required" name="base_nome">
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>Endereço:</label>
                            <input type="text" class="form-control" required="required" name="base_endereco">
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-12 col-sm-12 col-md-12">
                        <div class="form-actions">
                        	<input type="hidden" name="acao" value="cadastrarBase">
                            <button class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </div>
            </form>
            <br>
<?php if (!empty($bases)) { ?>
                <div class="scrollbar_2">
                    <ul class="list-group" id="listaBases">
    <?php foreach ($bases as $b) { ?>
                            <li class="list-group-item"><?= $b['base_nome']; ?></li>
                        <?php } ?>
                    </ul>
                </div>
<?php } ?>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript" src="modulos/ramal/public/js/min/modal.js"></script>