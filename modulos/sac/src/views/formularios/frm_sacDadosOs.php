<?php
$dados = filter_input_array(INPUT_POST) != null ? filter_input_array(INPUT_POST) : filter_input_array(INPUT_GET);
$id               = (!empty($dados['id_os']) ? $dados['id_os'] : null);
$id_cliente       = (!empty($dados['id']) ? $dados['id'] : null);
$opOs             = (!empty($dados['opOs']) ? $dados['opOs'] : null);
$veiculo          = new Veiculos ();
$acaoSessao 	  = filter_input(INPUT_GET, "acaoSessao"); 


/*
 * *****************************
 * ********* LISTA OS **********
 * *****************************
 */


$os = null;
if(!empty($id))
	$os                 = (!empty($id) ? $veiculo->selectOSVeiculo($id) : null);


/*
 * **************************************
 * ********* SELECIONAR PLACAS **********
 * **************************************
 */
$listaPlacaVeiculos = (!empty($id_cliente) ? $veiculo->selectVeiculosPorClienteOs($id_cliente) : null);

$status 	= !empty($os ['veiculos_os_status']) 	?  $os ['veiculos_os_status'] 	: null;
$placa 		= !empty($os ['placa']) 				?  $os ['placa'] 				: null;

?>
<div class="panel panel-primary">
    <div class="panel-heading ">Formulário OS</div>
    <div class="panel-body">
        <form action="modulos/sac/src/controllers/sac.php" method="post">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label><?="<h2>Cliente / ".ucfirst($dadosCliente['nome_cliente'])."</h2>"; ?></label>
                    </div>
                </div>
            </div>
		<?php if (!empty($id)) { ?>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <div class="IMG_placa">
                            <strong class="_text" id="textPlaca">
                    <?=$placa;?>
                            </strong>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="placa" value="<?=$os['placa']?>">
            </div>
		<?php } else {?>
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Pesquisa Placa.:</label>
                        <select name="placa" id="placa" required class="form-control" <?=Funcoes::Disable($veiculos_os_status);?>>
                            <option value="" selected="selected">Selecione uma placa</option>
						<?php
							if (! empty ( $listaPlacaVeiculos )) {
								$osPlaca = (! empty ( $os ['placa'] )) ? $os ['placa'] : NULL;
								foreach ( $listaPlacaVeiculos as $v ) {
									$selected = ($v ["placa"] == $osPlaca) ? 'selected' : '';
									echo "<option value=\"{$v['placa']}_{$v['id_veiculo']}\" {$selected} >{$v['placa']}</option>";
								}
							}
							?>
                        </select>
                        <input type="hidden" name="acao" value="buscaPlacaSac" />
                    </div>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8" align="right">
                    <div class="IMG_placa">
                        <strong class="_text" id="textPlaca">
                    <?=$placa?>
                        </strong>
                    </div>
                </div>
            </div>
		<?php }?>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <h3><label>Dados da Ordem Serviço:</label></h3>
                    </div>
                </div>
            </div>
                <?php if (! empty ( $opOs )) {
			$nOS = (! empty ( $os ['veiculos_os_id'] )) ? " Protocolo da OS : {$os['veiculos_os_protocolo']}<br>" : '';
			$DATA = (! empty ( $os ['veiculo_os_data_criacao'] )) ? "Data :" . date ( "d/m/Y H:m:s", strtotime ( $os ['veiculo_os_data_criacao'] ) ) : '';
		?>

            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <div class="form-group">
                        <h3><label><?=$nOS;?></label></h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <h4><label><?=$DATA;?></label></h4>
                    </div>
                </div>
            </div>
		<?php }
		$status 		= !empty($os['veiculos_os_status']) 	? $os['veiculos_os_status'] 	: "";
		$tipo   		= !empty($os["veiculos_os_tipo"])   	? $os["veiculos_os_tipo"] 		: "";
		$gravidade 		= !empty($os["veiculos_os_gravidade"]) 	? $os["veiculos_os_gravidade"] 	: "";
		
		
		?>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label>Status:</label>
                        <select name="veiculos_os_status" <?=Funcoes::Disable($opOs);?> class="form-control">
                            <option value="1" <?=($status=='1') ? 'selected' : '' ;?>>Aberto</option>
                            <option value="2" <?=($status=='2') ? 'selected' : '' ;?>>Em Andamento</option>
                            <option value="3" <?=($status=='3') ? 'selected' : '' ;?>>Finalizado</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label>Tipo OS:</label>
                        <select name="veiculos_os_tipo" class="form-control" <?=Funcoes::Disable($opOs);?>>
                            <option value="1" <?=$tipo == 1 ? 'selected' : null;?>>Manutenção</option>
                            <option value="2" <?=$tipo == 2 ? 'selected' : null;?>>Instalação</option>
                            <option value="3" <?=$tipo == 3 ? 'selected' : null;?>>Reclamação</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label>Gravidade:</label>
                        <select name="veiculos_os_gravidade" class="form-control" <?=Funcoes::Disable($opOs);?>>
                            <option value="1" <?=$gravidade == 1 ? 'selected' : null;?>>Baixa</option>
                            <option value="2" <?=$gravidade == 2 ? 'selected' : null;?>>Média</option>
                            <option value="3" <?=$gravidade == 3 ? 'selected' : null;?>>Alta</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Solicitante:</label>
                        <input type="text" name="veiculos_os_solicitante" required value="<?=(!empty($os["veiculos_os_solicitante"])) ? $os["veiculos_os_solicitante"] : NULL;?>" class="form-control" <?=Funcoes::Disable($opOs);?> />
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Endereço de Manutenção:</label>
                        <input type="text" name="veiculos_os_endereco_manutencao"  value="<?=(!empty($os["veiculos_os_endereco_manutencao"])) ? $os["veiculos_os_endereco_manutencao"] : NULL;?>" class="form-control" <?=Funcoes::Disable($opOs);?> />
                    </div>
                </div>
            </div>
            <div class="row">
            	<?php $osCredenciado = (!empty($os["veiculos_os_id_credenciado"])) ? $os["veiculos_os_id_credenciado"] : NULL; ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Credenciado:</label>
                        <select name="veiculos_os_id_credenciado" class="form-control" <?=Funcoes::Disable($opOs);?>>
                        	<option>Selecione...</option>
                        	<?php if(!empty($listaCredenciados)){
                        				foreach ($listaCredenciados as $c){
                        	?>
                        		<option value="<?=$c->get("credenciado_id");?>" <?=$c->get("credenciado_id") == $osCredenciado ? "selected" : "";?> <?=Funcoes::Disable($opOs);?>><?=$c->get("credenciado_razao_social");?></option>
                        	<?php }}?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Técnico:</label>
                        <input type="text" name="veiculos_os_tecnico"  value="<?=(!empty($os["veiculos_os_tecnico"])) ? $os["veiculos_os_tecnico"] : NULL;?>" class="form-control" <?=Funcoes::Disable($opOs);?> />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Motivo:</label>
                        <textarea name="veiculos_os_motivo_manutencao" required class="form-control" <?=Funcoes::Disable($opOs);?>><?=(!empty($os['veiculos_os_motivo_manutencao'])) ? $os['veiculos_os_motivo_manutencao'] : NULL;?></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Descrição:</label>
                        <textarea name="veiculos_os_manutencao_efetuada" class="form-control" <?=Funcoes::Disable($opOs);?>><?=(!empty($os['veiculos_os_manutencao_efetuada'])) ? $os['veiculos_os_manutencao_efetuada'] : NULL;?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-actions">
                        <input type="hidden" name="veiculos_os_id" value="<?=(!empty($os['veiculos_os_id'])) ?  $os['veiculos_os_id'] :  NULL;?>" />
                        <input type="hidden" name="acao" value="InsertOs" /> 
                        <input type="hidden" name="veiculos_os_id_cliente" value="<?=$id_cliente?>"/>
                        <input type="hidden" name="veiculos_os_id_veiculo" value="<?=!empty($os['veiculos_os_id_veiculo']) ? $os['veiculos_os_id_veiculo'] : ""?>"/>
                        <input type="<?=$opOs == "visualizar" ? "hidden" : "submit";?>" value="<?=($opOs == "EditarOs") ?  "Atualizar": "Salvar";?>" class="btn btn-primary">
                      	<?php if($opOs == "EditarOs" || $opOs == "visualizar") {?>
                        <a href="fpdf/gerarOsSac/index.php?id=<?=$os['veiculos_os_id'];?>" class="btn btn-default"  id=\btn_gerarPDF">Imprimir</a>
                        <?php if($acaoSessao != "relatorio"){?>
                        <a href="?pg=10&id=<?=$id_cliente;?>&acao=ListarCliente#os" class="btn btn-default">Limpar</a>
                        <?php } else {?>
                        <a href="index.php?pg=44&id=<?=$id_cliente;?>#os" class="btn btn-default">Voltar</a>
                        <?php }?>
                      	 <?php }?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php if($acaoSessao != "relatorio"){?>
<div class="panel panel-primary">
    <div class="panel-heading ">Lista OS</div>
    <div class="panel-body">
<?php include_once("lst_sacOSCliente.php");?>
    </div>
</div>
<?php }?>