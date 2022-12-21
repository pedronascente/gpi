<?php
$html .='<br>
	  <table width="100%" border="0">
		<tr>
		  <td>
                <div align="left">
                  <strong>
                     1.3 - VEÍCULO:
                  </strong>
                </div>
		   </td>
		  <td>
         </td>
         
	  </table>';
if($list_veiculos){
    $i = 1;
    $_PROTECAO = false;
    foreach($list_veiculos as $veiculo){
        $break = "";
        if($i == 8){
            $i = 1;
            $break =  'style="page-break-after:always"';
        }
        $combustivel = "";
        if(!empty($veiculo['combustivel'])){
            switch ($veiculo['combustivel']){
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
                <td><strong>MARCA - MODELO:</strong><br />'.$veiculo['marca'].'/'.$veiculo['modelo'].'</td>
                <td><strong>ANO:</strong><br />'.$veiculo['ano'].'</td>
                <td><strong>COMBUSTÍVEL:</strong><br />'.$combustivel.'</td>
                <td><strong>COR: </strong><br />'.$veiculo['cor'].'</td>
                
            </tr>
            <tr>
                <td><strong>CHASSI:</strong><br />'.$veiculo['chassis'].'</td>
                <td><strong>RENAVAM: </strong><br />'.$veiculo['renavam'].'</td>
                <td><strong>BATERIA:</strong><br />';
                    if($veiculo['tipo_bateria']=="12V"){ $html.='12 VOLTS';}else{$html.='24 VOLTS';}; 
                    $html .='
                </td>
                <td><strong>PLACA:</strong><br />'.$veiculo['placa'].'</td>      
            </tr>
            <tr>
                <td colspan="4">
                        <b>OBSERVAÇÕES:</b><br>'.$veiculo['obs'].'
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <p>
                        COM pedido de envio de proposta de seguro patrimonial veicular para ALIRO SEGURO AFFINTY AUTO P 
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <strong>Proposta do seguro  Veicular n° '.$veiculo['numero_cotacao_do_seguro'].'<strong>
                </td>
            </tr>
        </table>
        <br>';
        $i++;
    }
}