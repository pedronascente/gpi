 <?php
  $html = '	
        <style type="text/css">
                ul{text-align:left;}	ul li{list-style:none;}	#aa{text-align:left;}
        </style>
        <div style=" margin:0 auto ;width:700px ; font-size:11px; " align="center">
            <div style="page-break-after:always;">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                     <tr>
                       <td align="right">
                             <img src="../img/logo-contrato.jpg" width="207" height="67"  alt="" border="0"/>
                       </td>
                     </tr>
                     <tr>
                       <td align="center">
                             <strong>CONTRATO DE PRESTAÇÃO DE SERVIÇO DE MONITORAMENTO</strong>
                       </td>
                     </tr>
                     <tr>
                         <td>
                             <p align="justify">
                                 <span  style="margin-left:45px">Pelo</span> presente instrumento particular e na melhor forma de direito, de um lado  VOLPATO SERVIÇOS DE SEGURANÇA LTDA,  estabelecida na   Rua Amazonas, 205  Bairro Navegantes , Porto Alegre/RS inscrita sob o CNPJ 07.086.942/0001-83 doravante denominada CONTRATADA e de outro  lado, a pessoa Física ou Jurídica doravante designada como CONTRATANTE, devidamente qualificado nas CONDIÇÕES GERAIS DO CONTRATO DE PRESTAÇÃO DE SERVIÇO DE MONITORAMENTO , que é parte complementar e indissociável deste Contrato, ajustam entre si, o presente contrato de prestação de serviço de monitoramento. 
                             </p> 
                         </td>
                     </tr>
                     <tr>
                       <td align="left">
                             <strong>
                                     I - IDENTIFICAÇÃO DO CONTRATANTE
                             </strong>
                       </td>
                     </tr>
               </table>
                <table border="1" cellspacing="0" cellpadding="0" width="100%">
                      <tr>
                          <td  colspan="2"><strong>NOME/ RAZÃO SOCIAL:</strong><br />'.$list_cliente['nome_cliente'].'</td>
                          <td><strong>CIC/CNPJ/MF:</strong><br />'.$list_cliente['cnpjcpf_cliente'].'</td>
                          <td><strong>ESTADO CIVIL:</strong><br />'.strtoupper($list_cliente['estado_civil']) .'</td>
                      </tr>	
                      <tr>
                          <td  colspan="2" ><strong>INSC. MUNICIPAL:</strong><br />'.$list_cliente['inscr_municipal'].'</td>
                          <td  colspan="2" ><strong>INSC. ESTADUAL/RG:</strong> <br />'.$list_cliente['rg_cliente'].'</td>
                      </tr>
                      <tr>
                          <td  colspan="2" ><strong>ENDEREÇO: </strong><br>'.$list_cliente['logradouro_cliente'].' N&deg; '.$list_cliente['numero_cliente'].'&nbsp;&nbsp;'.$list_cliente['complemento_cliente'].'</td>
                          <td width="52%" colspan="2"><strong>BAIRRO:</strong><br />'.$list_cliente['bairro_cliente'].'</td>
                      </tr>
                      <tr>
                          <td width="27%" ><strong>CIDADE:</strong><br />'.$list_cliente['cidade_cliente'].'</td>
                          <td width="21%"  colspan="1"><strong>UF:</strong><br />'.$list_cliente['uf_cliente'].'</td>
                          <td colspan="2"><strong>CEP: </strong><br>'.$list_cliente['cep_cliente'].'</td>
                      </tr>
                      <tr>
                          <td ><strong>FONE:</strong><br />'.$list_cliente['telefone_cliente'].'/'.$list_cliente['celular_cliente'].'</td>
                          <td colspan="1"><strong>CONTATO:</strong><br />'.$list_cliente['contato_cliente'].'</td>
                          <td colspan="2"><strong>E-MAIL:</strong><br />'.$list_cliente['email_cliente'].'</td>
                      </tr>
                      <tr>
                          <td colspan="2" ><strong>ENDEREÇO DE COBRANÇA:</strong><br />'.$list_cliente['logradouro_cobranca'].' N&deg; '.$list_cliente['numero_cobranca'].'&nbsp;&nbsp;'.$list_cliente['complemento_cobranca'].'</td>
                          <td colspan="2"><strong>BAIRRO:<br /> </strong>'.$list_cliente['bairro_cobranca'].'</td>
                      </tr>
                      <tr>
                          <td><strong>CIDADE:</strong><br />'.$list_cliente['cidade_cobranca'].'</td>
                          <td  colspan="1"><strong>UF:</strong><br />'.strtoupper($list_cliente['uf_cobranca']).'</td>
                          <td colspan="2"><strong>CEP: </strong><br>'.$list_cliente['cep_cobranca'].'</td>
                      </tr>
                      <tr>
                          <td colspan="4" ><strong>FONE:</strong><br />'.$list_cliente['telefone_cobranca'].' / '.$list_cliente['celular_cobranca'].'</td>
                      </tr>
                      <tr>
                          <td colspan="4"><strong>OBSERVAÇÕES:</strong><br />'.nl2br($list_cliente['obs_clientes']).'</td>
                      </tr>
                </table>
            <br>
            <table width="100%" border="0">
                  <tr>
                      <td>
                          <div align="left">
                              <strong>II - DADOS DO VEÍCULO:</strong>
                          </div>
                       </td>
                  </tr>
            </table>';