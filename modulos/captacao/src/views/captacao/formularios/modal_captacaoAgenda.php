<?php
//namespace C:\wamp\www\gpi\modulos\captacao\src\views\captacao\formularios\modal_captacaoAgenda.php
include_once ('../../../../../../Config.inc.php');
@session_start();

//DADOS DO FORMULARIO [form_Agenda ]:
$agenda_contato_id = filter_input(INPUT_GET, 'agenda_contato_id', FILTER_VALIDATE_INT);
$id_usuario = isset($_SESSION ['user_info']['id_usuario']) ? $_SESSION ['user_info']['id_usuario'] : NULL;
$agendaContato = new AgendaContato ();
$captacao = new Captacao();

$acaoTela = filter_input(INPUT_GET, "acaoTela");

//RESPONSAVEL POR LISTAR UM REGISTRO DO HISTORICO
$findHistorico = $agendaContato->selectAgendaPorID($agenda_contato_id);
$id_captacao = filter_input(INPUT_GET, "id_captacao");
$id_captacao = empty($id_captacao) && isset($findHistorico['agenda_contato_id_captacao']) ? $findHistorico['agenda_contato_id_captacao'] : $id_captacao;
$status = isset($findHistorico['agenda_contato_status']) && $findHistorico['agenda_contato_status'] == 1 || $acaoTela == "visualizar" ? 'readonly="readonly"' : "";
$ddd = isset($findHistorico['agenda_contato_ddd']) ? $findHistorico['agenda_contato_ddd'] : "";
$proposta = isset($findHistorico['agenda_contato_id_proposta']) ? $findHistorico['agenda_contato_proposta_id'] : "";
$cliente = $captacao->selCliente($id_captacao);
$cliente = isset($cliente['cliente']) ? $cliente['cliente'] : "";

$proxima_data = date("Y-m-d");

if (!empty($findHistorico)) :
    $proxima_data = date('Y-m-d', strtotime($findHistorico ['agenda_contato_proxima_data']));
    echo "<input type=\"hidden\" name=\"\" id=\"reagendar_data\" value=\"{$proxima_data}\">";
endif;
?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Agenda</h4>
        </div>			
        <div class="modal-body">
            <form id="form_Agenda" name="form_Agenda" method="post">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Data:</label>
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div id="calendar" date-date="<?= $proxima_data ?>"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 col-sm-offset-1">
                        <div class="row">
                            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                <div class="form-group">
                                    <label>Hora:</label>
                                    <div class="input-group">
                                        <input type="text" name="agenda_contato_hora" id="agenda_contato_hora" required <?= $status; ?> class="mask_hora form-control" value="<?= isset($findHistorico['agenda_contato_hora']) ? $findHistorico['agenda_contato_hora'] : NULL; ?>">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-7 col-md-7s col-lg-7">
                                <div class="form-group">
                                    <label>Telefone:</label>
                                    <div class="input-group">
                                        <input type="text" name="agenda_contato_fone_cliente" required class="form-control mask_telefone" value="<?= isset($findHistorico['agenda_contato_fone_cliente']) ? $findHistorico['agenda_contato_fone_cliente'] : NULL; ?>" <?= $status; ?>>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-earphone"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Cliente:</label>
                                    <input type="text" name="agenda_contato_cliente" required class="form-control" value="<?= isset($findHistorico['agenda_contato_cliente']) ? $findHistorico['agenda_contato_cliente'] : $cliente; ?>" <?= $status; ?>>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>E-mail:</label>
                                    <div class="input-group">
                                        <input type="text" name="agenda_contato_email" class="form-control" required value="<?= isset($findHistorico['email']) ? $findHistorico['email'] : NULL; ?>" <?= $status; ?>>
                                        <span class="input-group-addon">@</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Motivo:</label>
                            <?php
                            //RESPONSAVEL POR LISTAR OS MOTIVOS:
                            $lista_motivos = $agendaContato->listarMotivos();
                            echo "<select name=\"agenda_contato_motivo\" class=\"form-control\" {$status}>";
                            foreach ($lista_motivos as $motivo) :
                                echo "<option value=\"{$motivo['agenda_contato_motivos_desc']}\" ";
                                $selected = isset($findHistorico ['agenda_contato_motivos_desc']) && $motivo ['agenda_contato_motivos_desc'] == $findHistorico ['agenda_contato_motivos_desc'] ? 'selected' : '';
                                echo "selected";
                                echo " >{$motivo['agenda_contato_motivos_desc']}</option>";
                            endforeach;
                            echo "</select>";
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Descrição:</label>
                            <textarea name="agenda_contato_obs" id="textarea" class="form-control" <?= $status; ?>><?= isset($findHistorico['agenda_contato_obs']) ? $findHistorico['agenda_contato_obs'] : NULL; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-actions">
                            <input type="hidden" name="acao" id="acao" value="<?= (!empty($agenda_contato_id)) ? "Reagendar" : "Agendar"; ?>"> 
                            <input type="hidden" value="<?= $agenda_contato_id; ?>" name="agenda_contato_id" id = "contatoID">
                            <input type="hidden" name="agenda_contato_captacao_id" value="<?= $id_captacao; ?>" id="idCaptacao"> 
                            <input type="hidden" name="agenda_contato_ddd" value="<?= $ddd; ?>"> 
                            <input type="hidden" name="agenda_contato_proposta_id" value="<?= $proposta; ?>"> 
                            <input type="hidden" name="agenda_contato_id_usuario" value="<?= $id_usuario; ?>"> 
                            <input type="hidden" id="acaoCaptacao" value="visualizar&voltar=18">                            
							<?php if ($acaoTela != "visualizar") { ?>
                                <?php if ((isset($findHistorico['agenda_contato_id']) && $findHistorico['agenda_contato_status'] == 0) || !isset($findHistorico['agenda_contato_id'])) { ?>
                                    <button type="submit" class="btn btn-primary botaoLoadForm">
                                        <?= (!empty($agenda_contato_id)) ? "Reagendar" : "Agendar"; ?>
                                    </button>
                                <?php } ?>
                                <?php if (isset($findHistorico['agenda_contato_id'])) { ?>

                                    <?php if ($findHistorico['agenda_contato_status'] == 0) { ?>
                                        <button type="button" class="btn btn-info" id="finalizar">
                                            Finalizar
                                        </button>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            <?php if (!empty($id_captacao) && !empty($findHistorico['agenda_contato_id'])) { ?>
                                <button type="button" class="btn btn-success" id="captacao">
                                    Captação
                                </button>
                            <?php } ?>

                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
    /*
     ********************************************************************
     ********** RESPONSAVEL POR REGISTRAR NA DB UM AGENDAMENTO **********
     ******************************************************************** 
     */
    $(function ()
    {
        /*
         *******************************************************
         ********** VERIFICA SE TEM UMA DATA AGENDADA **********
         *******************************************************
         */

        $(".mask_hora").mask('00:00');
        $(".mask_telefone").mask("(00)00000-0090");

        var data = "<?= $proxima_data; ?>";
        data = data.split("-");

        $('#calendar').datepicker({
            dateFormat: 'yy-mm-dd',
            language: "pt-BR",
            inline: true,
            todayBtn: true
        });

        $('#calendar').datepicker('setDate', new Date(data[0], data[1] - 1, data[2]));

        $("#form_Agenda").submit(function ()
        {
            var dia = $('#calendar').datepicker('getDate').getDate();
            var mes = $('#calendar').datepicker('getDate').getMonth() + 1;
            mes = mes < 10 ? "0" + mes : mes;
            var ano = $('#calendar').datepicker('getDate').getFullYear();
            var agenda_contato_proxima_data = ano + "-" + mes + "-" + dia;
            var dados = $(this).serialize() + '&agenda_contato_proxima_data=' + agenda_contato_proxima_data;
            $.ajax({
                url: "modulos/captacao/src/controllers/captacao.php",
                data: dados,
                type: 'POST',
                dataType: 'json',
                success: function (result) {
                    if (result.type == 1) {
                        alert('Registro Agendado com sucesso!');
                        location.reload();
                    } else {
                        alert('Informe uma nova Data ou Horario diferente!');
                    }
                },
                error: function () {
                    alert('error ao enviar');
                }
            });
            return false;
        });

        $("#finalizar").click(function () {
            var id_agenda = $("#contatoID").val();
            $.ajax({
                url: "modulos/captacao/src/controllers/captacao.php",
                data: {agenda_contato_id: id_agenda, acao: "updateStatusAgenda"},
                type: 'POST',
                dataType: 'text',
                success: function (text) {
                    alert("Registro finalizado com sucesso!");
                    window.location.reload();
                }
            });
        });

        $("#captacao").click(function () {
            var idCaptacao = $("#idCaptacao").val();
            window.location.href = "index.php?pg=19&id=" + idCaptacao + "&acao="+$("#acaoCaptacao").val();
        });
    });
</script>