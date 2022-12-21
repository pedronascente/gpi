<?php if (!empty($veiculoCliente)) { ?>
    <div class="panel panel-primary">
        <div class="panel-heading ">Formulário</div>
        <div class="panel-body">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <form method="post" action="modulos/sac/src/controllers/sac.php">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <h3><label>Dados do Veículo:</label></h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Placa:</label>
                                    <input type="text" name="placa" value="<?= isset($veiculoCliente['placa']) ? $veiculoCliente['placa'] : null; ?>" class="mask_placa form-control" <?= $contrato ? 'readonly="readonly"' : ''; ?>/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Marca:</label>
                                    <input type="text" name="marca" value="<?= isset($veiculoCliente['marca']) ? $veiculoCliente['marca'] : null; ?>" class="form-control"<?= $contrato ? 'readonly="readonly"' : ''; ?> />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Modelo:</label>
                                    <input type="text" name="modelo" value="<?= isset($veiculoCliente['modelo']) ? $veiculoCliente['marca'] : null; ?>" class="form-control"<?= $contrato ? 'readonly="readonly"' : ''; ?> />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Cor:</label>
                                    <input type="text" name="cor" value="<?= isset($veiculoCliente['cor']) ? $veiculoCliente['cor'] : null; ?>" class="form-control"<?= $contrato ? 'readonly="readonly"' : ''; ?>/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Ano:</label>
                                    <input type="text" name="ano" value="<?= isset($veiculoCliente['ano']) ? $veiculoCliente['ano'] : null; ?>" class="form-control mask_anofab"<?= $contrato ? 'readonly="readonly"' : ''; ?>/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Renavan:</label>
                                    <input type="text" name="renavam" value="<?= isset($veiculoCliente['renavam']) ? $veiculoCliente['renavam'] : null; ?>" class="form-control"<?= $contrato ? 'readonly="readonly"' : ''; ?>/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Chassis:</label>
                                    <input type="text" name="chassis" value="<?= isset($veiculoCliente['chassis']) ? $veiculoCliente['chassis'] : null; ?>" class="form-control"<?= $contrato ? 'readonly="readonly"' : ''; ?>/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Voltagem:</label>
                                    <input type="text" name="tipo_bateria" value="<?= isset($veiculoCliente['tipo_bateria']) ? $veiculoCliente['tipo_bateria'] : null; ?>" class="form-control"<?= $contrato ? 'readonly="readonly"' : ''; ?>/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>OBS:</label>
                                    <textarea name="observacoes" value="" class="form-control"<?= $contrato ? 'readonly="readonly"' : ''; ?> <?= $contrato ? 'readonly="readonly"' : ''; ?>/><?= isset($veiculoCliente['observacoes']) ? $veiculoCliente['observacoes'] : null; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <?php if (!$contrato) { ?>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-actions">
                                        <input type="hidden" name="id_veiculo" value="<?= $veiculoCliente['id_veiculo']; ?>">
                                        <input type="hidden" name="acao" value="editarVeiculo">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <h3><label>Dados de Instalação:</label></h3>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="modulos/sac/src/controllers/sac.php">
                        <div class="row">
                            <?php
                                    if(!empty($id_chip))
                            ?>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Chip:</label>
                                    <select name="veiculos_equipamentos_id_chip" class="form-control" id="selectChip">
                                        <option value="">Selecione...</option>
                                        <?php
                                        if (!empty($listaChips)) {
                                            foreach ($listaChips as $li) {
                                                ?>
                                                <option value="<?= $li->get("chip_id"); ?>" <?= $li->get("chip_id") == $id_chip ? "selected" : ""; ?>><?= $li->get("chip_linha"); ?></option>
                                            <?php }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Módulo:</label>
                                    <input type="text" id="moduloChip" value="<?= $chip->get("modulo_serial"); ?>" disabled="disabled" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Local Botão Pânico:</label>
                                    <input type="text" name="veiculos_equipamentos_local_botao_panico" value="<?= isset($equipamento['veiculos_equipamentos_local_botao_panico']) ? $equipamento['veiculos_equipamentos_local_botao_panico'] : null; ?>" class="form-control"  />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Local da Sirene:</label>
                                    <input type="text" name="veiculos_equipamentos_local_sirene" value="<?= isset($equipamento['veiculos_equipamentos_local_sirene']) ? $equipamento['veiculos_equipamentos_local_sirene'] : null; ?>" class="form-control"  />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Data Instalação:</label>
                                    <div class="input-group input-append date datepicker">
                                        <input type="text" name="veiculos_equipamentos_data_instalacao"  value="<?= !empty($equipamento['veiculos_equipamentos_data_instalacao']) ? Funcoes::formataData($equipamento['veiculos_equipamentos_data_instalacao']) : null; ?>" class="form-control"  />
                                        <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Responsável pela Instalação:</label>
                                    <input type="text" name="veiculos_equipamentos_responsavel_instalacao" value="<?= isset($equipamento['veiculos_equipamentos_responsavel_instalacao']) ? $equipamento['veiculos_equipamentos_responsavel_instalacao'] : null; ?>" class="form-control"  />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Observação:</label>
                                    <textarea name="veiculos_equipamentos_obs" class="form-control" ><?= isset($equipamento['veiculos_equipamentos_obs']) ? $equipamento['veiculos_equipamentos_obs'] : null; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Equipamentos Instalados:</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="textoEquipamento">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" id="adicionarEquipamento">Adicionar</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <div class="scrollbar">
                                        <ul class="list-group" id="listaEquipamentos">
                                            <?php
                                            if (!empty($listaEquipamentos)) {
                                                foreach ($listaEquipamentos as $eq) {
                                                    ?>
                                                    <div class="checkbox" id="div<?= $eq->get("equipamentos_sac_id"); ?>"><label><input type="checkbox" name="equipamentos[]" value="<?= $eq->get("equipamentos_sac_id"); ?>" <?= in_array(array("equipamentos_sac_clientes_equipamento" => $eq->get("equipamentos_sac_id")), $listaEquipamentosCliente) ? "checked" : ""; ?> class="markCheck"><?= $eq->get("equipamentos_sac_desc"); ?></label><a id="<?= $eq->get("equipamentos_sac_id"); ?>" class="excluirEquipamento"><span class="glyphicon glyphicon-remove pull-right"></span></a></div>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-actions">
                                    <input type="hidden" name="acao" id="acao" value="insertEquipamentosVeiculos" /> 
                                    <input type="hidden" name="id_cliente" value="<?= $veiculoCliente['cliente_ra'] ?>" /> 
                                    <input type="hidden" name="placa" value="<?= $veiculoCliente['placa'] ?>" /> 
                                    <input type="hidden" name="veiculos_equipamentos_id_veiculo" value="<?= $id_veiculo; ?>" /> 
                                    <input type="submit" name="submit" value="Salvar" class="btn btn-primary"/>
                                    <a href="index.php?pg=10&id=<?= $veiculoCliente['cliente_ra']; ?>&acao=ListarCliente#veiculos" class="btn btn-default">Voltar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}?>