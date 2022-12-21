<?php

include_once ("../../../../../Config.inc.php");
$dados = $_GET;	
if(isset($dados)){
	$month  =  isset($dados['month'])? $dados['month'] : '';
	$ano  =  isset($dados['ano'])? $dados['ano'] : '';
	$exportar  =  isset($dados['exportar'])? true : false;
	$PAGINA = $dados['pg'].'&month='.$month.'&ano='.$ano ;
}else{
	$PAGINA = $dados['pg'];
}
$pagina = $dados['pg'];

$captacao = new Captacao;
$captacao->selectViaturasAntigas($dados);
$total = $captacao->Read()->getRowCount();

$viaturasAntigas_excel = '';
if($exportar){
$viaturasAntigas_excel = $captacao->selectViaturasAntigas($dados);

$_html='';
$_html.='<table class="table " border="1" >';
$_html.='<tr>';
$_html.='<td colspan="5">Resultados : Pesquisa referente aos acionamentos Antigos  </td>';
$_html.='</tr>';
$_html.='<tr>';
$_html.='<td><b>Data</b></td>';
$_html.='<td><b>Hora</b></td>';
$_html.='<td>Conta</td>';
$_html.='<td>Atendente</td>';
$_html.='<td>Pontos</td>';
$_html.='</tr>';

foreach ($viaturasAntigas_excel as $k => $li) {
	$viaturas_data = Funcoes::FormataData($li ['data']);
	$viaturas_hora = !empty($li ['hora']) ? $li ['hora'] : '';
	$viaturas_conta = !empty($li ['conta']) ? $li ['conta'] : '';
	$viaturas_atendente = !empty($li ['atendente']) ? $li ['atendente'] : '';
	$viaturas_pontos = !empty($li ['pontos']) ? $li ['pontos'] : '';
	$viaturas_id = !empty($li ['id_viaturas']) ? $li ['id_viaturas'] : ''; 		
	$_html.='<tr>';				
	$_html.='<td>'.$viaturas_data.'</td>';
	$_html.='<td>'.$viaturas_hora.'</td>';
	$_html.='<td>'.$viaturas_conta.'</td>';
	$_html.='<td>'.$viaturas_atendente.'</td>';
	$_html.='<td>'.$viaturas_pontos.'</td>';		
	$_html.='</tr>';
	
} 
$_html.='</table>';

$arquivo = "relatorio.xls";

Funcoes::exportExel($_html, $arquivo );

exit();

}
?>

