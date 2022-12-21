<?php
include_once '../../../../../../Config.inc.php';

$id_contrato = filter_input(INPUT_GET, "id_contrato");

$contrato = new Contratos;

$logs = $contrato->getLogASC($id_contrato);
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close modalClose" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Log</h4>
        </div>
        <div class="modal-body">
            <?php if ($logs) { ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <th>Data</th>
                        <th>Aviso</th>
                        <th>Mensagem</th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($logs as $l) {
                                $data = !empty($l['data_inclusao']) ? Funcoes::formataData($l['data_inclusao']) : "";
                                $aviso = !empty($l['aviso']) ? $l['aviso'] : "";
                                $mensagem = !empty($l['mensagem']) ? $l['mensagem'] : "";
                                ?>
                                <tr>
                                    <td><?= $data; ?></td>
                                    <td><?= $aviso; ?></td>
                                    <td><?= $mensagem; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php
            } else {
                Funcoes::Nregistro();
            }
            ?>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
    $(function () {
        $(".modalClose").click(function () {
            $("#modalLog").modal("hide");
        });
    });
</script>