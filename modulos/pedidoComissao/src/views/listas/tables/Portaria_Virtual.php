<thead>
    <tr>
        <th width="5%">ID</th>
        <th>Data</th>
        <th>Cliente</th>
        <th>Conta / Pedido</th>
        <th>Meio</th>
        <th>Ins. / Vendas</th>
        <th>Mensal</th>
        <th>Comissão</th>
        <th>Desconto da Comissão</th>
        <th>Inconsistencia<a id="modulos/pedidoComissao/src/views/listas/helpeInconsistenciaUsuario.php" class="modalOpen" data-target="#modalAjuda"> </a></th>
        <th>Ação</th> 
    </tr>
</thead>
<tbody>
    <?php
    if($lista_pedidoComissao){
        foreach ($lista_pedidoComissao as $k => $dados) :
            $pedidoComissao->sets($dados);
            ?>
             <tr align="center">
                <td><?=$pedidoComissao->get_pedido_comissao_id();?></td>
                <td><?=$pedidoComissao->get_pedido_comissao_data();?></td>
                <td><?=$pedidoComissao->get_pedido_comissao_cliente();?></td>
                <td><?=$pedidoComissao->get_pedido_comissao_conta(); ?></td>
                <td><?=$pedidoComissao->get_pedido_comissao_captacao(); ?></td>
                <td><span class="span_esquerdo"> R$ </span><span class="span_direito"><?=$pedidoComissao->get_pedido_comissao_inst_venda(); ?></span></td>
                <td><span class="span_esquerdo"> R$ </span><span class="span_direito"><?=$pedidoComissao->get_pedido_comissao_mensal();?></span></td>
                <td><span class="span_esquerdo"> R$ </span><span class="span_direito"><?=$pedidoComissao->get_pedido_comissao_comissao1(); ?></span></td>
                <td><?=$pedidoComissao->get_pedido_comissao_desc_comissao();?></td>
                <td><?=($objetopcf->get_pcf_status() != 0) ? $pedidoComissao->get_inconsistencias_DescSituacao()  : ""; ?></td>
                <td>
                    <?php
                    //CONFIGURAR OS BOTOES DA TH [ACAO] :
                    if(($acao == 'AddPedidoComissao' || $acao == 'editarComissao') && ($page == "cadastrar" && !$pedidoComissao->get_inconsistencias_situacao() >= 1) || $page=="conferencia"){ ?>
                        <table width="100%" border="0">
                            <tr align="center">
                                <td> 
                                    <a id="modulos/pedidoComissao/src/views/formularios/frm_modal.php?page=<?=$page;?>&pcf_ano=<?=$pedidoComissao->get_pedido_comissao_data();?>&id_u=<?=$id_usuario;?>&id_setor=<?=$id_setor;?>&id_pc=<?=$pedidoComissao->get_pedido_comissao_id();?>&acao=editarComissao&tipo=modal" id="490_Editar Comissao_1" class="modalOpen btn  btn-sm btn-info" data-target="#modalPedidoComissao">
                                       <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                </td>
                                <td>
                                    <a id="modulos/pedidoComissao/src/controllers/pedido_comissao.php?page=<?=$page;?>&id_setor=<?=$id_setor;?>&id_pc=<?=$pedidoComissao->get_pedido_comissao_id();?>&id_user=<?=$id_usuario;?>&acao=delete" class="botaoLoad deletePedidoComissao btn  btn-sm btn-danger" >
                                       <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    <?php 
                    }else{
                        echo 'Indisponível';
                    } 
                    ?>
                </td>
            </tr>
            <?php
        endforeach;
    }
    ?>
</tbody>