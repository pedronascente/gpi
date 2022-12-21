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
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped dataTableBootstrapSemOrdem">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Cliente</th>
                    <th>Placa</th>
                    <th>UF</th>
                    <th>Evento</th>
                    <th>Atendimento</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista as $l) { ?>
                    <tr>
                        <td width="10%"><?= $l->get("sinistro_data"); ?></td>
                        <td><?= $l->get("sinistro_hora"); ?></td>
                        <td><?= $l->get("a_nome_cliente"); ?></td>
                        <td><?= $l->get("a_placa_veiculo"); ?></td>
                        <td><?= $l->get("sinistro_uf"); ?></td>
                        <td><?= $l->get("sinistro_evento"); ?></td>
                        <td><?= $l->get("sinistro_atendimento"); ?></td>
                        <?php if ($l->get("sinistro_status") == 1) { ?>
                            <td width="10%" align="center">
                                <table width="140px">
                                    <tr>
                                        <td><a href="index.php?pg=51&id=<?= $l->get("sinistro_id"); ?>&acao=editar#cadastro" class="btn btn-info">Editar</a></td>
                                        <td><a href="modulos/monitoramento/src/controllers/monitoramento.php?id=<?= $l->get("sinistro_id"); ?>&acao=excluirSinistro" class="btn btn-danger">Excluir</a></td>
                                    </tr>
                                </table>
                            </td>
                        <?php } else { ?>
                            <td><a href="index.php?pg=51&id=<?= $l->get("sinistro_id"); ?>&acao=visualizar#cadastro" class="btn btn-success">Visualizar</a></td>
                        <?php } ?>
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