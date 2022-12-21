<?php

$_ArrayListformaDePagamento = [
    '1' => 'CART&Atilde;O', 
    '2' => 'DEP&Oacute;SITO', 
    '3' => 'DINHEIRO', 
    '4' => 'BOLETO BANC&Aacute;RIO',
    '5' => 'OUTROS', 
    '6' => 'PAGSEGURO',
    '7' => 'ISENTO',
    '8' => 'ISENTO (Troca de Titularidade)',
    '9' => 'Funcionario (Desconto em Folha)',
    ]; 

    if(!empty($veiculo))
    {
        $array_data = [
        'taxa_instalacao' => $veiculo['taxa_instalacao'],
        'valor_locacao_equipamento' => $veiculo['valor_locacao_equipamento'],
        'valor_aluguel_software_rastreamento' => $veiculo['valor_aluguel_software_rastreamento'],
        'valor_mensal'=> $veiculo['valor_mensal'],
        'valor_servico_contratado'=> $veiculo['valor_servico_contratado'],
        ];
    }

    function calcular_soma_total($array_data){
        $total = floatval($array_data['taxa_instalacao']) + 
        floatval($array_data['valor_locacao_equipamento']) +
        floatval($array_data['valor_aluguel_software_rastreamento']) +
        floatval($array_data['valor_mensal']) +
        floatval($array_data['valor_servico_contratado']) ;
        return number_format($total, 2, ',', '.');
    }
?>

<div class="panel panel-primary">
    <div class="panel-heading">Forma de Pagamento</div>
    <div class=" panel-body">
        <div class="row">
             <div class=" col-xs-4 col-sm-4 col-md-4">
                <div class="form-group">
                    <label> Taxa de Habilitação:</label>
                    <div class="input-group" >
                        <span class="input-group-addon">$</span>
                        <input 
                            type="text" 
                            name="taxa_instalacao"  
                            class=" mask_real  form-control" 
                            required=""  
                            value="<?=(isset($veiculo['taxa_instalacao']))?$veiculo['taxa_instalacao']:'';?>" 
                        />
                    </div> 
                </div>
            </div>  
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="form-group">
                    <label>Forama Pagamento Habilitação:</label>
                    <select name="forma_pagamento_habilitacao" class="form-control text-center"    required=""   >  
                        <option value="">Selecione...</option>
                        <?php
                            foreach($_ArrayListformaDePagamento as $k=> $v){ ?>
                                 <option value="<?=$k;?>"
                                    <?php 
                                        if(isset($veiculo['forma_pagamento_habilitacao'])){
                                            if($k == $veiculo['forma_pagamento_habilitacao']) { 
                                                echo 'selected'; 
                                            } 
                                         } 
                                    ?> 
                                ><?=$v;?></option> <?php
                            }
                        ?>   
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-md-2">
                <label>Data Pagamento da Habilitação:</label>
                <div class="input-group input-append ">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar "></span>
                    </span>
                    <input 
                        type="text" 
                        name="data_pagamento_habilitacao" 
                        class="form-control datepicker  mask_data" 
						required="" 
                        value="<?=(isset($veiculo['data_pagamento_habilitacao']))?$veiculo['data_pagamento_habilitacao']:'';?>"
                        maxlength ="20"
                        /> 
                </div>
            </div>
        </div>
        <div class="row">
           <div class=" col-xs-4 col-sm-4 col-md-4">
                <div class="form-group">
                    <label> Locação do Equipamento:</label>
                    <div class="input-group" >
                        <span class="input-group-addon">$</span>
                        <input 
                            type="text" 
                            name="valor_locacao_equipamento"  
                            class=" mask_real  form-control" 
                            required=""
                            value="<?=(isset($veiculo['valor_locacao_equipamento']))?$veiculo['valor_locacao_equipamento']:'';?>"   
                        /> 
                    </div> 
                </div>
            </div>  
            <div class=" col-xs-4 col-sm-4 col-md-4">
                <div class="form-group">
                    <label> Aluguel do Software de Rastreamento:</label>
                    <div class="input-group" >
                        <span class="input-group-addon">$</span>
                        <input 
                            type="text" 
                            name="valor_aluguel_software_rastreamento"  
                            class=" mask_real  form-control" 
                            required=""
                            value="<?=(isset($veiculo['valor_aluguel_software_rastreamento']))?$veiculo['valor_aluguel_software_rastreamento'] : '';?>"   
                        /> 
                    </div> 
                </div>
            </div>  
            <div class=" col-xs-4 col-sm-4 col-md-4"> 
                <div class="form-group">
                    <label>Serviços contratados (letra "c", do item 3.1) do contrato:</label>
                    <div class="input-group" >
                        <span class="input-group-addon">$</span>
                        <input 
                            type="text" 
                            name="valor_servico_contratado"  
                            class=" mask_real  form-control" 
                            required=""
                            value="<?=(isset($veiculo['valor_servico_contratado'])?$veiculo['valor_servico_contratado']:'');?>"   
                        /> 
                    </div> 
                </div>
            </div>
        </div>  
        <div class="row">
           <div class="col-md-4">
                <div class="form-group">
                    <label>Valor Mensal:</label>
                    <div class="input-group" >
                        <span class="input-group-addon">$</span>
                        <input 
                            type="text" 
                            name="valor_mensal"   
                            class=" mask_real form-control" 
                            required=""
                            value="<?=(isset($veiculo['valor_mensal']))?$veiculo['valor_mensal']:'';?>"  
                        /> 
                    </div> 
                </div>
            </div> 
            <div class="col-md-4">
                <div class="form-group">
                    <label>Forama Pagamento Mensal:</label>
                    <select name="forma_pagamento_mensalidade" class="form-control text-center"  required="" >  
                        <option value="">Selecione...</option>
                        <?php
                            foreach($_ArrayListformaDePagamento as $k=> $v){ ?>
                                 <option value="<?=$k;?>" 
                                    <?php
                                        if(isset($veiculo['forma_pagamento_mensalidade'])){
                                            if($k == $veiculo['forma_pagamento_mensalidade']) { 
                                                echo 'selected'; 
                                            }    
                                        }  
                                    ?> 
                                ><?=$v?></option><?php
                            }
                        ?>   
                    </select>
                </div>
            </div> 
            <div class="col-xs-12 col-md-2">
                <label>Dia Pagamento Mensal:</label>
                <div class="input-group input-append ">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar "></span>
                    </span>
                    <select name="dia_pagamento_mensal" class="form-control text-center"  required="" >  
                        <option value="">Selecione...</option>
                        <?php
                            $_ArrayListDiaPagamentoMesal = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30];
                            foreach($_ArrayListDiaPagamentoMesal as  $v){ ?>
                                <option value="<?=$v;?>" 
                                    <?php
                                        if(isset($veiculo['dia_pagamento_mensal'])){
                                            if($v == $veiculo['dia_pagamento_mensal']) { 
                                                echo 'selected'; 
                                            }    
                                        }  
                                    ?> 
                                ><?=$v;?></option><?php
                            }
                        ?>   
                    </select>
                 </div>
            </div>
        </div>  
    </div>  
</div>  