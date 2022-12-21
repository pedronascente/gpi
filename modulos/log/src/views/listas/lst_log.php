<div class="panel panel-primary">
    <div class="panel-heading "> Lista logs</div>
    <div class="panel-body">
        <?php if (!empty($logs)) { ?>
        <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped dataTableBootstrap">
                    <thead>
                        <tr>
                            <th width="15%">Data</th>
                            <?php if ($permissao) { ?>
                                <th>Identificação</th>
                                <th>Tabela</th>
                            <?php } ?>
                            <th>Usuário</th>
                            <th>Descrição</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $lo) { ?>
                            <tr>
                                <td><?= $lo->get("log_data"); ?></td>
                                <?php if ($permissao) { ?>
                                    <td><?= $lo->get("log_identificacao") ?></td>
                                    <td><?= $lo->get("log_tabela"); ?></td>
                                <?php } ?>
                                <td><?= $lo->get("log_nome_usuario"); ?></td>
                                <td><?= $lo->get("log_descricao"); ?></td>
                                <td width="2%" align="center"><a id="modulos/log/src/views/formularios/modalLog.php?id=<?= $lo->get("log_id"); ?>" class="btn btn-sm btn-success botaoLoad modalOpen" data-target="#modal"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr><td colspan="<?= $permissao ? "6" : "4"; ?>">Registros Encontrados: <?= $totalLog; ?></td></tr>
                    </tfoot>
                </table>
                </div>
            </div>
            <?php
            $objPaginacaoLog->MontaPaginacao();
        } else {
            Funcoes::Nregistro();
        }
        ?>
</div>
