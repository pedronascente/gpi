<?php

include_once '../../Config.inc.php';

$ramal = new Ramal;

$listaRamais = $ramal->listRamal(null, null);

$html = "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<style type='text/css'>
table{font-size:10px ; font-family:Arial, Helvetica, sans-serif}
</style>
		<table border='1' cellspacing='0' cellpadding='0' width='100%'>
			<thead>
				<tr>
					<td colspan='4' align='center'>&nbsp;</td>
				</tr>
				<tr>
					<th>Colaborador</th>
					<th>Ramal</th>
					<th>Telefone</th>
					<th>E-mail</th>
				</tr>
			</thead>
			<tbody>";

foreach ($listaRamais as $r){
	$html .= "<tr>
				<td>{$r['ramal_nome_usuario']}</td>
				<td>{$r['ramal_ramal']}</td>
				<td>{$r['ramal_telefone']}</td>
				<td>{$r['ramal_email']}</td>
			</tr>";
}

$html .= "</tbody>
			</table>";

require_once("../dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4","portrait");
$dompdf->render();
$dompdf->stream('ramais.pdf');
