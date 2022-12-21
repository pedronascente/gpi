<div class="panel panel-primary">
    <div class="panel-heading "></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float: right">
                <?php                
                    $formularioBusca = new FormularioDeBusca;
                    $formularioBusca->setPg(42);
                    $formularioBusca->setAcao('pesquisaCondominio');
                    $formularioBusca->setFiltro('buscarPor');
                    $formularioBusca->formBusca();
                ?>
            </div>
        </div>
        <?php
        if ($listCondominios) { ?>
                <table  class="table table-striped table-bordered  table-hover dataTableBootstrap  " cellspacing="0">
                    <thead> 
                        <tr>
                            <th>Código</th>
                            <th>RazãoSocial</th>
                            <th>CEP</th>
                            <th>UF</th>
                            <th>Endereço</th>
                            <th>Numero</th>
                            <th>Cidade</th>
                            <th>Bairro</th>
                            <th>Complemento</th>
                            <th>Qtd.Serviços</th>
                            <th width="5%">Ações</th>
                        </tr>    
                    </thead>
                    <tbody>
                        <?php
                            foreach ($listCondominios as  $dados) {
                                $portariaCondominio->sets($dados);?> 
                                 <tr>
                                     <td><?=$portariaCondominio->getPcCodigo();?></td>
                                     <td><?=$portariaCondominio->getPcRazaoSocial();?></td>
                                     <td><?=$portariaCondominio->getPcCep();?></td>
                                     <td><?=$portariaCondominio->getPcUF();?></td>
                                     <td><?=$portariaCondominio->getPcEndereco();?></td>
                                     <td><?=$portariaCondominio->getPcNumero();?></td>
                                     <td><?=$portariaCondominio->getPcCidade();?></td>
                                     <td><?=$portariaCondominio->getPcBairro();?></td>
                                     <td><?=$portariaCondominio->getPcComplemento();?></td>
                                     <td align="center"><?=$portariaCondominio->getTotalServicos();?></td>
                                     <td width="5%">
                                         <table width="235px;" border="0"> 
                                             <tr>
                                                 <td><a href="index.php?pg=42&acao=editarC&id=<?=$portariaCondominio->getPcId();?>"  class="btn btn-info">Editar</a></td>
                                                 <td>
                                                     <form action="?#menu3" method="get">
                                                         <input type="hidden" name="pg" value="42">
                                                         <input type="hidden" name="acao" value="deletarC">
                                                         <input type="hidden" name="id" value="<?=$portariaCondominio->getPcId();?>">
                                                         <input type="submit"  value="Deletar"  class="btn btn-danger">
                                                     </form>
                                                 </td>
                                                 <td><a id="modulos/portaria/src/views/modal/modalViewServico.php?id=<?=$portariaCondominio->getPcId();?>" data-target="#modal" class="btn btn-success modalOpen" >Visualizar</a></td>
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