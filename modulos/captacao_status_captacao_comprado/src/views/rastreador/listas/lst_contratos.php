<?php  //namespace  C:\wamp\www\gpi\modulos\captacao\src\views\rastreador\listas\lst_contratos.php ?>
<div class="panel panel-primary ">
    <div class="panel-body">
        <?php  if(!empty($listaContratos)) { ?>
        <div class="col-md-12">    
            <div class="well well-sm">
                <span class="glyphicon glyphicon-eye-open"></span> => Visualizar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="glyphicon glyphicon-trash"></span> => Excluir &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="glyphicon glyphicon-share-alt"></span> => Enviar 
            </div>
        </div>
        <div class="col-md-12">
            <table class="table table-hover table-striped table-bordered dataTableBootstrap">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Atenção</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($listaContratos as $k => $contrato) :
                        $contrato_id = !empty($contrato['id_contrato']) ? $contrato['id_contrato'] : null;
                        $contrato_observacoes = !empty($contrato['observacoes_contrato']) ? $contrato['observacoes_contrato'] : null;
                        $contrato_id_cliente = (!empty($contrato ['id_cliente'])) ? $contrato ['id_cliente'] : "";
                        $contrato_cliente_ra = (!empty($contrato ['cliente_ra'])) ? $contrato ['cliente_ra'] : "";
                        $status_cadastro = (!empty($contrato ['status_cadastro'])) ? $contrato ['status_cadastro'] : "";
                        // VERIFICA SE TEM VEICULOS VEICULOS:
                        $veiculos = new Veiculos ();
                        $veiculos->selectPlanoAssitencialCliente(array(
                            "id_cliente" => $contrato_id_cliente
                        ));
                        $totalV = $veiculos->Read()->getRowCount();
                        // VERIFICA SE TEM ANEXOS:
                        $anexo = new Anexos;
                        $anexo->selectAnexosClientes($contrato_id_cliente);
                        $totalA = $anexo->Read()->getRowCount();                        
                        ?>
                        <tr <?php echo ($status_cadastro  ==0) ? 'Style="display:none"' :''; ?> >
                            <td width="50%"><?= Funcoes::addCaracter((!empty($contrato['nome_cliente'])) ? $contrato['nome_cliente'] : ""); ?></td>
                            <td><?= $contrato_observacoes; ?></td>
                            <td width="5%">
                                <table width="80px">
                                    <tr>
                                        <td width="5%">
                                            <a href="index.php?pg=15&id=<?= $contrato_id_cliente; ?>&id_cliente_contrato=<?= $contrato_id_cliente; ?>" class="btn btn-xs btn-success"  title="Editar Contrato">
                                                <span class="glyphicon glyphicon-pencil"></span>
                                            </a>
                                        </td>
                                        <td>
                                            <?php
                                            if (empty($totalA) && $totalA == '') :
                                                ?>
                                                <form action="modulos/captacao/src/controllers/captacao.php" method="post" class="deletaContrato">
                                                    <label> 
                                                        <input type="hidden" name="id_cliente_contrato" value="<?= $contrato_id_cliente; ?>">
                                                        <input type="hidden" name="id_cliente" value="<?= $contrato_cliente_ra; ?>"> 
                                                        <input type="hidden" name="id_contrato" value="<?= $contrato_id; ?>">  
                                                        <input type="hidden" name="acao" value="DeleteContrato">
                                                    </label> 
                                                    <button type="submit"   title="Deletar" class="btn btn-xs btn-danger " value="Excluir"><span class="glyphicon glyphicon-trash"></span></button>
                                                </form>
                                                <?php
                                            endif;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if (!empty($totalV) && $totalV > 0 && !empty($totalA) && $totalA > 0 && ($contrato['status_cadastro'] == 1 || $contrato['status_cadastro'] == 2)) :
                                                ?>
                                                <form action="modulos/captacao/src/controllers/captacao.php" method="post" class="loadForm">
                                                    <label> 
                                                        <input type="hidden" name="id_cliente" value="<?= $contrato_id_cliente; ?>"> 
                                                        <input type="hidden" name="id_contrato" value="<?= $contrato_id; ?>">
                                                        <input type="hidden" name="acao" value="EnviarContrato">
                                                    </label> 
                                                    <button type="submit"   title="Enviar Contrato" class="btn btn-xs btn-warning botaoLoadForm"><span class="glyphicon glyphicon-share-alt"></span></button>
                                                </form>
                                                <?php
                                            endif;
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                    ?>   
                </tbody>
            </table>
        </div>    
        <div> 
        </div <?=($status_cadastro==0) ? 'Style="display:none"' :'';?>>
            <?php  //$objPaginacaoContratos->MontaPaginacao();?>
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
        $(".deletaContrato").submit(function () {
            if (confirmarDelete()){
                return true;
            }else{
                return false;
            }        
        });
    });
</script>