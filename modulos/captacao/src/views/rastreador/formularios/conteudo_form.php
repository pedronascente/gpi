<div class="panel panel-primary  ">
    <div class="panel-heading">Cadastra Cliente</div>
     <div class="panel-default panel-body ">
        <?php if($result === '1'): ?>
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12  col-lg-12">
                <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign"> Registro excluido com sucesso!</span></div>           
           </div>
        </div>
        <?php endif;?>
        <ul class="nav nav-tabs">
            <?php  
                if (!empty($id_cliente)): ?>
                    
                    <li><a href="#cliente" data-toggle="tab">Veículo (s) <span class="alert-danger">(<?=(!empty($totalVeiculo) ? $totalVeiculo : '00'); ?>)</span></a></li>
                    <li><a href="#veiculo" data-toggle="tab">Veículo (s) <span class="alert-danger">(<?=(!empty($totalVeiculo) ? $totalVeiculo : '00'); ?>)</span></a></li>
                    <li><a href="#anexo" data-toggle="tab">Anexo(s)<span class="alert-danger">(<?= (!empty($totalAnexos) ? $totalAnexos : '00'); ?>)</span></a></li>
                    <?php 
                endif;
            ?>
            <li><a href="#contrato" data-toggle="tab" aria-expanded="false">Contrato Getado <span class="alert-danger">(<?= (!empty($totalContratos) ? $totalContratos : '00'); ?>)</span></a></li>
        </ul>
        
        <div class="tab-content">
            <?php 
                if (!empty($id_cliente)): ?>
                    <div class="tab-pane fade " id="cliente">
                       <?php  include_once('modulos/captacao/src/views/rastreador/formularios/frm_cliente.php'); ?>
                    </div>
                    <div class="tab-pane fade " id="veiculo">
                        <?php  include_once('modulos/captacao/src/views/rastreador/listas/lst_veiculos.php'); ?>
                    </div>
                    <div class="tab-pane fade" id="anexo">
                      <?php include_once('frm_anexos.php');  ?>
                    </div>   
                    <?php 
                endif;?>
                <div class="tab-pane fade" id="contrato">
                    <?php  include_once('modulos/captacao/src/views/rastreador/listas/lst_contratos.php'); ?>
                </div>
        </div>
  </div>
</div>