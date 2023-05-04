<?php
$Dados = filter_input_array(INPUT_POST);
$url = "http://$_SERVER[HTTP_HOST]";
$rota_api = $url.'/api_gpi/public/api/clientes';

if(empty($Dados))
{
   echo 'Informe um cliente válido!';
   die();
}

include_once('SacController.php');

$sac = new SacController();
$sac->setDados($Dados);
$sac->set_rota($rota_api); 
$resultado = $sac->createCurl();

?>
<script type="text/javaScript">
	alert("Registrado com sucesso.");
	location.replace("/gpi/index.php?pg=60"); 
</script>
