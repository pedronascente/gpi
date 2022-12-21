<?php

@session_start();

header('Content-Type: text/html; charset=utf-8');
include_once ("../../../../Config.inc.php");

$Dados = isset($_POST['acao']) ? filter_input_array(INPUT_POST) : filter_input_array(INPUT_GET);

$acao = isset($Dados ['acao']) ? $Dados ['acao'] : $_GET['acao'];
unset($Dados ['acao']);

$desenvolvimento = new Desenvolvimento;
$usuario = new Usuarios;

$motivo = isset($Dados['log_motivo']) ? $Dados['log_motivo'] : null;
unset($Dados['log_motivo']);

switch ($acao) {

    case "cadastrarSolicitacao":

        //altera status para aprovada se a solicitacao for criada por um desenvolvedor ou supervisor
        if ((in_array(array("tipo_permissao" => "desenvolvedor"), $_SESSION['user_info']['permissoes']) && $Dados['desenvolvimento_nivel_solicitacao'] == 1) || in_array(array("tipo_permissao" => "supervisor"), $_SESSION['user_info']['permissoes']))
            $Dados['desenvolvimento_status'] = 1;
        //aletera status para iniciada se a solicitacao for criada pelo suporte
        else if (in_array(array("tipo_permissao" => "suporte"), $_SESSION['user_info']['permissoes']) && $Dados['desenvolvimento_nivel_solicitacao'] == 2) {
            $Dados['desenvolvimento_status'] = 2;
            $Dados['desenvolvimento_id_programador'] = $_SESSION['user_info']['id_usuario'];
            $Dados['desenvolvimento_data_inicio'] = date("Y-m-d H:i:s");
        } else
            $Dados['desenvolvimento_status'] = 0;

        $tab = $Dados['tab'];
        $status = $Dados['status'];
        $acaoBusca = $Dados['acaoBusca'];

        unset($Dados['tab'], $Dados['status'], $Dados['acaoBusca']);

        $Dados['desenvolvimento_data_criacao'] = date("Y-m-d H:i:s");
        $Dados['desenvolvimento_situacao'] = 0;
        $id = $desenvolvimento->insert($Dados);


        //faz upload das imagens
        if (!empty($id) && !empty($_FILES['anexo0']['name']))
            inserirImagem($id, $_FILES['anexo0']);

        if (!empty($id) && !empty($_FILES['anexo1']['name']))
            inserirImagem($id, $_FILES['anexo1']);

        $Dados['desenvolvimento_id'] = $id;
        cadastrarLog($Dados);


        //envia e-mail ao suporte se o status é 1
        if ($Dados['desenvolvimento_status'] == 1) {
            $destinatarios = $Dados['desenvolvimento_nivel_solicitacao'] == 2 ? array("Suporte@grupovolpato.com", "suporte2@grupovolpato.com") : array("desenvolvimento03@grupovolpato.com", "desenvolvimento@grupovolpato.com");
            enviarEmailAviso(",<br>H&aacute; uma nova solicita&ccedil;&atilde;o no or&aacute;culo aprovada.", $destinatarios);
        } else if ($Dados['desenvolvimento_status'] == 0) {
            //envia e-mail ao supervisor se o status é 0
            enviarEmailAviso(",<br>H&aacute; uma nova solicita&ccedil;&atilde;o no or&aacute;culo para ser avaliada.", array("ti@grupovolpato.com"));
        }

        header("Location: ../../../../index.php?pg=23&status={$status}&resul=on&acao={$acaoBusca}#{$tab}");
        break;

    case "editar":

        $tab = $Dados['tab'];
        $status = $Dados['status'];
        $acaoBusca = $Dados['acaoBusca'];

        unset($Dados['tab'], $Dados['status'], $Dados['acaoBusca']);

        $solicitacao = $desenvolvimento->selectArray($Dados['desenvolvimento_id']);

        if (empty($Dados['desenvolvimento_status']))
            unset($Dados['desenvolvimento_status']);

        $status = isset($Dados['desenvolvimento_status']) ? $Dados['desenvolvimento_status'] : -1;
        if ($status == 5) 
            $acao = "visualizar";
        else if($status == 4)
        	$Dados['desenvolvimento_data_final'] = date("Y-m-d H:i:s");

        if (isset($Dados['desenvolvimento_status']) && $Dados['desenvolvimento_status'] == 1) {
            $destinatarios = $Dados['desenvolvimento_nivel_solicitacao'] == 2 ? array("Suporte@grupovolpato.com", "suporte2@grupovolpato.com") : array("desenvolvimento03@grupovolpato.com", "desenvolvimento@grupovolpato.com");
            enviarEmailAviso(",<br>H&aacute; uma nova solicita&ccedil;&atilde;o no or&aacute;culo aprovada.", $destinatarios);
        }
        
        $desenvolvimento->updateSolicitacao($Dados);

        //faz upload das imagens
        if (!empty($_FILES['anexo0']['name']))
            inserirImagem($Dados['desenvolvimento_id'], $_FILES['anexo0']);

        if (!empty($_FILES['anexo1']['name']))
            inserirImagem($Dados['desenvolvimento_id'], $_FILES['anexo1']);

        $Dados['log_motivo'] = $motivo;

        $result = $desenvolvimento->Update()->getResult();

        if (!empty($result))
            cadastrarLog($Dados, $solicitacao);

        //Envia e-mail para usuário avisando alteração de status
        if ($solicitacao['desenvolvimento_status'] != $Dados['desenvolvimento_status']) {

            $solicitacao['desenvolvimento_status'] = $Dados['desenvolvimento_status'];
            $desenvolvimento->select($Dados['desenvolvimento_id']);

            $msg = msg($desenvolvimento->get("desenvolvimento_usuario"), $desenvolvimento->get("desenvolvimento_id"));

            enviarEmailAviso($msg, array($solicitacao['desenvolvimento_email']), "Chamado n° {$desenvolvimento->get("desenvolvimento_id")} foi alterado");
        }

        //se a solictação já foi parada anteriormente manda um e-mail para o supervisor
        if ($solicitacao['desenvolvimento_status'] == 3) {
            $parada = $desenvolvimento->selectLogParada($Dados['desenvolvimento_id']);

            if (!empty($parada)) {
                enviarEmailAviso(",<br>A solicitação de número {$Dados['desenvolvimento_id']} foi parada novamente pelo seguinte motivo: {$parada["log_descricao"]}", array("ti@grupovolpato.com"));
            }
        }

        header("Location: ../../../../index.php?pg=23&status={$status}&resul=on&acao={$acaoBusca}#{$tab}");
        break;

    case "excluir":
        $id = filter_input(INPUT_GET, "id");
        $desenvolvimento->deleteSolicitacao($id);
        header("Location: ../../../../index.php?pg=23&status={$Dados['status']}&acao={$Dados['acaoBusca']}#{$Dados['tab']}");
        break;

    case "atribuirProgramador":
        $solicitacao = $desenvolvimento->selectArray($Dados['id_solicitacao']);
        $programador['desenvolvimento_id'] = $Dados['id_solicitacao'];
        $programador['desenvolvimento_id_programador'] = $Dados['id'];
        $programador['desenvolvimento_status'] = 2;
        $programador['desenvolvimento_data_inicio'] = date("Y-m-d H:i:s");
        $desenvolvimento->updateSolicitacao($programador);

        $result = $desenvolvimento->Update()->getResult();
        if (!empty($result))
            cadastrarLog($programador, $solicitacao);

        //envia e-mail alteração de status
        $solicitacao['desenvolvimento_status'] = 2;
        $desenvolvimento->setDados($solicitacao);
        if ($Dados['tela'] == 2)
            header("Location: ../../../../index.php?pg=23");
        else
            header("Location: ../../../../index.php?pg=22&id=" . $Dados['id_solicitacao'] . "&acao=editar&tab=" . $Dados['tab']);
        break;

    case "help":
        $Dados['desenvolvimento_id_programador'] = "";
        $Dados['desenvolvimento_status'] = "3";
        $desenvolvimento->updateSolicitacao($Dados);
        $Dados['log_motivo'] = $motivo;
        cadastrarLog($Dados, null);
        header("Location: ../../../../index.php?pg=23");
        break;

    case "respostaHelp":

        if ($Dados['desenvolvimento_help'] == 3) {
            $Dados['desenvolvimento_id_programador'] = $_SESSION['user_info']['id_usuario'];
            $Dados['desenvolvimento_status'] = "2";
        }

        $desenvolvimento->updateSolicitacao($Dados);
        cadastrarLog($Dados, null);
        header("Location: ../../../../index.php?pg=23");
        break;

    case "deletarAnexo":
        $desenvolvimento->deletarAnexo($Dados['id']);
        $log['log_solicitacao'] = $Dados['id_solicitacao'];
        $log['log_usuario'] = $_SESSION['user_info']['id_usuario'];
        $log['log_descricao'] = "Exclusão Imagem";
        $log['log_data'] = date("Y-m-d H:i:s");
        $log['log_texto'] = $Dados['descricao'];
        $desenvolvimento->insertLog($log);
        header("Location: ../../../../index.php?pg=22&id={$Dados['id_solicitacao']}&acao=editar");
        break;
        
   
    case "cancelarSolicitacao":
    	$desenvolvimento->updateSolicitacao(array("desenvolvimento_id"=>$Dados['id'], "desenvolvimento_status"=>8));
    	$log['log_solicitacao'] = $Dados['id'];
    	$log['log_usuario'] = $_SESSION['user_info']['id_usuario'];
    	$log['log_descricao'] = "Alteração status da solicitação para Em Análise";
    	$log['log_data'] = date("Y-m-d H:i:s");
    	$log['log_texto'] = !empty($Dados['log_motivo']) ? $Dados['log_motivo'] : "";
    	$desenvolvimento->insertLog($log);
    	header("Location: ../../../../index.php?pg=23");
    	break;

    case "finalizarSolicitacao":
        $solicitacao = $desenvolvimento->selectArray($Dados['id']);
        $dados['desenvolvimento_id'] = $Dados['id'];
        $dados['desenvolvimento_status'] = 5;
        $dados['desenvolvimento_data_final'] = date("Y-m-d H:i:s");
        $desenvolvimento->updateSolicitacao($dados);
        cadastrarLog($dados, $solicitacao);

        $solicitacao['desenvolvimento_status'] = 5;
        $desenvolvimento->select($dados['desenvolvimento_id']);
        $msg = Funcoes::getCumprimento() . ", {$desenvolvimento->get("desenvolvimento_usuario")} <br>O seu chamado n° {$desenvolvimento->get("desenvolvimento_id")} foi finalizado.<br><br>Atenciosamente,<br><br>Informática - Grupo Volpato";
        enviarEmailAviso($msg, array($solicitacao['desenvolvimento_email']), "Chamado n° {$desenvolvimento->get("desenvolvimento_id")} foi finalizado.");


        header("Location: ../../../../index.php?pg=23");
        break;

    case "bug":
        $solicitacao = $desenvolvimento->selectArray($Dados['id']);
        $dados['desenvolvimento_id'] = $Dados['id'];
        $dados['desenvolvimento_status'] = 7;
        $dados['desenvolvimento_data_final'] = "";
        $desenvolvimento->updateSolicitacao($dados);
        $dados['log_motivo'] = $Dados['motivo'];
        cadastrarLog($dados, $solicitacao);
        $solicitacao['desenvolvimento_status'] = 7;
        $desenvolvimento->select($dados['desenvolvimento_id']);
        $msg = msg($desenvolvimento->get("desenvolvimento_usuario"), $desenvolvimento->get("desenvolvimento_id"));
        enviarEmailAviso($msg, array($solicitacao['desenvolvimento_email']), "Chamado n° {$desenvolvimento->get("desenvolvimento_id")} foi alterado");
        header("Location: ../../../../index.php?pg=23");
        break;

    case "trocarNivel":
        $nivel = $Dados['nivel'] == 1 ? 2 : 1;
        $desenvolvimento->updateSolicitacao(array("desenvolvimento_id" => $Dados['id_solicitacao'], "desenvolvimento_nivel_solicitacao" => $nivel));
        header("Location: ../../../../index.php?pg=22&id={$Dados['id_solicitacao']}&acao=editar&tab={$Dados['tab']}");
        break;

    case "enviarEmail":


        $id = filter_input(INPUT_POST, "id");

        $desenvolvimento->select($id);

        $usuario = $desenvolvimento->get("desenvolvimento_usuario");
        $titulo = $desenvolvimento->get("desenvolvimento_modulo");
        $programador = $desenvolvimento->get("desenvolvimento_programador");
        $dataCriacao = $desenvolvimento->get("desenvolvimento_data_criacao");
        $dataInicio = $desenvolvimento->get("desenvolvimento_data_inicio");
        $dataFim = $desenvolvimento->get("desenvolvimento_data_final");
        $descricao = $desenvolvimento->get("desenvolvimento_descricao");
        $requisicao = $desenvolvimento->get("desenvolvimento_requisicao");
        $setor = $desenvolvimento->get("desenvolvimento_setor");
        $nivel = $desenvolvimento->get("desenvolvimento_nivel");
        $status = $desenvolvimento->get("desenvolvimento_status");

        require_once("../../../../fpdf/solicitacao/sub-pasta/dadosOs.php");

        $user = (new Usuarios)->selUsuario($_SESSION['user_info']['id_usuario']);

        $phpmailer = new PHPMailer();

        require_once("../../../../fpdf/dompdf/dompdf_config.inc.php");

        Funcoes::geraPDF($id, $html, null, new DOMPDF(), "\\fpdf\\solicitacao\\" . $id . ".pdf");


        $DadosEmail ['asssunto'] = utf8_decode($Dados['titulo']);
        $DadosEmail ['emailRementente'] = $user['usuario_email'];
        $DadosEmail ['remetente'] = utf8_decode($user['nome']);
        $DadosEmail ['emailDestino'] = $Dados['email'];
        $DadosEmail ['nomeEmailResposta'] = utf8_decode($user['nome']);
        $DadosEmail ['nome'] = utf8_decode($user['nome']);
        $DadosEmail ['emailResposta'] = $user['usuario_email'];
        $DadosEmail ['Body'] = utf8_decode($Dados['mensagem']);
        $DadosEmail ['nomeEpastaDoArquivoEmAnexo'] = "../../../../fpdf/solicitacao/" . $id . ".pdf";
        @Funcoes::EnviarEmail($DadosEmail, $phpmailer);
        unlink("../../../../fpdf/solicitacao/" . $id . ".pdf");
        header("Location: ../../../../index.php?pg=22&id={$Dados['id']}&acao=editar&tab={$Dados['tab']}");
        break;
}

function cadastrarLog($Dados, $solicitacao = NULL) {
    $i = 0;

    $desenvolvimento = new Desenvolvimento;
    $desenvolvimento->setDados($Dados);
    $usuario = new Usuarios;

    $logs = array();

    $campos[0] = array("campo" => "desenvolvimento_status", "descricao" => "status", "texto" => "log_motivo");
    $campos[1] = array("campo" => "desenvolvimento_nivel", "descricao" => "nivel", "texto" => false);
    $campos[1] = array("campo" => "desenvolvimento_nivel_solicitacao", "descricao" => "setor", "texto" => false);
    $campos[2] = array("campo" => "desenvolvimento_tipo", "descricao" => "tipo", "texto" => false);
    $campos[3] = array("campo" => "desenvolvimento_email", "descricao" => "email", "texto" => "desenvolvimento_email");
    $campos[4] = array("campo" => "desenvolvimento_modulo", "descricao" => "modulo", "texto" => "desenvolvimento_modulo");
    $campos[5] = array("campo" => "desenvolvimento_descricao", "descricao" => "descricao", "texto" => "desenvolvimento_descricao");
    $campos[6] = array("campo" => "desenvolvimento_obs_supervisor", "descricao" => "observação do supervisor", "texto" => "desenvolvimento_obs_supervisor");
    $campos[7] = array("campo" => "desenvolvimento_requisicao", "descricao" => "requisição", "texto" => "desenvolvimento_requisicao");


    if (empty($solicitacao) && !isset($Dados['desenvolvimento_help'])) {
        $log['log_solicitacao'] = $Dados['desenvolvimento_id'];
        $log['log_usuario'] = $_SESSION['user_info']['id_usuario'];
        $log['log_descricao'] = "Cadastro solicitação";
        $log['log_data'] = date("Y-m-d H:i:s");

        $texto = "";

        foreach ($campos as $c) {
            if (isset($Dados[$c['campo']]) && !Funcoes::dadosVaziosDesconsiderandoZero($Dados[$c['campo']])) {
                $valor = $desenvolvimento->get($c['campo']);
                $texto .= ucfirst($c['descricao']) . ": " . $valor . "\n";
            }
        }

        $log['log_texto'] = $texto;
        $logs[$i] = $log;
        $i++;
    }

    if (!empty($solicitacao)) {

        $log['log_solicitacao'] = $Dados['desenvolvimento_id'];
        $log['log_usuario'] = $_SESSION['user_info']['id_usuario'];
        $log['log_descricao'] = "Alteração Dados";

        $data = date("Y-m-d H:i:s");

        $textos = array('status', 'nivel', 'tipo');

        $texto = "";

        foreach ($campos as $c) {

            if (isset($Dados[$c['campo']]) && !Funcoes::dadosVaziosDesconsiderandoZero($Dados[$c['campo']]) && $Dados[$c['campo']] != $solicitacao[$c['campo']]) {

                if (in_array($c['descricao'], $textos)) {

                    $campo = $c['descricao'];
                    $valor = $desenvolvimento->get($c['campo']);
                    $t = $c['texto'] != false ? $Dados[$c['texto']] : "";

                    $l['log_solicitacao'] = $Dados['desenvolvimento_id'];
                    $l['log_usuario'] = $_SESSION['user_info']['id_usuario'];
                    $l['log_descricao'] = !empty($valor) ? "Alteração {$campo} da solicitação para $valor" : "Alteração {$campo} da solicitação";
                    $l['log_data'] = $data;
                    $l['log_texto'] = $t;
                    $logs[$i] = $l;
                    $i++;
                } else {
                    $campo = $c['descricao'];
                    $valor = $desenvolvimento->get($c['campo']);

                    $texto .= ucfirst($c['descricao']) . ": " . $valor . "\n";
                }
            }
        }

        $log['log_texto'] = $texto;
        $log['log_data'] = $data;

        if (!empty($log['log_texto']))
            $logs[$i] = $log;

        $i++;

        //programador
        if (isset($Dados["desenvolvimento_id_programador"]) && !empty($Dados["desenvolvimento_id_programador"]) && $Dados["desenvolvimento_id_programador"] != $solicitacao["desenvolvimento_id_programador"]) {
            $programador = $usuario->selUsuario($Dados["desenvolvimento_id_programador"]);
            $log['log_solicitacao'] = $Dados['desenvolvimento_id'];
            $log['log_usuario'] = $_SESSION['user_info']['id_usuario'];
            $log['log_descricao'] = "Solicitação atribuída para o programador {$programador['nome']} (Cód.{$Dados['desenvolvimento_id_programador']}).";
            $log['log_data'] = date("Y-m-d H:i:s");
            $logs[$i] = $log;
            $i++;
        }
    }

    //help
    if (isset($Dados["desenvolvimento_help"])) {

        //se foi solicitado ajuda
        if ($Dados["desenvolvimento_help"] == 1) {
            $programador = $usuario->selUsuario($Dados["desenvolvimento_id_programador"]);
            $log['log_solicitacao'] = $Dados['desenvolvimento_id'];
            $log['log_usuario'] = $_SESSION['user_info']['id_usuario'];
            $log['log_descricao'] = "Solicitado HELP";
            $log['log_data'] = date("Y-m-d H:i:s");
            $log['log_texto'] = $Dados['log_motivo'];
            $logs[$i] = $log;

            //respota da solicitação	
        } else {

            $resposta = $Dados["desenvolvimento_help"] == 2 ? "NEGADA" : "ACEITA";

            $log['log_solicitacao'] = $Dados['desenvolvimento_id'];
            $log['log_usuario'] = $_SESSION['user_info']['id_usuario'];
            $log['log_descricao'] = "Solicitação de HELP {$resposta}";
            $log['log_data'] = date("Y-m-d H:i:s");
            $log['log_texto'] = $Dados['log_motivo'];
            $logs[$i] = $log;
        }
    }

    if (sizeof($logs) > 0) {
        foreach ($logs as $l) {
            $desenvolvimento->insertLog($l);
        }
    }
}

function enviarEmailAviso($msg, array $detinatarios, $assunto = null) {

    if ($_SERVER['HTTP_HOST'] != "localhost") {

        $periodo = Funcoes::getCumprimento();

        $assunto = $assunto == null ? "AVISO ORÁCULO" : $assunto;

        $DadosEmail ['asssunto'] = utf8_decode($assunto);
        $DadosEmail ['emailRementente'] = 'revendavolpato@revendavolpato.com';
        $DadosEmail ['remetente'] = utf8_decode('Oráculo - Grupo Volpato');
        $DadosEmail ['nomeEmailResposta'] = utf8_decode("Oráculo - Grupo Volpato");
        $DadosEmail ['nome'] = "VOLPATO";
        $DadosEmail ['emailResposta'] = "revendavolpato@revendavolpato.com";
        $DadosEmail ['Body'] = utf8_decode($periodo.$msg);


        foreach ($detinatarios as $d) {
            $DadosEmail ['emailDestino'] = $d;
            Funcoes::EnviarEmail($DadosEmail, new PHPMailer());
        }
    }
}

function msg($nome, $chamado) {
    $msg = ", $nome <br><br>
				O seu chamado de numero $chamado, teve alteração.<br>
				Por favor verifique.<br><br>
				
				Atenciosamente,<br><br>
				
				Informática - Grupo Volpato";
    return $msg;
}

function inserirImagem($id_solicitacao, $arquivo) {

    $desenvolvimento = new Desenvolvimento;

    $name = isset($arquivo ["name"]) ? $arquivo ["name"] : $arquivo ["name"];
    $caminho = isset($arquivo['tmp_name']) ? $arquivo['tmp_name'] : $arquivo['tmp_name'];
    $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
    $nome_arquivo = md5(uniqid(time())) . "." . $extensao;
    $destino = $_SESSION['caminho_local'] . "/fpdf/solicitacao/imagensSolicitacao/";
    if (!file_exists($destino))
        mkdir($destino);
    Funcoes::UploadArquivos($caminho, $nome_arquivo, $destino);
    $desenvolvimento->insertAnexo(array("anexo_url" => $nome_arquivo, "desenvolvimento_id" => $id_solicitacao));

    $img['log_solicitacao'] = $id_solicitacao;
    $img['log_usuario'] = $_SESSION['user_info']['id_usuario'];
    $img['log_descricao'] = "Cadastro Imagens";
    $img['log_data'] = date("Y-m-d H:i:s");
    $img['log_texto'] .= $nome_arquivo;
    $desenvolvimento->insertLog($img);
}
