<?php  // namespace C:\wamp\www\gpi\modulos\captacao\src\views\captacao\formularios\modal_statusCaptacao.php ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Status Captação</h4>
        </div>			
        <div class="modal-body">
            <form id="formAlterarStatusCaptacao" name="alterarStatusCaptacao" method="post">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Status:</label>
                            <select name="captacao_status" id="captacao_status" class="form-control" required>
                                <option value="">Selecione um motivo</option>
                                <option value="cancelado">Cancelado</option>
                                <option value="comprado">Venda Efetuada</option>
                                <option value="em_agendamento">Em Agendamento</option>
                                <option value="visita_agendada">Visita Agendada</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Observação:</label>
                            <textarea name="motivo_finalizacao" id="motivo_finalizacao" class="form-control" required=""></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-actions">
                            <input type="hidden" name="id_captacao" id="id_captacao" value="<?= isset($_GET['id_captacao']) ? $_GET['id_captacao'] : ''; ?>" />
                            <input type="hidden" name="acao" id="acao" value="alterarStatusCaptacao" /> 
                            <button type="submit" class="btn btn-primary botaoLoadForm">
                                Salvar
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--
RESPONSAVEL POR FINALIZAR UMA CAPTAÇÃO
-->
<script type="text/javascript" language="javascript">
    $(function () {
        $('#formAlterarStatusCaptacao').submit(function () {
            var dados = $(this).serialize();
            $.ajax({
                url: "modulos/captacao/src/controllers/captacao.php",
                data: dados,
                type: 'POST',
                dataType: 'text',
                success: function (json) {
                    if (json == 1) {
                        alert('Status Alterados com sucesso!');
                        location.reload();
                    }
                },
                error: function () {
                    alert('error ao enviar');
                }
            });
            return false;
        })
    });
</script>