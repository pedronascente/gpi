<div class="panel panel-primary">
    <div class="panel-heading "></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float: right">
                <?php                
                    $formularioBusca = new FormularioDeBusca;
                    $formularioBusca->setPg(45);
                    $formularioBusca->setAcao('pesquisaAntenas');
                    $formularioBusca->setFiltro('buscarPor');
                    $formularioBusca->formBusca();
                ?>
            </div>
        </div>
        <?php
        if (isset($listAntenas)) { ?>
                <table  class="table table-striped table-bordered  table-hover dataTableBootstrap  " cellspacing="0">
                    <thead> 
                        <tr>
                            <th>Código</th>
                            <th>Nome Cliente</th>
                            <th>Longitude</th>
                            <th>Latitude</th>
                            <th width="5%">Ações</th>
                        </tr>    
                    </thead>
                    <tbody>
                        <?php
                            foreach ($listAntenas as  $dados) {
                                $portariaAntena->sets($dados);?> 
                                 <tr>
                                     <td><?=$portariaAntena->getPa_codigo();?></td>
                                     <td><?=$portariaAntena->getPa_cliente();?></td>
                                     <td><?=$portariaAntena->getPa_longitude();?></td>
                                     <td><?=$portariaAntena->getPa_latitude();?></td>
                                     <td width="5%">
                                         <table width="150px" border="0"> 
                                             <tr>
                                                 <td>
                                                     <a href="index.php?pg=45&acao=editarA&idA=<?=$portariaAntena->getPa_id();?>"  class="btn btn-info">
                                                         Editar
                                                     </a>
                                                 </td>
                                                 <td>
                                                     <form action="" method="get" style="margin: 0; padding: 0">
                                                         <input type="hidden" name="pg" value="45">
                                                         <input type="hidden" name="acao" value="deletarA">
                                                         <input type="hidden" name="idA" value="<?=$portariaAntena->getPa_id();?>">
                                                         <input type="submit"  value="Deletar"  class="btn btn-danger">
                                                     </form>
                                                 </td>
                                             </tr>
                                         </table> 
                                     </td>
                                 </tr>
                                <?php    
                            }
                        ?>
                    </tbody>
                </table>
           <?php
           $objPaginacaoCondominio->MontaPaginacao();
        }else{ 
            Funcoes::Nregistro();
        }?>
    </div>
</div>