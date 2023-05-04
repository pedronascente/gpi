<?php
include_once "../../Config.inc.php";
include_once './classe/ValorRealPorExtenso.php';

$id = isset($_GET['id']) ? $_GET['id'] : "";
$id_usuario = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : "";
$seguro = false;
$_PLANO = false;
$vlr_equipamento = null;
$valorFor = null;
$arrTotalEquipamento = null;
$vlr_tx_monitoramento = null;
$detalheVeiculos = '';
$html = '';
$_TIPO_SERVICO = [];
$diaMelhorPagamento = '';
$clientes = new Clientes;
$contrato = new Contratos;
$assinatura = new Usuarios;
$_extenso = new ValorRealPorExtenso();
$veiculos = new Veiculos;

/**
 * @Descrição : Buscar contrato , de acordo com o id  
 * @Method: getContratoPdf($id)
 * @Parametro :(id)
 * @Return :Arrar()
 */
$list_cliente = $contrato->getContratoPdf($id);

//@Descrição : Formatar dados  :
$id_usuario = $list_cliente['id_usuario'];
$id_cliente = $list_cliente['cliente_id'];
$tipo_cadastro = $list_cliente['tipo_cadastro'];
$data = Funcoes::DataHora($list_cliente['data_contrato_gerado'], $list_cliente['data_contrato_gerado']);
$dt = explode("-", $data);
$dma = explode("/", $dt[0]);
$m = $dma[1];
$nome_cliente = $list_cliente['nome_cliente'];
$cpf_cliente = $list_cliente['cnpjcpf_cliente'];

$list_veiculos = $veiculos->selectIDCliente($id_cliente);
$qtd_veiculos =  $veiculos->totalVeiculos($id_cliente);

# Mês:
switch ($m) {
    case 1:
        $mes = 'Janeiro';
        break;
    case 2:
        $mes = 'Fevereiro';
        break;
    case 3:
        $mes = 'Março';
        break;
    case 4:
        $mes = 'Abril';
        break;
    case 5:
        $mes = 'Maio';
        break;
    case 6:
        $mes = 'Junho';
        break;
    case 7:
        $mes = 'Julho';
        break;
    case 8:
        $mes = 'Agosto';
        break;
    case 9:
        $mes = 'Setembro';
        break;
    case 10:
        $mes = 'Outubro';
        break;
    case 11:
        $mes = 'Novembro';
        break;
    default:
        $mes = 'Dezembro';
}

# FORMA DE PAGAMENTO:
$arrFormaPgto = array(
    '1' => 'CART&Atilde;O',
    '2' => 'DEP&Oacute;SITO',
    '3' => 'DINHEIRO',
    '4' => 'BOLETO BANC&Aacute;RIO',
    '5' => 'OUTROS',
    '6' => 'PAGSEGURO',
    '7' => 'ISENTO',
    '8' => 'ISENTO (Troca de Titularidade)',
    '9' => 'Funcionario (Desconto em Folha)',
);

if (!empty($list_cliente['diaMelhorPagamento'])) {
    $diaMelhorPagamento = explode(' ', $_extenso->extenso($list_cliente['diaMelhorPagamento']))[0];
}

/*
__xdebug([
    'titulo' =>'list_cliente', 
    $diaMelhorPagamento
]);
die();
*/

//_________[ COMTRATO COM SEGURO ] //_____

$ENDERECO_COBRANCA = $clientes->getEnderecoByTipoEndereco(['tabela' => 'endereco_cobranca', 'id_cliente' => $id_cliente,  'tipo_endereco' => 'endereco_cobranca']);
$ENDERECO_ENTREGA = $clientes->getEnderecoByTipoEndereco(['tabela' => 'endereco_cobranca', 'id_cliente' => $id_cliente, 'tipo_endereco' => 'endereco_entrega']);
$CONTATO1 = $clientes->getContatoByRaContato(['tabela' => 'contato_cliente', 'id_cliente_contato' => $id_cliente, 'ra_contato' => 1]);
$CONTATO2 = $clientes->getContatoByRaContato(['tabela' => 'contato_cliente', 'id_cliente_contato' => $id_cliente, 'ra_contato' => 2]);
$list_assinatura = $assinatura->findUserById($id_usuario);
$valor_equipamento = Funcoes::formartaMoedaReal($vlr_equipamento);



if ($tipo_cadastro === "rastreador_com_seguro") {
    include('rastreador_com_seguro.php');
}

//_________[ COMTRATO SEM  SEGURO ] //_____

if ($tipo_cadastro !== "rastreador_com_seguro") {

    $forma_pagamento_habilitacao = ($arrFormaPgto[$list_cliente['forma_pagamento']]) ? $arrFormaPgto[$list_cliente['forma_pagamento']] : '5';
    $forma_pagamento_mensalidade = ($arrFormaPgto[$list_cliente['forma_pagamento_mensalidade']]) ? $arrFormaPgto[$list_cliente['forma_pagamento_mensalidade']] : '5';

    $val_txt_Instalacao = $veiculos->valorUnitarioTaxaInstalacao($id_cliente);
    $val_txt_Monitoramento = $veiculos->valorUnitarioTaxaMonitoramento($id_cliente);
    $valor_total_taxa_instalacao = number_format($veiculos->totaltaxaInstalacao($id_cliente), 2, ',', '.');
    $valor_total_taxa_manutencao = number_format($veiculos->totaltaxamanutencao($id_cliente, 'taxa_monitoramento'), 2, ',', '.');
    $valor_total_protecao_veicular = number_format($veiculos->totaltaxamanutencao($id_cliente, 'valor_protecao'), 2, ',', '.');
    $valor_total_protecao_veicular_assistencial = number_format($veiculos->totaltaxamanutencao($id_cliente, 'valor_protecao_assistencial'), 2, ',', '.');

    //CALCULA OS VALORES TOTAL:
    $calcular_total =
        floatval($veiculos->totaltaxamanutencao($id_cliente, 'taxa_monitoramento')) +
        floatval($veiculos->totaltaxamanutencao($id_cliente, 'valor_protecao')) +
        floatval($veiculos->totaltaxamanutencao($id_cliente, 'valor_protecao_assistencial'));
    $calcular_total_formatado = number_format($calcular_total, 2, ',', '.');


    if ($tipo_cadastro == 'venda') {
        //CALCULAR VALORES :
        $mensalidade = (floatval($veiculos->totaltaxamanutencao($id_cliente, 'taxa_monitoramento')));
        $valor_aluguel_software_rastreamento = (60 / 100) * $mensalidade;
        $valor_servico_contratado = (40 / 100) * $mensalidade;
        $soma_valores_servicos =  $valor_aluguel_software_rastreamento + $valor_servico_contratado;

        //VALORES FORMATADOS : 
        $mensalidade = number_format($mensalidade, 2, ',', '.');
        $valor_aluguel_software_rastreamento = number_format($valor_aluguel_software_rastreamento, 2, ',', '.');
        $valor_servico_contratado = number_format($valor_servico_contratado, 2, ',', '.');
        $soma_valores_servicos = number_format($soma_valores_servicos, 2, ',', '.');
    } else {
        //CALCULAR VALORES :
        $mensalidade = (floatval($veiculos->totaltaxamanutencao($id_cliente, 'taxa_monitoramento')));
        $valor_locacao_equipamento = (39 / 100) * $mensalidade;
        $valor_aluguel_software_rastreamento = (39 / 100) * $mensalidade;
        $valor_servico_contratado = (22 / 100) * $mensalidade;
        $soma_valores_servicos = $valor_locacao_equipamento + $valor_aluguel_software_rastreamento + $valor_servico_contratado;

        //VALORES FORMATADOS : 
        $mensalidade = number_format($mensalidade, 2, ',', '.');
        $valor_locacao_equipamento = number_format($valor_locacao_equipamento, 2, ',', '.');
        $valor_aluguel_software_rastreamento = number_format($valor_aluguel_software_rastreamento, 2, ',', '.');
        $valor_servico_contratado = number_format($valor_servico_contratado, 2, ',', '.');
        $soma_valores_servicos = number_format($soma_valores_servicos, 2, ',', '.');
    }


    /**
     * @Descrição :extrair os tipos de serviços dos veiculos
     * @Return  : array()
     */

    foreach ($list_veiculos as $k => $v) {
        $_TIPO_SERVICO[] = $v['tipo_seguro'];
    }

    $rastreamento = in_array('Rastreamento', $_TIPO_SERVICO) ? true : false;
    $protecao_veicular = in_array('Rastreamento + Proteção veicular', $_TIPO_SERVICO) ? true : false;
    $asistencia_veicular = in_array('Rastreamento + Assistência Veicular', $_TIPO_SERVICO) ? true : false;
    $protecao_veicular_e_assistencia_veicular = in_array('Rastreamento + Proteção veicular + Assistência Veicular', $_TIPO_SERVICO) ? true : false;





    /*

__xdebug([
    'titulo' =>'Tipo de cadastro', 
    $list_cliente['tipo_cadastro']
]);

__xdebug([
    'Titulo' =>'quantidade de veiculos', 
    $qtd_veiculos
]);
__xdebug([
    'Titulo' =>'Tipo de Serviço', 
    $_TIPO_SERVICO
]);

die();

*/



    /**
     * @Descrição : Responsavel por Buscar o Valor da Taxa de monitoramento , verificar se o veiculo tem seguro ,
     * e o Total de equipamntos
     * @Return  :$vlr_tx_monitoramento type Double
     */

    if (!empty($list_veiculos)) {
        foreach ($list_veiculos as $veic) {
            if (!empty($veic['valor_equipamento'])) {
                $arrTotalEquipamento[$veic['valor_equipamento']] = 0;
                $arrTotalEquipamento[$veic['valor_equipamento']]++;
                $vlr_equipamento += $veic['valor_equipamento'];
            }
            $vlr_tx_monitoramento += $veic['taxa_monitoramento'];
            // verifica se exixte algum veiculo com seguro
            if ($veic['seguro'] == 's') {
                $seguro = true;
                break;
            }
            //VERIFICAR SE EXISTE ALGUM VEICULO COM PLANO DIFERENTE DE (Rastreamento).
            if (null != $veic['tipo_seguro']) {
                if ($veic['tipo_seguro'] != 'Rastreamento') {
                    $_PLANO = true;
                    break;
                }
            }
        }
        $vlr_tx_monitoramento = Funcoes::formartaMoedaReal($vlr_tx_monitoramento);
    }

    if ($arrTotalEquipamento) {
        foreach ($arrTotalEquipamento as $vlr_quant => $quant) {
            $detalheVeiculos .= '&nbsp; ' . $quant . 'EQUIPAMENTO de R$' . Funcoes::formartaMoedaReal($vlr_quant) . '<br>';
        }
    }



    if ($tipo_cadastro == 'venda') {

        require_once("sem_seguro/venda/dados_cliente.php");

        #1 1 VEICULOS:      
        if ($qtd_veiculos == 1) {
            if ($protecao_veicular || $protecao_veicular_e_assistencia_veicular) {
                require_once("sem_seguro/venda/dados_veiculo.php");
                require_once("sem_seguro/venda/rastreador/rastreador_valores.php");
                require_once("sem_seguro/venda/protecao/protecao_clausulas_01.php");
                require_once("sem_seguro/venda/protecao/protecao_clausulas_02.php");
                require_once("sem_seguro/venda/protecao/assinatura_contrato.php");
                require_once("sem_seguro/venda/protecao/protecao_anexo.php");
                require_once("sem_seguro/venda/protecao/assinatura_contrato.php");
            } else if ($asistencia_veicular) {
                require_once("sem_seguro/venda/dados_veiculo.php");
                require_once("sem_seguro/venda/rastreador/rastreador_valores.php");
                require_once("sem_seguro/venda/rastreador/rastreador_clausulas.php");
                require_once("sem_seguro/venda/asistencia_veicular/clausulas.php");
            } else {
                require_once("sem_seguro/venda/dados_veiculo.php");
                require_once("sem_seguro/venda/section_03.php");
            }
            #2 MAIS DE 1 VEICULOS: 
        } else if ($qtd_veiculos > 1) {
            $html .= '<p>Os dados dos veículos encontram-se descritos no Anexo I, parte integrante deste instrumento. </p>';
            require_once("sem_seguro/venda/section_03.php");
            if ($protecao_veicular || $protecao_veicular_e_assistencia_veicular) {
                require_once("sem_seguro/venda/rastreador/rastreador_valores.php");
                require_once("sem_seguro/venda/protecao/protecao_clausulas_01.php");
                require_once("sem_seguro/venda/protecao/protecao_clausulas_02.php");
                require_once("sem_seguro/venda/protecao/assinatura_contrato.php");
                require_once("sem_seguro/venda/protecao/protecao_anexo.php");
                require_once("sem_seguro/venda/protecao/assinatura_contrato.php");
            } else if ($asistencia_veicular) {
                require_once("sem_seguro/venda/rastreador/rastreador_valores.php");
                require_once("sem_seguro/venda/rastreador/rastreador_clausulas.php");
                require_once("sem_seguro/venda/asistencia_veicular/clausulas.php");
                require_once("sem_seguro/venda/asistencia_veicular/assinatura_contrato.php");
            } else {
                require_once("sem_seguro/venda/section_03.php");
            }
            require_once("sem_seguro/venda/veiculos_anexos.php");
        }
    } else {
        require_once("sem_seguro/comodato/dados_cliente.php");
        #1 1 VEICULOS:      
        if ($qtd_veiculos == 1) {
            if ($protecao_veicular || $protecao_veicular_e_assistencia_veicular) {
                require_once("sem_seguro/comodato/dados_veiculo.php");
                require_once("sem_seguro/comodato/rastreador/rastreador_valores.php");
                require_once("sem_seguro/comodato/protecao/protecao_clausulas_01.php");
                require_once("sem_seguro/comodato/protecao/protecao_clausulas_02.php");
                require_once("sem_seguro/comodato/protecao/assinatura_contrato.php");
                require_once("sem_seguro/comodato/protecao/protecao_anexo.php");
                require_once("sem_seguro/comodato/protecao/assinatura_contrato.php");
            } else if ($asistencia_veicular) {
                require_once("sem_seguro/comodato/dados_veiculo.php");
                require_once("sem_seguro/comodato/rastreador/rastreador_valores.php");
                require_once("sem_seguro/comodato/rastreador/rastreador_clausulas.php");
                require_once("sem_seguro/comodato/asistencia_veicular/clausulas.php");
            } else {
                require_once("sem_seguro/comodato/dados_veiculo.php");
                require_once("sem_seguro/comodato/section_03.php");
            }
            #2 MAIS DE 1 VEICULOS: 
        } else if ($qtd_veiculos > 1) {
            $html .= '<p>Os dados dos veículos encontram-se descritos no Anexo I, parte integrante deste instrumento. </p>';
            //require_once("sem_seguro/comodato/section_03.php");
            if ($protecao_veicular || $protecao_veicular_e_assistencia_veicular) {
                require_once("sem_seguro/comodato/rastreador/rastreador_valores.php");
                require_once("sem_seguro/comodato/protecao/protecao_clausulas_01.php");
                require_once("sem_seguro/comodato/protecao/protecao_clausulas_02.php");
                require_once("sem_seguro/comodato/protecao/assinatura_contrato.php");
                require_once("sem_seguro/comodato/protecao/protecao_anexo.php");
                require_once("sem_seguro/comodato/protecao/assinatura_contrato.php");
            } else if ($asistencia_veicular) {
                require_once("sem_seguro/comodato/rastreador/rastreador_valores.php");
                require_once("sem_seguro/comodato/rastreador/rastreador_clausulas.php");
                require_once("sem_seguro/comodato/asistencia_veicular/clausulas.php");
                // require_once("sem_seguro/comodato/asistencia_veicular/assinatura_contrato.php");
            } else {
                require_once("sem_seguro/comodato/section_03.php");
            }
            require_once("sem_seguro/comodato/veiculos_anexos.php");
        }
    }
}

function __xdebug($array_dados, $h = 'n')
{

    if ($h == 'y') {
        echo $array_dados;
    } else {
        echo '<pre>';
        print_r($array_dados);
        echo '</pre>';
        echo '<hr>';
    }
}


/**
 * @Descrição : Responsavel por Gerar o PDF.
 * @Return  :Arquivo (.PDF)
 */



//echo $html;

//die();


require_once("../dompdf/dompdf_config.inc.php");
$_nome = $dma[0] . '-' . $dma[1] . '-' . $dma[2] . "-" . $list_cliente['nome_cliente'] . ".pdf";

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4", "portrait");
$dompdf->render();
$dompdf->stream($_nome);
