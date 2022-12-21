<?php
include_once __DIR__ . '/../../controllers/controller_frm_solicitacao.php';
?>
<div class="panel panel-primary">
    <div class="panel-heading "><?=$nivel_solicitacao == 2 ? "Suporte" : "Desenvolvimento";?> / Solicitação:</div>
    <div class="panel-body">
        <!--TRATAMENTO DE ERROR-->
        <?php if ($r) { ?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12  col-lg-12">
                    <?= Funcoes::tratarError(['error' => 'alert-success', 'mensagem' => ' Registrado com sucesso!']); ?>
                </div>
            </div>
        <?php } ?>
        <!--FORMULARIO-->
        <form method="post" action="modulos/desenvolvimento/src/controllers/desenvolvimento.php" id="os_desenvolvimento" enctype="multipart/form-data" class="loadForm">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group ">
                        <?php if (!empty($desenvolvimento_id)) { ?>
                            <strong>N° OS : <?=$id_solicitacao;?></strong><?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>Titulo:</label> 
                        <input type="text" name="desenvolvimento_modulo" id="modulo" class="form-control" <?= $permissaoCampoUsuario; ?> value="<?=($desenvolvimento->get("desenvolvimento_modulo")); ?>" maxlength="200"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Solicitante:</label> 
                        <input type="text" name="solicitante"  value="<?= empty($desenvolvimento_usuario) ? $nome : $desenvolvimento->get("desenvolvimento_usuario"); ?>" class="form-control" disabled="disabled" readonly />
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Setor:</label> 
                        <input type="text" name="setor" value="<?= empty($desenvolvimento_setor) ? $setor : $desenvolvimento->get("desenvolvimento_setor"); ?>"  class="form-control" disabled />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label>Ramal:</label> 
                        <input type="text" name="desenvolvimento_ramal" class="form-control" <?= $permissaoCampoUsuario; ?> value="<?= $desenvolvimento->get("desenvolvimento_ramal"); ?>" required="required"/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <div class="form-group">
                        <label>E-mail:</label> 
                        <input type="email" name="desenvolvimento_email" class="form-control" <?= $permissaoCampoUsuario; ?> value="<?= $email; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Nivel de Prioridade:</label> <select
                            name="desenvolvimento_nivel" class="form-control"
                            <?= $campoNivel; ?>>
                            <option value="3" <?= $desenvolvimento->get("desenvolvimento_nivel", true) == 3 ? 'selected' : null; ?>>Baixo</option>
                            <option value="2" <?= $desenvolvimento->get("desenvolvimento_nivel", true) == 2 ? 'selected' : null; ?>>Normal</option>
                            <option value="1" <?= $desenvolvimento->get("desenvolvimento_nivel", true) == 1 ? 'selected' : null; ?>>Urgente</option>
                        </select>
                    </div>
                </div>
                <?php if ($ti || $supervisor) { ?>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Tipo de Solicitação:</label> 
                            <select  name="desenvolvimento_tipo" class="form-control" <?= ($supervisor && $solicitacaoStatus  == 0) || $validaStatus ? "required" : "disabled"; ?>>
                                <?php if($nivel_solicitacao == 1){?>
                                <option></option>
                                <option value="1" <?= $desenvolvimento->get("desenvolvimento_tipo", true) == 1 ? 'selected' : null; ?>>Bug</option>
                                <option value="2" <?= $desenvolvimento->get("desenvolvimento_tipo", true) == 2 ? 'selected' : null; ?>>Projeto</option>
                                <option value="4" <?= $desenvolvimento->get("desenvolvimento_tipo", true) == 4 ? 'selected' : null; ?>>Auxílio</option>
                                <?php } else {?>
                                <option value="3" <?= $desenvolvimento->get("desenvolvimento_tipo", true) == 3 ? 'selected' : null; ?>>Manutenção</option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                <?php } ?>
                <?php if (($solicitacaoStatus != 0) || $supervisor) { ?>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Status:</label> 
                            <select name="desenvolvimento_status"  class="form-control" <?= $status; ?> id="status">
                                <?php if ($solicitacaoStatus == 0) { ?>
                                    <option value="" <?= $solicitacaoStatus == 0 ? 'selected' : 'selected'; ?>></option>
                                <?php } ?>
                                <?php if (($supervisor && $solicitacaoStatus < 1) || ($solicitacaoStatus == 1)) { ?>
                                    <option value="1" <?= $solicitacaoStatus == 1 ? 'selected' : null; ?>>Aprovada</option>
                                <?php } ?>
                                <?php if (($supervisor && $solicitacaoStatus <= 1) || $solicitacaoStatus == 6 || $solicitacaoStatus == 8) { ?>
                                    <option value="6" <?= $solicitacaoStatus == 6 ? 'selected' : null; ?>>Reprovada</option>
                                <?php } ?>
                                <?php if (in_array($solicitacaoStatus, array(2,3,7,8))) { ?>
                                    <option value="2" <?= $solicitacaoStatus == 2 ? 'selected' : null; ?>>Em Andamento</option>
                                <?php } ?>
                                <?php if ($solicitacaoStatus == 8) { ?>
                                    <option value="8" <?= $solicitacaoStatus == 8 ? 'selected' : null; ?>>Em Análise</option>
                                <?php } ?>
                                <?php if ((($ti || ($supervisor && $validaUsuario)) && $solicitacaoStatus >= 1) || $solicitacaoStatus == 4) { ?>
                                    <option value="4" <?= $solicitacaoStatus == 4 ? 'selected' : null; ?>>Em Testes</option>
                                <?php } ?>
                                <?php if ((($ti || ($supervisor && $validaUsuario)) && $solicitacaoStatus >= 1) || $solicitacaoStatus == 3) { ?>
                                    <option value="3" <?= $solicitacaoStatus == 3 ? 'selected' : null; ?>>Parada</option>
                                <?php } ?>
                                <?php if ($solicitacaoStatus == 7) { ?>
                                    <option value="7" <?= $solicitacaoStatus == 7 ? 'selected' : null; ?>>Bug</option>
                                <?php } ?>
                                <?php if ($solicitacaoStatus == 5) { ?>
                                    <option value="5" <?= $solicitacaoStatus == 5 ? 'selected' : null; ?>>Finalizada</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>   
                <?php } ?>
            </div>
            <div class="row" <?=$desenvolvimento->get("desenvolvimeno_log_motivo") == NULL ? "style='display:none;'" : null; ?> id="divMotivo">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>Descrição Status: <?=$desenvolvimento->get("log_descricao");?></label>
                        <textarea name="log_motivo" class="form-control" disabled id="motivo"><?= $desenvolvimento->get("desenvolvimeno_log_motivo"); ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>Requisição:</label>
                        <textarea name="desenvolvimento_requisicao" rows="5" class="form-control" <?= $permissaoCampoUsuario; ?>><?= $desenvolvimento->get("desenvolvimento_requisicao"); ?></textarea>
                    </div>
                </div>
            </div>
            <?php if (($ti && !empty($desenvolvimento_obs_supervisor)) || $supervisor) { ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Obs Supervisor:</label>
                            <textarea name="desenvolvimento_obs_supervisor" rows="5" class="form-control" <?= !$supervisor && !$ti && empty($desenvolvimento_obs_supervisor) ? "style='display:none;'" : ""; ?>
                                      <?= !$supervisor || $solicitacaoStatus > 1 && $solicitacaoStatus != 8 || $acao == "visualizar" ? "disabled" : ""; ?>><?= $desenvolvimento->get("desenvolvimento_obs_supervisor"); ?></textarea>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (($desenvolvimento->get("desenvolvimento_programador") != "")) { ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Consultor:</label> 
                            <input type="text" name="programador" id="programador" class="form-control" disabled="disabled" value="<?= $desenvolvimento->get("desenvolvimento_programador"); ?>" />
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (($desenvolvimento->get("desenvolvimento_descricao") != null) || ($desenvolvimento->get("desenvolvimento_descricao") == null && $permissaoCampoProgramador != 'disabled="disabled"')) { ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Descrição:</label>
                            <textarea name="desenvolvimento_descricao" id="descricao" rows="5" class="form-control" <?= $permissaoCampoProgramador; ?>><?= $desenvolvimento->get("desenvolvimento_descricao"); ?></textarea>
                        </div>
                    </div>
                </div>
            <?php }?>
            <?php if ($totalAnexos < 2 && $solicitacaoStatus == 0 && $id_usuario == $_SESSION['user_info']['id_usuario']) { ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            	<label>Imagens:</label>
                            	<br>
                             	<img src="public/img/empty-img.gif" id="img0" width="120" height="120">
                             	<br>
	                             	<a id="adicionarImg0" class="btn btn-success btn-sm selecionarArquivo"><span class="glyphicon glyphicon-plus"></span></a>
	                             	<a id="excluirImg0" class="btn btn-danger btn-sm excluirImagem"><span class="glyphicon glyphicon-remove"></span></a>
	                             	<input type="file" name="anexo0"  multiple id="anexo0" accept="image/*" maxlength="2"/>
                             	<br>
                             	<br>
                             	<?php if($totalAnexos != 1){?>
                             	<img src="public/img/empty-img.gif" id="img1" width="120" height="120">
                             	<br>
                             		<a id="adicionarImg1" class="btn btn-success btn-sm selecionarArquivo"><span class="glyphicon glyphicon-plus"></span></a>
	                             	<a id="excluirImg1" class="btn btn-danger btn-sm excluirImagem"><span class="glyphicon glyphicon-remove"></span></a>
                            		<input type="file" name="anexo1"  multiple id="anexo1" accept="image/*" maxlength="2"/>
                            	<?php }?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty($anexos)) { ?>
                <div class="tables-responsive">
                    <table class="table table-bordered   table-striped  table-hover" id="mostraHistorico">
                        <thead>
                            <tr>
                                <th>Anexo</th>
                                <?php if ($solicitacaoStatus == 0 && !$supervisor && !$ti) { ?>
                                    <th width='5%'>Ação</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php foreach ($anexos as $a) { ?> 
                                <tr>
                                    <td>
                                    	<a  href="fpdf/solicitacao/imagensSolicitacao/<?= $a['anexo_url']; ?>" target="_blank"><?= $a['anexo_url']; ?></a></td>
                                        <?php if ($solicitacaoStatus == 0 && !$supervisor && !$ti) { ?>
                                        <td>
                                        	<a href="modulos/desenvolvimento/src/controllers/desenvolvimento.php?id=<?= $a['anexo_id']; ?>&acao=deletarAnexo&id_solicitacao=<?= $desenvolvimento->get("desenvolvimento_id"); ?>&descricao=<?=$a['anexo_url'];?>"  class="btn btn-danger">Deletar</a></td>
                                        <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 ">
                    <div class="form-group">
                        <label>Data Criação:</label>
                        <div class="input-group">
                            <span class="input-group-addon"> 
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span> 
                            <input type="text" name="desenvolvimento_data_criacao" class="form-control" disabled="disabled"  value="<?= $dataCriacao; ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 ">
                    <div class="form-group">
                        <label>Data Inicialização:</label>
                        <div class="input-group">
                            <span class="input-group-addon"> 
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span> 
                            <input type="text" name="desenvolvimento_data_inicio" class="form-control" disabled="disabled" value="<?= $desenvolvimento->get("desenvolvimento_data_inicio"); ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 ">
                    <div class="form-group">
                        <label>Data Finalização:</label>
                        <div class="input-group">
                            <span class="input-group-addon"> 
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span> 
                            <input type="text" name="desenvolvimento_data_final" class="form-control" disabled="disabled" value="<?= $desenvolvimento->get("desenvolvimento_data_final"); ?>" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <input type="hidden" name="desenvolvimento_id_usuario" value="<?= $id_usuario; ?>" /> 
                <input type="hidden" name="desenvolvimento_nivel_solicitacao" value="<?= $nivel_solicitacao; ?>" /> 
                <input type="hidden" name="desenvolvimento_id" value="<?= $id_solicitacao; ?>" />
                <input type="hidden" name="tab" value="<?=filter_input(INPUT_GET, "tab");?>" />
                <input type="hidden" name="status" value="<?=filter_input(INPUT_GET, "status");?>" />
                <input type="hidden" name="acaoBusca" value="<?=filter_input(INPUT_GET, "acaoBusca");?>" />
                <?= !empty($dataInicio) ? '<input type="hidden" name="desenvolvimento_data_inicio"  value="' . Funcoes::formataDataComHoraSQL($dataInicio) . '"/>' : ''; ?>
                <input type="hidden" name="acao" value="<?= $acao; ?>" id="acao" />

                <?php
                if ($salvar != 'hidden') {
                    ?>
                    <button type="submit" class="btn btn-primary botaoLoadForm">Salvar</button>
                <?php } else if($solicitacaoStatus == 4 && $desenvolvimento->get("desenvolvimento_id_usuario") == $_SESSION['user_info']['id_usuario']){?>
                	<a href="modulos/desenvolvimento/src/controllers/desenvolvimento.php?acao=finalizarSolicitacao&id=<?=$desenvolvimento->get("desenvolvimento_id");?>" class="btn btn-success">Testado, ok</a>
                	<a id="modulos/desenvolvimento/src/views/formularios/modalStatus.php?id=<?=$desenvolvimento->get("desenvolvimento_id");?>&acao=bug" class="btn btn-danger modalOpen" data-target="#modal">Testado, falha</a>
                <?php }?>
                <?php if($solicitacaoStatus < 3 && $supervisor && $desenvolvimento->get("desenvolvimento_id_programador") == null && $desenvolvimento->get("desenvolvimento_id") != null){?>
                	<a href="modulos/desenvolvimento/src/controllers/desenvolvimento.php?acao=trocarNivel&id_solicitacao=<?=$desenvolvimento->get("desenvolvimento_id");?>&nivel=<?=$desenvolvimento->get("desenvolvimento_nivel_solicitacao", true);?>&tab=<?=filter_input(INPUT_GET, "tab");?>" class="btn  btn-danger"><?=$desenvolvimento->get("desenvolvimento_nivel_solicitacao", true) == 1 ? "Suporte" : "Desenvolvimento";?></a>
                <?php }?>
                <?php if ($ti && $desenvolvimento->get("desenvolvimento_id") != NULL  && $acao != "visualizar" && $solicitacaoStatus != 0 && $solicitacaoStatus != 4) { ?>
                    <a id="modulos/desenvolvimento/src/views/formularios/modalHelpfrm.php?desenvolvimento_id=<?=$desenvolvimento->get("desenvolvimento_id");?>" class="btn btn-warning modalOpen botaoLoad" data-target="#modal">Help</a>
                <?php } ?>
                <?php if($solicitacaoStatus < 2 && $solicitacaoStatus != 0 && $supervisor && $desenvolvimento->get("desenvolvimento_id_programador") == null && $desenvolvimento->get("desenvolvimento_id") != null){?>
					<a href="modulos/desenvolvimento/src/controllers/desenvolvimento.php?acao=atribuirProgramador&id=<?=$_SESSION['user_info']['id_usuario'];?>&id_solicitacao=<?=$desenvolvimento->get("desenvolvimento_id");?>&tela=1&tab=<?=filter_input(INPUT_GET, "tab");?>" class="btn  btn-primary">Atribuir</a>
				<?php }?>
				<?php if($solicitacaoStatus == 2 || $solicitacaoStatus == 3 || $solicitacaoStatus == 7 && $acao != "visualizar"){?>
					<a id="modulos/desenvolvimento/src/views/formularios/modalStatus.php?id=<?=$desenvolvimento->get("desenvolvimento_id");?>&acao=cancelarSolicitacao" class="btn btn-danger modalOpen" data-target="#modal">Cancelar Solicitação</a>
				<?php }?>
                <?php if ($acao != "cadastrarSolicitacao") { ?>
                    <a id="botaoHistorico" class="btn btn-info">Histórico </a> 
                    <a href="fpdf/solicitacao/index.php?id=<?= $desenvolvimento->get("desenvolvimento_id"); ?>" class="btn btn-success"> Imprimir </a>
                    <a id="modulos/desenvolvimento/src/views/formularios/modalEmail.php?id=<?=$desenvolvimento->get("desenvolvimento_id");?>&tab=<?=filter_input(INPUT_GET, "tab");?>" class="btn btn-default modalOpen" data-target="#modal">Enviar Por E-mail</a>
                <?php } ?>	
                <a href="index.php?pg=23#<?=filter_input(INPUT_GET, "tab");?>" class="btn btn-default">Voltar</a>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-primary" id="historico" style="display: none;">
    <div class="panel-heading ">Histórico</div>
    <div class="panel-body"> 
        <?php if ($historico) { ?>
            <div class="table-responsive">
                <table class="table table-bordered   table-striped  table-hover"
                       id="mostraHistorico">
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
                                	<a class="botaoLoad   btn btn-success modalOpen" id="modulos/desenvolvimento/src/views/formularios/modalDesevolvimento.php?id=<?= $h['log_id'] ?>" data-target="#modal"> Visualizar </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" align="center">Registros Encontrados: <?= $total; ?></td>
                        </tr>
                    </tfoot>
                </table>
                <?= $objPaginacao->MontaPaginacao(); ?>
            </div>
            <?php
        } else {
            Funcoes::Nregistro();
        }
        ?>
    </div>
</div>
<script type="text/javascript" language="javascript">
    $(function () {

        $("#os_desenvolvimento").submit(function () {

            var status = $("#status").val();

            if (status == 4) {
                var verifica = true;
                if ($("#descricao").val() == "") {
                    verifica = false;
                }
                if ($("#programador").val() == "") {
                    verifica = false;
                }
                if (!verifica) {
                    alert("Você deve preencher todos os dados antes de finalizar!");
                    
                } else 
                	$(".botaoLoadForm").attr("disabled", true);
                             
                return verifica;
              
            }

            if($("#anexo")[0].files.length > 2) {
                alert("Você só pode selecionar no máximo 2 imagens");
                return false;
            }

        });

        $("#status").change(function () {
            $("#divMotivo").removeAttr("style");
            $("#motivo").removeAttr("disabled");
            $("#motivo").val("");

            if($(this).val() == 3)
            	 $("#motivo").attr("required", true);
            else
            	 $("#motivo").attr("required", false);
        });

        $("#botaoHistorico").click(function () {
            if ($("#historico").attr("style") !== undefined)
                $("#historico").removeAttr("style");
            else
                $("#historico").attr("style", "display:none");

        });

        var imageFile = $('.selecionarArquivo');
    	var inputFile = $('#anexo0').hide();
    	var inputFile = $('#anexo1').hide();
    	var indice = 0;

    	imageFile.click(function() {
    		indice =  $(this).attr("id");
    		indice = indice.charAt(indice.length-1);
    		$("#anexo"+indice).click().change(function() {
    			var reader = new FileReader();
                reader.onload = function (e) {
     				$("#img"+indice).attr("src", e.target.result);
                }
                reader.readAsDataURL($("#anexo"+indice)[0].files[0]);
    		});
    	});

    	$(".excluirImagem").click(function(){
    		indice =  $(this).attr("id");
    		indice = indice.charAt(indice.length-1);
    		$("#img"+indice).attr("src", "public/img/empty-img.gif");
    		$("#anexo"+indice).val("");
        });

    });
</script>