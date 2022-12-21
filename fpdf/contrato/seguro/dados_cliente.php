 <?php
 $html ='	
    <div style=" margin:0 auto ;width:700px ; font-size:12px; text-align:justify" >
        <div style="page-break-after:always;">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <td align="right">
                       <img src="../img/logo-contrato.jpg" width="160" height="50"  alt="" border="0"/>
                  </td>
                </tr>
                <tr>
                    <td align="center">
                        <h4>
                            CONTRATO PARTICULAR DE LOCAÇÃO DO RASTREADOR VEICULAR    
                        </h4>
                    </td>
                </tr>
                <tr>
                    <td>
                         <p align="justify">
                         <b> 1.  DAS PARTES DO CONTRATO</b>
                         </p> 
                         <p>
                             <b>1.1. CONTRATADA: VOLPATO SERVIÇOS DE SEGURANÇA LTDA.</b> inscrita sob o CNPJ/MF 07.086.942/0001-83, estabelecida na Rua Amazonas, nº 205, bairro Navegantes, na cidade de Porto Alegre/RS, CEP 90.240-540, representada neste ato na forma de seu Contrato Social.
                         </p>
                    </td>
                </tr>
                <tr>
                   <td align="left">
                         <h4> 1.2. CONTRATANTE </h4>
                   </td>
                 </tr>
            </table>
            <table border="1" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td  colspan="5"><strong>NOME/ RAZÃO SOCIAL:</strong><br />'.$list_cliente['nome_cliente'].'</td>
                </tr>
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
                $html.='<tr>
                    <td colspan="5"><strong>OBSERVAÇÕES:</strong><br />'.nl2br($list_cliente['obs_clientes']).'</td>
                </tr>
            </table>
            ';