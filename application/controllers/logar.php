<?php
date_default_timezone_set('America/Sao_Paulo');
include_once ("../../Config.inc.php");
$dadosfROM = filter_input_array(INPUT_POST);
$act = !empty($dadosfROM['act']) ? $dadosfROM['act'] : $_GET['act'];
$usuarioLogin = !empty($dadosfROM['txt_usuario']) ? $dadosfROM['txt_usuario'] : '';
$senha = !empty($dadosfROM['txt_senha']) ? md5($dadosfROM['txt_senha']) : '';
$Dados = filter_input_array(INPUT_POST);
$objlogin = new Usuarios();

switch ($act):
    /*
     * *********************************************
     * ********** REALIZA LOGIN NO SISTEMA *********
     * *********************************************
     */
    case 1 :
	    $objlogin->setUsuario($usuarioLogin);
        $objlogin->setSenha($senha);
        $dados = $objlogin->selectUsuarioLogin();
        $rows = $objlogin->Read()->getRowCount();
        $permisssao = (!empty($dados)) ? $objlogin->selectPermissoes($dados['id']) : null;
        $ret = 'fail';
        $msg = "Nome de Usuário ou Senha inválidos.";

        /*
         * *****************************************************************
         * ********* VERIFICA A EXISTENCIA DE UM USUARIO NA BASE ***********
         * *****************************************************************
         */
		 
        if ($rows >= 1) {
            if ($dados['ativo'] != 2) {
                @session_start();
                // - Grava as informações do usuario
                $_SESSION['user_info']['id_usuario'] = isset($dados['id']) ? $dados['id'] : NULL;
                $_SESSION['user_info']['id_setor'] = isset($dados['id_setor']) ? $dados['id_setor'] : NULL;
                $_SESSION['user_info']['usuario'] = isset($dados['usuario']) ? $dados['usuario'] : NULL;
                $_SESSION['user_info']['nome'] = isset($dados['nome']) ? $dados['nome'] : NULL;
                $_SESSION['user_info']['ativo'] = isset($dados['ativo']) ? $dados['ativo'] : NULL;
                $_SESSION['user_info']['data_logado'] = isset($dados['data_logado']) ? $dados['data_logado'] : NULL;
                $_SESSION['user_info']['versao'] = isset($dados['versao_gpi']) ? $dados['versao_gpi'] : NULL;
                $_SESSION['user_info']['permissoes'] = isset($permisssao) ? $permisssao : NULL;
                $ret = 1;
                //atualiza data que o usuario se logou:  
                $rrtrtre = $objlogin->updateTempoUsuario(
                        array(
                            'id' => $dados['id'],
                            'data_logado' => date('Y-m-d H:i:s'),
                        )
                );
                Funcoes::gerarLogCadastro(new Log, "Login", array("id" => $dados['id']), 7);
            } else {
                $msg = "Usuário inativo, entre em contato com o suporte!";
                Funcoes::gerarLogCadastro(new Log, "tentantiva de login de usuário inativo", array("id" => $dados['id']), 7);
            }
        }
        die(json_encode(array("type" => $ret, "msg" => $msg)));
        break;
    case 2 :
        @session_start();
        //atualiza data que o usuario saiu do sistema:  
        //        $objlogin->updateTempoUsuario(
        //            array(
        //                'id' => $_SESSION['user_info']['id_usuario'],
        //                'data_logado_fim' => date('Y-m-d H:i:s'),
        //            )
        //        );
        Funcoes::gerarLogCadastro(new Log, "Logout", array("id" => $_SESSION['user_info']['id_usuario']), 7);
        session_destroy();
        setcookie('contador');
        unset($_SESSION['user_info']);
        echo "<script>alert('Session finalizada com Sucesso!'); location.href='../../login.php'; </script>";
        break;
    case 3:
        $user = $objlogin->selectUsuario($Dados['usuario']);
        $result = 0;
        $desenvolvimento = new Desenvolvimento;
        if ($objlogin->Read()->getRowCount() > 0) {
            $solicitacao['desenvolvimento_id_usuario'] = $user['id'];
            $solicitacao['desenvolvimento_data_criacao'] = date("Y-m-d H:i:s");
            $solicitacao['desenvolvimento_modulo'] = "Recuperação de Senha";
            $solicitacao['desenvolvimento_status'] = 1;
            $solicitacao['desenvolvimento_requisicao'] = "Recuperação de senha para o usuário: " . $Dados['usuario'];
            $solicitacao['desenvolvimento_nivel'] = 3;
            $solicitacao['desenvolvimento_email'] = $user['usuario_email'];
            $solicitacao['desenvolvimento_tipo'] = 4;
            $solicitacao['desenvolvimento_nivel_solicitacao'] = 1;
            $r = $desenvolvimento->insert($solicitacao);
            if ($r > 0) {
                $desenvolvimento->setDados($solicitacao);
                $campos[0] = array("campo" => "desenvolvimento_status", "descricao" => "status", "texto" => "log_motivo");
                $campos[1] = array("campo" => "desenvolvimento_nivel", "descricao" => "nivel", "texto" => false);
                $campos[1] = array("campo" => "desenvolvimento_nivel_solicitacao", "descricao" => "setor", "texto" => false);
                $campos[2] = array("campo" => "desenvolvimento_tipo", "descricao" => "tipo", "texto" => false);
                $campos[3] = array("campo" => "desenvolvimento_email", "descricao" => "email", "texto" => "desenvolvimento_email");
                $campos[4] = array("campo" => "desenvolvimento_modulo", "descricao" => "modulo", "texto" => "desenvolvimento_modulo");
                $campos[5] = array("campo" => "desenvolvimento_descricao", "descricao" => "descricao", "texto" => "desenvolvimento_descricao");
                $campos[7] = array("campo" => "desenvolvimento_requisicao", "descricao" => "requisição", "texto" => "desenvolvimento_requisicao");
                $log['log_solicitacao'] = $r;
                $log['log_usuario'] = $desenvolvimento->get("desenvolvimento_id_usuario");
                $log['log_descricao'] = "Cadastro solicitação";
                $log['log_data'] = date("Y-m-d H:i:s");
                $texto = "";
                foreach ($campos as $c) {
                    $valor = $desenvolvimento->get($c['campo']);
                    $texto .= ucfirst($c['descricao']) . ": " . $valor . "\n";
                }
                $log['log_texto'] = $texto;
                $desenvolvimento->insertLog($log);
            } else
                $result = 2;
        } else {
            $result = 1;
        }
        die(json_encode(array("result" => $result)));
        break;
    case 4:
        $cumprimento = Funcoes::getCumprimento();
        $DadosEmail ['asssunto'] = utf8_decode("Solicitação Usuário");
        $DadosEmail ['emailRementente'] = 'revendavolpato@revendavolpato.com';
        $DadosEmail ['remetente'] = 'Grupo Volpato';
        $DadosEmail ['emailDestino'] = "desenvolvimento03@grupovolpato.com";
        $DadosEmail ['nomeEmailResposta'] = "GRUPO VOLPATO";
        $DadosEmail ['nome'] = "VOLPATO";
        $DadosEmail ['emailResposta'] = "revendavolpato@revendavolpato.com";
        $DadosEmail ['Body'] = utf8_decode($cumprimento . ",<br>Solicitação de criacão/recuperação usuário:<br> Dados: <br><br> Nome: {$Dados['nome']} <br> Setor: {$Dados['setor']} <br> E-mail: {$Dados['email']}");
        $result = @Funcoes::EnviarEmail($DadosEmail, new PHPMailer());
        $result = $result == 1 ? 0 : 2;
        die(json_encode(array("result" => $result)));
        break;
endswitch;