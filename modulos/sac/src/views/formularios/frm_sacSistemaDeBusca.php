<div class="panel panel-primary">
    <div class="panel-heading "> Pesquisar Clientes</div>
    <div class="panel-body"> 
        <form action="index.php?pg=10#listarClientes" method="get">
            <div class="row">
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label>Status:</label>
                            <select name="status" class="form-control">
                                <option value="">Selecione...</option>
                                <option value="on" <?= ($selectStatus == 'on') ? 'selected' : ''; ?>>Ativo</option>
                                <option value="off" <?= ($selectStatus == 'off') ? 'selected' : ''; ?>>Inativo</option>
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
                            <option value="chip" <?= ($selectFiltro == 'chip') ? 'selected' : null; ?>>Chip</option>
                            <option value="modulo" <?= ($selectFiltro == 'modulo') ? 'selected' : null; ?>>Módulo</option>
                            <option value="cidade" <?= ($selectFiltro == 'cidade') ? 'selected' : null; ?>>Cidade</option>
                            <option value="estado" <?= ($selectFiltro == 'estado') ? 'selected' : null; ?>>Estado</option>
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
<div class="panel panel-primary">
    <div class="panel-heading "> Listar Clientes</div>
    <div class="panel-body">
        <?php include_once "lst_sacSistemaDeBusca.php"; ?>
    </div>
</div>
