<?php

$dt_inicial = filter_input(INPUT_GET, "dt_inicial_grafico");
$dt_final = filter_input(INPUT_GET, "dt_final_grafico");

$dt_inicial = Funcoes::FormatadataSql($dt_inicial);
$dt_final = Funcoes::FormatadataSql($dt_final);


$captacao = new Captacao();

$listaGrafico = $captacao->gerarGrafico($dt_inicial, $dt_final);

include_once '/../../../../../application/models/classes/phplot-6.2.0/phplot.php';


$data = array();

foreach ($listaGrafico as $k=>$li){
	$total = (int) $li['total'];
	$data[$k] = array($li['interesse'], $total);
}

$plot = new PHPlot(800,600);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('pie');
$plot->SetDataType('text-data-single');
$plot->SetDataValues($data);

$plot->SetTitle("Captacao Interesses");

# Set enough different colors;
 $plot->SetDataColors(array('red', 'green', 'blue', 'yellow', 'cyan',
 'magenta',  'lavender',
 'gray', 'orange'));

# Main plot title:

# Build a legend from our data array.
# Each call to SetLegend makes one line as "label: value".
foreach ($data as $row)
	$plot->SetLegend(implode(': ', $row));
	# Place the legend in the upper left corner:
	$plot->SetLegendPixels(5, 5);

	$plot->SetPrintImage(false);
	$plot->DrawGraph();
	
