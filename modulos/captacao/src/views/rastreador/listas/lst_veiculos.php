<div class="panel panel-primary">
    <div class=" panel-body ">
        <?php
            if(empty($list_veiculos[0]['valor_aluguel_software_rastreamento'])){
        ?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  text-right" style="margin: 10px 10px 10px 0 ">
                    <a href="?pg=30&id=<?php echo($id_cliente); ?>&id_cliente_contrato=<?php echo($id_cli); ?>#veiculos"
                       class="btn btn-primary">Novo Veículo</a>
                </div>
            </div>
        <?php
            }
        ?>        
        <div class="well well-sm">
            <span class="glyphicon glyphicon-pencil"></span> => Editar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="glyphicon glyphicon-trash"></span> => Excluir
        </div>
        <div class="table-responsive">
            <table cellpadding="0" class="table table-hover table-striped table-bordered ">
                <thead>
                    <tr class="_tr">
                        <th>Placa</th>
                        <th>Chassis</th>
                        <th>Marca / Modelo</th>
                        <th>Bloqueio</th>
                        <th>Tipo de Serviço</th>
                        <th colspan="2" width='5%'>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_taxa_instalacao = NULL;
                    $total_taxa_manutencao = NULL;
                    foreach ($list_veiculos as $k => $veiculo) :
                        $veiculo_id = (!empty($veiculo ['id_veiculo']) ? $veiculo ['id_veiculo'] : NULL);
                        $veiculo_taxa_instalacao = (!empty($veiculo ['taxa_instalacao']) ? $veiculo ['taxa_instalacao'] : 0.00);
                        $veiculo_taxa_monitoramento = (!empty($veiculo ['taxa_monitoramento']) ? $veiculo ['taxa_monitoramento'] : 0.00);
                        $total_taxa_instalacao += $veiculo_taxa_instalacao;
                        $total_taxa_manutencao += $veiculo_taxa_monitoramento;
                        ?>
                        <tr>
                            <td><?= (!empty($veiculo["placa"]) ? $veiculo["placa"] : NULL); ?></td>
                            <td><?= (!empty($veiculo['chassis']) ? $veiculo['chassis'] : NULL); ?></td>
                            <td><?= $veiculo['marca'] ?> / <?= $veiculo['modelo'] ?></td>
                            


                            <td style="display:none;"><?= $veiculo["status_planoAssistencia"]; ?></td>
                            <td><?= ($veiculo['bloqueio'] == 's') ? 'SIM' : 'NÃO'; ?></td>
                            <td>
                                <?php   
                                if($veiculo['tipo_seguro']){
                                     echo $veiculo['tipo_seguro'];   
                                }else{
                                   echo  $cliente['tipo']; 
                                }
                                ?>
                            </td>
                            <?php if (($statusCadastro == 2 && in_array($veiculo_id, Funcoes::pegarChaveArray($camposVeiculos, "cr_veiculo"))) || $statusCadastro != 2) { ?>
                                <td>
                                    <a href="index.php?pg=30&id_veiculo=<?= $veiculo_id; ?>&id=<?= $id_cliente; ?>&id_cliente_contrato=<?= $id_cli; ?>#veiculos"    class="btn btn-xs btn-info" title="editar">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                </td>
                                <td>
                                    <a href="modulos/captacao/src/controllers/captacao.php?idVeiculo=<?= $veiculo_id; ?>&id_cliente=<?= $id_cliente; ?>&acao=DeleteVeiculo&id_cliente_contrato=<?= $id_cli; ?>"

                                       class="btn btn-xs btn-danger" title="excluir">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </td>
                            <?php } else { ?>
                                <td colspan="2">Indisponível</td>
                            <?php } ?>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                    <tr>
                        <td colspan="9">
                            <table width="100%">
                                <tr class="_tr">
                                    <td align="center">Instalação Total:
                                        R$ <?= (isset($total_taxa_instalacao)) ? Funcoes::formartaMoedaReal($total_taxa_instalacao) : ''; ?> </td>
                                    <td align="center">Monitoramento Total:
                                        R$ <?= (isset($total_taxa_instalacao)) ? Funcoes::formartaMoedaReal($total_taxa_manutencao) : ''; ?> </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php     
    $objPagiacaoVeiculo->MontaPaginacao();   
?>