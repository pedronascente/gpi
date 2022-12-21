<?php
$html.='	
<br>        
  <div align="left"> <strong>  III - TAXA DE SERVIÇOS: </strong></div>
  <table width="100%" border="1" cellpadding="0" cellspacing="0">
	<tr align="center">
         <td style="padding:2px"  width="47%"><strong> TAXA DE HABILITAÇÃO </strong></div></td>
	     <td style="padding:2px"  width="53%"><strong> TAXA MENSALIDADE</strong></td>
	</tr>
	<tr>
             <td style="padding:2px" ><strong>QTD. VEÍCULOS:</strong> ' . $qtd_veiculos . '</td>
             <td style="padding:2px" ><strong>QTD. VEÍCULOS: </strong>' . $qtd_veiculos . '</td>
	</tr>
	';
        if($valor_total_protecao_veicular !='0,00' || $valor_total_protecao_veicular_assistencial !='0,00'){
            $html.='<tr>
                 <td style="padding:2px" ></td>
                 <td style="padding:2px" ><strong>RASTREAMENTO  :</strong> R$' . $valor_total_taxa_manutencao . '</td>
            </tr>';
        }
        if($valor_total_protecao_veicular !='0,00'){
            $html.=' 
            <tr>
                 <td style="padding:2px" ></td>
                 <td style="padding:2px" ><strong>PROTEÇÃO VEÍCULAR  :</strong> R$' . $valor_total_protecao_veicular . '</td>
            </tr>';
        }
        if($valor_total_protecao_veicular_assistencial !='0,00'){
            $html.='
            <tr>
                 <td style="padding:2px" ></td>
                 <td style="padding:2px" ><strong>ASSISTÊNCIA VEÍCULAR  :</strong> R$' . $valor_total_protecao_veicular_assistencial . '</td>
            </tr>';
        }
        
        $html.='
	<tr>
             <td style="padding:2px" ><strong>VALOR TOTAL  :</strong> R$ '. $valor_total_taxa_instalacao . '</td>
             <td style="padding:2px" ><strong>VALOR TOTAL  :</strong> R$ ' . $calcular_total_formatado . '</td>
	</tr>';
       
        if(  isset($ArrayListformaDePagamento) && !empty($ArrayListformaDePagamento)){
            $html.='
            <tr>
                 <td style="padding:2px" ><strong>DATA  :</strong> ' .  $ArrayListformaDePagamento[0]['data_pagamento_taxa_mes'] . '</td>
                 <td style="padding:2px" ><strong>DATA  :</strong> ' . $ArrayListformaDePagamento[1]['data_pagamento_taxa_mes']  . '</td>
            </tr>
            <tr>
                 <td style="padding:2px"><strong>FORMA PAGAMENTO:</strong> ' . $ArrayListformaDePagamento[0]['forma_pagamento']  . '</td>
                 <td style="padding:2px"><strong>FORMA PAGAMENTO:</strong> ' . $ArrayListformaDePagamento[1]['forma_pagamento']  . '</td>
            </tr>';		
        }else{
            $forma_pagamento_mensalidade = isset($list_cliente["forma_pagamento_mensalidade"])?$arrFormaPgto[$list_cliente["forma_pagamento_mensalidade"]]:"";
            $html.='
            <tr>
                 <td style="padding:2px" ><strong>DATA:</strong> ' . $list_cliente["data_pagamento"] . '</td>
                 <td style="padding:2px" ><strong>MELHOR DIA / PAGAMENTO   :</strong> ' . $list_cliente["diaMelhorPagamento"]  . '</td>	
            </tr>
            <tr>
                 <td style="padding:2px" ><strong>FORMA PAGAMENTO:</strong> ' . $arrFormaPgto[$list_cliente["forma_pagamento"]]  . '</td>
                 <td style="padding:2px" ><strong>FORMA PAGAMENTO:</strong> ' . $forma_pagamento_mensalidade . '</td>
            </tr>
            <tr>
                 <td style="padding:2px" colspan="2"><strong>OBSERVAÇÕES :</strong> ' . $list_cliente["obs_diaPagamento"]  . '</td>
            </tr>';		
        }
$html.='
</table>';
