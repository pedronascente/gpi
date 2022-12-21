<?php
if ($list_veiculos):
    foreach ($list_veiculos as $veiculo):
        $combustivel = "";
        if (!empty($veiculo['combustivel'])) {
            switch ($veiculo['combustivel']) {
                case 1: $combustivel = "COMBUSTÍVEL";
                    break;
                case 2: $combustivel = "ÁLCOOL";
                    break;
                case 3: $combustivel = "BICOMBUSTÍVEL";
                    break;
                case 4: $combustivel = "DIESEL";
                    break;
                case 5: $combustivel = "GNV";
                    break;
                case 6: $combustivel = "GASOLINA";
                    break;
            }
        }
			 $seguroV =   ($veiculo['seguro'] == 's') ? 'SIM':'NAO';
			 if($veiculo['bloqueio'] == 's'){
				  $bloqueio ='SIM';				
			 }elseif($veiculo['bloqueio'] == 'n'){
				  $bloqueio ='NÃO';
			 }else{
				  $bloqueio ='';
			 }
			 
			 $PROCURAR=array('ê','ã');
			 $UBSTITUIRPOR=array('Ê','Ã');
			 
			 $tipo_seguro =   (isset($veiculo['tipo_seguro'])) ? str_replace($PROCURAR, $UBSTITUIRPOR,$veiculo['tipo_seguro']):'';
			 $html .='
			          <table border="1" cellspacing="0" cellpadding="0" width="100%" >
						<tr>
						  <td width="20%"><strong>MARCA/MODELO:</strong><br />'.$veiculo['marca'].'/'.$veiculo['modelo'].'</td>
						  <td width="19%"><strong>ANO:</strong><br />'.$veiculo['ano'].'</td>
						  <td width="20%"><strong>COMBUSTÍVEL:</strong><br />'.$combustivel.'</td>
						  <td width="24%"><strong>COR: </strong><br />'.$veiculo['cor'].'</td>
						  <td "><strong>BLOQUEIO: </strong><br />'.$bloqueio.'</td>
						</tr>
						<tr>
						  <td colspan="2" ><strong>CHASSI:</strong><br />'.$veiculo['chassis'].'</td>
						  <td><strong>RENAVAM: </strong><br />'.$veiculo['renavam'].'</td>
						  <td width="17%"><strong>BATERIA:</strong><br />';
							if($veiculo['tipo_bateria']=="12V"){ 
								$html.='12 VOLTS';
							}else{
								$html.='24 VOLTS'; 
							};
						   $html .= 
						   '</td>';
  						$html .='<td><strong>PLACA:</strong><br />'.$veiculo['placa'].'</td>';
							
							$html .='</tr>
					      <tr>
							<td> <strong>SEGURO :</strong><br>' . $seguroV .'</td>';
							if($tipo_seguro){ 
								$html .='<td colspan="2"> <strong>TIPO SEGURO :</strong><br>' . strtoupper($tipo_seguro) .'</td>';
								$html .='<td><strong>TAXA HABILITAÇÃO :</strong><br> R$'.$veiculo['taxa_instalacao'].'</td>
									 <td ><strong>TAXA MENSAL:</strong><br> R$'.$veiculo['taxa_monitoramento'].'</td> ';   
							}else{
								 $html .='<td colspan="2"> <strong>TAXA HABILITAÇÃO :</strong><br> R$'.$veiculo['taxa_instalacao'].'</td>
									 <td colspan="2"><strong>TAXA MENSAL:</strong><br> R$'.$veiculo['taxa_monitoramento'].'</td> ';    
							} 
							$html .='<tr>
						  <td colspan="5"><strong>OBSERVAÇÕES:</strong><br />'.nl2br($veiculo['obs']).'</td>
						</tr>
					  </table>
					  <br>
					';
    endforeach;
endif;