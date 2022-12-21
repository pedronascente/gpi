<?php
include_once ("../../../../../../../Config.inc.php");
$objeto_captacao = new Captacao;
$captacao = $objeto_captacao->selCaptacao($_GET['id']);
$captacao_imovel_tipo_servico_vigiado = isset($captacao ['captacao_imovel_tipo_servico_vigiado'])?$captacao ['captacao_imovel_tipo_servico_vigiado']:NULL;
$captacao_imovel_tipo_servico_vigiado_horario = isset($captacao ['captacao_imovel_tipo_servico_vigiado_horario'])?$captacao ['captacao_imovel_tipo_servico_vigiado_horario']:NULL;
?>
<div class="row">
    <div class="col-xs-12  col-md-4">
        <div class="form-group">
            <label>Tipo de serviço vigiado:</label>
            <div class="form-group">
                <select name="captacao_imovel_tipo_servico_vigiado" class="form-control" required="">
                    <option value=""> -- Selecione -- </option>
                    <option value="Portaria Remota"   <?=($captacao_imovel_tipo_servico_vigiado=="Portaria Remota")?"selected":'';?>  >Portaria Remota</option>
                    <option value="Portaria Presencial/Vigilância"<?=($captacao_imovel_tipo_servico_vigiado=="Portaria Presencial/Vigilância")?"selected":'';?> >Portaria Presencial/Vigilância</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-xs-12  col-md-2">
        <div class="form-group">
            <label>Horário:</label>
            <input type="text" name="captacao_imovel_tipo_servico_vigiado_horario" value="<?=$captacao_imovel_tipo_servico_vigiado_horario;?>" class="form-control mask_hora"  required="">
        </div>
    </div>
</div>
