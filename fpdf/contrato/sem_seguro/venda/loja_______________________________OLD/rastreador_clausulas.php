<?php

$html .='
<br>
<p align="left" style="font-size:14px">E, por estarem assim justas e contratadas, as PARTES firmam este CONTRATO em 03 (três) vias de igual teor e forma, para um só efeito, juntamente com as duas testemunhas firmatárias, para que produza seus efeitos jurídicos e legais.</p>
<p align="right" style="font-size:14px"> Porto  Alegre, ' . $dma[0] . ' de ' . $mes . ' de  ' . $dma[2] . '</p>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<table width="100%" border="0" align="right" cellpadding="0" cellspacing="0" style="font-size:12px">
      <tr>
          <td height="40" align="center" >';
             if($list_cliente["tipo_assinatura"]=="ad"){
                $html.='<img src="../img/assinatura1.jpg" alt="" width="143" height="45"  border="0"/>';
            }    
         $html.=' </td>
          <td height="40" align="center" >&nbsp;</td>
      </tr>
      <tr>
           <td width="55%" valign="top">
           <div align="left" style=" margin:0;margin-right:10px; border-top:1px solid">
           <strong>CONTRATADA : </strong>
           VOLPATO SERVIÇOS DE SEGURANÇA LTDA.
           <br />
           <strong>CNPJ Nº: </strong>07.086.942/0001-83
           <br />
           <strong>NOME LEGÍVEL : </strong>Cristina Rosmann Volpato
           <br />
           <strong>CPF Nº: </strong>954.787.950-20
           </div>
           </td>
           <td width="55%" valign="top">
             <div align="left" style=" margin:0;margin-left:10px; border-top:1px solid">';
if ($list_cliente['tipo_pessoa'] == 'F' || $list_cliente['tipo_pessoa'] == 'f'):
    $html .='
                           <strong>CONTRATANTE  : </strong>' . $nome_cliente . '<br />   
                           <strong>CNPJ/CPF Nº  : </strong>' . $cpf_cliente . '<br />
                           <strong>NOME LEGÍVEL : </strong>' . $nome_cliente . '<br />
                           <strong>CPF N º      : </strong>' . $cpf_cliente . '</div>';
endif;

if ($list_cliente['tipo_pessoa'] == 'J' || $list_cliente['tipo_pessoa'] == 'j'):
    $html .='
                                   <strong>CONTRATANTE  : </strong>' . $list_cliente['nome_cliente'] . '<br />
                                   <strong>CNPJ/CPF Nº  : </strong>' . $list_cliente['cnpjcpf_cliente'] . '<br />';
    if (!empty($list_cliente['socio_1']) && empty($list_cliente['socio_2'])):
        $html .='
                                                   <strong>NOME LEGÍVEL : </strong>' . $list_cliente['socio_1'] . '<br />
                                                   <strong>CPF N º      : </strong>' . $list_cliente['cpf_socio1'] . '</div>
                                      ';
    endif;
    if (!empty($list_cliente['socio_1']) && !empty($list_cliente['socio_2'])):
        $html .='
                                                    <strong>NOME LEGÍVEL : </strong>' . $list_cliente['socio_1'] . '<br />
                                                    <strong>CPF N º      : </strong>' . $list_cliente['cpf_socio1'] . '<br />
                                                    <strong>NOME LEGÍVEL : </strong>' . $list_cliente['socio_2'] . '<br />
                                                   <strong>CPF N º      : </strong>' . $list_cliente['cpf_socio2'] . '</div>
                                      ';
    endif;
endif;
$html .='
           </td>
     </tr>
     <tr>
           <td colspan="2"><br><br></td>
     </tr> 
     <tr>
           <td height="16"><strong> TESTEMUNHAS:</strong></td>
           <td>&nbsp;</td>
     </tr>
     <tr>
           <td align="center">';
                        if($list_cliente["tipo_assinatura"]=="ad"){
                            $html.='<img src="../img/assinaturas/'.$list_assinatura['assinatura'].'" alt="" width="143" height="45"  border="0"/>';
                        }    
               $html.=' </td>
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
';
