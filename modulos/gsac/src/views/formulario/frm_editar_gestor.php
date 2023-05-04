
<?php
    $url = "http://$_SERVER[HTTP_HOST]";
    $id = $_GET['gestor_id'];
    $rota_api_gestor =  $url."/api_gpi/public/api/gestores/{$id}/edit";

    //Pegando o caminho absoluto a partir da raiz da pasta publica do servidor
    $path = $_SERVER['DOCUMENT_ROOT'] . '\gpi\modulos\gsac\src\controllers\\';
    $file = $path . 'SacController.php';

    include_once($file);
     
    $gestor = new SacController();
    $gestor->set_rota($rota_api_gestor); 
    $gestor = $gestor->getCurl();
    $gestor = json_decode($gestor);

    if(is_object($gestor) == false)
    {
        echo 'Gestor não encontrado, verifiqeue se o id é válido';
        die();
    }

?>


<div class="panel panel-primary">
    <div class="panel-heading ">Editar Gestor</div>
    <div class="panel-body"> 
          <form action="index.php?pg=80" method="post"> 
            <input type="hidden" name="id" value="<?=$gestor->id;?>">
            <input type="hidden" name="_method" value="put" />
            <div class="row">
                <div class="col-xs-12 col-sm-4  col-md-4">
                    <div class="form-group">
                        <label>Gestor:</label>
                        <input type="text" name="gestor"  class=" form-control" required="true"  value="<?=$gestor->gestor;?>"   placeholder="Digite o nome do gestor" />
                    </div>
                </div>
                 <div class="col-xs-12 col-sm-4  col-md-4">
                    <div class="form-group">
                        <label>Ramal:</label>
                        <input type="text" name="ramal" class="form-control" required="true" placeholder="Digite  o Ramal"    value="<?=$gestor->ramal;?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
				<hr>
                    <input type="submit" class="btn btn-success"  value="Salvar">
					<a href="/gpi/index.php?pg=61" class="btn  btn-danger">Voltar</a>
                </div>
            </div>
        </form>
    </div>
</div>