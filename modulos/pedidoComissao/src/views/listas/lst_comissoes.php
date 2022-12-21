<div class="panel panel-primary">
    <div class="panel-heading">Comissão / Listar :</div>
    <div class="panel-body">
        <?php
        if ($listComissoes) { ?>
        <div class="table-responsive">
           <table  class="table table-striped table-bordered  table-hover dataTableBootstrap  " cellspacing="0">
                <thead> 
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Periodo</th>
                        <th>Cliente</th>
                        <th>Funcionário</th>
                        <th>Conta/Pedido</th>
                        <th>Num. OS</th>
                        <th>Serviço</th>
                        <th>Comissão</th>
                        <th>Status</th>
                    </tr>    
                </thead>
                <tbody>
                    <?php
                    foreach ($listComissoes as  $dados) {
                        $pedidoComissao->sets($dados);
                      	$status = '';
                        if ($pedidoComissao->get_pcf_status() == 0 && $pedidoComissao->get_pcf_arquivar() != 1) {
                            $status = "Aberto";
                        } else if ($pedidoComissao->get_pcf_status() == 2) {
                            $status = "Reprovado";
                        } else if ($pedidoComissao->get_pcf_arquivar() == 1) {
                            $status = "Aprovado";
                        } else {
                            $status = "Em Análise";
                        }
                        
                    echo'
                        <tr align=\"center\" >
                            <td class="alinhar_centro">' .$pedidoComissao->get_pedido_comissao_id(). '</td>
                            <td class="alinhar_centro">' .$pedidoComissao->get_pedido_comissao_data(). '</td>
                            <td class="alinhar_centro">' .$pedidoComissao->get_pcf_periodo() . '</td>
                            <td>' . $pedidoComissao->get_pedido_comissao_cliente() . '</td>
                            <td>' . $pedidoComissao->get_pcf_nome() . '</td>
                            <td>' . $pedidoComissao->get_pedido_comissao_conta() . '</td>
                            <td>' . $pedidoComissao->get_pedido_comissao_n_os() . '</td>
                            <td>' . $pedidoComissao->get_pedido_comissao_servico() . '</td>
                            <td><span class="title_left">R$</span> <span class="title_right">' .$pedidoComissao->get_pedido_comissao_comissao1(). '</span></td>
                            <td>' . $status . '</td>
                        </tr>';
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10">Registros encontrados: <?= $total; ?> </td>
                    </tr>
                </tfoot> 
           </table>
         </div>
        <?php
        $objPaginacao->MontaPaginacao();
        }else{ 
        Funcoes::Nregistro();
        }?>
    </div>
</div>
	
