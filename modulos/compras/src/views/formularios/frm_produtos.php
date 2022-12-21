<div class="panel panel-primary">
    <div class="panel-heading "> Cadastro Produtos</div>
    <div class="panel-body">
        <form method="POST" action="modulos/compras/src/controllers/compras.php">
            <div class ="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Status:</label>
                        <select class="form-control" name="produto_status">
                            <option value="ativo" <?= $produtos->get("produto_status", true) == "ativo" ? "selected" : ""; ?>>Ativo</option>
                            <option value="inativo" <?= $produtos->get("produto_status", true) == "inativo" ? "selected" : ""; ?>>Inativo</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Data Cadastro:</label>
                        <input type="text" class="form-control" name="produto_data_cadastro" value="<?= $produtos->get("produto_data_cadastro") != NULL ? $produtos->get("produto_data_cadastro") : date("d/m/Y H:i:s"); ?>" readonly="readonly">
                    </div>
                </div>
                <?php if ($produtos->get("produto_id") != NULL) { ?>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Código:</label>
                            <input type="text" class="form-control" disabled="disabled" disabled="disabled" value="<?= $produtos->get("produto_id"); ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Quantidade:</label>
                            <input type="text" class="form-control" name="produto_quantidade" value="<?= $produtos->get("produto_quantidade"); ?>" disabled="disabled">
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class ="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>Descrição:</label>
                        <input type="text" class="form-control" name="produto_descricao" value="<?= $produtos->get("produto_descricao"); ?>" required="required">
                    </div>
                </div>
            </div>
            <div class ="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label>Referência:</label>
                        <input type="text" class="form-control" name="produto_referencia" value="<?= $produtos->get("produto_referencia"); ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" <?= !empty($listaCategorias) ? "style='display:none;'" : ""; ?> id="divAddCategoria">
                    <div class="form-group">
                        <label>Categoria:</label>
                        <div class="input-group">
                            <input type="text" id="nomeCategoria" class="form-control">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary botaoLoad adicionarCategoria">
                                    Add
                                </button>                         
                            </div>
                        </div>                               
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" <?= empty($listaCategorias) ? "style='display:none;'" : ""; ?> id="divSelectCategoria">
                    <div class="form-group">
                        <label>Categoria:</label>
                        <div class="input-group">
                            <select name="produto_categoria" class="form-control" id="selectCategoria">
                                <option value="">Selecione ...</option>
                                <?php
                                if (!empty($listaCategorias)) {
                                    foreach ($listaCategorias as $cat) {
                                        ?>
                                        <option value="<?= $cat->get("produto_categoria_id"); ?>" <?= $produtos->get("produto_categoria", true) == $cat->get("produto_categoria_id") ? "selected" : ""; ?>><?= $cat->get("produto_categoria_desc"); ?></option>                        				
                                    <?php
                                    }
                                }
                                ?>
                            </select>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default botaoLoad adicionarCategoria">
                                    Add
                                </button>
                            </div>                     
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" <?= !empty($listaUnidades) ? "style='display:none;'" : ""; ?> id="divAddUnidade">
                    <div class="form-group">
                        <label>Unidade:</label>
                        <div class="input-group">
                            <input type="text" id="nomeUnidade" class="form-control">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary botaoLoad adicionarUnidade">
                                    Add
                                </button>                         
                            </div>
                        </div>                               
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" <?= empty($listaUnidades) ? "style='display:none;'" : ""; ?> id="divSelectUnidade">
                    <div class="form-group">
                        <label>Unidade:</label>
                        <div class="input-group">
                            <select name="produto_unidade" class="form-control" id="selectUnidade">
                                <option value="">Selecione ...</option>
                                <?php
                                if (!empty($listaUnidades)) {
                                    foreach ($listaUnidades as $un) {
                                        ?>
                                        <option value="<?= $un->get("produto_unidade_id"); ?>" <?= $produtos->get("produto_unidade", true) == $un->get("produto_unidade_id") ? "selected" : ""; ?>><?= $un->get("produto_unidade_desc"); ?></option>                        				
    							<?php
    								}
								}
								?>
                            </select>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default botaoLoad adicionarUnidade">
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class ="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Estoque Mínimo:</label>
                        <input type="text" class="form-control mask_quantidade" name="produto_estoque_min" value="<?= $produtos->get("produto_estoque_min"); ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Localização:</label>
                        <input type="text" class="form-control" name="produto_localizacao" value="<?= $produtos->get("produto_localizacao"); ?>">
                    </div>
                </div>
            </div>
            <div class ="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>OBS:</label>
                        <textarea class="form-control" name="produto_obs"><?= $produtos->get("produto_obs"); ?></textarea>
                    </div>
                </div>
            </div>
            <div class ="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-actions">
                        <input type="hidden" name="acao" value="salvarProduto">
                        <input type="hidden" name="produto_id" value="<?= $produtos->get("produto_id"); ?>">
                        <button type="submit" class="btn btn-primary">Salvar</button>
						<?php if ($produtos->get("produto_id") != null) { ?>
                            <a href="index.php?pg=47" class="btn btn-info">Voltar</a>
						<?php } ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>