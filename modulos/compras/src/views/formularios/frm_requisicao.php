<div id="alert"></div>
<div class="panel panel-primary">
    <div class="panel-heading "> Cadastro Requisição</div>
    <div class="panel-body">
        <form method="POST" action="modulos/compras/src/controllers/compras.php">
            <div class ="row">
                <div class="col-xs-12 col-sm-6 col-md-5 col-lg-3">
                    <div class="form-group">
                        <label>Data:</label>
                        <div class="input-group input-append date datepicker">
                            <input type="text" class="form-control" name="produto_requisicao_data" value="<?= $produtosRequisicao->get("produto_requisicao_data") != NULL ? $produtosRequisicao->get("produto_requisicao_data") : ""; ?>" <?= Funcoes::Disable($acao); ?> required="required">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-5 col-lg-3">
                    <div class="form-group">
                        <label>Tipo:</label>
                        <select name="produto_requisicao_tipo" class="form-control" <?= Funcoes::Disable($acao); ?> required="required" id="tipoRequisicao">
                            <option value="saida" 	<?= $produtosRequisicao->get("produto_requisicao_tipo", true) == "saida" ? "selected" : ""; ?>>Saída</option>
                            <option value="entrada" <?= $produtosRequisicao->get("produto_requisicao_tipo", true) == "entrada" ? "selected" : ""; ?>>Entrada</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-5 col-lg-3">
                    <div class="form-group">
                        <label>Data Criação:</label>
                        <input type="text" name="produto_requisicao_data_criacao" class="form-control" value="<?= $produtosRequisicao->get("produto_requisicao_data_criacao") != NULL ? $produtosRequisicao->get("produto_requisicao_data_criacao") : date("d/m/Y H:i:s"); ?>" readonly="readonly">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-5 col-lg-3">
                    <div class="form-group">
                        <label>Supervisor:</label>
                        <input type="text" class="form-control" value="<?= $produtosRequisicao->get("produto_requisicao_usuario") != NULL ? $produtosRequisicao->get("produto_requisicao_usuario") : $_SESSION['user_info']['nome']; ?>" disabled="disabled">
                    </div>
                </div>
            </div>
            <div class ="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>Setor:</label>
                        <select name="produto_requisicao_setor" class="form-control selectpicker" <?= Funcoes::Disable($acao); ?> required="required" id="setorRequisicao">
                            <option value="">Selecione ... </option>
                            <?php if (!empty($setores)) {
                                foreach ($setores as $s) {
                                    ?>
                                    <option value="<?= $s['setor_id']; ?>" <?= $s['setor_id'] == $produtosRequisicao->get("produto_requisicao_setor") ? "selected" : ""; ?>><?= $s['setor_local']; ?></option>
                                <?php }
                            }
                            ?>

                        </select>
                        <input type="hidden" name="setorUsuario" id="setorUsuario" value="<?= $_SESSION['user_info']['id_setor']; ?>">
                    </div>
                </div>
            </div>
				<?php if ($produtosRequisicao->get("produto_requisicao_tipo", true) != "entrada") { ?>
                <div class ="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="solicitanteRequiscao">
                        <div class="form-group">
                            <label>Solicitante:</label>
                            <input type="text" name="produto_requisicao_solicitante" value="<?= $produtosRequisicao->get("produto_requisicao_solicitante"); ?>" class="form-control" <?= Funcoes::Disable($acao); ?> required="required" id="solicitante"> 
                        </div>
                    </div>
                </div>
				<?php } ?>
            <div class ="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>Produto:</label>
                        <select name="produto_requisicao_produto" class="form-control selectpicker" <?= Funcoes::Disable($acao); ?> required="required" id="produtoRequisicao">
                            <option value="">Selecione ... </option>
                            <?php if (!empty($listaProdutos)) {
                                foreach ($listaProdutos as $p) {
                                    ?>
                                    <option value="<?= $p["produto_id"]; ?>" <?= $p["produto_id"] == $produtosRequisicao->get("produto_requisicao_produto") ? "selected" : ""; ?>><?= $p["produto_descricao"]; ?></option>
    						<?php }
							}
							?>

                        </select>
                    </div>
                </div>
            </div>
            <div class ="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" <?= Funcoes::Disable($acao); ?>>
                    <div class="form-group">
                        <label>Quantidade:</label>
                        <input type="text" name="produto_requisicao_quantidade" id="quantidadeRequisicao" value="<?= $produtosRequisicao->get("produto_requisicao_quantidade"); ?>" class="form-control mask_quantidade" <?= Funcoes::Disable($acao); ?> required="required">
                    </div>
                </div>
					<?php if ($acao != "visualizar") { ?>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Quantidade Atual:</label>
                            <input type="text" id="quantidadeAtualizada" class="form-control" disabled="disabled">
                            <input type="hidden" id="quantidadeAtual">
                            <input type="hidden" id="estoqueMinimo">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Unidade:</label>
                            <input type="text" id="unidade" class="form-control" disabled="disabled">
                        </div>
                    </div>
					<?php } ?>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>OBS:</label>
                        <textarea class="form-control" name="produto_requisicao_obs" <?= Funcoes::Disable($acao); ?>><?= $produtosRequisicao->get("produto_requisicao_obs"); ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-actions">
                        <?php if ($acao != "visualizar") { ?>
                            <input type="hidden" name="acao" value="salvarRequisicao">
                            <input type="hidden" name="produto_requisicao_id" value="<?= $produtosRequisicao->get("produto_requisicao_id"); ?>">
                            <input type="hidden" name="produto_requisicao_usuario" value="<?= $produtosRequisicao->get("produto_requisicao_usuario") != NULL ? $produtos->get("produto_requisicao_usuario") : $_SESSION['user_info']['id_usuario']; ?>">
                            <input type="submit" class="btn btn-primary" value="Salvar">
						<?php } else { ?>
                            <a class="btn btn-info" href="index.php?pg=47#requisicao">Voltar</a>
						<?php } ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
