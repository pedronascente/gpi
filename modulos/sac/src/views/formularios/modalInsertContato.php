<?php
include_once ("../../../../../Config.inc.php");
$acao      = filter_input ( INPUT_GET, "acao", FILTER_DEFAULT );
$id        = ($acao == "add") ? filter_input ( INPUT_GET, "id_cliente", FILTER_VALIDATE_INT ) : filter_input ( INPUT_GET, "id", FILTER_VALIDATE_INT );
$nivel     = filter_input(INPUT_GET, "nivel");
/*
 * ***************************************
 * ********* SELECIONAR CONTATO *********
 * ***************************************
 */
if ($acao == "EditarContato") :
	/*********************************************************
	 **********************	02/06/2015 ***********************
	 ********************** Manutenção ***********************
	 *********************************************************/
	$agendaContato  = new AgendaContato();
	$contato        = $agendaContato->selectContato ( $id );
endif;

?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Contato</h4>
        </div>			
        <div class="modal-body">
            <form method="post" action="modulos/sac/src/controllers/sac.php">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group" align="center">
                            <div class="well">Caso houver a necessidade de registrar mais de (01) E-mail. <br>Separe	por ( ; ) ponto e virgula, exemplo:<br> email1@teste.com; email2@teste.com.</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Contato.: <span class="campo_obrigatorio">*</span></label>
                            <input type="text" name="contato_nome" value="<?=isset($contato['contato_nome']) ? $contato['contato_nome'] : null ;?>" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Telefone(1).: <span class="campo_obrigatorio">*</span></label>
                            <input type="text" name="contato_telefone1" value="<?=isset($contato['contato_telefone1']) ? $contato['contato_telefone1'] : null;?>" maxlength="15"  class="mask_telefone form-control"  required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Telefone(2).:</label>
                            <input type="text" name="contato_telefone2" value="<?=isset($contato['contato_telefone2']) ? $contato['contato_telefone2'] : null;?>" maxlength="15" class="mask_telefone form-control">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Telefone(3).:</label>
                            <input type="text" name="contato_telefone3" value="<?=isset($contato['contato_telefone3']) ? $contato['contato_telefone3'] : null;?>" maxlength="15" class="mask_telefone form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>E-mail(1) .:  <span class="campo_obrigatorio">*</span></label>
                            <textarea name="contato_email1" class="form-control" required><?=isset($contato['contato_email1']) ? $contato['contato_email1'] : null;?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
	                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	                    <div class="form-actions">
	                        <input type="hidden" name="contato_nivel" value="<?=$nivel;?>">
	                        <input type="hidden" name="acao" value="<?=($acao == "add") ? "InsertContato" : "EditarContato"; ?>">
	                        <input type="hidden" name="<?=($acao == "add") ? "contato_id_cliente" : "contato_id"; ?>" value="<?=$id?>">
	                        <input type="submit" name="submit" value="<?=($acao == "add") ? "Salvar" : "Editar"; ?>" id="salvar" class="btn btn-primary">
	                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	                    </div>
	                </div>
				</div>
            </form>
        </div>
    </div>
</div>
<script language="JavaScript" type="text/javascript" > 
$(function(){ 
    $(".mask_telefone").mask("(00)00000-0090"); 
});                
</script> 
