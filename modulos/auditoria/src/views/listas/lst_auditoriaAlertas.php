<div class="panel panel-primary">
    <div class="panel-heading"></div>
    <div class="panel-body">
        <?php
        if (!empty($lista_historico)) {
            ?>
            <table class="table table-bordered table-hover table-striped dataTableBootstrapSemOrdem">
                <thead>
                    <tr>
                        <th width="15%">Data Criação</th>
                        <th>Data Agendada</th>
                        <th>Vendedor</th>
                        <th>Cliente</th>
                        <th>Motivo</th>
                        <th>Situação</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($lista_historico as $list) {
                        $agenda_contato_status 		= !empty($list['agenda_contato_status']) ? !empty($list['agenda_contato_status']) : 0;
                        $situacao 					= $agenda_contato_status == 1 ? "Finalizado" : "Aberto";
                        $data_criacao 				= !empty($list ['agenda_contato_data_criacao']) ? Funcoes::formataData($list ['agenda_contato_data_criacao']) : "";
                        $data_agendada 				= !empty($list ['agenda_contato_proxima_data']) && !empty($list['agenda_contato_hora']) ? Funcoes::formataData($list ['agenda_contato_proxima_data']) . " " . $list['agenda_contato_hora'] : "";
                        $cor 						= $agenda_contato_status != 1 ? 'style="color:#F00"' : null;
                        $cliente 					= $list['agenda_contato_cliente'] == " " || empty($list['agenda_contato_cliente']) ? $list['captacao_cliente'] : $list['agenda_contato_cliente'];
                        $motivo 					= !empty($list['agenda_contato_motivo']) ? $list['agenda_contato_motivo'] : "";
                        $nome 						= !empty($list['nome']) ? $list['nome'] : "";
                        ?>
                        <tr align="center">
                            <td <?=$cor;?>><?=$data_criacao;?></td>
                            <td <?=$cor;?>><?=$data_agendada;?></td>
                            <td <?=$cor;?>><?=$nome;?></td>
                            <td <?=$cor;?>><?=$cliente;?></td>
                            <td <?=$cor;?>><?=$motivo?></td>
                            <td <?=$cor;?>><?=$situacao;?></td>
                            <td width="5%">
                                <a id="modulos/captacao/src/views/captacao/formularios/modal_captacaoAgenda.php?agenda_contato_id=<?= $list['agenda_contato_id']; ?>&id_captacao=<?= $list['agenda_contato_captacao_id']; ?>&acaoTela=visualizar&acao=auditoria" class="botaoLoad modalOpen btn btn-success" data-target="#modal"> 
                                    Visualizar
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                	<tr><td colspan="7">Registros Encontrados: <?=$total;?></td></tr>
                </tfoot>
            </table>
            <?php
            $objPaginacao->MontaPaginacao();
        } else 
            Funcoes::Nregistro();
        ?>
    </div>
</div>