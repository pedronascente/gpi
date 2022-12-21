<?php


header('Content-Type: text/html; charset=utf-8');
include_once ("../../../../../Config.inc.php");


$cumprimento = Funcoes::getCumprimento();

$desenvolvimento = new Desenvolvimento();

$listaEmail = $desenvolvimento->selectTestadasEmail();

if (!empty($listaEmail)) {

    foreach ($listaEmail as $e) {

        $DadosEmail ['asssunto'] = utf8_decode("AVISO ORÁCULO");
        $DadosEmail ['emailRementente'] = 'revendavolpato@revendavolpato.com';
        $DadosEmail ['remetente'] = 'Oráculo - Grupo Volpato';
        $DadosEmail ['emailDestino'] = $e->get('desenvolvimento_email');
        $DadosEmail ['nomeEmailResposta'] = 'Oráculo - Grupo Volpato';
        $DadosEmail ['nome'] = "VOLPATO";
        $DadosEmail ['emailResposta'] = "revendavolpato@revendavolpato.com";
        $DadosEmail ['Body'] = utf8_decode($cumprimento . ',' . $desenvolvimento->get("desenvolvimento_nome_usuario") . '<br>Esse é o último dia para testar os chamados de número '.$e->get("log_motivo").', amanhã eles serão finalizados automaticamente por inatividade.<br><br>Atenciosamente,<br><br>Informática - Grupo Volpato');

        Funcoes::EnviarEmail($DadosEmail, new PHPMailer());
    }
}


$listaFinalizar = $desenvolvimento->selectSolicitacoesParaSeremFinalizadas();

if (!empty($listaFinalizar)) {

    foreach ($listaFinalizar as $f) {

        $atualizar = explode(",", $f->get("desenvolvimento_id"));

        foreach ($atualizar as $a) {
            $desenvolvimento->updateSolicitacao(array("desenvolvimento_id" => $a, "desenvolvimento_status" => 5, "desenvolvimento_data_final" => date("Y-m-d H:i:s")));
            $desenvolvimento->insertLog(array("log_solicitacao" => $a, "log_data" => date("Y-m-d H:i:s"), "log_usuario" => 1, "log_descricao" => "Alteração status da solicitação pelo sistema para Finalizada"));
        }

        $DadosEmail ['asssunto'] = utf8_decode("AVISO ORÁCULO");
        $DadosEmail ['emailRementente'] = 'revendavolpato@revendavolpato.com';
        $DadosEmail ['remetente'] = 'Oráculo - Grupo Volpato';
        $DadosEmail ['emailDestino'] = $f->get('desenvolvimento_email');
        $DadosEmail ['nomeEmailResposta'] = 'Oráculo - Grupo Volpato';
        $DadosEmail ['nome'] = "VOLPATO";
        $DadosEmail ['emailResposta'] = "revendavolpato@revendavolpato.com";
        $DadosEmail ['Body'] = utf8_decode($cumprimento . ',' . $desenvolvimento->get("desenvolvimento_nome_usuario") . '<br>Chamados finalizados automaticamente porque foi expirado o período de 7 dias de teste: ' . $f->get("desenvolvimento_id") . "<br><br>Atenciosamente,<br><br>Informática - Grupo Volpato");

        Funcoes::EnviarEmail($DadosEmail, new PHPMailer());
    }
}

$desenvolvimento->updateSolicitacoesParadas();