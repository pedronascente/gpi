<?php
//namespace C:\wamp\www\gpi\modulos\captacao\src\views\captacao\formularios\frm_cadastrarCaptacao.php 
$result = (filter_input(INPUT_GET, "r")) ? filter_input(INPUT_GET, "r") : null;
if ($result) {
    echo '<div class="row">';  
    echo '<div class="col-xs-12 col-sm-12 col-md-12 ">';
    echo      Funcoes::tratarError(['error' => 'alert-success', 'mensagem' => 'Captação Registrado com sucesso!']); 
    echo '</div>';
    echo '</div>';          
} 
?>
<style>  ._alert-background{background: antiquewhite} </style>  
<form action="modulos/captacao/src/controllers/captacao.php" method="post" id="basic_validate_usuario" novalidate="novalidate"> 
    <div class="panel panel-primary">
        <div class="panel-heading">Abrir Captação</div>
        <div class="panel-body">
            <div class="row ">
                <div class="col-xs-12 col-sm-4  col-md-4">
                    <div class="form-group">
                        <label>Interesse:</label>
                        <select name="captacao_interesse" id="captacao_interesse" class="form-control select_interesse" required >
                            <option value="">Selecione</option>
                            <?php
                            $captacao = new Captacao;
                            $listaCaptacaoInteresse = $captacao->selectCaptacaoNiveisInteresses();
                            foreach ($listaCaptacaoInteresse as $interesse) {
                                ?>
                                <option value="<?= $interesse['captacao_niveis_interesses_id']; ?>"><?= $interesse['captacao_niveis_interesses_desc']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12  col-md-12" >
                    <div class="form-group">
                        <label>Cliente:</label>
                        <input type="text" name="captacao_cliente" value="" class="form-control" required placeholder="Digite nome do cliente" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12  col-md-12 ">
                    <div class="form-group">
                        <label>E-mail:</label>
                        <input type="email" name="captacao_email" id="captacao_email" class="form-control" placeholder="Entre com o email"  >
                    </div>
                </div>
            </div>                
            <div class="row">
                <div class="col-xs-12 col-sm-3  col-md-3">
                    <div class="form-group">
                        <label>Telefone:</label>
                        <input type="text" name="captacao_telefone1" id="captacao_telefone1" class="mask_telefone form-control" required placeholder="Telefone" />
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3">
                    <div class="form-group">
                        <label>Telefone:</label>
                        <input type="text" name="captacao_telefone2" id="captacao_telefone2" class="mask_telefone form-control" placeholder="Telefone" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Indicador:</label>
                        <select name="captacao_indicador" id="captacao_indicador" class="form-control" required="">
                            <option value="" selected="selected"> -- Como conheceu a empresa? -- </option>
                            <option value="indicacao">Indicação</option>
                            <option value="internet">Internet</option>
                            <option value="facebook">Facebook</option>
                            <option value="jornal">Jornal</option>
                            <option value="outdoor">Outdoor</option>
                            <option value="outros">Outros</option>
                            <option value="placas">Placas</option>
                            <option value="revista">Revista</option>
                            <option value="whatsApp">WhatsApp</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label>Observações:</label>
                        <textarea name="captacao_obs" rows="5" id="captacao_obs"  class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <input type="hidden" name="acao" id="acao" value="InsertCaptacao" /> 
                    <input type="hidden" name="origem" id="origem" value="monitoramento" /> 
                    <input type="hidden" name="captacao_responsavel"  class="form-control"  value="<?= $_SESSION['user_info']['nome']; ?>">
                    <input type="submit" class="btn btn-danger"  value="Finalizar">
                </div>
            </div>
        </div>
    </div>
</form>
