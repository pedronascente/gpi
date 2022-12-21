<?php
if (!empty($listaOs)) {
    ?>				<div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Protocolo</th>
                    <th>Data</th>
                    <th>Solicitante</th>
                    <th>Placa</th>
                    <th>Status</th>
                    <th>Tipo OS</th>
                    <th>Gravidade</th>
                    <th align="center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($listaOs as $k => $liOs) {
                    $tipo_os = null;
                    $statusOS = null;
                    $gravidade = null;
                    $acaoOs = empty($p) ? "EditarOS" : "visualizar";
                    
                    switch ($liOs["veiculos_os_tipo"]){
                    	case 1: $tipo_os = "Manutenção"; break;
                    	case 2: $tipo_os = "Instalação"; break;
                    	case 3: $tipo_os = "Reclamação";  break;
                    }

                    switch ($liOs["veiculos_os_status"]) {
                        case 1: $statusOS = "Aberto"; break;
                        case 2: $statusOS = "Em Andamento"; break;
                        case 3: $statusOS = "Finalizado"; $acaoOs = "visualizar"; break;
                    }
                    
                    switch ($liOs["veiculos_os_gravidade"]) {
                        case 1: $gravidade = "Baixa"; break;
                        case 2: $gravidade = "Média"; break;
                        case 3: $gravidade = "Alta";  break;
                    }
                    
                    ?>
                    <tr align="center">
                        <td><?= (isset($liOs["veiculos_os_protocolo"])) ? $liOs["veiculos_os_protocolo"] : ''; ?></td>
                        <td><?= (isset($liOs["veiculo_os_data_criacao"])) ? date('d/m/Y H:m', strtotime($liOs["veiculo_os_data_criacao"])) : ''; ?></td>
                        <td><?= (isset($liOs["veiculos_os_solicitante"])) ? $liOs["veiculos_os_solicitante"] : ''; ?></td>
                        <td><?= (isset($liOs["placa"])) ? $liOs["placa"] : ''; ?></td>
                        <td><?= $statusOS; ?></td>
                        <td><?= $tipo_os; ?></td>
                        <td><?= $gravidade; ?></td>
                        <td align="center" width="2%">
                            <a href="index.php?pg=10&id=<?= $liOs ['veiculos_os_id_cliente']; ?>&id_os=<?= $liOs["veiculos_os_id"]; ?>&acao=ListarCliente&opOs=<?= $acaoOs; ?>&acaoSessao=<?=$acaoSessao;?>#os" class="btn btn-sm <?=!empty($p) || $liOs["veiculos_os_status"] == 3 ? "btn-success" : "btn-info";?>">
                               <?=!empty($p) || $liOs["veiculos_os_status"] == 3 ? '<span class="glyphicon glyphicon-eye-open"></span>' : '<span class="glyphicon glyphicon-pencil"></span>';?>
                            </a>
                        </td> 
                    </tr>
    <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
    $objPaginacaoOS->MontaPaginacao();
} else {
    Funcoes::Nregistro();
}
?>
