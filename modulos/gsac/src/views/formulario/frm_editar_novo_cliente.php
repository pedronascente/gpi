<?php
	$url = 'http://10.1.1.58:9093';
	$id = $_GET['id'];
	$rota_api_cliente =  $url."/api_gpi/public/api/clientes/{$id}/edit";
	$rota_api_gestor = $url."/api_gpi/public/api/gestores";
	//Pegando o caminho absoluto a partir da raiz da pasta publica do servidor
	$path = $_SERVER['DOCUMENT_ROOT'] . '\gpi\modulos\gsac\src\controllers\\';
	$file = $path . 'SacController.php';

	include_once($file);

	$sac = new SacController();
	$sac->set_rota($rota_api_cliente); 
	$cliente = $sac->getCurl();
	$cliente = json_decode($cliente);
	 
	$gestor = new SacController();
	$gestor->set_rota($rota_api_gestor); 
	$gestor = $gestor->getCurl();
	$gestor = json_decode($gestor);

	if(is_object($cliente) == false)
	{
		echo 'Cliente não encontrado, verifiqeue se o id é válido';
		die();
	}

?>

<div class="panel panel-primary">
    <div class="panel-heading ">Editar caadastro cliente</div>
    <div class="panel-body"> 
        <form action="index.php?pg=64" method="post"> 
            <input type="hidden" name="id" value="<?=$cliente->id;?>">
            <input type="hidden" name="_method" value="put" />
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
										if($g->id == $cliente->gestor_id)
										{
											$sel = 'selected';
										}else{
											$sel ='';
										}
                                        echo '<option value="'.$g->id.'" '.$sel.' >'.$g->gestor.'</option>';
                                    }
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
                        <input type="text" name="nome" value="<?=$cliente->cliente;?>" class="form-control"  required />
                    </div>
                </div>
            </div>
            <div class="row">
                <!--<div class="col-xs-12 col-sm-4  col-md-4" >
                    <div class="form-group">
                        <label>CPF / CNPJ:</label>
                        <input type="text" name="cpf_cnpj" value="<?=$cliente->cpf_cnpj;?>" class="form-control"  required />
                    </div>
                </div>-->
                <div class="col-xs-12 col-sm-4  col-md-4" >
                    <div class="form-group">
                        <label>Placa:</label>
                        <input type="text" name="placa" value="<?=$cliente->placa;?>" class="form-control" required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <input type="submit" class="btn btn-success"  value="Atualizar">
				    <a href="/gpi/index.php?pg=60" class="btn btn-danger">Voltar</a>
                </div>
            </div>
        </form>
    </div>
</div>