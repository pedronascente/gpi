<?php
 //namespace  C:\wamp\www\gpi\modulos\captacao\src\controllers\proposta1.php   
include_once '../../../../Config.inc.php';
header('Content-Type: text/html; charset=utf-8');
include_once("../../bootstrap.php");
$Dados = filter_input_array(INPUT_POST);
if (!empty($Dados) && isset($Dados)):
    $acao = $Dados['acao'];
    unset($Dados['acao'], $Dados['id_cliente'], $Dados['x'], $Dados['y']);
endif;
$proposta = new Proposta;
//INSERT OU UPDATE  VEICULOS DA PROPOSTA:
switch ($acao) {
    case 'insert':
    case 'editar':
        $id_proposta = isset($Dados ['proposta_id']) ? $Dados ['proposta_id'] : "";
        $id_captacao = $Dados['id_captacao'];
        $Dados['proposta_id_captacao'] = $id_captacao;
        $Dados['tipo_seguro'] = isset($Dados['tipo_seguro']) ? $Dados['tipo_seguro'] : "";
        if (!empty($Dados ['proposta_id'])):
            $proposta->updateProposta(
                array(
                    "proposta_tipo_proposta" => $Dados['proposta_tipo_proposta'], 
                    "proposta_id_captacao" => $id_captacao, 
                    "proposta_id" => $Dados['proposta_id'],
                        "vigencia" => $Dados['vigencia'],
                )
            );
            $Dados['cpv_id_proposta'] = $Dados ['proposta_id'];
        else :
      
            $Dados['cpv_id_proposta'] = $proposta->insert(
                        array(
                            'proposta_id_captacao' => $id_captacao, 
                            'proposta_tipo_proposta' => $Dados['proposta_tipo_proposta'],
                            'vigencia' => $Dados['vigencia']
                        )
                    );
        
        
        endif;
        unset($Dados ['proposta_id'], $Dados['id_captacao'], $Dados['proposta_tipo_proposta'],$Dados['vigencia']);
        $Dados['cpv_taxa_intalacao'] = Funcoes::moeda(str_replace('R$ ', '', $Dados['cpv_taxa_intalacao']));
        $Dados['cpv_taxa_valor_mensal'] = Funcoes::moeda(str_replace('R$ ', '', $Dados['cpv_taxa_valor_mensal']));
        $Dados['cpv_total_taxa_intalacao'] = ($Dados['cpv_qtd_veiculo'] * $Dados['cpv_taxa_intalacao']);
        $Dados['cpv_total_valor_mensal'] = ($Dados['cpv_qtd_veiculo'] * $Dados['cpv_taxa_valor_mensal']);
        $Dados['cpv_total_taxa_valor'] = ($Dados['cpv_total_valor_mensal'] + $Dados['cpv_total_taxa_intalacao']);
        $Dados['cpv_alimentacao'] = '12v';
        if ($Dados['tipo_seguro'] == 'null') {
            unset($Dados['tipo_seguro']);
        }
        unset($Dados['id_captacao'], $Dados['proposta_id_captacao']);
        //INSERT :
        if ($acao == 'insert'):
            $result = $proposta->insertCaptacaoPropostaVeiculos($Dados);
        
        //UPDATE :
        elseif ($acao == 'editar'):
            $Dados['cpv_id'] = $Dados['id_cpv'];
            unset($Dados['id_cpv']);
            $proposta->updateCaptacaoPropostaVeiculos($Dados);
        endif;
        break;
    //DELETE VEICULOS DA PROPOSTA:
    case 'deletar':
        $id_cpv = $Dados['id_cpv'];
        $id_captacao = $Dados['id_captacao'];
        $proposta->deletarCaptacaoPropostaVeiculosId($id_cpv);
        break;
   //RESPONSAVEL POR REGISTRAR O PLANO ASSISTENCIAL:
    case "insrtPLS":
        $id_captacao = $Dados['id_captacao'];
        unset($Dados['id_captacao']);
        $Dados['cpv_vlr_mes_plano_assistencial'] = Funcoes::moeda(str_replace('R$ ', '', $Dados['cpv_vlr_mes_plano_assistencial']));
        $proposta->updateCaptacaoPropostaVeiculosIdProposta($Dados);
        break;
    case "updateProposta":
        $proposta->updateProposta($Dados);
        die(json_encode(1));
        break;
}

header('Location:../../../../index.php?pg=19&id=' . $id_captacao . '&acao=visualizar&voltar=18#tabs-2');

