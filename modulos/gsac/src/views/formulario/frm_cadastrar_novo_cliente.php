<?php
	
    $path = $_SERVER['DOCUMENT_ROOT'] . "\gpi\modulos\gsac\src\controllers\\";
    $file = $path . "SacController.php";

    include_once($file);

    $url = "http://$_SERVER[HTTP_HOST]";
    $rota_api_gestor = $url."/api_gpi/public/api/gestores";

    $sac = new SacController();
    $sac->set_rota($rota_api_gestor); 
    $gestores = $sac->getCurl();
    $gestores = json_decode($gestores);

?>

<?php  include_once('listar_gestor.php');?>
<br>
<div class="panel panel-primary">
    <div class="panel-heading ">Cadastrar cliente</div>
    <div class="panel-body"> 
        <form action="index.php?pg=63" method="post"> 
            <div class="row">
                <div class="col-xs-12 col-sm-4  col-md-4">                   
                    <div class="form-group">
                        <label>Gestor:</label>
                        <select name="gestor_id" class="form-control" required="">
                            <option value="" >Selecione</option>
                            <?php
                                 if($gestores)
								 {
									foreach($gestores as $g)
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
                    <input type="submit" class="btn btn-success"  value="Salvar">
					<a href="/gpi/index.php?pg=60" class="btn btn-danger">Voltar</a>
                </div>
            </div>
        </form>
    </div>
</div>