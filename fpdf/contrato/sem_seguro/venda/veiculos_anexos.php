<?php   
$html.= '
</div>
<div style="page-break-after:always;">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td style="padding:2px" align="center"><strong>ANEXO I</strong></td>
        </tr>
        <tr>
            <td style="padding:2px"><strong> DADOS DOS VEÍCULOS:  </strong></td>
        </tr>
    </table>';
if($list_veiculos)
{
    $i = 1;
    $_PROTECAO = false;
    
    foreach($list_veiculos as $veiculo)
    {
        $break = "";
        /*
		if($i == 20)
        {
            $i = 1;
            $break =  'style="page-break-after:always"';
        }
		*/

        $combustivel = "";
        if(!empty($veiculo['combustivel']))
        {
            switch ($veiculo['combustivel'])
            {
                case 1: $combustivel = "COMBUSTÍVEL"; break;
                case 2: $combustivel = "ÁLCOOL"; break;
                case 3: $combustivel = "BICOMBUSTÍVEL"; break;
                case 4: $combustivel = "DIESEL"; break;
                case 5: $combustivel = "GNV"; break;
                case 6: $combustivel = "GASOLINA"; break;
            }
        }

        $bloqueio = ($veiculo['bloqueio'] == 's') ? 'SIM':'NÃO';
        $html .='
        <table border="1" cellspacing="0" cellpadding="0" width="100%" '.$break.'>
            <tr>
                <td style="padding:2px"><strong>MARCA/MODELO:</strong><br />'.$veiculo['marca'].'/'.$veiculo['modelo'].'</td>
                <td style="padding:2px"><strong>ANO:</strong><br />'.$veiculo['ano'].'</td>
                <td style="padding:2px"><strong>COMBUSTÍVEL:</strong><br />'.$combustivel.'</td>
                <td style="padding:2px"><strong>COR: </strong><br />'.$veiculo['cor'].'</td>
                <td style="padding:2px"><strong>BLOQUEIO: </strong><br />'.$bloqueio.'</td>
            </tr>
            <tr>
                <td style="padding:2px"><strong>PLACA:</strong><br />'.$veiculo['placa'].'</td>
                <td style="padding:2px" colspan="2" ><strong>CHASSI:</strong><br />'.$veiculo['chassis'].'</td>
                <td style="padding:2px"><strong>RENAVAM: </strong><br />'.$veiculo['renavam'].'</td>
                <td style="padding:2px"><strong>BATERIA:</strong><br />';
                    if($veiculo['tipo_bateria']=="12V")
                    { 
                        $html.='12 VOLTS';}else{$html.='24 VOLTS';
                    }; 
                    $html .='
                </td>
            </tr>
            <tr>    
                <td style="padding:2px"> <strong>SERVIÇO:</strong><br>RASTREAMENTO</td>
                <td style="padding:2px" colspan="2"><strong>TAXA MENSAL:</strong><br> R$'.$veiculo['taxa_monitoramento'].'</td> 
                <td style="padding:2px" colspan="2"><strong>TAXA HABILITAÇÃO  :</strong><br> R$'.$veiculo['taxa_instalacao'].'</td>
            </tr>';
                  
            if($veiculo['tipo_seguro'] == "Rastreamento + Proteção veicular")
            {
                $html .='
                <tr>    
                    <td style="padding:2px" colspan="3"> <strong>SERVIÇO:</strong><br> PROTEÇÃO VEICULAR</td>
                    <td style="padding:2px" colspan="2"><strong>TAXA MENSAL:</strong><br> R$'.$veiculo['valor_protecao'].'</td> 
                </tr>';  
            } 

            if($veiculo['tipo_seguro'] == "Rastreamento + Assistência Veicular")
            {
                $html .='     
                <tr>    
                    <td style="padding:2px" colspan="2"><strong>SERVIÇO:</strong><br> ASSISTÊNCIA VEICULAR</td>
                    <td style="padding:2px" colspan="3"><strong>TAXA MENSAL:</strong><br> R$'.$veiculo['valor_protecao_assistencial'].'</td>
                </tr>';  
            }    

            if($veiculo['tipo_seguro'] == "Rastreamento + Proteção veicular + Assistência Veicular")
            {
                $html .='
                <tr>    
                    <td style="padding:2px"> <strong>SERVIÇO:</strong><br>RASTREAMENTO</td>
                    <td style="padding:2px" colspan="2"><strong>TAXA MENSAL:</strong><br> R$'.$veiculo['taxa_monitoramento'].'</td> 
                    <td style="padding:2px" colspan="2"><strong>TAXA HABILITAÇÃO  :</strong><br> R$'.$veiculo['taxa_instalacao'].'</td>
                </tr>
                <tr>    
                    <td colspan="2"> <strong>SERVIÇO:</strong><br> PROTEÇÃO VEICULAR</td>
                    <td colspan="3"><strong>TAXA MENSAL:</strong><br> R$'.$veiculo['valor_protecao'].'</td> 
                </tr>
                <tr>    
                    <td style="padding:2px" colspan="2"> <strong>SERVIÇO:</strong><br> ASSISTÊNCIA VEICULAR</td>
                    <td style="padding:2px" colspan="3"><strong>TAXA MENSAL:</strong><br> R$'.$veiculo['valor_protecao_assistencial'].'</td> 
                </tr>';  
            }        

            $html .='
            <tr>
                <td style="padding:2px" colspan="5"><strong>OBSERVAÇÕES:</strong><br />'.nl2br($veiculo['obs']).'</td>
            </tr>
        </table>
        <br>';
        $i++;
    }
}
$html .="</div>";       