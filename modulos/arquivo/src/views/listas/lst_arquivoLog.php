<?php
@session_start();


setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

include_once '../../../../../Config.inc.php';

$arquivo = new Arquivo;

$id_usuario = $_SESSION['user_info']['id_usuario'];
$nome = $_SESSION['user_info']['nome'];

$nomeSupervisor = isset($log['nome']) ? $log['nome'] : $nome;

$id_arquivo = filter_input(INPUT_GET, "arquivo_id");
$acao = filter_input(INPUT_GET, "acao");

$data = date("d/m/Y H:i:s");

$listaLog = $arquivo->selectLog($id_arquivo, null);
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">LOG ARQUIVO</h4>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
            <form method="post" action="modulos/arquivo/src/controllers/arquivo.php" id="formArquivoLog">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Data:</label>
                            <input type="text" value="<?= $data; ?>" disabled="disabled" class="form-control" id="arquivoData">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Supervisor:</label>
                            <input type="text"  value="<?= $nomeSupervisor ?>"  class="form-control" disabled="disabled" id="nomeSupervisor">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Usuário:</label>
                            <input type="text" name="arquivo_log_usuario" class="form-control disabled" required id="arquivoUsuario">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Motivo:</label>
                            <select name="arquivo_log_motivo" class="form-control disabled" required="required" id="motivoLog">
                                <option value="Consulta">Consulta</option>
                                <option value="Retirada">Retirada</option>
                                <option value="Devolução">Devolução</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>OBS:</label>
                            <textarea name="arquivo_log_obs" class="form-control disabled" id="arquivoOBS"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="form-actions">
                            <input type="hidden" name="arquivo_log_supervisor" value="<?= $id_usuario; ?>">
                            <input type="hidden" name="arquivo_log_data" value="<?= Funcoes::formataDataComHoraSQL($data); ?>" id="dataBanco">
                            <input type="hidden" name="arquivo_log_arquivo" value="<?= $id_arquivo; ?>" class="idArquivo">
                            <input type="hidden" name="arquivo_log_tipo" value="2">
                            <input type="hidden" name="acao" value="cadastrarLog">

                            <button type="submit" class="btn btn-primary botaoLoadForm" id="btnSalvar">
                                Salvar
                            </button>

                            <button type="button" class="btn btn-info botaoLoadForm" id="btnVoltarLog">
                                Voltar
                            </button>

                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

                        </div>
                    </div>
                </div>
            </form>
            <br>
            <table class="table table-bordered" id="tabelaLogArquivo">
                <thead>
                    <tr>
                        <th>Motivo</th>
                        <th>Usuário</th>
                        <th>Supervisor</th>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($listaLog) { ?>
                        <?php foreach ($listaLog as $l) { ?>
                            <tr align="center">
                                <?php $tipo = $l['arquivo_log_tipo'] == 1 ? "Registro" : "Cadastrado"; ?>
                                <td><?= $l['arquivo_log_motivo'] ?></td>
                                <td><?= $l['arquivo_log_usuario'] ?></td>
                                <td><?= $l['nome'] ?></td>
                                <td><?= !empty($l['arquivo_log_data']) ? Funcoes::formataDataComHora($l['arquivo_log_data']) : "" ?></td>
                                <td><?= $tipo; ?></td>
                                <td><a id="<?= $l['arquivo_log_id'] ?>" class="visualizarLog btn btn-sm btn-success"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">

    $(function () {

        $("#btnVoltarLog").hide();

        $("#formArquivoLog").submit(function (e) {
            var formulario = $("#formArquivoLog").serialize();
            e.preventDefault();
            var formulario = $("#formArquivoLog").serialize();
            $.ajax({
                url: "modulos/arquivo/src/controllers/arquivo.php",
                dataType: 'json',
                data: formulario,
                type: 'post',
                success: function (obj) {
                    if (obj.result >= 1) {
                        var tr = '<tr align="center"  style="background:#FFFFFF">'
                                + '<td>' + $("#motivoLog :selected").text() + '</td>'
                                + '<td>' + $("#arquivoUsuario").val() + '</td>'
                                + '<td>' + $("#nomeSupervisor").val() + '</td>'
                                + '<td>' + $("#arquivoData").val() + '</td>'
                                + '<td>Cadastrado</td>'
                                + '<td><a id="' + obj.result + '" class="visualizarLog btn btn-sm btn-success">Visualizar</a></td>'
                                + '</tr>';
                        $("#tabelaLogArquivo tbody tr:first").before(tr);
                        $("#" + obj.result).on("click", function () {
                            visualizarLog(obj.result);
                        });
                        $(".dataTables_empty").hide();
                    } else {
                        alert("Erro ao cadastrar!");
                    }
                }
            })
        });

        $(".visualizarLog").click(function () {
            visualizarLog($(this).attr("id"));
        });

        $("#btnVoltarLog").click(function () {
            $(".disabled").val("");
            $("#nomeSupervisor").val("<?= $nomeSupervisor; ?>");
            $("#arquivoData").val("<?= date("d/m/Y H:i:s") ?>");
            $("#dataBanco").val("<?= date("Y-m-d H:i:s"); ?>");
            $(".disabled").prop("disabled", false);
            $("#motivoShow").remove();
            $(this).hide();
            $("#btnSalvar").show();
        });


        $("#tabelaLogArquivo").DataTable({
            "order": [[0, "desc"]],
            "paging": true,
            "bFilter": true,
            "bInfo": true,
            "iDisplayLength": 5, 
            "language" : {
                "sEmptyTable": "Nenhum registro encontrado",
               	"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
               	"sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar:",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "sInfoThousands": ".",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sLengthMenu": "_MENU_ resultados por página",
            },
        });


        function visualizarLog(id) {
            $.ajax({
                url: "modulos/arquivo/src/controllers/arquivo.php",
                dataType: 'json',
                data: {id: id, acao: "selectLog"},
                type: 'post',
                success: function (log) {
                    $("#arquivoData").val(log['arquivo_log_data']);
                    $("#nomeSupervisor").val(log['nome']);
                    $("#arquivoUsuario").val(log['arquivo_log_usuario']);
                    $("#motivoLog").val(log['arquivo_log_motivo']);
                    $("#arquivoOBS").val(log['arquivo_log_obs']);
                    $("#btnSalvar").hide();
                    $("#btnVoltarLog").show();
                    $(".disabled").prop("disabled", true);
                    $("#motivoLog").append("<option value='7' id='motivoShow'>" + log['arquivo_log_motivo'] + "</option>")
                    $("#motivoLog").val(7);
                }
            })
        }

    });
</script>