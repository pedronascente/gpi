<div class="panel panel-primary">
    <div class="panel-heading ">Lista de serviços do Condominio : [ <?=$portariaCondominio->getPcRazaoSocial();?> ] </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float: right">
                <?php                
                    $formularioBusca = new FormularioDeBusca;
                    $formularioBusca->setPg(42);
                    $formularioBusca->setAcao('pesquisarServicos');
                    $formularioBusca->setFiltro('buscarPor');
                    $formularioBusca->setId($idCondominio);
                    $formularioBusca->formBusca();
                ?>
            </div>
        </div>
        <?php
        if (!empty($listaServico)) { ?>
                <table  class="table table-striped table-bordered  table-hover dataTableBootstrap  " cellspacing="0">
                    <thead> 
                        <tr>
                            <th>SERVIÇO</th>
                            <th>RESPONSAVEL</th>
                            <th>TELEFONE</th>
                            <th  width="5%">AÇÕES</th>
                        </tr>    
                    </thead>
                    <tbody>
                        <?php
                            foreach ($listaServico as  $dados) {
                                 $portariaCondominioServico->sets($dados);?> 
                                 <tr>
                                     <td><?=$portariaCondominioServico->getPcspsTipoServico();?></td>
                                     <td><?=$portariaCondominioServico->getPcsResponsavel();?></td>
                                     <td><?=$portariaCondominioServico->getPcsTelefone();?></td>
                                     <td   width="5%">
                                         <table width="145px;" border="0"> 
                                             <tr>
                                                 <td><a href="index.php?pg=42&acao=editarS&idS=<?=$portariaCondominioServico->getPcsId();?>&id=<?=$idCondominio?>#menu2"  class="btn btn-info">Editar</a></td>
                                                 <td><a href="index.php?pg=42&acao=deletarS&idS=<?=$portariaCondominioServico->getPcsId();?>&id=<?=$idCondominio?>" class="btn btn-danger">Deletar</a></td>
                                             </tr>
                                         </table> 
                                     </td>
                                 </tr>
                                <?php    
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">Registros encontrados: <?=(NULL != $totalServicos) ? $totalServicos : 00; ?> </td>
                        </tr>
                    </tfoot> 
                </table>
           <?php
           $objPaginacaoServico->MontaPaginacao();
        }else{ 
            Funcoes::Nregistro();
        }?>
    </div>
</div>