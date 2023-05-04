<?php
$html .= '
<div style="page-break-after:always;"> 
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:12px">
        <tr>
            <td height="45" colspan="2" align="center"> Porto  Alegre, ' . $dma[0] . ' de ' . $mes . ' de  ' . $dma[2] . '</td>
        </tr>
	<tr>
	   <td height="40" align="center" >';
if ($list_cliente["tipo_assinatura"] == "ad") {
  $html .= '<img src="../img/assinatura1.jpg" alt="" width="143" height="45"  border="0"/>';
}
$html .= '</td>
	   <td height="40" align="center" >&nbsp;</td>
	</tr>
	<tr>
            <td width="55%" valign="top">
                <div align="left" style=" margin:0;margin-right:10px; border-top:1px solid">
                    <strong>CONTRATADA : </strong>VOLPATO SERVIÇOS DE SEGURANÇA LTDA.<br />
                    <strong>CNPJ Nº: </strong>07.086.942/0001-83<br />
                    <strong>NOME LEGÍVEL : </strong>Cristina Rosmann Volpato<br />
                    <strong>CPF Nº: </strong>954.787.950-20
                </div>
            </td>
            <td width="55%" valign="top">
		<div align="left" style=" margin:0;margin-left:10px; border-top:1px solid">';
if ($list_cliente['tipo_pessoa'] == 'F' || $list_cliente['tipo_pessoa'] == 'f') :
  $html .= '
                          <strong>CONTRATANTE  : </strong>' . $nome_cliente . '<br />   
                          <strong>CNPJ/CPF Nº  : </strong>' . $cpf_cliente . '<br />
                          <strong>NOME LEGÍVEL : </strong>' . $nome_cliente . '<br />
                          <strong>CPF N º      : </strong>' . $cpf_cliente . '</div>';
endif;
if ($list_cliente['tipo_pessoa'] == 'J' || $list_cliente['tipo_pessoa'] == 'j') :
  $html .= '
                        <strong>CONTRATANTE  : </strong>' . $list_cliente['nome_cliente'] . '<br />
                        <strong>CNPJ/CPF Nº  : </strong>' . $list_cliente['cnpjcpf_cliente'] . '<br />';
endif;
$html .= '
		</td>
	  </tr>';


if (!empty($list_cliente['socio_1']) && !empty($list_cliente['socio_2'])) :

  $html .= '
    <tr>
        <td colspan="2"><br><br></td>
    </tr> 
    <tr>
        <td height="16"><strong> SÓCIOS:</strong></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
            <td colspan="2"><br><br></td>
    </tr> 
    <tr>
        <td>
            <div align="left" style=" margin:0;margin-right:10px; border-top:1px solid">
            <strong>1º SÓCIO : </strong>' . $list_cliente['socio_1']  . '<br />
            <strong> &nbsp; &nbsp; CPF: </strong>' . $list_cliente['cpf_socio1'] . '<br />
            </div>
        </td>
        <td>
            <div align="left" style=" margin:0;margin-left:30px; border-top:1px solid; font-weight:bold">
                <strong>2º SÓCIO : </strong>' . $list_cliente['socio_2']  . '<br />
                <strong> &nbsp; &nbsp; CPF: </strong>' . $list_cliente['cpf_socio2'] . '<br />
            </div>
        </td>
    </tr>';

endif;

if (!empty($list_cliente['socio_1']) && empty($list_cliente['socio_2'])) :

  $html .= '
    <tr>
        <td colspan="2"><br><br></td>
    </tr> 
    <tr>
        <td height="16"><strong> SÓCIO:</strong></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2"><br><br></td>
    </tr> 
    <tr>
        <td>
            <div align="left" style=" margin:0;margin-right:10px; border-top:1px solid">
            <strong>1º SÓCIO : </strong>' . $list_cliente['socio_1']  . '<br />
            <strong> &nbsp; &nbsp; CPF: </strong>' . $list_cliente['cpf_socio1'] . '<br />
            </div>
        </td>
    </tr>	';

endif;

$html . '
	  <tr>
		<td colspan="2"><br><br></td>
	  </tr> 
	  <tr>
		<td height="16"><strong> TESTEMUNHAS:</strong></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td align="center">';
if ($list_cliente["tipo_assinatura"] == "ad") {
  $html .= '<img src="../img/assinaturas/' . $list_assinatura['assinatura'] . '" alt="" width="143" height="45"  border="0"/>';
}
$html .= ' </td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>
		  <div align="left" style=" margin:0;margin-right:10px; border-top:1px solid">
			<strong>1º NOME : </strong>' . $list_assinatura['nome'] . '<br />
			<strong> &nbsp; &nbsp; CPF: </strong>' . $list_assinatura['cpf'] . '<br />
		  </div>
		</td>
		<td>
		  <div align="left" style=" margin:0;margin-left:30px; border-top:1px solid; font-weight:bold">
			2º<br />
			.
		   </div>
		  </td>
	  </tr>
	  </table>
          
</div>';
