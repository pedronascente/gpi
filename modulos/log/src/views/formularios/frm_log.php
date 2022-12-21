<div class="panel panel-primary">
    <div class="panel-heading "> Lista logs</div>
    <div class="panel-body">
        <div class="row">
            <form method="GET" action="">
                <?php if ($desenvolvedor && $permissao) { ?>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                        <div class="form-group">
                            <label>Tabela:</label>
                            <select name="id_tabela" class="form-control">
                                <option value="">Selecione ...</option>
                                <?php
                                if (!empty($listaTabelas)) {
                                    foreach ($listaTabelas as $tabela) {
                                        ?>
                                        <option value="<?= $tabela['log_tabelas_ra']; ?>"><?= $tabela['log_tabelas_desc']; ?></option>
                                    <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>		
                    </div>
<?php } ?>
                <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3">
                    <label>Período:</label>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="data1" class="form-control datepicker">
                            <span class="input-group-addon">até</span>
                            <input type="text" name="data2" class="form-control datepicker">
                        </div>
                    </div>		
                </div>
                <div class="col-xs-12 col-sm-5 col-md-3 col-lg-2">
                    <label>Texto:</label>	
                    <div class="form-group">
                        <input type="text" name="busca" class="form-control">
                    </div>		
                </div>
                <div class="col-xs-12 col-sm-5 col-md-3 col-lg-2">
                    <br>
                    <div class="form-actions">
                        <input type="hidden" name="pg" value="41">
                        <input type="hidden" name="acaoP" value="pesquisar">
                        <input type="hidden" name="acao" value="<?=$acao;?>">
                        <button class="btn btn-primary" type="submit">Filtrar</button>
                    </div>		
                </div>
            </form>
        </div>
    </div>
</div>
