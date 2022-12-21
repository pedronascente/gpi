<?php
$html .= '<p><b>  1.3 - VEÍCULO:</b></p>';
if ($list_veiculos) {
    $i = 1;
    $_PROTECAO = false;
    foreach ($list_veiculos as $veiculo) {
        $break = "";
        if ($i == 8) {
            $i = 1;
            $break =  'style="page-break-after:always"';
        }
        $combustivel = "";
        if (!empty($veiculo['combustivel'])) {
            switch ($veiculo['combustivel']) {
                case 1:  $combustivel = "COMBUSTÍVEL";  break;
                case 2:  $combustivel = "ÁLCOOL"; break;
                case 3:  $combustivel = "BICOMBUSTÍVEL";  break;
                case 4:  $combustivel = "DIESEL";  break;
                case 5:  $combustivel = "GNV"; break;
                case 6:  $combustivel = "GASOLINA"; break;
            }
        }
        $bloqueio = ($veiculo['bloqueio'] == 's') ? 'SIM' : 'NÃO';
        $html .= ' <table border="1" cellspacing="0" cellpadding="0" width="100%" style="font-size:12px;" ' . $break . '>
            <tr>
                <td style="padding:2px"><strong>MARCA - MODELO:</strong><br />' . $veiculo['marca'] . '/' . $veiculo['modelo'] . '</td>
                <td style="padding:2px"><strong>ANO:</strong><br />' . $veiculo['ano'] . '</td>
                <td style="padding:2px"><strong>COMBUSTÍVEL:</strong><br />' . $combustivel . '</td>
                <td style="padding:2px"><strong>COR: </strong><br />' . $veiculo['cor'] . '</td>
                <td style="padding:2px"><strong>BLOQUEIO: </strong><br />'.$bloqueio.'</td>
            </tr>
            <tr>
                <td style="padding:2px"><strong>CHASSI:</strong><br />' . $veiculo['chassis'] . '</td>
                <td style="padding:2px"><strong>RENAVAM: </strong><br />' . $veiculo['renavam'] . '</td>
                <td style="padding:2px"><strong>BATERIA:</strong><br />';
        if ($veiculo['tipo_bateria'] == "12V") {
            $html .= '12 VOLTS';
        } else {
            $html .= '24 VOLTS';
        };
        $html .= '
                </td>
                <td style="padding:2px" colspan="2"><strong>PLACA:</strong><br />' . $veiculo['placa'] . '</td>      
            </tr>
            <tr>
                <td colspan="5" style="padding:2px"><b>OBSERVAÇÕES:</b><br>' . $veiculo['obs'] . '</td>
            </tr>
        </table>
       ';
        $i++;
    }
}
