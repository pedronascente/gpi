<?php 
include_once ('../../../../../Config.inc.php');

$id_solicitacao = filter_input(INPUT_GET, "desenvolvimento_id");

$desenvolvimento = new Desenvolvimento;

$historico = $desenvolvimento->selectHistorico($id_solicitacao, 4);
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Help</h4>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
        	<form action="modulos/desenvolvimento/src/controllers/desenvolvimento.php" method="POST">
        		 <div class="table-responsive">
                <table class="table table-bordered   table-striped  table-hover"  id="mostraHistorico">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Usuário</th>
                            <th>Descrição</th>
                            <th width='5%'>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historico as $k => $h) { ?>
                            <tr>
                                <td><?= !empty($h['log_data']) ? Funcoes::formataDataComHora($h['log_data']) : ''; ?></td>
                                <td><?= !empty($h['nome']) ? $h['nome'] : ''; ?></td>
                                <td><?= !empty($h['log_descricao']) ? $h['log_descricao'] : ''; ?></td>
                                <td>
                                    <a class="botaoLoad   btn btn-success modalOpen" id="modulos/desenvolvimento/src/views/formularios/modalDesevolvimento.php?id=<?= $h['log_id'] ?>" data-target="#modalDesenvolvimento">
                                        Visualizar
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>	
                </table>
            </div>
	        	<div class="row">
	        		<div class="col-xs12 col-sm-12 col-md-12 col-lg-12">
	        			<div class="form-group">
		        				<ul class="nav nav-pills">
	                                <li role="presentation" class="active resposta" id="3"><a>Aceitar</a></li>
	                                <li role="presentation" class="resposta" id="2"><a>Recusar</a></li>
	                            </ul>
	        			</div>
	        		</div>
	        	</div>
	        	<div class="row" id="motivo" style="display:none;">
	        		<div class="col-xs12 col-sm-12 col-md-12 col-lg-12">
	        			<div class="form-group">
	        				<label>Descrição do Problema:</label>
	        				<textarea rows="5" class="form-control" name="log_motivo" id="log_motivo"></textarea>
	        			</div>
	        		</div>
	        	</div>
	        	<div class="row">
	        		<div class="col-xs12 col-sm-12 col-md-12 col-lg-12">
	        			<div class="form-actions">
	        				
	        				<input type="hidden" name="desenvolvimento_id" value="<?=$id_solicitacao;?>">
	        				<input type="hidden" name="acao" value="respostaHelp">
	        				<input type="hidden" name="desenvolvimento_help" value="3" id="valueResposta">
	        			
	        				<button type="submit" class="btn  btn-primary">Salvar</button>
	        				
	        				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	        				
	        			</div>
	        		</div>
	        	</div>
        	</form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalDesenvolvimento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<script type="text/javascript" language="javascript">
    $(function () {
    	$(".modalOpen").click(funcoes.carregarModal);
    	$(".resposta").click(function(){
    		$("ul.nav-pills li.active").removeClass("active");
    		$(this).addClass("active");

    		var respota = $(this).attr("id");
    			$("#valueResposta").val(respota);

    		if(respota == 2){
        		$("#motivo").removeAttr("style");
        		$("#log_motivo").prop("required", true);
    		}
    		else {
    			$("#motivo").attr("style", "display:none;");
    			$("#log_motivo").removeAttr("required");
    		}
        });
    });
</script>