<?php
 $_forma_pagamento_mensalidade =  !empty($list_cliente["forma_pagamento_mensalidade"]) ? $arrFormaPgto[$list_cliente["forma_pagamento_mensalidade"]]:"" ;
 $html.='	
<style type="text/css">
    ._tdTopo{border-top:1px solid; }
    ._tdEsq{border-left:1px solid; }
    ._tdDir{border-right:1px solid; }
    ._tdBaixo{border-bottom:1px solid; }
</style>    
<div align="left"> <strong>  III - TAXA DE SERVIÇOS: </strong></div>
    <table width="100%"  border="1"  cellpadding="0" cellspacing="0">
        <tr align="center">
            <td >
                 <table width="100%" border="0"  cellpadding="1" cellspacing="0">
                    <tr >
                         <td class="_tdBaixo"><strong> TAXA DE HABILITAÇÃO </strong></td>
                    </tr>
                    <tr>
                        <td  class="_tdBaixo"><strong>QTD. VEÍCULOS:</strong> ' . $qtd_veiculos . '</td>
                    </tr>
                    <tr>
                        <td  class="_tdBaixo"><strong>VALOR TOTAL  :</strong> R$ '. $valor_total_taxa_instalacao . '</td>
                    </tr>
                    <tr>
                        <td  class="_tdBaixo"><strong>DATA:</strong> ' . $list_cliente["data_pagamento"] . '</td>
                    </tr>
                    <tr>
                         <td  class=""><strong>FORMA PAGAMENTO:</strong> ' . $arrFormaPgto[$list_cliente["forma_pagamento"]]  . '</td>
                    </tr>';

                    if($valor_total_protecao_veicular !='0,00' && $valor_total_protecao_veicular_assistencial !='0,00'){
                        $html.='
                        <tr>
                             <td  class="_tdTopo"><span style="color:white">.</span></td>
                        </tr>
                        <tr>
                             <td  class="_tdTopo"><span style="color:white">.</span></td>
                        </tr>';
                    }else if($valor_total_protecao_veicular !='0,00' || $valor_total_protecao_veicular_assistencial !='0,00'){
                        $html.='
                        <tr>
                             <td  class="_tdTopo"><span style="color:white">.</span></td>
                        </tr>';
                    }
               $html.=' </table>
            </td>
            <td>
                 <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="_tdBaixo"><strong> TAXA MENSALIDADE</strong></td>
                    </tr>
                    <tr>
                        <td class="_tdBaixo"><strong>QTD. VEÍCULOS: </strong>' . $qtd_veiculos . '</td>
                    </tr>
                    <tr>
                        <td class="_tdBaixo"><strong>RASTREAMENTO  :</strong> R$' . $valor_total_taxa_manutencao . '</td>
                    </tr>';
                    if($valor_total_protecao_veicular !='0,00'){
                        $html.=' 
                        <tr>
                            <td class="_tdBaixo"><strong>PROTEÇÃO VEÍCULAR  :</strong> R$' . $valor_total_protecao_veicular . '</td>
                        </tr>';
                    }
                    if($valor_total_protecao_veicular_assistencial !='0,00'){
                        $html.='
                        <tr>
                            <td class="_tdBaixo"><strong>ASSISTÊNCIA VEÍCULAR  :</strong> R$' . $valor_total_protecao_veicular_assistencial . '</td>
                        </tr>';
                    }
                    $html .='
                    <tr>
                        <td class="_tdBaixo"><strong>VALOR TOTAL  :</strong> R$ ' .$calcular_total_formatado. '</td>
                    </tr>
                    <tr>
                       <td class="_tdBaixo"><strong>MELHOR DIA PAGAMENTO   :</strong> ' . $list_cliente["diaMelhorPagamento"]  . '</td>	
                    </tr>
                    <tr>
                        <td class=""><strong>FORMA PAGAMENTO:</strong> ' . $_forma_pagamento_mensalidade . '</td>
                    </tr>';
                    $html.='         
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2"><strong>OBSERVAÇÕES :</strong> ' . $list_cliente["obs_diaPagamento"]  . '</td>
        </tr>
    </table>';