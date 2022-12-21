<div class="panel panel-primary">
    <div class="panel-heading "> Chips</div>
    <div class="panel-body"> 
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                <select class="form-control selectStatus" name="status">
                    <option value="2" <?= $status == 2 ? "selected" : ""; ?>>Em Andamento</option>
                    <option value="3" <?= $status == 3 ? "selected" : ""; ?>>Programados</option>
                    <option value="5" <?= $status == 5 ? "selected" : ""; ?>>Vinculados</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float: right">
                <?php
                $formularioBusca = new FormularioDeBusca;
                $formularioBusca->setPg($pg);
                $formularioBusca->setFiltro('busca');
                $formularioBusca->setMethod("GET");
                $formularioBusca->setHiddens(array("status" => $status));
                $formularioBusca->setValue($busca);
                $formularioBusca->formBusca();
                ?>
            </div>
        </div>
        <?php if (!empty($lista)) { ?>
        	<div class="well well-sm">
				<span class="glyphicon glyphicon-eye-open"></span> => Visualizar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="glyphicon glyphicon-pencil"></span> => Editar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="glyphicon glyphicon-resize-full"></span> => Desvincular &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="glyphicon glyphicon-cd"></span> => Defeito
			</div>
            <table class="table table-bordered  table-striped dataTableBootstrap">
                <thead>
                    <tr>
                        <th>Chip Linha</th>
                        <th>Serial Módulo</th>
                        <th>Status</th>
                        <th>Cliente</th>
                        <th >Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista as $l) { ?>
                        <tr>
                            <td width="10%"><?= $l->get("chip_linha"); ?></td>
                            <td><?= $l->get("modulo_serial"); ?></td>
                            <td><?= $l->get("chip_status"); ?></td>
                            <td><?= $l->get("chip_cliente"); ?></td>
                            <td width="5%">
                                <table  width='210px'>
                                    <tr>
                                        <td>
                                            <a href="index.php?pg=46&id_programacao=<?= $l->get("chip_id"); ?>&acao_tela=programacao#programacao" class="btn btn-sm <?= $l->get("chip_status", true) == 3 ? "btn btn-success" : "btn btn-info"; ?>"><?= $l->get("chip_status", true) == 3 ? '<span class="glyphicon glyphicon-eye-open">' : '<span class="glyphicon glyphicon-pencil">'; ?></a>
                                        </td>
                                        <?php if ($l->get("chip_status", true) != 5) { ?>
                                            <td><a href="modulos/compras/src/controllers/compras.php?id_chip=<?= $l->get("chip_id"); ?>&id_modulo=<?= $l->get("modulo_id"); ?>&acao=desvincular" class="botaoLoad btn btn-sm btn-danger" >
                                                    <span class="glyphicon glyphicon-resize-full"></span>
                                                </a></td>
                                            <td> <a id="modulos/compras/src/views/formularios/modalMotivoDefeito.php?id_chip=<?= $l->get("chip_id"); ?>&id_modulo=<?= $l->get("modulo_id"); ?>" class="botaoLoad btn btn-warning modalOpen" data-target="#modal">
		                                        <span class="glyphicon glyphicon-cd"></span>
		                                    </a></td>
                                        <?php } ?>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr><td colspan="5">Registros: <?= $total; ?></td></tr>
                </tfoot>
            </table>
            <?php
            $objPaginacaoLista->MontaPaginacao();
        } else {
            Funcoes::Nregistro();
        }
        ?>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading "> Módulos Não Programados</div>
    <div class="panel-body"> 
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                <select class="form-control selectStatus" name="status_modulo">
                    <option value="1" <?= $statusModulo == 1 ? "selected" : ""; ?>>Novos</option>
                    <option value="2" <?= $statusModulo == 2 ? "selected" : ""; ?>>Com Defeito</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float: right">
                <?php
                $formularioBusca = new FormularioDeBusca;
                $formularioBusca->setPg($pg);
                $formularioBusca->setFiltro('buscaModulo');
                $formularioBusca->setMethod("GET");
                $formularioBusca->setHiddens(array("status_modulo" => $statusModulo));
                $formularioBusca->setValue($buscaModulo);
                $formularioBusca->formBusca();
                ?>
            </div>
        </div>
        <?php if (!empty($modulos)) { ?>
            <table class="table table-bordered  table-striped dataTableBootstrap">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Serial</th>
                        <th>Modelo</th>
                        <th>Obs</th>
                        <?php if(!$permissaoProgramacao){?>
                        <th>Ações</th>
                        <?php }?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($modulos as $k => $li) { ?>
                        <tr>
                            <td width="10%"><?= $li->get("modulo_status"); ?></td>
                            <td><?= $li->get("modulo_serial"); ?></td>
                            <td><?= $li->get("modulo_modelo"); ?></td>
                            <td><?= $li->get("modulo_obs"); ?></td>
                             <?php if(!$permissaoProgramacao){?>
                            <td width="2%">
                                <table width="80px">
                                    <tr>
                                        <td> 
                                            <a href="index.php?pg=46&id_modulo=<?= $li->get("modulo_id"); ?>&acao_tela=modulo#cadastroModulos" class="btn btn-sm <?= $li->get("modulo_status", true) == 3 ? "btn-success" : "btn-info"; ?>"><?= $li->get("modulo_status", true) == 3 ? '<span class="glyphicon glyphicon-eye-open"></span>' : '<span class="glyphicon glyphicon-pencil"></span>'; ?></a>
                                        </td>
                                        <?php if ($li->get("modulo_status", true) != 3) { ?>
                                            <td>
                                                <a href="modulos/compras/src/controllers/compras.php?id=<?= $li->get("modulo_id"); ?>&acao=deleteModulo" class="botaoLoad btn  btn-sm btn-danger" >
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                </table>
                            </td>
                            <?php }?>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr><td colspan="<?=!$permissaoProgramacao ? "5" : "4";?>">Registros: <?= $totalModulo; ?></td></tr>
                </tfoot>
            </table>
            <?php
            $objPaginacao->MontaPaginacao();
        } else {
            Funcoes::Nregistro();
        }
        ?>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading "> Chips Não Programados</div>
    <div class="panel-body"> 
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2" style="display:none;">
                <select class="form-control selectStatus" name="status_chip">
                    <option value="1" <?= $statusChip == 1 ? "selected" : ""; ?>>Novos</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float: right">
                <?php
                $formularioBusca = new FormularioDeBusca;
                $formularioBusca->setPg($pg);
                $formularioBusca->setFiltro('buscaChip');
                $formularioBusca->setMethod("GET");
                $formularioBusca->setHiddens(array("status_chip" => $statusChip));
                $formularioBusca->setValue($buscaChip);
                $formularioBusca->formBusca();
                ?>
            </div>
        </div>
        <?php if (!empty($chips)) { ?>
            <table class="table table-bordered  table-striped dataTableBootstrap">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Linha</th>
                        <th>Operadora</th>
                        <th>ICCID</th>
                        <th>Puk</th>
                        <th>Puk2</th>
                        <th>VPN</th>
                        <th>Pim</th>
                        <?php if(!$permissaoProgramacao){?>
                        <th>Ações</th>
                        <?php }?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($chips as $k => $li) { ?>
                        <tr>
                            <td width="10%"><?= $li->get("chip_status"); ?></td>
                            <td><?= $li->get("chip_linha"); ?></td>
                            <td><?= $li->get("chip_operadora"); ?></td>
                            <td><?= $li->get("chip_iccid"); ?></td>
                            <td><?= $li->get("chip_puk"); ?></td>
                            <td><?= $li->get("chip_puk2"); ?></td>
                            <td><?= $li->get("chip_vpn"); ?></td>
                            <td><?= $li->get("chip_pim"); ?></td>
                            <?php if(!$permissaoProgramacao){?>
                            <td width="2%">
                                <table width="80px">
                                    <tr>
                                        <td><a href="index.php?pg=46&id_chip=<?= $li->get("chip_id"); ?>&acao_tela=chip#cadastrarChips" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                        <?php if ($li->get("chip_status", true) != 3) { ?>
                                            <td>
                                                <a href="modulos/compras/src/controllers/compras.php?id=<?= $li->get("chip_id"); ?>&acao=deleteChip" class="botaoLoad btn  btn-sm btn-danger" >
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a></td>
                                        <?php } ?>
                                    </tr>
                                </table>
                            </td>
                           <?php }?>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr><td colspan="<?=!$permissaoProgramacao ? "9" : "8";?>">Registros: <?= $totalChip; ?></td></tr>
                </tfoot>
            </table>
            <?php
            $objPaginacaoChip->MontaPaginacao();
        } else {
            Funcoes::Nregistro();
        }
        ?>
    </div>
</div>
