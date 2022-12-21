<?php
//controllers/controller_view_frm_pedidoComissao.php
echo ($result == 'on') ? '<div class="alert alert-success">Registrado com sucesso!</div>' : null; 
if ($lista_planilha) { ?>
    <div class="panel panel-primary">
        <div class="panel-heading ">Comissão / Adicionar / Gerenciar planilhdas de Comissões</div>
        <div class="panel-body"> 
            <form  action="modulos/pedidoComissao/src/controllers/pedido_comissao.php" method="post" class="loadForm">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label><strong>Nome:</strong></label>
                            <select name="pcf_nome" id="pcf_nome" class="form-control"  required="">
                                 <option selected="selected" value=""> -- Selecione -- </option>
                                    <?php 
                                        foreach ($ArrayListNomes as $k=> $v){
                                            switch ($v['id_empresa']){
                                            case'1':$empresa = 'VPSP';break;
                                            case'2':$empresa = 'VH';break;
                                            case'3':$empresa = 'VP - Alarmes';break;
                                            case'4':$empresa = 'VP - Guaíba'; break;
                                            case'5':$empresa = 'Volpmann Matriz';break;
                                            case'6':$empresa = 'Volpmann - Filial'; break;
                                            case'7':$empresa = 'Volpato - Matriz'; break;
                                            case'8':$empresa = 'Volpato - Tramandaí'; break;
                                            case'9':$empresa = 'Volpato - Filial'; break;
                                            case'10':$empresa = 'Easyseg'; break;
                                        }                                    
                                    ?>
                                    <option value="<?=$v['nome'].'_'.$v['id_empresa'];?>" <?php echo ($objetopcf->get_pcf_nome()==$v['nome'])?'selected':''?> ><?="{$v['nome']} - ($empresa)";?>  </option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>CTPS:</strong></label>
                            <input type="text" name="pcf_ctps" id="pcf_ctps" class="form-control" value="<?=$objetopcf->get_ctpsFuncionario();?>" required/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="form-group">
                            <label><strong>Matrícula:</strong></label>
                            <input type="text" name="pcf_matricula" id="pcf_matricula" class="form-control"  value="<?=$objetopcf->get_matriculaFuncionario();?>" required>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                        <div class="form-group">
                            <label><strong>Periodo:</strong></label>
                            <select id="pcf_periodo" name="pcf_periodo" class="form-control"  required>
                                <option selected="selected" value="">Selecione</option>
                                <option value="JAN / FEV" <?=$objetopcf->get_pcf_periodo() == "JAN / FEV" ? "selected" : null;?>>JAN / FEV</option>
                                <option value="FEV / MAR" <?=$objetopcf->get_pcf_periodo() == "FEV / MAR" ? "selected" : null;?>>FEV / MAR</option>
                                <option value="MAR / ABR" <?=$objetopcf->get_pcf_periodo() == "MAR / ABR" ? "selected" : null;?>>MAR / ABR</option>
                                <option value="ABR / MAI" <?=$objetopcf->get_pcf_periodo() == "ABR / MAI" ? "selected" : null;?>>ABR / MAI</option>
                                <option value="MAI / JUN" <?=$objetopcf->get_pcf_periodo() == "MAI / JUN" ? "selected" : null;?>>MAI / JUN</option>
                                <option value="JUN / JUL" <?=$objetopcf->get_pcf_periodo() == "JUN / JUL" ? "selected" : null;?>>JUN / JUL</option>
                                <option value="JUL / AGO" <?=$objetopcf->get_pcf_periodo() == "JUL / AGO" ? "selected" : null;?>>JUL / AGO</option>
                                <option value="AGO / SET" <?=$objetopcf->get_pcf_periodo() == "AGO / SET" ? "selected" : null;?>>AGO / SET</option>
                                <option value="SET / OUT" <?=$objetopcf->get_pcf_periodo() == "SET / OUT" ? "selected" : null;?>>SET / OUT</option>
                                <option value="OUT / NOV" <?=$objetopcf->get_pcf_periodo() == "OUT / NOV" ? "selected" : null;?>>OUT / NOV</option>
                                <option value="NOV / DEZ" <?=$objetopcf->get_pcf_periodo() == "NOV / DEZ" ? "selected" : null;?>>NOV / DEZ</option>
                                <option value="DEZ / JAN" <?=$objetopcf->get_pcf_periodo() == "DEZ / JAN" ? "selected" : null;?>>DEZ / JAN</option>
                            </select>
                        </div>
                    </div>
               </div>
               <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                        <div class="form-group">
                            <label><strong>Ano:</strong></label>
                            <select id="pcf_ano" name="pcf_ano" class="form-control" required>
                                <?php
                                for ($i = date('Y') - 1; $i <= date('Y')+1; $i++){ ?>
                                	<option value="<?=$i;?>" <?=$objetopcf->get_pcf_ano() == $i ? 'selected' : '';?>><?=$i;?></option><?php 
								}
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="form-group">
                            <label><strong>Planilha:</strong></label>
                            <select  name="pcf_planilha" class="form-control" required>
                                <option selected="selected" value=""   >Selecione</option>
                                <?php foreach ($lista_planilha as $li): ?>
                                    <option value="<?=$li["planilha_comissoes_id"];?>" <?=$objetopcf->get_pcf_planilha() == $li["planilha_comissoes_id"] ? "selected" : null;?>><?= $li["planilha_comissoes_nome"];?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
               </div>
			   
               <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-actions">
                            <input type="hidden" name="pcf_id_supervisor" id="pcf_id_supervisor" value="<?= $id_u ?>">
                            <input type="hidden" name="pcf_id_usuario" 	  id="pcf_id_supervisor" value="<?= $id_u ?>">
                            <input type="hidden" name="pcf_id" value="<?=$objetopcf->get_pcf_id();?>">
                            <input type="hidden" name="acao" value="insertPlanilha">
                            <button  type="submit" class="btn btn-primary">
                                 Salvar
                            </button>
                            <button type="reset" class="btn btn-danger limpa">
                                Limpar
                            </button>
                        </div>
                    </div>
               </div>
            </form>
        </div>
    </div>
<?php 
} else { ?>
    <div class="alert alert-danger" role="alert">ATENÇÃO: Entre em contato com o Suporte!</div>
<?php
}

?>
  