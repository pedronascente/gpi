<?php
include_once '../../../../Config.inc.php';
header('Content-Type: text/html; charset=utf-8');
include_once("../../bootstrap.php");
$Dados=$_POST;
$proposta=new Proposta;
if (!empty($Dados) && isset($Dados)):
    $acao=$Dados['acao'];
    unset($Dados['acao']);
endif;
//INSERT OU UPDATE  VEICULOS DA PROPOSTA:
switch ($acao) {
    case 'insert':
        $id_captacao=$Dados['proposta_id_captacao'];
        //Selecionar Proposta de acordo com ID da captação:
        $SELECIONAR_PROPOSTA = $proposta->getByIdCaptacao($Dados['proposta_id_captacao']);
        if(!empty($SELECIONAR_PROPOSTA)){
               $proposta->updateProposta(['proposta_id'=>$SELECIONAR_PROPOSTA['proposta_id'],'vigencia' => $Dados['vigencia']]);
              //Recuperar o ID da proposta .
              $captacao_propostaveiculo['cpv_id_proposta']=$SELECIONAR_PROPOSTA['proposta_id'];
        }else{
             //RRegistra Nova Proposta:
            $captacao_propostaveiculo['cpv_id_proposta']=$proposta->insert(
                array(
                    'proposta_id_captacao' => $Dados['proposta_id_captacao'], 
                    'vigencia' => $Dados['vigencia']
                )
            );
        }

        $cpv_taxa_intalacao = floatval(Funcoes::moeda(str_replace('R$ ', '', $Dados['cpv_taxa_intalacao']))) ;
        $cpv_taxa_valor_mensal = floatval(Funcoes::moeda(str_replace('R$ ', '', $Dados['cpv_taxa_valor_mensal']))) ;
        $cpv_qtd_veiculo = intval($Dados['cpv_qtd_veiculo']); 
        $cpv_total_taxa_intalacao = ($cpv_qtd_veiculo * $cpv_taxa_intalacao);   
        $cpv_total_valor_mensal =  ($cpv_qtd_veiculo * $cpv_taxa_valor_mensal );
        $cpv_total_taxa_valor = ($cpv_total_valor_mensal  +  $cpv_total_taxa_intalacao);

        //REGISTRAR OS VEICULOS DA PROPOSTA :
        $captacao_propostaveiculo['cpv_taxa_intalacao']       = $cpv_taxa_intalacao;
        $captacao_propostaveiculo['cpv_taxa_valor_mensal']    = $cpv_taxa_valor_mensal;
        $captacao_propostaveiculo['cpv_total_taxa_intalacao'] = $cpv_total_taxa_intalacao;
        $captacao_propostaveiculo['cpv_total_valor_mensal']   = $cpv_total_valor_mensal;
        $captacao_propostaveiculo['cpv_total_taxa_valor']     = $cpv_total_taxa_valor;
        $captacao_propostaveiculo['cpv_alimentacao']          = '12v';        
        $captacao_propostaveiculo['cpv_qtd_veiculo']          = $Dados['cpv_qtd_veiculo'];
        $captacao_propostaveiculo['forma_pagamento']          = $Dados['forma_pagamento'];
        $captacao_propostaveiculo['cpv_descricao_veiculo']    = $Dados['cpv_descricao_veiculo'];
        $captacao_propostaveiculo['tipo_seguro']              = $Dados['tipo_seguro'];

        // var_dump($captacao_propostaveiculo) ; die;
        $proposta->insertCaptacaoPropostaVeiculos($captacao_propostaveiculo); 
    break;
    //DELETE VEICULOS DA PROPOSTA:
    case 'deletar':
        $id_captacao=$Dados['id_captacao'];
        $proposta->deletarCaptacaoPropostaVeiculosId($Dados['cpv_id']);
    break;
    //RESPONSAVEL POR REGISTRAR O PLANO ASSISTENCIAL:
    case "insrtPLS":
        $id_captacao=$Dados['id_captacao'];
        unset($Dados['id_captacao']);
        $Dados['cpv_vlr_mes_plano_assistencial']=Funcoes::moeda(str_replace('R$ ', '', $Dados['cpv_vlr_mes_plano_assistencial']));
        $proposta->updateCaptacaoPropostaVeiculosIdProposta($Dados);
    break;
}
header('Location:../../../../index.php?pg=19&id=' . $id_captacao . '&acao=visualizar&voltar=18#tabs-2');