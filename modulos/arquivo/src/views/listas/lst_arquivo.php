<div class="panel panel-primary">
    <div class="panel-heading ">Pesquisar Arquivos</div>
    <div class="panel-body"> 
        <form method="GET" action="">
            <div class="rows">
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label>Filtro:</label>
                        <select name="filtro" class="form-control">
                            <option></option>
                            <option value="cliente">Cliente</option>
                            <option value="placa">Placa</option>
                            <option value="cpf_cnpj">CPF/CNPJ</option>
                            <option value="arquivo">Arquivo</option>
                            <option value="gaveta">Gaveta</option>
                            <option value="pasta">Pasta</option>
                        </select>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Campo:</label>
                        <input type="text" name="texto" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label>Armário:</label>
                        <select name="id_armario" class ="form-control listaArquivo" id="selectArquivo">
                            <option value="-1"></option>
                            <?php if ($armarios) { ?>
                                <?php foreach ($armarios as $a) { ?>
                                    <option value="<?= $a['arquivo_armario_id'] ?>"><?= $a['arquivo_armario_desc'] ?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label>Gaveta:</label>
                        <select name="id_gaveta" required class ="form-control optionVazio" id="selectGaveta">
                            <option value="-1"></option>
                            <?php if ($gavetas) { ?>
                                <?php foreach ($gavetas as $g) { ?>
                                    <option value="<?= $g['arquivo_gaveta_id'] ?>"><?= $g['arquivo_gaveta_desc']; ?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <br>
                    <div class="form-actions">
                        <input type="hidden" name="pg" value="24">

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
    <div class="panel-heading ">Listar Arquivos</div>
    <div class="panel-body"> 	
<?php if ($lista) { ?>
				<div class="well well-sm">
					<span class="glyphicon glyphicon-eye-open"></span> => Visualizar Log &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span class="glyphicon glyphicon-pencil"></span> => Editar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span class="glyphicon glyphicon-trash"></span> => Excluir
				</div>
				<div class="table-responsive">
                <table class="table table-bordered table-hover table-striped dataTable">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>CPF/CNPJ</th>
                            <th>Placas</th>
                            <th>Arquivo</th>
                            <th>Gaveta</th>
                            <th>Pasta</th>
                            <th width="2%">Log</th>
                            <th width="5%" colspan="2">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php foreach ($lista as $k => $ar) { ?>
                            <tr align="center">
                                <td><?= !empty($ar['nome_cliente']) ? $ar['nome_cliente'] : ""; ?></td>
                                <td><?= !empty($ar['cnpjcpf_cliente']) ? $ar['cnpjcpf_cliente'] : ""; ?></td>
                                <td><?= !empty($ar['placa']) ? $ar['placa'] : ""; ?></td>
                                <td><?= !empty($ar['arquivo_gaveta_desc']) ? $ar['arquivo_armario_desc'] : ""; ?></td>
                                <td><?= !empty($ar['arquivo_gaveta']) ? $ar['arquivo_gaveta_desc'] : ""; ?></td>
                                <td><?= !empty($ar['arquivo_pasta']) ? $ar['arquivo_pasta'] : ""; ?></td>
                                <td><a class="botaoLoad btn btn-sm btn-success modalOpen" id="modulos/arquivo/src/views/listas/lst_arquivoLog.php?&arquivo_id=<?= $ar['arquivo_id'] ?>" data-target="#modal"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                                <td><a href="index.php?pg=24&acao=editar&id=<?= $ar['arquivo_id']; ?>#cadastro" class="btn  btn-sm btn-info"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                <td><a  class="botaoLoad deletarArquivo btn  btn-sm btn-danger" id="<?= $ar['arquivo_id']; ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
                            </tr>
            <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
            <?php
            var_dump($objPaginacao->MontaPaginacao());
        } else {
            Funcoes::Nregistro();
        }
        ?>
    </div>
