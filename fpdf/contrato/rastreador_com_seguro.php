<?php
$list_assinatura = $assinatura->findUserById($id_usuario);
        $valor_total_taxa_instalacao = number_format($veiculos->totaltaxaInstalacao($id_cliente), 2, ',', '.');
        $soma_valores_servicos =  (floatval($list_veiculos[0]['valor_locacao_equipamento']) + floatval($list_veiculos[0]['valor_aluguel_software_rastreamento']) + floatval($list_veiculos[0]['valor_servico_contratado']));
        $soma_valores_servicos = number_format($soma_valores_servicos, 2, ',', '.');
       
        $forma_pagamento_mensalidade = (!empty($list_veiculos[0]['forma_pagamento_mensalidade'])) ? $arrFormaPgto[$list_veiculos[0]['forma_pagamento_mensalidade']]: 5; 
        $forma_pagamento_habilitacao = ($arrFormaPgto[$list_veiculos[0]['forma_pagamento_habilitacao']]) ? $arrFormaPgto[$list_veiculos[0]['forma_pagamento_habilitacao']]:'5';
       
        $dia_pagamento_mensal = explode(' ', $_extenso->extenso($list_veiculos[0]['dia_pagamento_mensal']))[0];
        $valor_locacao_equipamento = floatval($veiculos->totaltaxamanutencao($id_cliente, 'valor_locacao_equipamento'));
        $valor_aluguel_software_rastreamento = floatval($veiculos->totaltaxamanutencao($id_cliente, 'valor_aluguel_software_rastreamento'));
        $valor_servico_contratado = floatval($veiculos->totaltaxamanutencao($id_cliente, 'valor_servico_contratado'));
        $valor_mensal = floatval($veiculos->totaltaxamanutencao($id_cliente, 'valor_mensal'));
       
        //calcula o valor total do seguro:
        $valor_total_seguro = ($valor_locacao_equipamento + $valor_aluguel_software_rastreamento + $valor_servico_contratado + $valor_mensal);
        $valor_total_seguro = number_format($valor_total_seguro, 2, ',', '.');
        $valor_locacao_equipamento = number_format($valor_locacao_equipamento, 2, ',', '.');
        $valor_aluguel_software_rastreamento = number_format($valor_aluguel_software_rastreamento, 2, ',', '.');
        $valor_servico_contratado = number_format($valor_servico_contratado, 2, ',', '.');
        $valor_mensal = number_format($valor_mensal, 2, ',', '.');
       
        require_once("seguro/dados_cliente.php");
        require_once("seguro/dados_veiculo.php");
        require_once("seguro/clausulas.php");