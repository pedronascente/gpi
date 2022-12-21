<?php
include_once '../../Config.inc.php';
include_once './formataDados.php';

$id_setor = filter_input ( INPUT_GET, 'id_s', FILTER_VALIDATE_INT );
$id_usuario = filter_input ( INPUT_GET, 'id_u', FILTER_VALIDATE_INT );
$acao = filter_input ( INPUT_GET, 'acao', FILTER_VALIDATE_INT );

$total = 0;
$pcf = new PedidoComissaoFuncionario (); 
$pcf->selDadoFuncionario ($id_usuario);

$total = $pcf->somarComissoes($pcf->get_pcf_id())-$pcf->somarDescontos($pcf->get_pcf_id());
$pc = new PedidoComissao ();
$lista_pedidoComissao = $pc->select (array("id_usuario"=>$id_usuario));


if($pcf->get_pcf_id_empresa()==10) {
      $pegar_image_logo = "logo_easyseg.jpg";
}else{
     $pegar_image_logo = "logo_volpato.jpg";
}  

$html = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
    table{font-size:10px ; font-family:Arial, Helvetica, sans-serif}
      .pc_img{padding:0 0 0 30px}
      .linhatr{background:url(img/02.jpg)  repeat-x  top; width:1px; height:4px;}
    </style>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td colspan="5">
     <img src="img/'.$pegar_image_logo.'" width="180" height="" border="0" alt="'.$pegar_image_logo.'"  />
  </td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td colspan="5">
   <br />
   <strong> Comiss&otilde;es Comercial - '.$pcf->get_setor().'</strong>
  </td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td><strong>Nome</strong><br />'.$pcf->get_nomeFuncionario().'</td>
  <td><strong>Matr&iacute;cula</strong><br />'.$pcf->get_matriculaFuncionario().'</td>
  <td><strong>CTPS</strong><br />'.$pcf->get_ctpsFuncionario().'</td>
  <td><strong>Periodo</strong><br />'.$pcf->get_pcf_periodo().'</td>
  <td><strong>Ano</strong><br />'.$pcf->get_pcf_ano().'</td>
</tr>
</table>';

for($i = 0; $i<= 2; $i++):
$html.='<br>';
endfor;

//ARQUIVO QUE CONTEM TODAS AS TABELAS REFERENTES AO SETORES:
include ("../../modulos/pedidoComissao/src/views/listas/tables/pdfs/pdfs_setores.php");
	
for($i = 0; $i<= 2; $i++):
$html.='<br>';
endfor;
$html.='<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr align="right">
<td colspan="2">Total de Comiss&otilde;es : R$  '.Funcoes::formartaMoedaReal($total).'</td>
</tr>
</tbody>
<tfoot align="center">';
for($i = 0; $i<= 6; $i++):
$html.='<tr><td colspan="2">&nbsp;</td> </tr>';
endfor;
$html.='
    <tr align="center">
        <td><span>_______________________________________________</span><br>'.$pcf->get_nomeFuncionario().'</td>
        <td><span>_______________________________________________</span><br>Conferente</td>
    </tr>
  </tfoot>
</table>';

if($acao=='92399880'){
    include './formataDados_1.php';
    $NOME_FUNCIONARIO = $_GET['nomeFuncionario'];
    $MATRICULA_FUNCIONARIO = $_GET['matricula'];
    $CTPS_FUNCIONARIO = $_GET['ctps'];
    $PERIODO_FUNCIONARIO = $_GET['periodo'];
    $ANO = $_GET['ano']; 
    $TOTAL = $_GET['_vtotal'];    
    $html = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
    table{font-size:10px ; font-family:Arial, Helvetica, sans-serif}
      .pc_img{padding:0 0 0 30px}
      .linhatr{background:url(img/02.jpg)  repeat-x  top; width:1px; height:4px;}
    </style>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="5">
           <img src="img/'.$pegar_image_logo.'" width="180" height="" border="0" alt="'.$pegar_image_logo.'"  />
        </td>
      </tr>
      <tr>
          <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5">
         <br />
         <strong> Comiss&otilde;es Comercial - '.$pcf->get_setor().'</strong>
        </td>
      </tr>
      <tr>
         <td colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Nome</strong><br />'.$NOME_FUNCIONARIO.'</td>
        <td><strong>Matr&iacute;cula</strong><br />'.$MATRICULA_FUNCIONARIO.'</td>
        <td><strong>CTPS</strong><br />'.$CTPS_FUNCIONARIO.'</td>
        <td><strong>Periodo</strong><br />'.$PERIODO_FUNCIONARIO.'</td>
        <td><strong>Ano</strong><br />'.$ANO.'</td>
      </tr>
    </table>';

for($i = 0; $i<= 2; $i++):
$html.='<br>';
endfor;

//ARQUIVO QUE CONTEM TODAS AS TABELAS REFERENTES AO SETORES:
include ("../../modulos/pedidoComissao/src/views/listas/tables/pdfs/pdfs_setores_1.php");
	
for($i = 0; $i<= 2; $i++):
$html.='<br>';
endfor;
//Com base nos dias trabalhados:
$html.='<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tbody>
    <tr align="right">
        <td colspan="5">*Valor Total Recebido Referente ao Percentual da equipe técnica. <BR>
        </td>
    </tr>
    <tr>
        <td colspan="5"> <br></td>
    </tr>
    <tr align="right">
        <td colspan="5" style="font-size:16;">Total: R$  '.$TOTAL.'</td>
    </tr>
</tbody>
<tfoot align="center">';
	
for($i = 0; $i<= 6; $i++):
$html.='<tr><td colspan="2">&nbsp;</td> </tr>';
endfor;
$html.='
        <tr align="center">
            <td><span>_______________________________________________</span><br>'.$NOME_FUNCIONARIO.'</td>
            <td><span>_______________________________________________</span><br>Conferente</td>
        </tr>
  </tfoot>
</table>';
}





//echo $html ; 






// objeto que cria o arquivo PDF.

include_once ("../dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF ();
$dompdf->load_html ( $html ,'UTF-8');
$dompdf->set_paper ( "a4", "portrait" );
$dompdf->render ();
$dompdf->stream ( "pedido_comissao.pdf" ); 
/*

*/