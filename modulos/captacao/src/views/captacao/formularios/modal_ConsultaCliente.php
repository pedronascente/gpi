<?php
//namespace C:\wamp\www\gpi\modulos\captacao\src\views\captacao\formularios\modal_ConsultaCliente.php
include_once '../../../../../../Config.inc.php';
$getArray = filter_input_array(INPUT_GET);
$id_captacao = !empty($getArray ['id']) ? $getArray ['id'] : '';
@session_start();
$id_usuario = isset($_SESSION ['user_info'] ['id_usuario']) ? $_SESSION ['user_info'] ['id_usuario'] : NULL;
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Consultar SPC | SERASA</h4>
        </div>			
        <div class="modal-body">
            <form action="modulos/captacao/src/controllers/captacao.php" method="post" id="consultarCPF">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>
                                <ul class="nav nav-pills">
                                    <li role="presentation" class="active tipoPessoa" id="f"><a>Física</a></li>
                                    <li role="presentation" class="tipoPessoa" id="j"><a>Júridica</a></li>
                                </ul>
                            </label>	
                        </div>
                    </div>
                </div>
              
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Contrato:</label>
                            <select name="tipo_cadastro" id="tipo_cadastro" required class="form-control">
                                <option selected="selected" value="rastreador">Contrato Comodato</option>
                                <option value="venda">Contrato de Venda</option>
                                <option value="rastreador_com_seguro">Contrato Rastreador com Seguro</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="vigencia">
                    	<div class="form-group">
	                        <label>Vigência:</label>
	                        <select name="vigencia" class="form-control">
	                            <option selected="selected" value="1">12 meses</option>
	                            <option value="2">24 meses</option>
	                            <option value="3">36 meses</option>
	                        </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>CPF/CNPJ:</label>
                            <input type="text" name="cnpjcpf_cliente" required class="mask_cpf form-control" id="cpf_cnpj">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label id="title_nome">Nome:</label>
                            <input type="text" name="nome_cliente" required  class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class=" form-group  ">
                            <label>Status Cliente:</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" id="radio3" name="radioApRp" class="radio_AprovaReprova" checked="checked" value="aprovado">  Aprovado
                                </label>    
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" id="radio4" name="radioApRp" class="radio_AprovaReprova" value="reprovado"> Reprovado
                                </label>
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class=" form-group  "  id="boxMotivoReprovacao"  style="display: none" >
                            <label>Motivo Reprovado :</label>
                            <select name="motivo_reprovacao_cliente" class="form-control"   <?=$required;?> disabled="disabled" id="selectReprovado">
                                <option value="">Selecione</option>
                                <option value="CNPJ Invalido">CNPJ Invalido</option>
                                <option value="Dados com restricoes">Dados com restricoes</option>
                                <option value="CPF Invalido">CPF Invalido</option>
                                <option value="Nome Incompleto">Nome Incompleto</option>
                                <option value="Nome Incorreto">Nome Incorreto</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-actions">
                            <input type="hidden" name="redirect"  value="redirect">
                            <input type="hidden" name="id_captacao"  value="<?= $id_captacao; ?>">
                            <input type="hidden" name="acao" value="consultaSPCSERASA"> 
                            <input type="hidden" name="tipo_pessoa" id="textoTipoPessoa" value="f"> 
                            <input type="hidden" name="id_usuario" id="id_usuario" value="<?= $id_usuario; ?>">
                            <input type="hidden" name="tipoFrm" value="consultar"> 
                            <button type="submit" class="btn btn-danger botaoLoadForm"> Consultar </button>
                            <br>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="public/js/funcoes.js"></script>
<script type="text/javascript">
$(function(){
    $('.radio_AprovaReprova').click(function(){
        var _r = $(this).val();
        if(_r=='aprovado'){
            $('#boxMotivoReprovacao').css('display','none');
        }else if(_r=='reprovado'){
            $('#boxMotivoReprovacao').css('display','block');
        }
    })
})
</script>