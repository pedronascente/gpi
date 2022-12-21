<div class="panel panel-primary">
    <div class="panel-heading "> Lista Requisicao</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float: right">
                <?php
                $formularioBusca = new FormularioDeBusca;
                $formularioBusca->setPg($pg);
                $formularioBusca->setFiltro('buscaRequisicao');
                $formularioBusca->setMethod("GET");
                $formularioBusca->setValue($buscaRequisicao);
                $formularioBusca->formBusca();
                ?>
            </div>
        </div>
        <?php if (!empty($listaRequisicao)) { ?>
        	<div class="well well-sm">
				<span class="glyphicon glyphicon-eye-open"></span> => Visualizar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="glyphicon glyphicon-trash"></span> => Excluir
			</div>
			<div class="table-responsive">
            <table class="table table-bordered table-hover table-striped dataTableBootstrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>Solicitante</th>
                        <th>Supervisor</th>
                        <th>Produto</th>
                        <th>Setor</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaRequisicao as $l) { ?>
                        <tr>
                            <td width="5%"><?= $l->get("produto_requisicao_id"); ?></td>
                            <td><?= $l->get("produto_requisicao_tipo"); ?></td>
                            <td><?= $l->get("produto_requisicao_data"); ?></td>
                            <td><?= $l->get("produto_requisicao_solicitante"); ?></td>
                            <td><?= $l->get("produto_requisicao_usuario"); ?></td>
                            <td><?= $l->get("produto_requisicao_produto"); ?></td>
                            <td><?= $l->get("produto_requisicao_setor"); ?></td>
                            <td align="center" width="2%">
                                <table  width='100px'>
                                    <tr>
                                        <td><a class="btn btn-sm btn-success btn-sm" href="index.php?pg=47&acao=visualizar&id_requisicao=<?= $l->get("produto_requisicao_id"); ?>#requisicao"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                                        <td><a id="modulos/compras/src/controllers/compras.php?id=<?= $l->get("produto_requisicao_id"); ?>&acao=deletarRequisicao" class="btn btn-sm btn-danger confimarDeleteLink btn-sm botaLoad"><span class="glyphicon glyphicon-trash"></span></a></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
            <?php
            $objPaginacaoRequisicao->MontaPaginacao();
        } else {
            Funcoes::Nregistro();
        }
        ?>
    </div>
</div>