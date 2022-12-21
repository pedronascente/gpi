<div class="table-responsive" style="margin-top:30px !important;">
    <table  class="table">
        <tr align="center">
            <?php if ($ti || $supervisor) { ?>
                <td width="11.1%" <?= Funcoes::colorirLinha(0); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarGeral&status=0#home">Storyboard(<?= isset($listaValoresSolicitacoesGerais[0]) ? $listaValoresSolicitacoesGerais[0] : '0'; ?>)</td>
                <td width="11.1%" <?= Funcoes::colorirLinha(1); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarGeral&status=1#home">Aprovada(<?= isset($listaValoresSolicitacoesGerais[1]) ? $listaValoresSolicitacoesGerais[1] : '0'; ?>)</td>
            <?php } ?>
            <td width="11.1%" <?= Funcoes::colorirLinha(2); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarGeral&status=2#home">Iniciada(<?= isset($listaValoresSolicitacoesGerais[2]) ? $listaValoresSolicitacoesGerais[2] : '0'; ?>)</td>
            <td width="11.1%" <?= Funcoes::colorirLinha(4); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarGeral&status=4#home">Em Testes(<?= isset($listaValoresSolicitacoesGerais[4]) ? $listaValoresSolicitacoesGerais[4] : '0'; ?>)</td>
            <td width="11.1%" <?= Funcoes::colorirLinha(3); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarGeral&status=3#home">Parada(<?= isset($listaValoresSolicitacoesGerais[3]) ? $listaValoresSolicitacoesGerais[3] : '0'; ?>)</td>
            <?php if ($ti || $supervisor) { ?>
                <td width="11.1%" <?= Funcoes::colorirLinha(7); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarGeral&status=7#home">Bug(<?= isset($listaValoresSolicitacoesGerais[7]) ? $listaValoresSolicitacoesGerais[7] : '0'; ?>)</td>
            <?php } ?>
            <?php if ($ti || $supervisor) { ?>
                <td width="11.1%" <?= Funcoes::colorirLinha(8); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarGeral&status=8#home">Reanálise(<?= isset($listaValoresSolicitacoesGerais[8]) ? $listaValoresSolicitacoesGerais[8] : '0'; ?>)</td>
            <?php } ?>
            <td width="11.1%" <?= Funcoes::colorirLinha(5); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarGeral&status=5#home">Finalizada(<?= isset($listaValoresSolicitacoesGerais[5]) ? $listaValoresSolicitacoesGerais[5] : '0'; ?>)</td>
            <?php if ($ti || $supervisor) { ?>
                <td width="11.1%" <?= Funcoes::colorirLinha(6); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarGeral&status=6#home">Reprovada(<?= isset($listaValoresSolicitacoesGerais[6]) ? $listaValoresSolicitacoesGerais[6] : '0'; ?>)</td>
            <?php } ?>
        </tr>
    </table>
</div>
<?php if (!empty($listaSolicitacoesGerais)) { ?>
    <div class="well well-sm">
        <span class="glyphicon glyphicon-list-alt"></span> =>  Testar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="glyphicon glyphicon-pencil"></span> => Editar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="glyphicon glyphicon-eye-open"></span> => Visualizar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="glyphicon glyphicon-trash"></span> => Excluir
    </div>
    <div class="table-responsive">
        <table class="table table-bordered   table-hover dataTableBootstrapSemOrdem">
            <thead>
                <tr>
                    <th>Número</th>
                    <?php if (!$ti) { ?>
                        <th>Setor</th>
                    <?php } ?>
                    <th>Solicitante</th>
                    <th>Nível</th>
                    <th>Status</th>
                    <?php if ($supervisor || $ti) { ?>
                        <th>Tipo</th>
                    <?php } ?>
                    <th>Título</th>
                    <th>Consultor</th>
                    <?php if ($statusDesenvolvimento == 5) { ?>
                        <th>Início</th>
                        <th>Finalização</th>
                    <?php } ?>
                    <?php if ($ti) { ?>
                        <th>Atribuir</th>
                    <?php } ?>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($listaSolicitacoesGerais as $solicitacao) {
                    $solicitacaoStatus = $solicitacao->get("desenvolvimento_status", true);
                    $nivelSolicitacao = ($suporte && $solicitacao->get("desenvolvimento_nivel_solicitacao", true) == 2) || ($desenvolvedor && $solicitacao->get("desenvolvimento_nivel_solicitacao", true) == 1);
                    $editar = ((($solicitacaoStatus == 0 || $solicitacaoStatus == 4) && $solicitacao->get("desenvolvimento_id_usuario") == $id_usuario) || ((($nivelSolicitacao || $supervisor) && $solicitacaoStatus >= 1 && $solicitacaoStatus != 6 && $solicitacaoStatus != 8 && $solicitacaoStatus != 4 && $solicitacao->get("desenvolvimento_id_programador") == $id_usuario)) || ($supervisor && ($solicitacaoStatus <= 1 || $solicitacaoStatus == 8))) && $solicitacaoStatus != 5;
                    $deletar = (($supervisor && $solicitacaoStatus == 0) || ($solicitacao->get("desenvolvimento_id_usuario") == $id_usuario && $solicitacaoStatus == 0));
                    $botoes = null;
                    $id_programador = $solicitacao->get("desenvolvimento_programador");

                    if ($editar) {
                        $descricao = $solicitacao->get("desenvolvimento_status", true) == 4 ? '<span class="glyphicon glyphicon-list-alt"/>' : '<span class="glyphicon glyphicon-pencil"/>';
                        $botoes .= ''
                                . '<td><a href="index.php?pg=22&id=' . $solicitacao->get("desenvolvimento_id") . '&acao=editar&tab=home&acaoBusca=' . $acao . '&status=' . filter_input(INPUT_GET, "status") . '" class="btn btn-sm btn-info" title="Editar linha">'
                                . $descricao
                                . '</a></td>';

                        if ($deletar)
                            $botoes .='<td><a id="modulos/desenvolvimento/src/controllers/desenvolvimento.php?acao=excluir&tab=home&acaoBusca=' . $acao . '&status=' . filter_input(INPUT_GET, "status") . '&id=' . $solicitacao->get("desenvolvimento_id") . '" class="excluirSolicitacao btn  btn-sm btn-danger" title="Deletar linha">'
                                    . '     <span class="glyphicon glyphicon-trash"/>'
                                    . '</a></td>';
                        $editar .= true;
                    } else {
                        $botoes = '<td><a href="index.php?pg=22&id=' . $solicitacao->get("desenvolvimento_id") . '&acao=visualizar&tab=home&acaoBusca=' . $acao . '&status=' . filter_input(INPUT_GET, "status") . '" class="btn btn-sm  btn-success" title="Visualizar linha">'
                                . '     <span class="glyphicon glyphicon-eye-open"/>'
                                . '</a></td>';
                    }

                    $programador = "-";

                    if ($solicitacao->get('desenvolvimento_help') >= 1 && $solicitacao->get('desenvolvimento_help') != 3 && $nivelSolicitacao)
                        $programador = '<a id="modulos/desenvolvimento/src/views/formularios/modalHelp.php?desenvolvimento_id=' . $solicitacao->get("desenvolvimento_id") . '" class="btn btn-sm btn-danger modalOpen botaoLoad" data-target="#modal"><strong>?</strong></a>';
                    else if (!empty($id_programador))
                        $programador = $solicitacao->get("desenvolvimento_programador");

                    $modulo = $solicitacao->get('desenvolvimento_modulo');
                    $quant = $solicitacaoStatus == 5 ? 15 : 35;


                    if (strlen($modulo) > $quant)
                        $modulo = substr($modulo, 0, $quant) . "...";


                    $negrito = $solicitacao->get("desenvolvimento_nivel", true) == 1 && $solicitacaoStatus != 5 ? "style='font-weight:bold;'" : "";
                    ?>

                    <tr <?= Funcoes::colorirLinha($solicitacaoStatus); ?> align="center">
                        <td width="5%" <?= $negrito; ?>><?= $solicitacao->get("desenvolvimento_id"); ?></td>
                        <?php if (!$ti) { ?>
                            <td width="5%" <?= $negrito; ?>><?= $solicitacao->get("desenvolvimento_nivel_solicitacao"); ?></td>
                        <?php } ?>
                        <td width="20%" <?= $negrito; ?>><?= $solicitacao->get("desenvolvimento_usuario"); ?></td>
                        <td width="5%" <?= $negrito; ?>><?= $solicitacao->get("desenvolvimento_nivel"); ?></td>
                        <td width="10%" <?= $negrito; ?>><?= $solicitacao->get("desenvolvimento_status"); ?></td>
                        <?php if ($ti || $supervisor) { ?>
                            <td width="5%" <?= $negrito; ?>><?= $solicitacao->get("desenvolvimento_tipo"); ?></td>
                        <?php } ?>
                        <td <?= $negrito; ?>><?= $modulo; ?></td>
                        <td width="15%" <?= $negrito; ?>><?= $programador; ?></td>
                        <?php if ($statusDesenvolvimento == 5) { ?>
                            <td <?= $negrito; ?>><?= $solicitacao->get("desenvolvimento_data_inicio"); ?></td>
                            <td <?= $negrito; ?>><?= $solicitacao->get("desenvolvimento_data_final"); ?></td>
                        <?php } ?>
                        <?php
                        $verificarAtribuir = (($solicitacaoStatus == 1 && empty($id_programador)) && $nivelSolicitacao) ? true : false;

                        if ($verificarAtribuir) {
                            ?>
                            <td width="5%" <?= $negrito; ?>>
                                <a href="modulos/desenvolvimento/src/controllers/desenvolvimento.php?acao=atribuirProgramador&id=<?= $id_usuario; ?>&id_solicitacao=<?= $solicitacao->get("desenvolvimento_id"); ?>&tela=2" class="btn  btn-primary">Atribuir</a>
                            </td>
                            <?php
                        } else if ($ti) {
                            echo("<td>Indisponível</td>");
                        }
                        ?>
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
                <?php
                $num = $statusDesenvolvimento == 5 ? 2 : 0;
                $colspan = 8 + $num;
                if ($supervisor || $ti)
                    $colspan = 9 + $num;
                ?>
                <tr><td colspan="<?= $colspan; ?>">Registros encontrados:<?= $totalSolictacao; ?></td></tr>
            </tfoot>
        </table>
    </div>
    <?php
    $objPaginacao->MontaPaginacao();
} else {
    Funcoes::Nregistro();
}
?>