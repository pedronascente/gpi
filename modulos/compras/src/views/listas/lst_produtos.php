<div class="panel panel-primary">
    <div class="panel-heading "> Lista Produtos</div>
    <div class="panel-body">
        <table  width="20%" align="center" border="1">
            <tr height="35">
                <td  style="color: #00008B;" width="12.5%" class="bordaTD cursorPointer" id="index.php?pg=47&filtro=2" align="center">Atingiu estoque minímo</td>
                <td	 style="color: #FF0000;" width="12.5%"  class="bordaTD cursorPointer" id="index.php?pg=47&filtro=1" align="center">Zerados</td>
            </tr>
        </table>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float: right">
                <?php
                $formularioBusca = new FormularioDeBusca;
                $formularioBusca->setPg($pg);
                $formularioBusca->setFiltro('busca');
                $formularioBusca->setMethod("GET");
                $formularioBusca->setValue($busca);
                $formularioBusca->formBusca();
                ?>
            </div>
        </div>
        <?php if (!empty($lista)) { ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped dataTableBootstrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Data Cadastro</th>
                        <th>Descrição</th>
                        <th>Referencia</th>
                        <th>Categoria</th>
                        <th>Unidade</th>
                        <th>Quantidade</th>
                        <th>Est. Minímo</th>
                        <th>Localização</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($lista as $li) {
                        $cor = $li->get("produto_quantidade", true) <= $li->get("produto_estoque_min", true) ? 'style="color: #00008B;"' : "";
                        $cor = $li->get("produto_quantidade", true) == 0 ? 'style="color: #FF0000;"' : $cor;
                        ?>
                        <tr <?= $cor; ?>>
                            <td width="5%"><?= $li->get("produto_id"); ?></td>
                            <td><?= $li->get("produto_status"); ?></td>
                            <td><?= $li->get("produto_data_cadastro"); ?></td>
                            <td><?= $li->get("produto_descricao"); ?></td>
                            <td><?= $li->get("produto_referencia"); ?></td>
                            <td><?= $li->get("produto_categoria_desc"); ?></td>
                            <td><?= $li->get("produto_unidade_desc"); ?></td>
                            <td><?= $li->get("produto_quantidade"); ?></td>
                            <td><?= $li->get("produto_estoque_min"); ?></td>
                            <td><?= $li->get("produto_localizacao"); ?></td>
                            <td width="2%" align="center"><a class="btn btn-sm btn-info" href="index.php?pg=47&id=<?= $li->get("produto_id"); ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                        </tr>
    <?php } ?>
                </tbody>
            </table>
            </div>
            <?php
            $objPaginacao->MontaPaginacao();
        } else {
            Funcoes::Nregistro();
        }
        ?>
    </div>
</div>