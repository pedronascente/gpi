<?php
	$url = 'http://10.1.1.58:9093';
	$rota_api_gestor = $url."/api_gpi/public/api/gestores";
    $path = $_SERVER['DOCUMENT_ROOT'] . "\gpi\modulos\gsac\src\controllers\\";
    $file = $path . "SacController.php";

    include_once($file);

    $sac = new SacController();
    $sac->set_rota($rota_api_gestor); 
    $gestor = $sac->getCurl();
    $gestor = json_decode($gestor);

?>

<?php  include_once('listar_gestor.php');?>
<br>
<div class="panel panel-primary">
    <div class="panel-heading ">Cadastrar novo cliente</div>
    <div class="panel-body"> 
        <form action="index.php?pg=63" method="post"> 
            <div class="row">
                <div class="col-xs-12 col-sm-4  col-md-4">                   
                    <div class="form-group">
                        <label>Gestor:</label>
                        <select name="gestor_id" class="form-control" required="">
                            <option value="" >Selecione</option>
                            <?php
                                 if($gestor)
								 {
									foreach($gestor as $g)
									{
										echo '<option value="'.$g->id.'" >'.$g->gestor.'</option>';
                                    }
                                 }
                            ?>   
                       </select>
                    </div>
                </div>   
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12  col-md-12">
                    <div class="form-group">
                        <label>Cliente:</label>
                        <input type="text" name="nome" class="form-control" required="true"  placeholder="Digite nome do cliente" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4  col-md-4">
                    <div class="form-group">
                        <label>Placa:</label>
                        <input type="text" name="placa" class="form-control" required="true" placeholder="Digite placa" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
				<hr>
                    <input type="submit" class="btn btn-success"  value="Cadastrar Cliente">
                    <a href="<?=$url?>/gpi/index.php?pg=65" class="btn btn-primary">Cadastrar Gestor</a>
					<a href="<?=$url?>/gpi/index.php?pg=60" class="btn btn-danger">Voltar</a>
                </div>
            </div>
        </form>
    </div>
</div>