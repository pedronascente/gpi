<div class="row">
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
        <select class="form-control selectStatus" name="status">
            <option   id="index.php?pg=23&acao=pesquisar&n1=#menu2">Todos</option>
            <option <?= $n1 == 1 ? "selected" : ""; ?>  id="index.php?pg=23&acao=pesquisar&n1=1#menu2">Desenvolvimento</option>
            <option <?= $n1 == 2 ? "selected" : ""; ?>  id="index.php?pg=23&acao=pesquisar&n1=2#menu2">Suporte</option>
        </select>
    </div>
</div>
<div class="table-responsive" style="margin-top:30px !important;">
    <table  class="table">
        <tr align="center">
            <?php if ($supervisor) { ?>
                <td width="12.5%" <?= Funcoes::colorirLinha(0); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisar&status=0#menu2">Storyboard(<?= isset($listaValoresSolicitacoesGerais[0]) ? $listaValoresSolicitacoesGerais[0] : '0'; ?>)</td>
                <td width="12.5%" <?= Funcoes::colorirLinha(1); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisar&status=1#menu2">Aprovada(<?= isset($listaValoresSolicitacoesGerais[1]) ? $listaValoresSolicitacoesGerais[1] : '0'; ?>)</td>
                <td width="12.5%" <?= Funcoes::colorirLinha(8); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisar&status=8#menu2">Reanálise(<?= isset($listaValoresSolicitacoesGerais[8]) ? $listaValoresSolicitacoesGerais[8] : '0'; ?>)</td>
            <?php }  ?>
                <td width="12.5%" <?= Funcoes::colorirLinha(2); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisar&status=2#menu2">Iniciada(<?= isset($listaValoresSolicitacoes[2]) ? $listaValoresSolicitacoes[2] : '0'; ?>)</td>
                <td width="12.5%" <?= Funcoes::colorirLinha(3); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisar&status=3#menu2">Parada(<?= isset($listaValoresSolicitacoes[3]) ? $listaValoresSolicitacoes[3] : '0'; ?>)</td>
                <td width="12.5%" <?= Funcoes::colorirLinha(7); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisar&status=7#menu2">Bug(<?= isset($listaValoresSolicitacoes[7]) ? $listaValoresSolicitacoes[7] : '0'; ?>)</td>
        </tr>
    </table>
</div>
<?php if (!empty($listaSolicitacoes)) { ?>
    <table class="table table-bordered   table-hover dataTableBootstrapSemOrdem">
        <thead>
            <tr>
                <th>Número</th>
                <th>Solicitante</th>
                <th>Nível</th>
                <th>Status</th>
                <?php if ($supervisor || $ti) { ?>
                    <th>Tipo</th>
                <?php } ?>
                <th>Título</th>
                <th>Consultor</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($listaSolicitacoes as $solicitacao) {
                $descricao = $solicitacao->get("desenvolvimento_status", true) == 4 ? '<span class="glyphicon glyphicon-list-alt"></span>' : '<span class="glyphicon glyphicon-pencil"></span>';
                $solicitacaoStatus = $solicitacao->get("desenvolvimento_status", true);
                $editar = ((($solicitacaoStatus == 0 || $solicitacaoStatus == 4) && $solicitacao->get("desenvolvimento_id_usuario") == $id_usuario) || ((($ti || $supervisor) && $solicitacaoStatus >= 1 && $solicitacaoStatus != 6 && $solicitacaoStatus != 4 && $solicitacao->get("desenvolvimento_id_programador") == $id_usuario)) || ($supervisor && ($solicitacaoStatus <= 1 || $solicitacaoStatus == 8))) && $solicitacaoStatus != 5;
                $deletar = (($supervisor && $solicitacaoStatus == 0) || ($solicitacao->get("desenvolvimento_id_usuario") == $id_usuario && $solicitacaoStatus == 0));
                $botoes = null;
                $id_programador = $solicitacao->get("desenvolvimento_programador");
                
                $modulo = $solicitacao->get('desenvolvimento_modulo');
                $quant = $solicitacaoStatus == 5 ? 15 : 35;
                
                
                if (strlen($modulo) > $quant)
                	$modulo = substr($modulo, 0, $quant) . "...";

                if ($editar) {
                    $botoes .= ''
                            . '<td><a href="index.php?pg=22&id=' . $solicitacao->get("desenvolvimento_id") . '&acao=editar&tab=menu2&acaoBusca=' . $acao . '&status=' . filter_input(INPUT_GET, "status") . '" class="btn btn-sm btn-info" title="Editar linha">'
                            . $descricao
                            . '</a></td>';

                    if ($deletar)
                        $botoes .='<td><a id="modulos/desenvolvimento/src/controllers/desenvolvimento.php?acao=excluir&tab=menu2&acaoBusca=' . $acao . '&status=' . filter_input(INPUT_GET, "status") . '&id=' . $solicitacao->get("desenvolvimento_id") . '" class="excluirSolicitacao btn  btn-sm btn-danger" title="Deletar linha">'
                                . '     Deletar'
                                . '</a></td>';


                    $editar .= true;
                } else {
                    $botoes = '<td><a href="index.php?pg=22&id=' . $solicitacao->get("desenvolvimento_id") . '&acao=visualizar&tab=menu2&acaoBusca=' . $acao . '&status=' . filter_input(INPUT_GET, "status") . '" class="btn btn-sm btn-success" title="Visualizar linha">'
                            . '     Visualizar'
                            . '</a></td>';
                }

                $programador = "-";

                if ($solicitacao->get("desenvolvimento_help") >= 1 && $solicitacao->get("desenvolvimento_help") != 3)
                    $programador = '<a id="modulos/desenvolvimento/src/views/formularios/modalHelp.php?desenvolvimento_id=' . $solicitacao->get("desenvolvimento_id") . '" class="btn btn-danger modalOpen botaoLoad" data-target="#modalHelp"><strong>?</strong></a>';
                else if (!empty($id_programador))
                    $programador = $solicitacao->get("desenvolvimento_programador");
                
                $negrito = $solicitacao->get("desenvolvimento_nivel", true) == 1 ? "style='font-weight:bold;'" : "";
                ?>

                <tr <?= Funcoes::colorirLinha($solicitacaoStatus); ?> align="center">
                    <td width="5%" <?=$negrito;?>><?= $solicitacao->get("desenvolvimento_id"); ?></td>
                    <td width="20%" <?=$negrito;?>><?= $solicitacao->get("desenvolvimento_usuario"); ?></td>
                    <td width="5%" <?=$negrito;?>><?= $solicitacao->get("desenvolvimento_nivel"); ?></td>
                    <td width="10%" <?=$negrito;?>><?= $solicitacao->get("desenvolvimento_status"); ?></td>
                    <?php if ($ti || $supervisor) { ?>
                        <td width="5%" <?=$negrito;?>><?= $solicitacao->get("desenvolvimento_tipo"); ?></td>
                    <?php } ?>
                    <td <?=$negrito;?>><?=$modulo;?></td>
                    <td width="15%" <?=$negrito;?>><?= $programador; ?></td>
                    <td width="5%">
                        <table width="120px">
                            <tr align="center">
                                <?= $botoes; ?>	
                            </tr>
                        </table>
                    </td>					
                </tr>
                <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr><td colspan="<?= $supervisor || $ti ? "8" : "7"; ?>">Registros encontrados: <?= $total; ?></td></tr>   
        </tfoot>
    </table>
    <div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div> 
    <?php
    $objPagina->MontaPaginacao();
} else {
    Funcoes::Nregistro();
}
?>