<div class="panel panel-primary">
    <div class="panel-heading "> Pesquisar Os</div>
    <div class="panel-body"> 
        <form action="index.php?pg=10#listarCliente" method="get">
            <div class="row">
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label>Situação OS:</label>
                            <select name="situacao_os" class="form-control">
                                <option value="">Selecione...</option>
                                <option value="1" <?= ($selectSituacao == 1) ? 'selected' : ''; ?>>Aberto</option>
                                <option value="2" <?= ($selectSituacao == 2) ? 'selected' : ''; ?>>Em Andamento</option>
                                <option value="3" <?= ($selectSituacao == 3) ? 'selected' : ''; ?>>Finalizado</option>
                            </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label>Tipo OS:</label>
                        <select name="tipo_os" class="form-control">
                            <option value="">Selecione...</option>
                            <option value="1" <?= ($selectTipo == 1) ? 'selected' : ''; ?>>Manutenção</option>
                            <option value="2" <?= ($selectTipo == 2) ? 'selected' : ''; ?>>Instalação</option>
                            <option value="3" <?= ($selectTipo == 3) ? 'selected' : ''; ?>>Reclamação</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label>Filtro:</label>
                        <select name="selectFiltro" id="selectFiltro" class="form-control">
                            <option value="">Selecione um Filtro</option>
                            <option value="Razao_Social" <?= ($selectFiltro == 'Razao_Social') ? 'selected' : null; ?>>Razão Social</option>
                            <option value="placa" <?= ($selectFiltro == 'placa') ? 'selected' : null; ?>>Placa</option>
                            <option value="cpf_cnpj" <?= ($selectFiltro == 'cpf_cnpj') ? 'selected' : null; ?>>CPF/CNPJ</option>
                            <option value="os" <?= ($selectFiltro == 'os') ? 'selected' : null; ?>>Protocolo da OS</option>
                            <option value="cidade" <?= ($selectFiltro == 'cidade') ? 'selected' : null; ?>>Cidade</option>
                            <option value="estado" <?= ($selectFiltro == 'estado') ? 'selected' : null; ?>>Estado</option>
                            <option value="credenciado" <?= ($selectFiltro == 'credenciado') ? 'selected' : null; ?>>Credenciado</option>
                            <option value="tecnico" <?= ($selectFiltro == 'tecnico') ? 'selected' : null; ?>>Técnico</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Pesquisar:</label>
                        <input type="text" name="campo_pesquisa" id="campo_pesquisa" class="form-control"/> 
                    </div>
                </div>
                <div class="col-xs-10 col-sm-3 col-md-3 col-lg-3" style="position:relative; top:25px; margin-bottom:30px">
                    <div class="form-actions">
                        <input type="hidden" name="acao" value="Pesquisar" />
                        <input type="hidden" name="pg" value="<?= $pg; ?>">  

                        <button  type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-search"></span> Pesquisar
                        </button>

                        <button type="reset" class="btn btn-danger limpa">
                            <span class="glyphicon glyphicon-trash"></span> Limpar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

