<div class="panel panel-primary">
    <div class="panel-heading "> Lista Os</div>
    <div class="panel-body"> 
        <?php if (!empty($listaOSAberto)) { ?>
                <table class="table table-bordered table-hover table-striped dataTableBootstrap">
                    <thead>
                        <tr>
                            <th>Data Criação</th>
                            <th>Protocolo</th>
                            <th>Status</th>
                            <th>Cliente</th>
                            <th>Placa</th>
                            <th>Credenciado</th>
                            <th>Técnico</th>
                            <th>Gravidade</th>
                            <th>Tipo</th>
                            <th>Solicitante</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($listaOSAberto as $osAberto) {

                            $tipo_os = null;
                            $statusOS = null;
                            $gravidade = null;
                            $acaoOs = "EditarOs";

                            switch ($osAberto["veiculos_os_tipo"]) {
                                case 1: $tipo_os = "Manutenção";
                                    break;
                                case 2: $tipo_os = "Instalação";
                                    break;
                                case 3: $tipo_os = "Reclamação";
                                    break;
                            }

                            switch ($osAberto["veiculos_os_status"]) {
                                case 1: $statusOS = "Aberto";
                                    break;
                                case 2: $statusOS = "Em Andamento";
                                    break;
                                case 3: $statusOS = "Finalizado";
                                    $acaoOs = "visualizar";
                                    break;
                            }

                            switch ($osAberto["veiculos_os_gravidade"]) {
                                case 1: $gravidade = "Baixa";
                                    break;
                                case 2: $gravidade = "Média";
                                    break;
                                case 3: $gravidade = "Alta";
                                    break;
                            }
                            ?>
                            <tr>
                                <td><?= Funcoes::formataDataComHora($osAberto['veiculo_os_data_criacao']) ?></td>
                                <td><?= $osAberto['veiculos_os_protocolo']; ?></td>
                                <td><?= $statusOS; ?></td>
                                <td><?= $osAberto['nome_cliente']; ?></td>
                                <td><?= $osAberto['veiculos_os_placa']; ?></td>
                                <td><?= $osAberto['credenciado_razao_social']; ?></td>
                                <td><?= $osAberto['veiculos_os_tecnico']; ?></td>
                                <td><?= $gravidade; ?></td>
                                <td><?= $tipo_os; ?></td>
                                <td><?= $osAberto['veiculos_os_solicitante']; ?></td>
                                <td align="center"><a href="index.php?pg=10&id=<?= $osAberto['veiculos_os_id_cliente'] ?>&id_os=<?= $osAberto['veiculos_os_id'] ?>&acao=ListarCliente&opOs=<?= $acaoOs; ?>#os" class="btn btn-success">Visualizar</a></td>
                            </tr>
    <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr><td colspan="10">Registros Encontrados: <?= $totalOsAberto; ?></td></tr>
                    </tfoot>
                </table>
<?php
$objPaginacaoOSAberto->MontaPaginacao();
} else {
    Funcoes::Nregistro();
}
?>
    </div>
</div>