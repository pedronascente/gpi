<?php
include_once '../../../../../Config.inc.php';

$id = filter_input(INPUT_GET, 'id_veiculo_antigo', FILTER_DEFAULT);
$id_cliente = filter_input(INPUT_GET, 'cliente_ra', FILTER_DEFAULT);
$acao = filter_input(INPUT_GET, 'acao', FILTER_DEFAULT);

?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Veículo</h4>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
            <form method="post" action="modulos/sac/src/controllers/sac.php">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Placa:</label>
                            <input type="text"  class="mask_placa form-control" name="placa"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Marca:</label>
                            <input type="text" class="form-control" name="marca"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Modelo:</label>
                            <input type="text"  class="form-control" name="modelo"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Cor:</label>
                            <input type="text" class="form-control" name="cor"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Ano:</label>
                            <input type="text" class="form-control mask_anofab" name="ano"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Renavan:</label>
                            <input type="text" class="form-control" name="renavam"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Chassis:</label>
                            <input type="text" class="form-control" name="chassis"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Voltagem:</label>
                            <select name="tipo_bateria" class="form-control" name="tipo_bateria">
                                <option value="12V">12 VOLTS</option>
                                <option value="24V">24 VOLTS</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>OBS:</label>
                            <textarea class="form-control" name="observacoes"></textarea>
                        </div>
                    </div>
                    <?php if($acao == "trocarVeiculo"){?>
                	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Motivo Troca:</label>
                            <textarea class="form-control" name="observacoes_troca"></textarea>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-actions">
                        	<input type="hidden" name="acao" value="<?=$acao;?>">
                        	<?php if($acao == "trocarVeiculo"){?>
                        	<input type="hidden" name="veiculo_id_antigo" value="<?=$id;?>"> 
                        	<?php } else {?>
                        	<input type="hidden" name="cliente_ra" value="<?=$id_cliente;?>"> 
                        	<?php }?>
                            <input type="submit" value="<?=$acao == "trocarVeiculo" ? "Trocar Veiculo" : "Cadastrar";?>" id="salvar" class="btn <?=$acao == "trocarVeiculo" ? "btn-danger" : "btn-primary";?>">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript" src="public/js/funcoes.js"></script>
