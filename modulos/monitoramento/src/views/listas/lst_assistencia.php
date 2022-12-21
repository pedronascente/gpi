<div class="panel panel-primary">
    <div class="panel-heading"></div>
    <div class="panel-body">
        <br>
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
            <table class="table table-bordered table-hover table-striped dataTableBootstrapSemOrdem">
                <thead>
                    <tr>
                        <th>Protocolo</th>
                        <th>Nome Cliente</th>
                        <th>Data</th>
                        <th>Responsável</th>
                        <th>Solicitação</th>
                        <th>Local</th>
                        <th>Empresa</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista as $li) { ?>
                        <tr>
                            <td width="5%"><?= $li->get("assistencia_protocolo"); ?></td>
                            <td><?= $li->get("a_nome_cliente"); ?></td>
                            <td><?= $li->get("assistencia_data") . " " . $li->get("assistencia_hora") ?></td>
                            <td><?= $li->get("a_nome_responsavel"); ?></td>
                            <td><?= $li->get("assistencia_solicitacao"); ?></td>
                            <td><?= $li->get("assistencia_local"); ?></td>
                            <td><?= $li->get("guincho_razao_social"); ?></td>
                            <td width="10%" align="center">
                                <table width="140px">
                                    <tr>
                                        <?php if ($li->get("assistencia_status", true) == 2) { ?>
                                            <td><a class="btn btn-success" href="index.php?pg=49&id=<?= $li->get("assistencia_id"); ?>&acao=visualizar#cadastro">Visualizar</a></td>
                                        <?php } else { ?>
                                            <td><a class="btn btn-info" href="index.php?pg=49&id=<?= $li->get("assistencia_id"); ?>&acao=editar">Editar</a></td>
                                            <td><a class="btn btn-danger" href="modulos/monitoramento/src/controllers/monitoramento.php?acao=excluirAssistencia&id=<?= $li->get("assistencia_id"); ?>">Excluir</a></td>
                                        <?php } ?>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php
            $objPaginacao->MontaPaginacao();
        } else {
            Funcoes::Nregistro();
        }
        ?>
    </div>
</div>