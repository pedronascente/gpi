<div class="panel panel-primary">
    <div class="panel-heading">Lista Ramais</div>
    <div class="panel-body">
        <a href= "fpdf/ramal/index.php" class="btn btn-primary">Imprimir em PDF</a>
        <a href= "modulos/ramal/src/controllers/ramal.php?acao=excel" class="btn btn-primary">Exportar para Excel</a>
        <br><br>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <?php
            foreach ($listBase as $k => $base) {
                $base_id = $base ['base_id'];
                $lista_setores = $ramal->listSetor($base_id);
                if (!empty($lista_setores)) {
                    ?>
                    <div class="panel panel-info">
                        <div class="panel-heading" role="tab" id="base<?= $k; ?>" role="button" data-toggle="collapse" href="#ramaisBase<?= $k; ?>" aria-expanded="false" aria-controls="ramaisBase<?= $k; ?>">
                            <strong>BASE <?= $base['base_nome']; ?></strong>
                        </div>
                        <div id="ramaisBase<?= $k; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="base<?= $k; ?>">
                            <div class="panel-body">
                                <?php
                                foreach ($lista_setores as $s) {
                                    $listRamal = $ramal->listRamal($s['setor_id'], $base_id);
                                    ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped" id="table_ramal"> 
                                            <thead>
                                                <tr>
                                                    <th colspan="7"><strong><?= mb_strtoupper($s['setor_local'], 'UTF-8'); ?></strong></th>
                                                </tr>
                                                <tr>
                                                    <th width="15%">Colaborador</th>
                                                    <th width="5%">Ramal</th>
                                                    <th width="10%">Telefone</th>
                                                    <th>E-mail</th>
                                                    <th width="10%">Status</th>
                                                    <th width="2%">Atualizar Ramal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($listRamal as $arrRamais) {
                                                    $status = $arrRamais ['ramal_status_id'] != 1 ? 'Desatualizado' : 'Atualizado';
                                                    ?>
                                                    <tr>
                                                        <td id="tdNome<?= $arrRamais['ramal_id']; ?>">&nbsp;<?= $arrRamais['ramal_nome_usuario']; ?></td>
                                                        <td id="tdRamal<?= $arrRamais['ramal_id']; ?>" align="center" class="ramal_ramal"><?= $arrRamais['ramal_ramal']; ?></td>
                                                        <td id="tdFone<?= $arrRamais['ramal_id']; ?>" align="center">&nbsp;<?= $arrRamais['ramal_telefone']; ?></td>
                                                        <td id="tdEmail<?= $arrRamais['ramal_id']; ?>" align="center"><?= $arrRamais['ramal_email']; ?></td>
                                                        <td><?= $status; ?></td>
                                                        <td>
                                                            <table width="80px">
                                                                <tr align="center">
                                                                    <td>
                                                                        <a id="<?= M_RAMAL ?>src/views/formularios/form.php?id=<?= $arrRamais['ramal_id']; ?>&acao=<?= $acaoRamal; ?>" class="botaoLoad modalOpen btn btn-sm btn-info" data-target="#modal"> 
                                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                                        </a>
                                                                    </td>
                                                                    <?php if ($recpcaoMaster) { ?>
                                                                        <td>
                                                                            <a  id="<?= $arrRamais['ramal_id']; ?>" class="btn btn-danger btn-sm botaoLoad deletarRamal">
                                                                                <span class="glyphicon glyphicon-trash"></span>
                                                                            </a>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr> 
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                }
                            }
                            ?> 
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>