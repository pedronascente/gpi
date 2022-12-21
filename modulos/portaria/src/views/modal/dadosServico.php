<div class="panel panel-primary">
    <div class="panel-heading ">
    </div>
    <div class="panel-body">
        <table  class="table table-striped table-bordered  table-hover dataTableBootstrap  " cellspacing="0">
            <thead> 
                <tr>
                    <th>Serviço</th>
                    <th>Responsavel</th>
                    <th>Telefone</th>
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
    </div><!--panel-body-->
</div><!--panel-primary-->  