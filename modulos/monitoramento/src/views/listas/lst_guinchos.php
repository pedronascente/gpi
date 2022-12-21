<div class="responsive">
    <div class="panel panel-primary">
        <div class="panel-heading "></div>
        <div class="panel-body">
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
                    <table class="table table-bordered table-hover table-striped dataTableBootstrapSemOrdem">
                        <thead>
                            <tr>
                                <th width="35%">Razão Social</th>
                                <th>Cidade</th>
                                <th>Endereço</th>
                                <th>Atendimento</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lista as $li) { ?>
                                <tr id="tr<?= $li->get("guincho_id"); ?>">
                                    <td><?= $li->get("guincho_razao_social"); ?></td>
                                    <td><?= $li->get("guincho_cidade"); ?></td>
                                    <td><?= $li->get("guincho_endereco"); ?></td>
                                    <td><?= $li->get("guincho_atendimento"); ?></td>
                                    <td width="10%" align="center">
                                        <a href="index.php?pg=48&id=<?= $li->get("guincho_id") . Funcoes::getParametrosURL($dadosFiltro); ?>" class="btn btn-xs  btn-info"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <a id="<?= $li->get("guincho_id"); ?>" class="btn  btn-xs btn-danger excluirGuincho"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
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
</div>