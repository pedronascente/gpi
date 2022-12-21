<?php
$html.='	    
<br>    
  <div align="left"> <strong>  III - TAXA DE SERVIÇOS: </strong></div>
    <table width="100%" border="1" cellpadding="0" cellspacing="0">
	<tr align="center">
            <td width="47%">
                <strong> TAXA DE HABILITAÇÃO </strong></div>
            </td>
	    <td width="53%"><strong> TAXA MENSALIDADE</strong></td>
	</tr>
	<tr>
            <td><strong>Qtde.  Veículos:</strong> ' . $qtd_veiculos . '</td>
            <td><strong>Qtde.  Veículos: </strong>' . $qtd_veiculos . '</td>
	</tr>
	<tr>
            <td><strong>Valor Total R$ :</strong> ' . $valor_total_taxa_instalacao . '</td>
            <td><strong>Valor Total R$ :</strong> ' . $valor_total_taxa_manutencao . '</td>
	</tr>';
        if(isset($ArrayListformaDePagamento) && !empty($ArrayListformaDePagamento)){
            $html.='
            <tr>
                <td><strong>Data  :</strong> ' .  $ArrayListformaDePagamento[0]['data_pagamento_taxa_mes'] . '</td>
                <td><strong>Data  :</strong> ' . $ArrayListformaDePagamento[1]['data_pagamento_taxa_mes']  . '</td>
            </tr>
            <tr>
                <td><strong>Forma Pagamento:</strong> ' . $ArrayListformaDePagamento[0]['forma_pagamento']  . '</td>
                <td><strong>Forma Pagamento:</strong> ' . $ArrayListformaDePagamento[1]['forma_pagamento']  . '</td>
            </tr>';		
        }else{
            $html.='
            <tr>
                <td><strong>Data:</strong> ' . $list_cliente["data_pagamento"] . '</td>
                <td><strong>Melhor dia / Pagamento   :</strong> ' . $list_cliente["diaMelhorPagamento"]  . '</td>	
            </tr>
            <tr>
                <td><strong>Forma Pagamento:</strong> ' . @$arrFormaPgto[$list_cliente["forma_pagamento"]]  . '</td>
                <td><strong>Forma Pagamento:</strong> ' . @$arrFormaPgto[$list_cliente["forma_pagamento_mensalidade"]] . '</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Observações  :</strong> ' . $list_cliente["obs_diaPagamento"]  . '</td>
            </tr>';		
        }
$html.='
</table>';