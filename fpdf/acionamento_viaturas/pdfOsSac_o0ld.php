<?php
require_once ("dompdf/dompdf_config.inc.php");

$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ordem de Serviço</title>
<style type="text/css">
table{ font:11px Arial, Helvetica, "sans-serif"; }
h1{ font-size:13px;font-weight:bold;;}
._span{padding:3px 0 3px 0; width:100%;background:#DADADA;float:left}
body{margin:0;padding:0}
</style>
</head>
<body>
<table  width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
	<thead>
    	<tr>
		<td>
			<table width="100%" cellpadding="3" cellspacing="2" border="0">
			  <tr>
			    <td align="left"> <img src="logo_volpato.png" width="180" height="32" border="0" alt="" style="float:left" /></td>
		 	    <td align="right"><h1 style="font-size:20px;">Ordem de Serviço</h1></td>
			  </tr>
			</table>
	    </td>
	  </tr>
    </thead>
    <tbody>
        <tr>
          <td>
             <table width="100%" cellpadding="3" cellspacing="2" border="0">
                <tbody>
                  <tr >
                    <td colspan="4"><h1>Dados do Cliente</h1></td>
                     <td  align="right"><strong>N° da OS:1548<br />Data: 12/12/1988</strong></td>
                  </tr>
                  <tr>
                    <td colspan="5">Nome / Razão Social:<br /><div class="_span">PEDRO ADELAIR NASCENTE JARDIM</div></td>
                  </tr>
                  <tr>
                    <td colspan="2" >Cep.:<br /><div class="_span">90880-310</div></td>
                    <td colspan="3">Logradouro:<br /><div class="_span">RUA. MOAB CALDAS </div></td>
                  </tr>
                  <tr>
                    <td>N°<br /><div class="_span">174</div></td>
                    <td>Complemento:<br /><div class="_span">EM FRENTE A LOJAS RENNER</div></td>
                    <td>Bairro:<br /><div class="_span">STA TEREZA</div></td>
                    <td>Cidade:<br /><div class="_span">PORTO ALEGRE</div></td>
                    <td>UF:<br /><div class="_span">RS</div></td>
                  </tr>
                  <tr>
                    <td colspan="3">Contato1<br /><div class="_span">RICARDO DA ROSA SOARS</div></td>
                    <td>DDD:<br /><div class="_span">51</div></td>
                    <td>Telefone:<br /><div class="_span">98588-9985</div></td>
                  </tr>
                </tbody>
             </table>  
          </td>
        </tr>
        <tr>
          <td>
             <table width="100%" cellpadding="3" cellspacing="2" border="0">
                <tbody>
                  <tr>
                    <td colspan="4"><h1>Dados veículo</h1></td>
                  </tr>
                  <tr>
                    <td>Plca:<br /><div class="_span">98588-9985</div></td>
                    <td>Marca:<br /><div class="_span">98588-9985</div></td>
                    <td>Modelo:<br /><div class="_span">98588-9985</div></td>
                    <td>Cor:<br /><div class="_span">98588-9985</div></td>
                  </tr>
                  <tr>
                    <td>Ano:<br /><div class="_span">98588-9985</div></td>
                    <td>Renavam:<br /><div class="_span">98588-9985</div></td>
                    <td>Chassi:<br /><div class="_span">98588-9985</div></td>
                    <td>Voltagem:<br /><div class="_span">98588-9985</div></td>
                  </tr>
                </tbody>
             </table> 
          </td>
        </tr>
         <tr>
          <td>
             <table width="100%" cellpadding="3" cellspacing="2" border="0">
                <tbody>
                  <tr>
                    <td colspan="4"><h1>Dados do Equipamento</h1></td>
                  </tr>
                  <tr>
                    <td>Serial Módulo:<br /><div class="_span">98588-9985</div></td>
                    <td>Chip:<br /><div class="_span">98588-9985</div></td>
                    <td>Operadora:<br /><div class="_span">98588-9985</div></td>
                    <td>Modelo:<br /><div class="_span">98588-9985</div></td>
                  </tr>
                </tbody>
             </table> 
          </td>
        </tr>
        <tr>
          <td>
              <table width="100%" cellpadding="3" cellspacing="2" border="0">
                <tbody>
                  <tr>
                    <td colspan="4"><h1>Dados de Instação</h1></td>
                  </tr>
                  <tr>
                    <td>Local do Módulo:<br /><div class="_span">98588-9985</div></td>
                    <td>Local Botão Pânico:<br /><div class="_span">98588-9985</div></td>
                    <td colspan="2">Local da Sirene:<br /><div class="_span">98588-9985</div></td>
                  </tr>
                  <tr>
                    <td>Data Instalação:<br /><div class="_span">98588-9985</div></td>
                    <td colspan="4">Responsavel pela Instalação:<br /><div class="_span">98588-9985</div></td>
                  </tr>
                </tbody>
             </table> 
          </td>
        </tr>
         <tr>
          <td>
             <table width="100%" cellpadding="3" cellspacing="2" border="0">
                <tbody>
                  <tr>
                    <td><h1>Dados da Ordem de Serviço</h1></td>
                  </tr>
                  <tr>
                    <td>Motivo da Manutenção:<br /><div class="_span">98588-9985</div></td>
                  </tr>
                  <tr>
                    <td>Manutenção Efetuada:
					   <br /><div class="_span">&nbsp;</div>
					   <br /><div class="_span">&nbsp;</div>
					   <br /><div class="_span">&nbsp;</div>
					   <br /><div class="_span">&nbsp;</div>
					 </td>
                  </tr>
                </tbody>
             </table> 
          </td>
        </tr>
     </tbody>
     <tfoot>
       <tr>
         <td>
          <table width="100%" cellpadding="6" cellspacing="5" border="0">
            <tbody>
                  <tr>
                    <td>&nbsp;</td>
                     <td>&nbsp;</td>
                  </tr>
				  <tr>
                    <td>&nbsp;</td>
                     <td>&nbsp;</td>
                  </tr>
				  
                  <tr>
                    <td style="border-bottom: 2px solid #000;width:50%">&nbsp;</td>
                    <td style="border-bottom:2px solid #000;width:50%">&nbsp;</td>
                  </tr>
                  <tr align="center">
                    <td>Técnico Responsável</td>
                    <td>Cliente</td>
                  </tr>
            </tbody> 
         </table>
         </td>
       </tr>
     </tfoot>
</table>
</body>
</html>';

// objeto que cria o arquivo PDF.
$dompdf = new DOMPDF ();
$dompdf->load_html ( $html );
$dompdf->set_paper ( "a4", "portrait" );
$dompdf->render ();
$dompdf->stream ( "os.pdf" ); 













