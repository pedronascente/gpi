<?php
include_once '../../../../../Config.inc.php';
$id_planilha          = filter_input(INPUT_GET, "id_planilha");
$tela                 = filter_input(INPUT_GET, "tela");
$pedidoComissao       = new PedidoComissao;
$pcf                  = new PedidoComissaoFuncionario;
$auditoria            = $tela == 1 ? true : false;
$comissoes            = $pedidoComissao->getPedidoComissaoPorPlanilha($id_planilha);
$lista_inconsistencia = null;
$lista_comissoes      = $comissoes;
$planilha             = $pcf->selectPCF($id_planilha);
$id_supervisor        = $planilha['pcf_id_supervisor'];
$id_setor             = $planilha['pcf_id_setor'];
$pc = new PedidoComissao;

@session_start();


$status = $auditoria ? $id_planilha : null;

if ($comissoes) {

    foreach ($comissoes as $k => $comissao) {

        if (!empty($comissao['pedido_comissao_placa']) || !empty($comissao['pedido_comissao_conta'])) {

            $planilha = !$auditoria ? $comissao['pedido_comissao_id_usuario'] : null;

            $pc->listaInconsistencia($comissao['pedido_comissao_placa'], $comissao['pedido_comissao_conta'], $comissao['pedido_comissao_data'], $status, false, $planilha, null, null);

            if ($pc->Read()->getRowCount() == 0){
                unset($lista_comissoes[$k]);
            }
        } else {
            unset($lista_comissoes[$k]);
        }
    }
}
$th = $auditoria ? "<th>Casdastro</th>" : "";
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">INCONSISTÊNCIAS PLANILHA :</h4>
        </div><!-- /modal-header -->
        <div class="modal-body">
            <input type="hidden" value="<?= $tela ?>" id="tela">
            <input type="hidden" value="<?= $id_planilha ?>" id="idPlanilha">
            <input type="hidden" value="<?= $id_supervisor; ?>" id="usuarioInconsistencia">
            <?php 
                if ($lista_comissoes) { ?>
                    <?php 
                        if (!$auditoria) { ?>
                            <div class="alert alert-warning" role="alert">Se você enviar a planilha com inconsistências, elas serão enviadas á auditoria para aprovação!</div>
                            <?php 
                        }else
                            { ?>
                            <div class="row" align="left" id="tutorial">
                                <div class="colxs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="well well-sm">
                                        <div class="row">
                                        <div class="colxs-12 col-sm-3 col-md-3 col-lg-3">
                                            <span class="glyphicon glyphicon-ok"></span> - Aprova Inconsistência.
                                        </div>
                                        <div class="colxs-12 col-sm-8 col-md-8 col-lg-8">
                                            <span class="glyphicon glyphicon-remove"></span> - Reprova Inconsistência a retirando do somatório final da planilha.
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                       }
                   ?>
                    <div class="scrollbar table-responsive" id="divInconsistencia">
                        <table class="table table-condensed table-striped table-bordered dataTable">
                            <thead>
                                <tr>
                                    <th>Funcionário</th>
                                    <?= $th; ?>
                                    <th>Conta/Placa</th>
                                    <th>Período</th>
                                    <th>Data</th>
                                    <th>Cliente</th>
                                    <th>Comissão</th>
                                    <th>Serviço</th>
                                    <th>OS</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($lista_comissoes as $dados) {
                                    $pedidoComissao->sets($dados);
                                    $conta_placa = null;
                                    if ($pedidoComissao->get_pedido_comissao_conta() != NULL && $pedidoComissao->get_pedido_comissao_placa() != NULL) {
                                        $conta_placa = $pedidoComissao->get_pedido_comissao_conta() . "/" . $pedidoComissao->get_pedido_comissao_placa();
                                    } else if ($pedidoComissao->get_pedido_comissao_conta() != NULL) {
                                        $conta_placa = $pedidoComissao->get_pedido_comissao_conta();
                                    } else {
                                        $conta_placa = $pedidoComissao->get_pedido_comissao_placa();
                                    }
                                    ?>
                                    <tr  class="trInconsistencia" id="<?=$pedidoComissao->get_pedido_comissao_id(); ?>">
                                        <td><?=$pedidoComissao->get_usuario(); ?></td>
                                        <?=$auditoria ? '<td>' . $pedidoComissao->get_usuarioCadastro() . '</td>' : '' ?>
                                        <td><?= $conta_placa; ?></td>
                                        <td><?=$pedidoComissao->get_pcf_periodo() ; ?></td>
                                        <td><?=$pedidoComissao->get_pedido_comissao_data(); ?></td>
                                        <td><?=$pedidoComissao->get_cliente(); ?></td>
                                        <td><?=$pedidoComissao->get_pedido_comissao_comissao1(); ?></td>
                                        <td><?= $pedidoComissao->get_pedido_comissao_servico(); ?></td>
                                        <td><?=$pedidoComissao->get_pedido_comissao_n_os(); ?></td>
                                        <td width="9%">
                                            <?php if ($auditoria) { ?>
                                                <?php if ($pedidoComissao->get_situacao() == 1 || $pedidoComissao->get_situacao() == NULL) { ?>

                                                    [<a id="<?=$pedidoComissao->get_pedido_comissao_id(); ?>_2_<?=$pedidoComissao->get_id();//inconsistencia ?>"  class="statusInconsistencia listar  btn-success"><span class="glyphicon glyphicon-ok"></span></a>]
                                                    [<a id="<?=$pedidoComissao->get_pedido_comissao_id(); ?>_3_<?=$pedidoComissao->get_id();//inconsistencia ?>"  class="statusInconsistencia listar  btn-danger"><span class="glyphicon glyphicon-remove"></span></a>]

                                                    <?php
                                                } else {
                                                    echo $pedidoComissao->get_situacao() == 2 ? "Liberada" : "Reprovada";
                                                }
                                                ?>

                                                [<a id="<?= $conta_placa ?>///<?= $pedidoComissao->get_pedido_comissao_id(); ?>" class="verInconsistencias"><span class="glyphicon glyphicon-eye-open"></span></a>]

                                            <?php } else { ?>
                                                <?php if ($pedidoComissao->get_pedido_comissao_id_usuario() == $id_planilha) { ?>
                                                    <a href="modulos/pedidoComissao/src/controllers/pedido_comissao.php?id_pc=<?=$pedidoComissao->get_pedido_comissao_id(); ?>&acao=delete&id_user=<?= $id_planilha; ?>&id_setor=<?= $id_setor; ?>" class="btn  btn-sm btn-danger">
                                                        Excluir
                                                    </a>
                                                    <?php
                                                } else {
                                                    echo "<td><td>";
                                                }
                                                ?>
                                            <?php } ?>
                                        </td>

                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="alert alert-warning" id="mensagem" style="display:none;"><span class="glyphicon  glyphicon-alert"></span>  Nenhum registro encontrado.</div>
                    <?php 
           
                } else{
                    Funcoes::Nregistro();
                }
                ?>
                <br>
                <div id="tabelaMostraInconsistencias" style="display:none;" class="scrollbar table-responsive">
                    <table class="table table-condensed table-hover table-striped table-bordered" id="incosistenciasTabela">
                        <thead>
                            <tr><th colspan="10" id="titulo"> Título</th></tr>
                            <tr>
                                <th>Funcionário</th>
                                <?= $th; ?>
                                <th>Conta/Placa</th>
                                <th>Período</th>
                                <th>Ano</th>
                                <th>Data</th>
                                <th>Cliente</th>
                                <th>Comissão</th>
                                <th>Serviço</th>
                                <th>N° OS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($lista_comissoes as $k => $li) {

                                $id = $li['pedido_comissao_id'];
                                $funcionario = !empty($li['usuario']) ? $li['usuario'] : '';
                                $periodo = !empty($li['pcf_periodo']) ? $li['pcf_periodo'] : '';
                                $data = !empty($li['pedido_comissao_data']) ? Funcoes::formataData($li['pedido_comissao_data']) : '';
                                $cliente = !empty($li['cliente']) ? $li['cliente'] : '';
                                $comissao = !empty($li['pedido_comissao_comissao1']) ? $li['pedido_comissao_comissao1'] : '';
                                $servico = !empty($li['pedido_comissao_servico']) ? $li['pedido_comissao_servico'] : '';
                                $os = !empty($li['pedido_comissao_n_os']) ? $li['pedido_comissao_n_os'] : '';
                                $usuario = !empty($li['usuarioCadastro']) ? $li['usuarioCadastro'] : '';
                                $inconsistencia = !empty($li['id']) ? $li['id'] : 0;

                                $conta_placa = null;

                                if (!empty($li['pedido_comissao_conta']) && !empty($li['pedido_comissao_placa']))
                                    $conta_placa = $li['pedido_comissao_conta'] . "/" . $li['pedido_comissao_placa'];

                                else if (!empty($li['pedido_comissao_conta']))
                                    $conta_placa = $li['pedido_comissao_conta'];
                                else
                                    $conta_placa = $li['pedido_comissao_placa'];
                                ?>
                                <tr  class="trInconsistencia" id="<?= $id; ?>">
                                    <td><?= $funcionario; ?></td>
                                    <?= $auditoria ? '<td>' . $usuario . '</td>' : '' ?>
                                    <td><?= $conta_placa; ?></td>
                                    <td><?= $periodo; ?></td>
                                    <td><?= $data; ?></td>
                                    <td><?= $cliente; ?></td>
                                    <td><?= $comissao; ?></td>
                                    <td><?= $servico; ?></td>
                                    <td><?= $os; ?></td>
                                    <td width="9%">
                                    
                                        <?php if ($auditoria) { ?>
                                            <?php if ($li["situacao"] == 1 || empty($li["situacao"])) { ?>

                                                [<a id="<?= $id ?>_2_<?= $inconsistencia ?>"  class="statusInconsistencia listar  btn-success"><span class="glyphicon glyphicon-ok"></span></a>]
                                                [<a id="<?= $id ?>_3_<?= $inconsistencia ?>"  class="statusInconsistencia listar  btn-danger"><span class="glyphicon glyphicon-remove"></span></a>]

                                                <?php
                                            } else {
                                                echo $li['situacao'] == 2 ? "Liberada" : "Reprovada";
                                            }
                                            ?>

                                            [<a id="<?= $conta_placa ?>///<?= $id; ?>" class="verInconsistencias"><span class="glyphicon glyphicon-eye-open"></span></a>]

                                        <?php } else { ?>
                                            <?php if ($li['pedido_comissao_id_usuario'] == $id_planilha) { ?>
                                                <a href="modulos/pedidoComissao/src/controllers/pedido_comissao.php?id_pc=<?= $id; ?>&acao=delete&id_user=<?= $id_planilha; ?>&id_setor=<?= $id_setor; ?>" class="btn  btn-sm btn-danger">
                                                    Excluir
                                                </a>
                                                <?php
                                            } else {
                                                echo "<td><td>";
                                            }
                                            ?>
                                        <?php } ?>
                                    </td>

                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <br>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <?php if (!$auditoria) { ?><input type="button" id="<?= $id_planilha; ?>" class="enviarPlanilha btn btn-default" title="Enviar Planilha para coferência." value="Enviar"><?php } ?>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script language="javascript" type="text/javascript" src="modulos/pedidoComissao/public/js/min/modal.js"></script>