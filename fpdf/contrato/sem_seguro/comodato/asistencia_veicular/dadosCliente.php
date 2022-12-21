 <?php
 $html = '	
    <div style=" margin:0 auto ;width:700px ; font-size:12px; " align="center">
        <div style="page-break-after:always;">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <td align="right">
                       <img src="../img/logo-contrato.jpg" width="207" height="67"  alt="" border="0"/>
                  </td>
                </tr>
                <tr>
                    <td align="center">
                        <strong>
                            CONTRATO DE ASSISTÊNCIA VEICULAR 24H
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                         <p align="justify">
                            <span  style="margin-left:45px">Pelo</span> presente instrumento particular e na melhor forma de direito, de um lado <strong>Volpato Serviços de Segurança LTDA. </strong>
                            estabelecida na Rua Amazonas 205, Porto Alegre/RS inscrita sob o CNPJ/MF 07.086.942/0001-83, doravante denominada CONTRATADA
                            e de outro lado, a pessoa Física ou Jurídica  doravante designada como CONTRATANTE:
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
            <table border="1" cellspacing="0" cellpadding="0" width="100%">';
                if($seguro !=true){
                    $html.='
                    <tr>
                        <td  colspan="4"><strong>NOME/ RAZÃO SOCIAL:</strong><br />'.$list_cliente['nome_cliente'].'</td>
                        <td><strong>DATA NASCIMENTO:</strong><br />'.$list_cliente['data_nascimento'].'</td>
                    </tr>';
                }else{
                    $html.='
                    <tr>
                        <td colspan="3"><strong>NOME/ RAZÃO SOCIAL:</strong><br />'.$list_cliente['nome_cliente'].'</td>
                        <td><strong>CPF/CNPJ:</strong><br />'.$list_cliente['cnpjcpf_cliente'].'</td>
                        <td><strong>ESTADO CIVIL:</strong><br />'.strtoupper($list_cliente['estado_civil']) .'</td>
                    </tr>';
                }			
                $html.='
                <tr>
                    <td  colspan="2" ><strong>INSC. MUNICIPAL:</strong><br />'.$list_cliente['inscr_municipal'].'</td>
                    <td><strong>INSC. ESTADUAL/RG:</strong> <br />'.$list_cliente['rg_cliente'].'</td>
                    <td  colspan="2" ><strong>CPF/CNPJ:</strong><br />'.$list_cliente['cnpjcpf_cliente'].'</td>
                </tr>';
                if(!empty($CONTATO1['nome_contato']) || !empty($CONTATO2['nome_contato'])){
                    if(!empty($CONTATO1['nome_contato'])){
                        $html.='
                        <tr>
                            <td colspan="2"><strong>1°CONTATO:</strong><br />'.$CONTATO1['nome_contato'].'</td>  
                            <td><strong>TELEFONE 1:</strong><br />'.$CONTATO1['telefone1_contato'].'</td>
                            <td><strong>TELEFONE 2:</strong><br />'.$CONTATO1['telefone2_contato'].'</td>
                            <td><strong>TELEFONE 3:</strong><br />'.$CONTATO1['telefone3_contato'].'</td> 
                        </tr>';
                         if(!empty($CONTATO1['email_contato'])){
                            $html.='
                             <tr>
                                <td colspan="5"><strong>E-MAIL /1°CONTATO:</strong><br />'.$CONTATO1['email_contato'].'</td>  
                            </tr>';
                         }
                    }
                    if(!empty($CONTATO2['nome_contato'])){
                        $html.='
                        <tr>
                            <td colspan="2"><strong>2°CONTATO:</strong><br />'.$CONTATO2['nome_contato'].'</td>  
                            <td><strong>TELEFONE 1:</strong><br />'.$CONTATO2['telefone1_contato'].'</td>
                            <td><strong>TELEFONE 2:</strong><br />'.$CONTATO2['telefone2_contato'].'</td>
                            <td><strong>TELEFONE 3:</strong><br />'.$CONTATO2['telefone3_contato'].'</td> 
                        </tr> ';
                        if(!empty($CONTATO2['email_contato'])){
                            $html.='<tr>
                            <td colspan="5"><strong>E-MAIL /2°CONTATO:</strong><br />'.$CONTATO2['email_contato'].'</td>  
                        </tr>';
                        }
                    }
                }else{
                    $html.='
                        <tr>
                            <td colspan="3"><strong>CONTATO:</strong><br />'.$list_cliente['contato_cliente'].'</td>  
                            <td colspan="2"><strong>E-MAIL:</strong><br />'.$list_cliente['email_cliente'].'</td>                 
                        </tr>
                        <tr>
                            <td colspan="3"><strong>TELEFONE 1:</strong><br />'.$list_cliente['telefone_cliente'].'</td>
                            <td colspan="2"><strong>TELEFONE 2:</strong><br />'.$list_cliente['celular_cliente'].'</td>
                        </tr>
                    ';
                }
                $html.='                
                <tr>
                    <td  colspan="3"><strong>ENDEREÇO RESIDENCIAL: </strong><br>'.$list_cliente['logradouro_cliente'].' N&deg; '.$list_cliente['numero_cliente'].'&nbsp;&nbsp;'.$list_cliente['complemento_cliente'].'</td>
                    <td  colspan="2"><strong>BAIRRO:</strong><br />'.$list_cliente['bairro_cliente'].'</td>                             
                </tr>
                <tr>
                    <td  colspan="3"><strong>CIDADE:</strong><br />'.$list_cliente['cidade_cliente'].'</td>
                    <td><strong>UF:</strong><br/>'.$list_cliente['uf_cliente'].'</td>
                    <td><strong>CEP:</strong><br>'.$list_cliente['cep_cliente'].'</td>
                </tr>';
                if(!empty($ENDERECO_COBRANCA['logradouro_cobranca'])){
                    $html.='
                    <tr>
                        <td colspan="3" ><strong>ENDEREÇO DE COBRANÇA:</strong><br />'.$ENDERECO_COBRANCA['logradouro_cobranca'].' N&deg; '.$ENDERECO_COBRANCA['numero_cobranca'].'&nbsp;&nbsp;'.$ENDERECO_COBRANCA['complemento_cobranca'].'</td>
                        <td colspan="2"><strong>BAIRRO:<br /> </strong>'.$ENDERECO_COBRANCA['bairro_cobranca'].'</td>
                    </tr>
                    <tr>
                        <td  colspan="3"><strong>CIDADE:</strong><br />'.$ENDERECO_COBRANCA['cidade_cobranca'].'</td>
                        <td><strong>UF:</strong><br />'.strtoupper($ENDERECO_COBRANCA['uf_cobranca']).'</td>
                        <td><strong>CEP: </strong><br>'.$ENDERECO_COBRANCA['cep_cobranca'].'</td>
                    </tr>';
                }
                if(!empty($ENDERECO_ENTREGA['logradouro_cobranca'])){
                    $html.='
                    <tr>
                        <td colspan="3" ><strong>ENDEREÇO DE ENTREGA:</strong><br />'.$ENDERECO_ENTREGA['logradouro_cobranca'].' N&deg; '.$ENDERECO_ENTREGA['numero_cobranca'].'&nbsp;&nbsp;'.$ENDERECO_ENTREGA['complemento_cobranca'].'</td>
                        <td colspan="2"><strong>BAIRRO:<br /> </strong>'.$ENDERECO_ENTREGA['bairro_cobranca'].'</td>
                    </tr>
                    <tr>
                        <td  colspan="3"><strong>CIDADE:</strong><br />'.$ENDERECO_ENTREGA['cidade_cobranca'].'</td>
                        <td><strong>UF:</strong><br />'.strtoupper($ENDERECO_ENTREGA['uf_cobranca']).'</td>
                        <td><strong>CEP: </strong><br>'.$ENDERECO_ENTREGA['cep_cobranca'].'</td>
                    </tr>
                    <tr>
                        <td  colspan="3"><strong>A/C:</strong><br />'.$ENDERECO_ENTREGA['contato_cobranca'].'</td>
                        <td><strong>TELEFONE:</strong><br />'.strtoupper($ENDERECO_ENTREGA['telefone_cobranca']).'</td>
                        <td><strong>CELULAR: </strong><br>'.$ENDERECO_ENTREGA['celular_cobranca'].'</td>
                    </tr>';
                }
                $html.='<tr>
                    <td colspan="5"><strong>OBSERVAÇÕES:</strong><br />'.nl2br($list_cliente['obs_clientes']).'</td>
                </tr>
            </table>';