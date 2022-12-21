<div class="panel panel-primary">
    <div class="panel-heading "> <strong>Captações  Migradas com Sucesso!</strong></div>
    <div class="panel-body"> 
        <div class="row">
            <div class="col-md-12">
                     <div class="alert alert-success" role="alert">
                     <?php  
                          if($this->session->has_userdata('mensagem')){
                               echo $this->session->userdata('mensagem');
                          }else{
                               die('Não foi possivel ');
                          }
                      ?>
                     </div>
                    <a href="<?=base_url('migrarcaptacao');?>" class="btn btn-primary"> << Voltar</a>
            </div>
        </div>
    </div>
</div>