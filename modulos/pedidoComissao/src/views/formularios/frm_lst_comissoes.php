<div class="panel panel-primary">
    <div class="panel-heading ">Comissão  / Pesquisa :</div>
    <div class="panel-body"> 
        <form method="get" name="frmRelatorio_comissao" id="frmRelatorio_comissao" action="index.php?pg=9">
            <div class="rows">
                <div class="col-sm-2 col-xs-12 col-lg-2 col-md-2">
                    <div class="form-group">
                        <label><strong>Campo:</strong></label>
                        <input type="text" id="txt_nome" name="texto_busca" size="40"   value="<?= isset($DadosGet['texto_busca']) ? $DadosGet['texto_busca'] : null ?>" class="form-control"/>
                    </div>
                </div>
                <div class="col-sm-1 col-xs-12 col-lg-1 col-md-1">
                    <div class="form-group">
                        <label><strong>Status:</strong></label>
                        <select name="pedido_comissao_status" id="pedido_comissao_status" class="form-control">
                            <option value="">Todos</option>
                            <option value="arquivados"  <?=isset($DadosGet['pedido_comissao_status']) && $DadosGet['pedido_comissao_status'] == 'arquivados' ? 'selected' : null; ?>>Arquivado</option> 
                            <option value="conferencia"  <?=isset($DadosGet['pedido_comissao_status']) && $DadosGet['pedido_comissao_status'] == 'conferencia' ? 'selected' : null; ?>>Conferencia</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12 col-lg-2 col-md-2">
                    <div class="form-group">
                        <label><strong>Péríodo:</strong></label>
                        <div class="input-group input-append date datepicker">
                            <input type="text" name="dt_inicial" id="dt_inicial" class="form-control" value="<?=isset($DadosGet['dt_inicial']) ? $DadosGet['dt_inicial'] : null;?>" />
                              <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12 col-lg-2 col-md-2">
                    <div class="form-group">
                        <label><strong>Até:</strong></label>
                        <div class="input-group input-append date datepicker">
                            <input type="text" name="dt_final" id="dt_final" class="form-control" value="<?=isset($DadosGet['dt_final']) ? $DadosGet['dt_final'] : null;?>" />
                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-12 col-lg-3 col-md-3">
                <br>
                    <div class="form-actions">
                        <input type="hidden" value="Pesquisar" name ="acao">
                        <input type="hidden" value="9" name ="pg">
                        <button  type="submit" class="btn btn-primary">
                         Pesquisar
                        </button>
                        <button type="reset" class="btn btn-danger limpa">
                             Limpar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div><!--panel-body-->
</div><!--panel-primary-->