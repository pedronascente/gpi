<?php 
    if ($viaturas) { ?>
    <div class="table-responsive">    
    <table class="  table table-bordered   table-striped  table-hover dataTableBootstrapSemOrdem" >
          <thead>
               <tr>
                   <th>Data</th>
                   <th>Hora</th>
                   <th><strong>Conta</strong></th>
                   <th><strong>Atendente</strong></th>
                   <th>Pontos</th>
                   <th width="2%"> Ação</th>
               </tr>
           </thead>
           <tbody >
               <?php
                   foreach ($viaturas as $k => $li) {
                       $viaturas_data = (!empty($li ['data'])) ? Funcoes::FormataData($li ['data']) : "";
                       $viaturas_hora = !empty($li ['hora']) ? $li ['hora'] : '';
                       $viaturas_conta = !empty($li ['conta']) ? $li ['conta'] : '';
                       $viaturas_atendente = !empty($li ['atendente']) ? $li ['atendente'] : '';
                       $viaturas_pontos = !empty($li ['pontos']) ? $li ['pontos'] : '';
                       $viaturas_id = !empty($li ['id_viaturas']) ? $li ['id_viaturas'] : '';
                       ?>  		
                       <tr>				
                           <td><?=(!empty($viaturas_data)) ? $viaturas_data : ""; ?></td>
                           <td><?=(!empty($viaturas_hora)) ? $viaturas_hora : ""; ?></td>
                           <td><?=(!empty($viaturas_conta)) ? $viaturas_conta : ""; ?></td>
                           <td><?=(!empty($viaturas_atendente)) ? $viaturas_atendente : ""; ?></td>
                           <td><?=(!empty($viaturas_pontos)) ? $viaturas_pontos : ""; ?></td>
                           <td align="center">
                               <a href="index.php?pg=27&pgAnterior=<?= $pagina; ?>&id=<?=(!empty($viaturas_id)) ? $viaturas_id : ""; ?>" class="btn btn-sm   btn-success">						
                                    <span class="glyphicon glyphicon-eye-open"></span>
                               </a>
                           </td>
                       </tr>	
                       <?php 
                    } 
               ?>
           </tbody>        
           <tfoot>
               <tr>
                   <td colspan="6">Registros encontrados: <?= $total; ?> </td>
               </tr>
           </tfoot>    
        </table>	
        <?php
        $objPaginacao->MontaPaginacao();
    } else {
        Funcoes::Nregistro();
    }
?>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <a href="index.php?pg=28" class="btn  btn-primary  viaturas ">
            Pesquisar Dados Antigos
        </a>
    </div> 
</div>
 