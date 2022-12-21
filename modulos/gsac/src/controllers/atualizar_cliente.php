<?php

$url = 'http://10.1.1.58:9093';
$Dados = filter_input_array(INPUT_POST);
$rota_api = $url.'/api_gpi/public/api/clientes/'.$Dados['id'];

if(empty($Dados))
{
	echo 'Informe um cliente válido';
    die();                                                                                            ;
}

include_once('SacController.php');

$sac = new SacController();
$sac->setDados($Dados);
$sac->set_rota($rota_api); 
$resultado = $sac->editCurl();

?>

<script type="text/javaScript">
	alert("Registro Atualizado com sucesso.");
	location.replace("/gpi/index.php?pg=60"); 
</script>