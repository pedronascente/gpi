<?php
$html.='
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
      <td>
              <div align="left">
                    <strong>
                            III - VALORES:
                    </strong>
              </div>
       </td>
      <td></td>
    </tr>
</table> 
<table border="1" cellspacing="0" cellpadding="0"  width="100%">
    <tr>
      <td width="47%"  align="left">
        <strong>'.$detalheVeiculos.' &nbsp; Valor Total  R$ '.$valor_equipamento.'</strong>
      </td>
      <td width="53%" align="center">
                    <strong>FORMA DE PAGAMENTO DA COMPRA DO EQUIPAMENTO:</strong><br /><br />
      </td>
    </tr>
    <tr>
      <td align="center">
                    <br /><strong>HABILITAÇÃO: ISENTO </strong> <br /><br />
      </td>
      <td align="center">
              <strong>TAXA DE MONITORAMENTO MENSAL: R$ '.$vlr_tx_monitoramento.' <br> 
		   	Melhor dia para efetuar o Pagamento: '.$list_cliente['diaMelhorPagamento'].' <br>
		   ISENTO POR 12 MESES</strong><br />      </td>
    </tr>

    <tr>
      <td align="center">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" style="border-right:solid 1px; border-bottom:solid 1px;">DATA</td>
              <td align="center" style="border-bottom:solid 1px;">VALOR</td>
          </tr>
          <tr>
              <td align="center" style="border-right:solid 1px;">'.$list_cliente["data_pagamento"].'</td>
              <td align="center">R$: '.$valor_equipamento.'</td>
          </tr>
          </table>
      </td>
      <td align="center">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" style="border-right:solid 1px; border-bottom:solid 1px;">Nº. DO DOCUMENTO</td>
              <td align="center" style="border-bottom:solid 1px;">MEIO</td>
          </tr>
          <tr>
              <td align="center" style="border-right:solid 1px;">PAGAMENTO À VISTA</td>
              <td align="center">'.$arrFormaPgto[$list_cliente["forma_pagamento"]].'</td>
          </tr>		   
          </table>	  
      </td>     		  	
      </tr>	 	
	  <tr><td colspan="2"><strong>OBSERVAÇÕES:</strong><br />'.$list_cliente["obs_diaPagamento"].'</td></tr>
</table>';