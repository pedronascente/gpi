<?php
include_once '../../../../../Config.inc.php';
$pc = new PedidoComissao;

@session_start();

$conta_placa = $_GET['conta_placa'];
$nivel = $_GET['nivel'];
$conta = null;
$placa = null;

if ($nivel == 1) {
    $conta = null;
    $placa = $conta_placa;
} else if ($nivel == 2) {
    $conta = $conta_placa;
    $placa = null;
}

$lista = $pc->getInconsistencias($placa, $conta, false);

?>
<link type="text/css" rel="stylesheet" href="public/css/dataTable.css"/>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Inconsistências Planilha</h4>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
            <div class="row" align="left">
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
           <div class="scrollbar table-responsive">
                <table class="table table-condensed table-hover table-striped table-bordered dataTable" width="100%">
                    <thead>
                        <tr>
                            <th>Funcionário</th>
                            <th>Supervisor</th>
                            <th>Cadastro</th>
                            <th>Período</th>
                            <th>Ano</th>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Comissão</th>
                            <th>Serviço</th>
                            <th>N° OS</th>
                            <th>Situação</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                <?php
                foreach ($lista as $k => $li) {

                    $id = $li['pedido_comissao_id'];
                    $funcionario = !empty($li['nomeFuncionario']) ? $li['nomeFuncionario'] : '';
                    $periodo = !empty($li['pcf_periodo']) ? $li['pcf_periodo'] : '';
                    $ano = !empty($li['pcf_ano']) ? $li['pcf_ano'] : '';
                    $data = !empty($li['pedido_comissao_data']) ? Funcoes::formataData($li['pedido_comissao_data']) : '';
                    $cliente = !empty($li['cliente']) ? $li['cliente'] : '';
                    $comissao = !empty($li['comissao']) ? $li['comissao'] : '';
                    $servico = !empty($li['pedido_comissao_servico']) ? $li['pedido_comissao_servico'] : '';
                    $os = !empty($li['pedido_comissao_n_os']) ? $li['pedido_comissao_n_os'] : '';
                    $supervior = !empty($li['supervisor']) ? $li['supervisor'] : '';
                    $usuario = !empty($li['usuarioCadastro']) ? $li['usuarioCadastro'] : '';
                    $id_usuario = !empty($li['pcf_id_supervisor']) ? $li['pcf_id_supervisor'] : '';
                    $inconsistencia = !empty($li['id']) ? $li['id'] : 0;
                    ?>
                    <tbody>
                        <tr align="center">
                            <td><?= $funcionario; ?></td>
                            <td><?= $supervior ?></td>
                            <td><?= $usuario ?></td>
                            <td><?= $periodo; ?></td>
                            <td><?= $ano; ?></td>
                            <td><?= $data; ?></td>
                            <td><?= $cliente; ?></td>
                            <td><?= $comissao ?></td>
                            <td><?= $servico; ?></td>
                            <td><?= $os; ?></td>
                            <td id="situacao<?= $id; ?>">
                                <?php
                                if ($li['situacao'] == 1 || empty($li['situacao']))
                                    echo "Em Análise";
                                else
                                    echo $li['situacao'] == 2 ? "Liberada" : "Reprovada";
                                ?>
                            </td>
                            <td>
                                [<a  id="<?= $id ?>_2_<?= $inconsistencia; ?>" class="statusInconsistencia btn-success"><span class="glyphicon glyphicon-ok"></span></a>]
                                [<a  id="<?= $id ?>_3_<?= $inconsistencia; ?>" class="statusInconsistencia btn-danger"><span class="glyphicon glyphicon-remove"></span></a>]
                            </td>
                        </tr>
                    </tbody>

                <?php } ?>
                </table>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script language="javascript" type="text/javascript" src="modulos/pedidoComissao/public/js/min/modal.js"></script>
