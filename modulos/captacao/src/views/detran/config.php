
<?php


$placa = $_POST['placa'];

$renavam = $_POST['renavam'];

$rota = "https://pcsdetran.rs.gov.br/consulta-veiculo/{$placa}?renavam={$renavam}";

//echo $rota;


?>



<iframe src="<?php echo $rota;?>" style="border:none ;height: 800px;width: 100%;" frameborder="0" allowfullscreen  is="x-frame-bypass"> </iframe>
