<?php

$captacao = new Captacao();
$dados = filter_input_array(INPUT_GET);

$selecionada = $captacao->selectViaturasSelecionada($dados);

if (!empty($selecionada)) {
    foreach ($selecionada as $k => $li) {
        $viaturas_data = !empty($li ['data']) ? Funcoes::FormataData($li ['data']) : '';
        $viaturas_hora = !empty($li ['hora']) ? $li ['hora'] : '';
        $viaturas_conta = !empty($li ['conta']) ? $li ['conta'] : '';
        $viaturas_atendente = !empty($li ['atendente']) ? $li ['atendente'] : '';
        $viaturas_pontos = !empty($li ['pontos']) ? $li ['pontos'] : '';
        $viaturas_id = !empty($li ['id_viaturas']) ? $li ['id_viaturas'] : '';
        $zona1ouqualquer = !empty($li ['zona1ouqualquer']) ? $li ['zona1ouqualquer'] : '';
        $disparos = !empty($li ['disparos']) ? $li ['disparos'] : '';
        $zonas = !empty($li ['zonas']) ? $li ['zonas'] : '';
        $todaszonas = !empty($li ['todaszonas']) ? $li ['todaszonas'] : '';
        $trintadias = !empty($li ['30dias']) ? $li ['30dias'] : '';
        $temporal = !empty($li ['temporal']) ? $li ['temporal'] : '';
        $pontos = !empty($li ['pontos']) ? $li ['pontos'] : '';
        $texto = !empty($li ['texto']) ? $li ['texto'] : '';
        $atendente = !empty($li ['atendente']) ? $li ['atendente'] : '';
    }
}

if ($pontos <= 49) {
    $valores = array("cor" => "green", "message" => "N&atilde;o enviar viatura, grande possibilidade de disparo em falso.");
} else if ($pontos >= 50 && $pontos <= 90) {
    $valores = array("cor" => "#FF8C00", "message" => "Enviar viatura, possibilidade de intrus&atilde;o.");
} else if ($pontos > 90) {
    $valores = array("cor" => "red", "message" => "Enviar viatura, h&aacute; intrus&atilde;o no local.");
}

function verificaOptions($tipo, $valor) {

    if ($tipo == "zona1ouqualquer") {
        if ($valor == 1) {
            $return = array("message" => "Zonas de Entrada.");
        } else if ($valor == 2) {
            $return = array("message" => "Outras zonas + Zonas de Entrada.");
        } else if ($valor == 3) {
            $return = array("message" => "Outras zonas.");
        }
    }

    if ($tipo == "disparos") {
        if ($valor == 1) {
            $return = array("message" => "Um.");
        } else if ($valor == 2) {
            $return = array("message" => "Dois.");
        } else if ($valor == 3) {
            $return = array("message" => "Tr&ecirc;s ou mais.");
        }
    }

    if ($tipo == "zonas") {
        if ($valor == 1) {
            $return = array("message" => "Uma zona.");
        } else if ($valor == 2) {
            $return = array("message" => "Duas zonas.");
        } else if ($valor == 3) {
            $return = array("message" => "Tr&ecirc;s ou mais zonas.");
        }
    }

    if ($tipo == "todaszonas") {
        if ($valor == 1) {
            $return = array("message" => "Sim.");
        } else if ($valor == 2) {
            $return = array("message" => "N&atilde;o.");
        }
    }

    if ($tipo == "trintadias" || $tipo == "temporal") {
        if ($valor == 1) {
            $return = array("message" => "Sim.");
        } else if ($valor == 2) {
            $return = array("message" => "Não.");
        }
    }
    
    
    if(!empty($return['message'])){
        return $return['message'];
    }
    
}
