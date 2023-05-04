<?php
$Dados = filter_input_array(INPUT_GET);
$url = "http://$_SERVER[HTTP_HOST]";
$rota_api = $url . '/api_gpi/public/api/gestores/' . $Dados['id'];

if (empty($Dados)) {
   echo 'Informe um gestor válido!';
   die();
}

include_once('SacController.php');

$sac = new SacController();
$sac->setDados($Dados);
$sac->set_rota($rota_api);
$resultado = $sac->deleteCurl();

?>

<script type="text/javaScript">
   alert("Registro excluido com sucesso.");
	location.replace("/gpi/index.php?pg=61"); 
</script>