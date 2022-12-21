<div class="table-responsive" style="margin-top:30px !important;">
    <table  class="table">
        <tr align="center">
            <td width="11.1%" <?= Funcoes::colorirLinha(0); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarM&status=0#menu1">Storyboard(<?= isset($listaValoresMinhasSolicitacoes[0]) ? $listaValoresMinhasSolicitacoes[0]  : '0'; ?>)</td>
            <td width="11.1%" <?= Funcoes::colorirLinha(1); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarM&status=1#menu1">Aprovada(<?= isset($listaValoresMinhasSolicitacoes[1]) ? $listaValoresMinhasSolicitacoes[1] : '0'; ?>)</td>    
            <td width="11.1%" <?= Funcoes::colorirLinha(2); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarM&status=2#menu1">Iniciada(<?= isset($listaValoresMinhasSolicitacoes[2]) ? $listaValoresMinhasSolicitacoes[2] : '0'; ?>)</td>
            <td width="11.1%" <?= Funcoes::colorirLinha(4); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarM&status=4#menu1">Em Testes(<?= isset($listaValoresMinhasSolicitacoes[4]) ? $listaValoresMinhasSolicitacoes[4] : '0'; ?>)</td>
            <td width="11.1%" <?= Funcoes::colorirLinha(3); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarM&status=3#menu1">Parada(<?= isset($listaValoresMinhasSolicitacoes[3]) ? $listaValoresMinhasSolicitacoes[3] : '0'; ?>)</td>
           	<td width="11.1%" <?= Funcoes::colorirLinha(7); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarM&status=7#menu1">Bug(<?= isset($listaValoresMinhasSolicitacoes[7]) ? $listaValoresMinhasSolicitacoes[7] : '0'; ?>)</td>
           	<td width="11.1%" <?= Funcoes::colorirLinha(8); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarM&status=8#menu1">Reanálise(<?= isset($listaValoresMinhasSolicitacoes[8]) ? $listaValoresMinhasSolicitacoes[8] : '0'; ?>)</td>
            <td width="11.1%" <?= Funcoes::colorirLinha(5); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarM&status=5#menu1">Finalizada(<?= isset($listaValoresMinhasSolicitacoes[5]) ? $listaValoresMinhasSolicitacoes[5] : '0'; ?>)</td>
            <td width="11.1%" <?= Funcoes::colorirLinha(6); ?> class="bordaTD" id="index.php?pg=23&acao=pesquisarM&status=6#menu1">Reprovada(<?= isset($listaValoresMinhasSolicitacoes[6]) ? $listaValoresMinhasSolicitacoes[6] : '0'; ?>)</td>
        </tr>
    </table>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
        <select class="form-control selectStatus" name="status">
            <option   id="index.php?pg=23&acao=pesquisar&n2=#menu1">Todos</option>
            <option <?= $n2 == 1 ? "selected" : ""; ?>  id="index.php?pg=23&acao=pesquisar&n2=1#menu1">Desenvolvimento</option>
            <option <?= $n2 == 2 ? "selected" : ""; ?>  id="index.php?pg=23&acao=pesquisar&n2=2#menu1">Suporte</option>
        </select>
    </div>
</div><br>
<?php if (!empty($listaMinhasSolicitacoes)) { ?>
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
                	<th width="5%">Número</th>
                    <th width="5%">Módulo</th>
                    <th width="5%">Nível</th>
                    <th>Status</th>
                    <th>Título</th>
                    <th width="15%">Consultor</th>
                    <th>Início</th>
                    <th>Finalização</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($listaMinhasSolicitacoes as $s) {
                	$solicitacaoStatus = $s->get("desenvolvimento_status", true);
                    $nivelSolicitacao = ($suporte && $s->get("desenvolvimento_nivel_solicitacao", true) == 2) || ($desenvolvedor && $s->get("desenvolvimento_nivel_solicitacao", true) == 1);
                    $editar = ((($solicitacaoStatus == 0 || $solicitacaoStatus == 4) && $s->get("desenvolvimento_id_usuario") == $id_usuario) || (($nivelSolicitacao && $solicitacaoStatus >= 1 && $solicitacaoStatus != 6 && $solicitacaoStatus != 4 && $s->get("desenvolvimento_id_programador") == $id_usuario)) || ($supervisor && ($solicitacaoStatus <=1 || $solicitacaoStatus == 8))) && $solicitacaoStatus != 5;
                    $deletar = (($supervisor && $solicitacaoStatus == 0) || ($s->get("desenvolvimento_id_usuario") == $id_usuario && $solicitacaoStatus == 0));
                    $botoes = null;
                    $id_programador = $s->get("desenvolvimento_programador");
                    
                    $modulo = $s->get('desenvolvimento_modulo');
                    $quant = $solicitacaoStatus == 5 ? 15 : 35;
                    
                    
                    if (strlen($modulo) > $quant)
                    	$modulo = substr($modulo, 0, $quant) . "...";

                	if ($editar) {
                	$descricao = $s->get("desenvolvimento_status", true) == 4 ? '<span class="glyphicon glyphicon-list-alt"></span>' : '<span class="glyphicon glyphicon-pencil"></span>';
                        $botoes .= ''
                                . '<td><a href="index.php?pg=22&id=' . $s->get("desenvolvimento_id") . '&acao=editar&tab=menu1&acaoBusca='.$acao.'&status='.filter_input(INPUT_GET, "status").'" class="btn btn-sm btn-info" title="Editar linha">'
                                . $descricao
                                . '</a></td>';
                        
                        if($deletar)
	                        $botoes .='<td><a id="modulos/desenvolvimento/src/controllers/desenvolvimento.php?acao=excluir&tab=menu1&acaoBusca='.$acao.'&status='.filter_input(INPUT_GET, "status").'&id=' . $s->get("desenvolvimento_id") . '" class="excluirSolicitacao btn  btn-sm btn-danger" title="Deletar linha">'
	                        		. '     <span class="glyphicon glyphicon-trash">'
	                        		. '</a></td>';
                        $editar .= true;
                    } else {
                        $botoes = '<td><a href="index.php?pg=22&id=' . $s->get("desenvolvimento_id") . '&acao=visualizar&tab=menu1&acaoBusca='.$acao.'&status='.filter_input(INPUT_GET, "status").'" class="btn btn-sm  btn-success" title="Visualizar linha">'
                                . '     <span class="glyphicon glyphicon-eye-open">'
                                . '</a></td>';
                    }
                    
                    
                    $cor =  $s->get("desenvolvimento_status", true);
                    ?>
                    <tr <?= Funcoes::colorirLinha($cor); ?> align="center">
                        <td><?=$s->get("desenvolvimento_id");?></td>
                        <td><?=$s->get("desenvolvimento_nivel_solicitacao");?></td>
                        <td><?=$s->get("desenvolvimento_nivel");?></td>
                        <td><?=$s->get("desenvolvimento_status");?></td>
                        <td><?=$modulo?></td>
                        <td><?=$s->get("desenvolvimento_programador");?></td>
                        <td><?=$s->get("desenvolvimento_data_inicio");?></td>
                        <td><?=$s->get("desenvolvimento_data_final");?></td>
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
                <tr><td colspan="9">Registros encontrados: <?= $totalMinhaSolicitacao; ?></td></tr>
            </tfoot>
        </table>
        </div>
    <?php
    $objPaginacao->MontaPaginacao();
} else {
    Funcoes::Nregistro();
}
?>