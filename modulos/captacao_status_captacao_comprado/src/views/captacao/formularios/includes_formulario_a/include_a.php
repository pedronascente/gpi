<?php
include_once ("../../../../../../../Config.inc.php");
$objeto_captacao = new Captacao;
$captacao = $objeto_captacao->selCaptacao($_GET['id']);
$captacao_tipo_servico = isset($captacao ['captacao_tipo_servico'])?$captacao ['captacao_tipo_servico']:NULL;
$captacao_localizacao_do_servico_atual = isset($captacao ['captacao_localizacao_do_servico_atual'])?$captacao ['captacao_localizacao_do_servico_atual']:NULL;
$captacao_cliente_desde = isset($captacao ['captacao_cliente_desde'])?$captacao ['captacao_cliente_desde']:NULL;
$captacao_tipo_servico_desc_outros = isset($captacao ['captacao_tipo_servico_desc_outros'])?$captacao ['captacao_tipo_servico_desc_outros']:NULL;
$captacao_pendencias_financeiras = isset($captacao ['captacao_pendencias_financeiras'])?$captacao ['captacao_pendencias_financeiras']:NULL;
$captacao_acoes = isset($captacao ['captacao_acoes'])?$captacao ['captacao_acoes']:NULL;
$captacao_conceito = isset($captacao ['captacao_conceito'])?$captacao ['captacao_conceito']:NULL;
$captacao_obs = isset($captacao ['captacao_obs'])?$captacao ['captacao_obs']:NULL;
?>
<div class="alert _alert-background"> 
    <ul>
        <li>Bem então o senhor já sabe como funciona, não é mesmo?</li>
        <li>No caso em que o cliente diga que não sabe como funciona, aplique a apresentação padronizada. </li>
        <li>Se a resposta do cliente for de que ele já sabe como funciona, faça a pergunta seguinte.</li>
        <li>Em quais de nossos serviços de alarmes monitorados o senhor(a) já é nosso cliente?</li>
    </ul>
</div>
<div class="row">
    <div class="col-xs-12  col-md-3">
        <div class="form-group">
            <label>Tipo de Serviços:</label>
            <select name="captacao_tipo_servico"  class="form-control  captacao_tipo_servico2" required="">
                <option value=""> -- Selecione -- </option>
                <option value="Alarme Monitorado Residencial"  <?=($captacao_tipo_servico=="Alarme Monitorado Residencial")?"selected":'';?>>Alarme Monitorado Residencial</option>
                <option value="Alarme Monitorado Empresarial"  <?=($captacao_tipo_servico=="Alarme Monitorado Empresarial")?"selected":'';?>>Alarme Monitorado Empresarial</option>
                <option value="Outros (descrever)"             <?=($captacao_tipo_servico=="Outros (descrever)")?"selected":'';?>>Outros (descrever)</option>
            </select>
        </div>
    </div>
</div>
<div class="row captacao_tipo_servico_desc_outros2" style="display: none">
    <div class="col-xs-12 col-md-12">
        <div class="form-group">
            <textarea name="captacao_tipo_servico_desc_outros" class="form-control"  placeholder="Descreva aqui , qual é o outro tipo de serviço."><?=$captacao_tipo_servico_desc_outros;?></textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12  col-md-12">
        <div class="form-group">
            <label>O senhor(a) pode informar o endereço onde está localizado o imóvel  dos serviços atuais? </label>
            <input type="text" name="captacao_localizacao_do_servico_atual" value="<?=$captacao_localizacao_do_servico_atual;?>" class="form-control" placeholder="Digite nome da cidade" />
        </div>
    </div>
</div>
<div class="alert _alert-background"> 
    <p>Com base no endereço, você deve buscar no CRM utilizado as informações relativas ao já cliente, dentre as quais:</p>
</div> 
<div class="row">
    <div class="col-xs-12 col-md-2 ">
        <div class="form-group ">
            <label>Cliente desde:(dia/mes)</label>
            <input type="text" name="captacao_cliente_desde"  value="<?=$captacao_cliente_desde;?>" class="form-control mask_anofab" />
        </div>
    </div>
    <div class="col-xs-12 col-md-3">
        <div class="form-group">
            <label>Pendencias financeiras:</label>
            <input type="text" name="captacao_pendencias_financeiras"   value="<?=$captacao_pendencias_financeiras;?>"   class=" form-control " />
        </div>
    </div>
    <div class="col-xs-12 col-md-2">
        <div class="form-group">
            <label>Ações:</label>
            <input type="text" name="captacao_acoes"  value="<?=$captacao_acoes;?>" class="form-control" />
        </div>
    </div>
</div>                
<div class="row">
    <div class="col-xs-12  col-md-3">
        <div class="form-group">
            <label>Conceito  no software de gestão  :</label>
            <select name="captacao_conceito"  class="form-control  " required="">
                <option value=""> -- Selecione -- </option>
                <option value="Otimo"   <?=($captacao_conceito=="Otimo")?"selected":'';?>>Otimo</option>
                <option value="Bom"     <?=($captacao_conceito=="Bom")?"selected":'';?>>Bom</option>
                <option value="Regular" <?=($captacao_conceito=="Regular")?"selected":'';?>>Regular</option>
                <option value="Ruim"    <?=($captacao_conceito=="Ruim")?"selected":'';?> >Ruim</option>
                <option value="Péssimo" <?=($captacao_conceito=="Péssimo")?"selected":'';?>>Péssimo</option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12  col-md-12">
        <div class="form-group">
            <label>Observações sobre o cliente:</label>
            <textarea class="form-control"  name="captacao_obs"><?=$captacao_obs;?></textarea>
        </div>
    </div>
</div>   
