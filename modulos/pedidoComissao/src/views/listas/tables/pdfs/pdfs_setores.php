<?php
$html .= '
<style type="text/css">
    table{font-size:10px ; font-family:Arial, Helvetica, sans-serif}
    
     
    </style>    

<table width="100%" border="0" cellpadding="0" cellspacing="2">
    <thead  style="color:#FFF; background:#96989A;">
            <tr> ';
switch ($id_setor) :
    case 33 :
        // COMERCIAL DE ALARMES
        $html .= '
        <td>Linha</td>
        <td>Data</td>
        <td>Cliente</td>
        <td>Conta / Pedido</td>
        <td>Servi&ccedil;o</td>
        <td>Meio</td>
        <td>Ins. / Vendas</td>
        <td>Mensal</td>
        <td>Comiss&atilde;o</td>
        <td>Desconto da Comiss&atilde;o</td>
        <td>Inconsistencia</td>
        </tr>
        </thead>
        <tbody>
        <tr>
        <td colspan="7">&nbsp;</td>
        </tr>';
        $html .= listaDados($lista_pedidoComissao, '33');
    break;
    case 46 :
        // PLANILHA - COMERCIAL RASTREAMENTO VEICULAR
        $html .= '
        <td>Linha</td>
        <td>Data</td> 
        <td>Nome do cliente</td> 
        <td align="center">Qtd de Ve&iacute;culos</td>
        <td>Placa</td>
        <td>Tx.Instala&ccedil;&atilde;o</td>
        <td>Desconto de Comiss&atilde;o</td>
        <td>Mensal</td> 
        <td>Comiss&atilde;o</td>
        <td>Inconsistencia</td>	
        </tr>
        </thead>
        <tbody>
        <tr>
        <td colspan="7">&nbsp;</td>
        </tr>';
        $html .= listaDados($lista_pedidoComissao, '46');
    break;
    case 60 :
        // PLANILHA - ENTREGA_DE_ALARMES
        $html .= '
        <td>Linha </td> 
        <td>Data</td>
        <td>Conta / Pedido</td>
        <td>Nome Cliente</td> 
        <td>Comiss&atilde;o</td>
        <td>Desconto da Comiss&atilde;o</td>
        <td>Inconsistencia</td>	
        </tr>
        </thead>
        <tbody>
        <tr>
        <td colspan="7">&nbsp;</td>
        </tr>';
        $html .= listaDados($lista_pedidoComissao, '60');
    break;
    case 61 :
        // PLANILHA - REVERSAO
        $html .= '
        <td>Linha</td> 
        <td>Data</td>
        <td>Cliente</td> 
        <td>Conta / Pedido</td> 
        <td>Comiss&atilde;o</td> 
        <td>Desconto da Comiss&atilde;o</td>
        <td>Raz&atilde;o Social Antiga</td> 
        <td>Motivo</td>
        <td>Empresa</td>
        <td>Reclamação</td>
        <td>Inconsistencia</td>	
        </tr>
        </thead>
        <tbody>
        <tr>
        <td colspan="7">&nbsp;</td>
        </tr>';
        $html .= listaDados($lista_pedidoComissao, '61');
    break;
    case 62 :
        // PLANILHA - SUPERVISAO_COMERCIAL_ALARMES_CERCA_ELETRICA_CFTV
        $html .= '
        <td>Linha</td> 
        <td>Data</td> 
        <td>Cliente</td> 
        <td>Conta / Pedido</td> 
        <td>Servi&ccedil;o</td>
        <td>R$ Inst./Venda</td> 
        <td>R$ Mensal</td> 
        <td>Consultor</td>
        <td>Comiss&atilde;o</td>
        <td>Desconto da Comiss&atilde;o</td>
        <td>Inconsistencia</td>	
        </tr>
        </thead>
        <tbody>
        <tr>
        <td colspan="7">&nbsp;</td>
        </tr>';
        $html .= listaDados($lista_pedidoComissao, '62');
    break;
    case 63 :
        // PLANILHA - SUPERVISAO_COMERCIAL_RASTREAMENTO
        $html .= '
        <td>Linha</td>
        <td>Data</td>
        <td>Conta / Pedido</td>
        <td>Comiss&atilde;o</td>
        <td>Desconto da Comiss&atilde;o</td>
        <td>Total Rastreadores</td>
        <td>Inconsistencia</td>	
        </tr>
        </thead>
        <tbody>
        <tr>
        <td colspan="7">&nbsp;</td>
        </tr>';
        $html .= listaDados($lista_pedidoComissao, '63');
    break;
    case 64 :
        // PLANILHA - SUPERVISAO_COMERCIAL_E_SAC_ALARMES_CERCA_ELETRICA_CFTV
        $html .= '
        <td>Linha</td>
        <td>Data</td>
        <td>Conta / Pedido</td>
        <td>Nome Cliente</td>
        <td>Comiss&atilde;o</td> 
        <td>Desconto da Comiss&atilde;o</td>
        <td>Ins. / Vendas</td> 
        <td>Mensal</td>
        <td>Equip / Servi&ccedil;o</td>
        <td>Inconsistencia</td>	
        </tr>
        </thead>
        <tbody>
        <tr>
        <td colspan="7">&nbsp;</td>
        </tr>';
        $html .= listaDados($lista_pedidoComissao, '64');
    break;
    case 65 :
        // PLANILHA - TECNICA_ALARMES_CERCA_ELETRICA_CFTV
        $html .= '
        <td>Linha 65</td> 
        <td>Data</td> 
        <td>Conta / Pedido</td> 
        <td>N&deg; O.S</td> 
        <td>Cliente</td> 
        <td>Servi&ccedil;o</td> 
        <td>Comiss&atilde;o</td>
        <td>Desconto da Comiss&atilde;o</td>
        <td>Inconsistencia</td>	
        </tr>
        </thead>
        <tbody>
        <tr>
        <td colspan="7">&nbsp;</td>
        </tr>';
        $html .= listaDados($lista_pedidoComissao, '65');
    break;
    case 66 :
        // PLANILHA - TECNICA_DE_RASTREAMENTO
        $html .= '
        <td>Linha</td> 
        <td>Data</td> 						
        <td>Cliente</td>
        <td>Conta / Pedido</td>  
        <td>Placa</td>
        <td>Observa&ccedil;&atilde;o</td> 
        <td>Comiss&atilde;o</td>
        <td>Desconto da Comiss&atilde;o</td>
        <td>Inconsistencia</td>	
        </tr>
        </thead>
        <tbody>
        <tr>
        <td colspan="7">&nbsp;</td>
        </tr>';
        $html .= listaDados($lista_pedidoComissao, '66');
     break;
    case 150:
    	$html .= '
    	<th>Linha</th>
        <th>Data</th>
        <th>Cliente</th>
        <th>Conta / Pedido</th>
        <th>Meio</th>
        <th>Ins. / Vendas</th>
        <th>Mensal</th>
        <th>Comissão</th>
        <th>Desconto da Comissão</th>
        <th>Inconsistencia</th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <td colspan="10">&nbsp;</td>
        </tr>';
    	$html .= listaDados($lista_pedidoComissao, '150');
    	break;
    case 32:
    	$html .= '
    	<th>Linha</th>
        <th>Data</th>
        <th>Cliente</th>
        <th>Conta / Pedido</th>
        <th>Comissão</th>
        <th>Inconsistencia</th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <td colspan="10">&nbsp;</td>
        </tr>';
    	$html .= listaDados($lista_pedidoComissao, '32');
    	break;
endswitch;
$html .= '
	</tbody> 
</table>';

