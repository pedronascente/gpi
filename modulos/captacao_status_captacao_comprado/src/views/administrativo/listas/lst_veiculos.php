<div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="veiculos" role="button" data-toggle="collapse"      href="#dadosVeiculos" aria-expanded="false" aria-controls="dadosVeiculos">
        Veículos - Registros encontrados <?= "({$totalVeiculo})"; ?>
    </div>
    <div id="dadosVeiculos" class="panel-collapse collapse" role="tabpanel" aria-labelledby="veiculos">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <td>Placa</td>
                            <td>Modelo</td>
                            <td>Chassis</td>
                            <td>Plano</td>
                            <td>Visualizar</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($list_veiculo)) :
                            foreach ($list_veiculo as $k => $li) : $veiculo_placa = !empty($li ['placa']) ? $li ['placa'] : NULL;
                                $veiculo_modelo = !empty($li ['modelo']) ? $li ['modelo'] : NULL;
                                $veiculo_chassis = !empty($li ['chassis']) ? $li ['chassis'] : NULL;
                                $veiculo_id = !empty($li ['id_veiculo']) ? $li ['id_veiculo'] : NULL;
                                ?>
                                <tr align="center">
                                    <td><?= $veiculo_placa; ?></td>
                                    <td><?= $veiculo_modelo; ?></td>
                                    <td><?= $veiculo_chassis; ?></td>
                                    <td><?= $li ['tipo_seguro']; ?></td>
                                    <td>
                                        <a id="modulos/captacao/src/views/administrativo/listas/lst_modal_Visualizar_Veiculos_Pagina_Listar_Cliente.php?id=<?= $veiculo_id; ?>"
                                           class="btn btn-success botaoLoad modalOpen"
                                           data-target="#modalVeiculos">
                                            Visualizar
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>