<div class="panel panel-primary">
    <div class="panel-heading "> Dados do Cliente</div>
    <div class="panel-body" id="arquivoCliente"> 
        <form method="post" action="modulos/arquivo/src/controllers/arquivo.php" id="formArquivoCliente">
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>
                            <ul class="nav nav-pills">
                                <li role="presentation" class="<?= $tiPoPessoa == "f" ? "active" : null; ?> <?= $tipoPessoaAcao; ?>" id="f"><a>Física</a></li>
                                <li role="presentation" class="<?= $tiPoPessoa == "j" ? "active" : null; ?> <?= $tipoPessoaAcao; ?>" id="j"><a>Júridica</a></li>
                            </ul>
                        </label>	
                       
                        <?php   

                                if($acao=='editar'){
                                ?>
                                
                                    <input 
                                type="text" 
                                name="cnpjcpf_cliente" 
                                value="<?= isset($cliente['cnpjcpf_cliente']) ? $cliente['cnpjcpf_cliente'] : null; ?>" 
                                class="form-control   disabled" 
                                 required >


                        <?php    
                                }else{

                                ?>
                                
                                <input 
                                type="text" 
                                name="cnpjcpf_cliente" 
                                value="<?= isset($cliente['cnpjcpf_cliente']) ? $cliente['cnpjcpf_cliente'] : null; ?>" 
                                class="form-control  mask_cpf disabled" 
                                id="cnpjcpf_cliente" required >

                        <?php
                                }

                          ?>

                        
                    </div>
                </div>
            </div>
            <div class ="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label id="title_nome">Nomes:</label>
                        <input 
                                type="text" 
                                name="nome_cliente" 
                                value="<?= isset($cliente['nome_cliente']) ? $cliente['nome_cliente'] : null; ?>"  
						        class="form-control disabled" required 
                                id="nome_cliente" <?php //$disabled ?>>	
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"> 
                    <div class="form-actions">
                        <input type="hidden" value="3" name="nivel">
                        <input type="hidden" value="f" name="tipo_pessoa" id="textoTipoPessoa">
                        <?php if ($acao != "editar" || empty($id_cliente)) { ?>
                            <input type="hidden" value="cadastrarCliente" name="acao">
                            <button type="submit" class="btn btn-primary botaoLoadForm" id="btnSalvarCliente">
                                <span class="glyphicon glyphicon-floppy-saved"></span> Salvar
                            </button>
                        <?php }else{ ?>
                            <input type="hidden" value="editarCliente" name="acao">
                            <input type="hidden" value="<?= isset($cliente['id_cliente']) ? $cliente['id_cliente'] : null; ?>" name="id_cliente">
                            <button type="submit" class="btn btn-primary botaoLoadForm" id="btnSalvarCliente">
                                <span class="glyphicon glyphicon-floppy-saved"></span> Editar
                            </button>
                        <?php } ?>
                    </div>
                </div>   
            </div>    
        </form>    	
    </div>
</div>


<div class="panel panel-primary" id="arquivoVeiculos">
    <div class="panel-heading">Veículos</div>
    <div class="panel-body">
        <form method="post" action="modulos/arquivo/src/controllers/arquivo.php" id="formArquivoVeiculos">
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Placa</label>	
                        <input type="text" name="placa" class="form-control "  maxlength="10"  id="placa" required>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-actions">
                        <br>
                        <input type="hidden" name="cliente_ra"  id="arquivo_placas_cliente" value="<?= !empty($id_cliente) ? $id_cliente : null; ?>">
                        <input type="hidden" value="cadastrarPlaca" name="acao">
                        <input type="hidden" value="3" name="nivel">
                        <input type="hidden" value="<?= $id; ?>" name="arquivo_id">
                        <input type="hidden" value="<?= $acao; ?>" name="acaoAtual"> 	
                        <a class="btn btn-primary" id="addPlaca">Salvar</a>
                    </div>
                </div>
            </div>
        </form>
        <table class="table table-bordered table-hover table-striped" id="tablePlacas">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Placa</th>
                    <th>Status</th>
                    <?php if(!empty($id)){?>
                    <th width="10%"></th>
                    <th width="10%"></th>
                    <?php }?>
                </tr>                
            </thead>
            <tbody>
                <?php if ($listaVeiculo) { ?>
                    <?php foreach ($listaVeiculo as $k => $veiculo) { 
                    	$status = !empty($veiculo['veiculo_status']) &&  $veiculo['veiculo_status'] == 2 ? "Inativo" : "Ativo"; 
                    ?>
                        <tr style="background:#FFFFFF" align="center" class="linhaPlacas">
                            <td><?= !empty($veiculo['id_veiculo']) ? $veiculo['id_veiculo'] : "" ?></td>
                            <td><?= !empty($veiculo['placa']) ? $veiculo['placa'] : "" ?></td>
                            <td><?= $status;?></td>
                            <td width="10%">
                                <?php if (empty($veiculo['id_cliente'])) { ?>
                                    <a  class="botaoLoad deletarPlaca btn btn-danger btn-sm" id="<?= $veiculo['id_veiculo'] . "_" . $veiculo['placa'] . "_" . $id; ?>">Deletar</a>
                                <?php } else { ?>
                                    Indisponível
                                <?php } ?>
                           </td>
                           <td>
                                <?php if($veiculo['veiculo_status'] == 1){?>
                                	<a href="modulos/arquivo/src/controllers/arquivo.php?acao=trocarStatusVeiculo&veiculo_status=2&arquivo_id=<?=$id;?>&id_veiculo=<?=$veiculo['id_veiculo'];?>&placa=<?=$veiculo['placa'];?>" class="btn btn-sm btn-primary">Desativar</a>
                                <?php } else {?>
                                	<a href="modulos/arquivo/src/controllers/arquivo.php?acao=trocarStatusVeiculo&veiculo_status=1&arquivo_id=<?=$id;?>&id_veiculo=<?=$veiculo['id_veiculo'];?>&placa=<?=$veiculo['placa'];?>" class="btn btn-sm btn-success">Ativar</a>
                                <?php }?>
                            </td>
                        <tr>
                            <?php
                        }
                    }
                    ?>                   
            </tbody>
        </table>
    </div>
</div>
<div class="panel panel-primary" id="arquivo">
    <div class="panel-heading ">Gerenciador de Arquivos</div>
    <div class="panel-body">
        <form method="post" action="modulos/arquivo/src/controllers/arquivo.php" class="loadForm">	
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Armários:</strong></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Adicionar Armário:</label>
                                <div class="input-group">
                                    <input type="text" id="texto_arquivo" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary botaoLoad" id="adicionarArquivo" type="button">Add</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <select name="arquivo_arquivo"  class ="form-control" id="selectA">
                                        <?php if ($armarios) { ?>
                                            <?php foreach ($armarios as $a) { ?>
                                                <option value="<?= $a['arquivo_armario_id'] . "_" . $a['arquivo_armario_desc'] ?>" <?= $a['arquivo_armario_id'] == $arquivoArmario ? "selected" : null; ?>><?= $a['arquivo_armario_desc'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>              
                                    </select>  
                                    <span class="input-group-btn">
                                        <a class="btn  btn-danger deleteArmario"><span class="glyphicon glyphicon-trash"></span></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Gavetas:</strong></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Adicionar Gaveta:</label>
                                <div class="input-group">
                                    <input type="text" id="texto_gaveta" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary botaoLoad" id="adicionarGaveta" type="button">Add</button>
                                    </span>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <select name="arquivo_gaveta"  class ="form-control" id="selectG">
                                        <?php if ($gavetas) { ?>
                                            <?php foreach ($gavetas as $g) { ?>
                                                <option value="<?= $g['arquivo_gaveta_id'] . "_" . $g['arquivo_gaveta_desc'] ?>" <?= $g['arquivo_gaveta_id'] == $arquivoGaveta ? "selected" : null; ?>><?= $g['arquivo_gaveta_desc'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <span class="input-group-btn">
                                        <a class="btn btn-danger deleteGaveta"><span class="glyphicon glyphicon-trash"></span></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Pasta:</strong></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Pasta:</label>
                                <input type="text" name="arquivo_pasta" class="form-control" required value="<?= isset($arquivo['arquivo_pasta']) ? $arquivo['arquivo_pasta'] : null; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div  class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-actions">
                        <input type="hidden" name="arquivo_id" value="<?= isset($arquivo['arquivo_id']) ? $arquivo['arquivo_id'] : null; ?>">
                        <input type="hidden" name="arquivo_cliente" value="<?= !empty($id_cliente) ? $id_cliente : null; ?>" id="idCliente">
                        <input type="hidden" value="<?= $acao == "editar" ? $acao : "insertArquivo"; ?>" name="acao" id="acao">
                        <button type="submit" class="btn btn-primary botaoLoadForm" id="btnSalvarCliente">
                            Salvar
                        </button>
                        <a href="index.php?pg=24" class="btn btn-info"> Voltar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
