<?php

$pontos = filter_input(INPUT_GET, "pontos");




if(!empty($pontos)){
	if ($pontos <= 49) {
		$valores = array("cor" => "alert-success", "message" => "N&atilde;o enviar viatura, grande possibilidade de disparo em falso!");
	} else if ($pontos >= 50 && $pontos <= 90) {
		$valores = array("cor" => "alert-warning", "message" => "Enviar viatura, possibilidade de intrus&atilde;o!");
	} else if ($pontos > 90) {
		$valores = array("cor" => "alert-danger", "message" => "Enviar viatura, h&aacute; intrus&atilde;o no local!");
	}
}
?>
<div class="modal-dialog">
    <div class="modal-content <?=$valores['cor']?>">
        <div class="modal-body" align="center">
        	<h3><label><?=$valores['message']?></label></h3>
        </div>
     </div>
</div>