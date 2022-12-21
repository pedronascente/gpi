<?php

include_once "../../Config.inc.php";

$captacao = new Captacao;

$ano = filter_input(INPUT_GET, "ano");
$tipo = filter_input(INPUT_GET, "tipo");

$mesesD = array(1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
$meses = array(1 => "01", 2 => "02", 3 => "03", 4 => "04", 5 => "05", 6 => "06", 7 => "07", 8 => "08", 9 => "09", 10 => "10", 11 => "11", 12 => "12");


//TABELAS DE VENDAS POR MÊS
$html = '
		  	<h2>Histórico de vendas - ' . $ano . ' - Desempenho</h2>
			<div style=" margin:0 auto ;width:700px ; font-size:10px; " align="center">';


foreach ($meses as $k => $m) {
    $dt_inicial = $ano . "-" . $m . "-01 00:00:00";
    $dt_final = $ano . "-" . $m . "-31 23:59:59";
    $lista = $captacao->gerarIndiceComparativoVendedores($dt_inicial, $dt_final);
    $somaCaptacao = 0;
    $somaContrato = 0;

    if (!empty($lista)) {
        $html .= '<table cellspacing="0" cellpadding="0" width="100%" border="1">
				<tr align="center">
					<th colspan="4"><strong>' . $mesesD[$k] . '</strong></th>
				</tr>
				<tr>
					<th>Vendedores</th>
					<th>Captações Recebidas</th>
					<th>Captações Vendidas</th>
					<th>Percentual Vendas</th>
				</tr>';
        foreach ($lista as $l) {
            $vendedor = isset($l['label']) ? ucwords($l['label']) : "";
            $captacaoNum = isset($l['captacao']) ? $l['captacao'] : "0";
            $contratoNum = isset($l['contrato']) ? $l['contrato'] : "0";
            $percentual = !empty($contratoNum) && !empty($contratoNum) ?  number_format((int) $captacaoNum / (int) $contratoNum, 2, ',', ' ') : 0;
            $somaCaptacao += (int) $captacaoNum;
            $somaContrato += (int) $contratoNum;
            $html .= '<tr>
                        <td>' . $vendedor . '</td>
                        <td>' . $captacaoNum . '</td>
                        <td>' . $contratoNum . '</td>
                        <td>' . $percentual . '%</td>
                    </tr>';
        }

        $percentualSoma = !empty($somaCaptacao) ? number_format($somaCaptacao / $somaContrato, 2, ',', ' ') : "0";
        $html .= '<tr>
				<td><strong>Média de vendas</strong></td>
				<td>' . $somaCaptacao . '</td>
				<td>' . $somaContrato . '</td>
				<td>' . $percentualSoma . '%</td>
			  </tr>
			</table><br>';

    }
}

$somaCaptacao = 0;
$somaContrato = 0;

//TABEL DE VENDAS MENSAL
$lista = $captacao->gerarIndicesComparativoMensal($ano);

if (!empty($lista)) {
    $html .= '<table cellspacing="0" cellpadding="0" width="100%" border="1">
				<tr align="center">
					<th colspan="4"><strong>Comparativo Mensal</strong></th>
				</tr>
				<tr>
					<th>Mês</th>
					<th>Captações Recebidas</th>
					<th>Captações Vendidas</th>
					<th>Percentual Vendas</th>
				</tr>';

    foreach ($lista as $l) {
        $mes = $mesesD[$l['label']];
        $captacaoNum = isset($l['captacao']) ? $l['captacao'] : "0";
        $contratoNum = isset($l['contrato']) ? $l['contrato'] : "0";
        $percentual = !empty($contratoNum) && !empty($contratoNum) ?  number_format((int) $captacaoNum / (int) $contratoNum, 2, ',', ' ') : 0;
        $somaCaptacao += (int) $captacaoNum;
        $somaContrato += (int) $contratoNum;
        $html .= '<tr>
						<td>' . $mes . '</td>
						<td>' . $captacaoNum . '</td>
						<td>' . $contratoNum . '</td>
						<td>' . $percentual . '%</td>
				 </tr>';
    }

    $percentualSoma = !empty($somaCaptacao) ? number_format($somaCaptacao / $somaContrato, 2, ',', ' ') : "0";
    $html .= '<tr>
				<td><strong>Média de vendas</strong></td>
				<td>' . $somaCaptacao . '</td>
				<td>' . $somaContrato . '</td>
				<td>' . $percentualSoma . '%</td>
			  </tr>
			</table><br>';
}

$somaCaptacao = 0;
$somaContrato = 0;

//TABELA DE VENDAS SEGURO
$lista = $captacao->gerarIndiceComparativoSeguro($ano);

if (!empty($lista)) {
    $html .= '<table cellspacing="0" cellpadding="0" width="100%" border="1">
				<tr align="center">
					<th colspan="4"><strong>Comparativo Vendas/Seguro</strong></th>
				</tr>
				<tr>
					<th>Mês</th>
					<th>Vendas</th>
					<th>Seguro</th>
					<th>Percentual Vendas/Seguro</th>
				</tr>';

    foreach ($lista as $l) {
        $mes = $mesesD[$l['label']];
        $captacaoNum = isset($l['captacao']) ? $l['captacao'] : "0";
        $contratoNum = isset($l['contrato']) ? $l['contrato'] : "0";
        $percentual = !empty($contratoNum) && !empty($contratoNum) ?  number_format((int) $captacaoNum / (int) $contratoNum, 2, ',', ' ') : 0;
        $somaCaptacao += (int) $captacaoNum;
        $somaContrato += (int) $contratoNum;
        $html .= '<tr>
						<td>' . $mes . '</td>
						<td>' . $captacaoNum . '</td>
						<td>' . $contratoNum . '</td>
						<td>' . $percentual . '%</td>
				 </tr>';
    }

    $percentualSoma = !empty($somaCaptacao) ? number_format($somaCaptacao / $somaContrato, 2, ',', ' ') : "0";
    $html .= '<tr>
				<td><strong>Média de vendas</strong></td>
				<td>' . $somaCaptacao . '</td>
				<td>' . $somaContrato . '</td>
				<td>' . $percentualSoma . '%</td>
			  </tr>
			</table><br>';
}

$somaCaptacao = 0;
$somaContrato = 0;

//TABELA DE VENDAS ESTADOS
$listaE = $captacao->gerarIndiceComparativoEstadoAnual($ano);

if(!empty($listaE)){
	
	$html .= '<table cellspacing="0" cellpadding="0" width="100%" border="1" align="center">
				<tr align="center">
					<th colspan="26"><strong>Comparativo Vendas/Estados</strong></th>
				</tr>
				<tr>
					<th>Estados</th>';
	foreach ($mesesD as $d){
		$html .= '<th colspan="2">'.$d.'</th>';
	}
	
	$html .= '<th></th></tr><tr><th></th>';
	
	foreach ($mesesD as $d){
		$html .= '<th>Capt.</th>';
		$html .= '<th>Cont.</th>';
	}
	
	
	$html .= '<th>Percentual</th></tr>';


	foreach ($listaE as $le){
			$html .=  "<tr><td>{$le['uf']}</td>";
			
			$listaV = $captacao->gerarIndiceComparativoEstadoAnual($ano, true, $le['uf']);
			
			$lista = Funcoes::pegarChaveArray($listaV, "mes");
			
			$lista = array_flip($lista);
			
			
			for ($i = 1; $i < 13; $i++){
				
				$cap = isset($lista[$i]) && !empty($listaV[$lista[$i]]['captacao']) 	? $listaV[$lista[$i]]['captacao'] : 0;
				$con = isset($lista[$i]) && !empty($listaV[$lista[$i]]['contrato']) 	? $listaV[$lista[$i]]['contrato'] : 0;
				
				$somaCaptacao += $cap;
				$somaContrato += $con;
				
				$html .= "<td>{$cap}</td><td>{$con}</td>";
			
			}
			
			$percentual = !empty($somaCaptacao) && !empty($somaContrato) ?  number_format((int) $somaCaptacao / (int) $somaContrato, 2, ',', ' ') : 0;
			 
			$html .= "<td>{$percentual} %</td></tr>";

	}
	$html .= "</table>";
	
}
$html .= '</div>';

//echo($html); die;

if($tipo == "excel")
	Funcoes::exportExel(utf8_encode($html), "Historico.xls");
else {
	include_once "../dompdf/dompdf_config.inc.php";
	$dompdf = new DOMPDF ();
	$dompdf->load_html($html);
	$dompdf->set_paper("A4","portrait");
	$dompdf->render();
	return $dompdf->stream("Comparativo {$ano}.pdf");
}