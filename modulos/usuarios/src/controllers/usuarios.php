<?php

header('Content-Type: text/html; charset=utf-8');
include_once ('../../../../Config.inc.php');
$DadosForm [0] = filter_input_array(INPUT_POST);
$acao = isset($DadosForm [0] ['acao']) ? $DadosForm [0] ['acao'] : $_GET['acao'];
$id = !empty($DadosForm [0] ['id']) ? $DadosForm [0] ['id'] : null;
unset($DadosForm [0] ['acao']);
if (!empty($_FILES)) {
    $DadosForm[1] = $_FILES;
}
$setor = new Setor ();
$usuario = new Usuarios ();
$permissao = new Permissao;

if (!isset($_SESSION['user_info']))
    @session_start();

$ftp_server = "ftp.seguidor.com.br";
$ftp_username = "seguidor";
$ftp_userpass = "33ftp666";
$caminho = $_SESSION['caminho_local'] . "\modulos\usuarios\public\img\assinaturas";



switch ($acao) {
    //UPDATE TEMPO DE RESPOSTA USUARIOS
    case 'uptempo' :
        // VARIAVEIS.
        $id_usuario = Funcoes::removerCodigoMalicioso($_POST ['id_usuario']);
        $valor = Funcoes::removerCodigoMalicioso($_POST ['valor']);
        // OBJETO USUARIO
        $usuario->updateTempoUsuario(array(
            'valor_tempo_espera' => $valor,
            'id' => $id_usuario
        ));
        // OBJETO USUARIO
        die(json_encode(array(
            'type' => 'success'
        )));
        break;

    //DELETE USUÁRIO:
    case 'del' :
        // VARIAVEL.
        $id = Funcoes::removerCodigoMalicioso($_POST ['id_user']);
        // OBJETO USUARIO
        $assinatura = $usuario->selUsuario($id); // pega o nome da assinatura do usuario:
        $assinatura = $assinatura ['assinatura'];
        $arquivo = 'fpdf/img/assinaturas/' . $assinatura; // pega o caminho da assinatura.
        if (file_exists($arquivo)) :
            @unlink($arquivo);
            $usuario->delete($id);
            $m = array(
                'type' => 'success'
            );
        else :
            $m = array(
                'type' => 'fail'
            );
        endif;
        echo json_encode($m);
        break;

    //CADASTRO DE ASSINATURAS:
    case 'cadastrar_assinatura' :
        $pasta = '../../../../fpdf/img/assinaturas';
        $assinatura = isset($_FILES ["assinatura"]) ? $_FILES ["assinatura"] : '';
        $nome_assinatura = isset($assinatura ['name']) ? $assinatura ['name'] : '';
        $destino = isset($assinatura ['tmp_name']) ? $assinatura ['tmp_name'] : ''; // onde fica armazenado temporario
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $nome_assinatura, $ext); // Pega extensão da imagem
        $nome_imagem = Funcoes::gerarNomeAleatorio(10) . "." . $ext [1]; // Gera um nome único para a imagem
        Funcoes::UploadImg($destino, $nome_imagem, 200, "", $pasta);
        $DadosForm ['0'] ['assinatura'] = $nome_imagem;
        // OBJETO USUARIO
        $usuario->trataDados($DadosForm);
        $usuario->updateUser();
        $result = 'on';
        header('location: ../../../../index.php?pg=4&result=' . $result);
        break;
    //UPDATE SETOR:	
    case "up_setor" :
        // objeto
        $usuario->updateUser(array('id_setor' => $id_setor, 'id_usuario' => $id_usuario));
        die(json_encode(array('type' => 'success')));
        break;
    //UPDATE ATIVO:
    case "up_ativo" :
        $ativo = $DadosForm ['0'] ['ativo'];
        // objeto:
        $usuario->updateUser(array('ativo' => $ativo, 'id_usuario' => $id));
        die(json_encode(array('type' => 'success')));
        break;

    //INSERT USUARIO:
    case 'cadastrar_usuario' :
        unset($DadosForm [0]['id_permissao_grupo'], $DadosForm [0]['id']);
        if (isset($DadosForm ['1'] ['assinatura']) && $DadosForm ['1']['assinatura'] ['error'] != 4) {
            $destino = $DadosForm ['1'] ['assinatura']['tmp_name'];
            preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $DadosForm [1] ['assinatura'] ['name'], $ext); // Pega extensão da imagem
            $nome = $DadosForm [0] ['usuario'] . "." . $ext [1]; // Gera um nome único para a imagem
            Funcoes::UploadImg($destino, $nome, 192, "", $caminho);
            Funcoes::uploadArquivosServidor($ftp_server, $ftp_username, $ftp_userpass, "assinaturaEmail/" . $nome, $DadosForm['1']['assinatura']['tmp_name']);
            $DadosForm [0]['assinaturaEmail'] = $nome;
            $DadosForm [0]['assinatura'] = 'nome_temp';
            $DadosForm [0]['data_logado'] ='2021-05-24 15:05:12';
        } else {
            unset($DadosForm [1]);
        }
        $DadosForm = validaDados($DadosForm);
        // setar dados para serem tratados
        $usuario->trataDados($DadosForm);
        // cadastrar usuário no banco
        $id_usuario = $usuario->insert();
        $result = 'on';
        header('location: ../../../../index.php?pg=21&result=' . $result);
        break;
    //UPDATE USUARIO :
    case "editar" :
		//Recuperar o ID do usuario:
        $id_usuario = $DadosForm[0]['id'];
		//Recuperar o usuario:
		$user = $usuario->selUsuario($id_usuario);
		//Verifica grupo :
		$grupo = $usuario->verificaPermissaoGrupo($id_usuario);
        if (isset($DadosForm [0]['id_permissao_grupo']) && !empty($DadosForm[0]['id_permissao_grupo'])) 
		{
            if ($DadosForm [0]['id_permissao_grupo'] != "")
			{
                $usuario->selectDuplicadas($id_usuario, $DadosForm[0]['id_permissao_grupo']);
                if (!empty($grupo)){
                    $usuario->updateGrupo(array('id_usuario' => $id_usuario, 'id_permissao_grupo' => $DadosForm [0]['id_permissao_grupo']), $grupo['id_permissao_grupo']);
                }else{
                    $usuario->insertPermissaoUsuario(array('id_usuario' => $id_usuario, 'id_permissao_grupo' => $DadosForm [0]['id_permissao_grupo']));
				}
            }else if (!empty($grupo['id_permissao_grupo'])){
                $usuario->deleteGrupoPermissao($id_usuario, $grupo['id_permissao_grupo']);		
			}
        }
		unset($DadosForm [0]['id_permissao_grupo']);	
		//recupera  imagens:
		$nome_nova_imagem = $DadosForm[1]['assinatura']['name'];
		$nome_imagem_da_base = $user['assinaturaEmail'];
		
		// substitui imagem se foi trocada:
		if(!empty($nome_nova_imagem) &&  $nome_nova_imagem == $nome_imagem_da_base) 
		{
		    unlink($caminho.$user['assinaturaEmail']);
            $destino = $DadosForm[1]['assinatura']['tmp_name'];
			$nome_imagem = $DadosForm [1]['assinatura']['name'];
			// Pega extensão da imagem:
            preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i",$nome_imagem , $ext); 
			// Gera um nome único para a imagem:
            $nome = $DadosForm[0]['usuario'] . "." . $ext[1]; 
            Funcoes::UploadImg($destino, $nome, 192, "", $caminho);
            Funcoes::uploadArquivosServidor($ftp_server, $ftp_username, $ftp_userpass, "assinaturaEmail/" . $nome, $destino);
            $DadosForm [0]['assinaturaEmail'] = $nome;
        } 
        $usuario->trataDados($DadosForm);
        $usuario->updateUser();
        $result = 'on';
	
        header('location: ../../../../index.php?pg=4&result=' . $result);
        break;

    //RESETAR USUARIO:
    case "resetSenha" :
        $usuario->trataDados($DadosForm);
        $usuario->updateUser();
        echo '<script type="text/javascript">
                    alert("Senha Resetada com sucesso.");
                    location.href=": ../../../../../../index.php?pg=4";
             </script>';
        break;


    //ADICIONA PLANILHA DE COMISSÃO 
    case "atribuirPlanilhaComissao" :

        foreach ($DadosForm ['0'] ['id_pc'] as $planilha) :
            // verifica duplicadas:
            $usuario->verificaPlanilhaComissaoUsuario(array(
                'idUsuario' => $id,
                'planilha' => $planilha
            ));

            $total = $usuario->Read()->getRowCount();
            if ($total >= 1) {
                $result = 'off';
                // insere na base :
            } else {
                $Dados ['usuariosPlanilhas_id_usuarios'] = $id;
                $Dados ['usuariosPlanilhas_id_planilha_comissoes'] = $planilha;
                $usuario->atribuirPlanilhaComissaoUsuario($Dados);
                $result = '1';
            }
        endforeach
        ;
        if ($DadosForm [0] ['tela'] == "editar")
            header('location: ../../../../index.php?pg=21&id=' . $id . '&acao=editar');
        else
            header('location: ../../../../index.php?pg=4&result=' . $result);
        break;

    //DELETA PLANILHA DE COMISSÃO
    case "deletePlanilhaUsuario" :
        $idUsuario = $_GET ['id_usuario'];
        $usuario->deletePlanilhaUsuario(array(
            "id_usuario" => $idUsuario,
            "id_planilha" => $_GET ['id_planilha']
        ));
        header("Location: ../../../../index.php?pg=21&id={$idUsuario}&acao=editar");
        break;

    //CHECAR SE O USUÁRIO JÁ EXISTE NO SISTEMA:
    case "verDuplicidade" :
        $total = $usuario->validarUsuario($DadosForm [0] ['usuario']);
        $retorno = 2;
        if ($total > 0)
            $retorno = 0;
        die(json_encode(array("type" => $retorno)));
        break;

    //EXCLUIR PERMISSÕES DE ACORDO COM ID DO USUARIO E O ID DA PERMISSÃO.
    case "deletePermissaoUsuario" :
        $id_usuario = $_GET ['id_usuario'];
        $idPermissaoUser = $_GET['id_permissao'];
        $verificaPermissaoVenda = $usuario->verificaUsuarioPermissaoVenda($id_usuario);
        $verificar = !empty($verificaPermissaoVenda);
        $usuario->deletePermissoes(array(
            'id_usuario' => $id_usuario,
            'id_permissaouser' => $idPermissaoUser
        ));
        if ($verificar)
            $usuario->deletarNivelCaptacaoVendedor($id_usuario);
        header("Location: ../../../../index.php?pg=21&id={$id_usuario}&acao=editar");
        break;

    //ATRIBUIR PERMISSÕES PARA O USUARIO :
    case "atribuirPermissaoUsuario" :
        $id_usuario = $DadosForm[0]['usuario'];
        $id_permissaouser = $DadosForm [0] ['id_permissaouser'];
        //DELETAR PERMISSAO : 
        $usuario->deletePermissosUsuario($id_usuario);
        foreach ($id_permissaouser as $k => $permissao) {
            $usuario->insertPermissaoUsuario(array(
                'id_usuario' => $id_usuario,
                'id_permissaouser' => $permissao
            ));
        }
        die(json_encode(array("tipo" => TRUE)));
        break;

    //SELECIONA AS PERMISSÕES DO GRUPOS
    case "selecionarPermissoesGrupos":
        $id_grupo = preg_replace("/[^0-9]/", "", filter_input(INPUT_POST, "id_grupo"));
        $permissoesGrupo = $permissao->selectPermmisoesGrupo($id_grupo);
        die(json_encode($permissoesGrupo));
        break;

    // CADASTRA OU EDITA UM GRUPO DE PERMISSÂO :
    case "salvarGrupoPemrmissao":
        if (!empty($DadosForm [0]['nome_grupo'])) {
            $id = $permissao->insertGrupo(array("gp_descricao" => $DadosForm [0]['nome_grupo']));
            if (!empty($id)) {
                foreach ($DadosForm[0]['id_permissaouser'] as $p) {
                    $permissao->insertPermissaoGrupo(array("permissao_grupo_grupo" => $id, "permissao_grupo_permissao" => $p));
                }
            }
            die(json_encode(array("type" => "0", "id" => $id)));
        } else {
            $id_grupo = preg_replace("/[^0-9]/", "", $DadosForm[0]['grupoPermissao']);
            $permissoesGrupo = $permissao->selectPermmisoesGrupo($id_grupo);
            $permissoes = $DadosForm[0]['id_permissaouser'];
            foreach ($permissoesGrupo as $p) {
                $verifica = (int) Funcoes::arraySearch($p['id_permissao'], $DadosForm[0]['id_permissaouser']);
                if ($verifica == -1) {
                    $permissao->deletePermissaoGrupo($id_grupo, $p['id_permissao']);
                } else {
                    unset($permissoes[$verifica]);
                }
            }

            foreach ($permissoes as $perm) {
                $permissao->insertPermissaoGrupo(array("permissao_grupo_grupo" => $id_grupo, "permissao_grupo_permissao" => $perm));
            }

            die(json_encode(array("type" => "1", "id" => $id_grupo)));
        }
        break;

    case "selecionarPemissoesUsuario":
        $id = preg_replace("/[^0-9]/", "", filter_input(INPUT_POST, "id"));
        $permissoesUsuario = $usuario->selectPermissoesIndividuais($id);
        $grupoUsuario = !empty($id) ? $usuario->selectGrupoPermissao($id) : 0;
        $permissoesUsuario['grupo'] = isset($grupoUsuario['id_permissao_grupo']) ? $grupoUsuario['id_permissao_grupo'] : 0;
        die(json_encode($permissoesUsuario));
        break;

    case "insertPermissao":
        $id = $permissao->insert($DadosForm[0]);
        die(json_encode(array("type" => $id)));
        break;

    case "cadastrarSetor":
        $setor->insert($DadosForm[0]);
        die(json_encode(array("texto" => $DadosForm[0]['setor_local'])));
        break;

    case "cadastrarBase":
        $setor->insertBase($DadosForm[0]);
        die(json_encode(array("texto" => $DadosForm[0]['base_nome'])));
        break;


    //ALTERAR SENHA:
    case "alterar_senha" :
        $id = $_SESSION ['user_info'] ['id_usuario'];
        $senha = $DadosForm ['0'] ['senha'];
        $confirma_senha = $DadosForm ['0'] ['confirma_senha'];
        if ($senha === $confirma_senha) :
            $DadosForm ['0'] ['senha'] = $senha;
            $DadosForm ['0'] ['id'] = $id;
            unset($DadosForm ['0'] ['confirma_senha']);
            $usuario->trataDados($DadosForm);
            $usuario->updateUser();
            unset($_SESSION ['user_info']);
            echo '<script type="text/javascript">
            		alert("Senha resetada com sucesso.");
		    	 </script>';
            header('location: index.php');
        else :
            echo '<script type="text/javascript">
                    alert("Senhas nao conferem."); location.href=": ../../../../../../index.php?pg=0";
                </script>';
        endif;
        break;


    //EDITAR MEUS DADOS
    case "editar_meus_dados" :
        if ($DadosForm[0]['senha'] == '') {
            unset($DadosForm[0]['senha']);
        } else {
            $DadosForm[0]['senha'] = md5($DadosForm[0]['senha']);
        }
        $usuario->updateUsuario($DadosForm[0]);
        header('location: /gpi/login.php');
        break;
}

function validaDados($DadosForm) {
    if ($DadosForm [0]['id_cargo'] == '') {
        unset($DadosForm [0]['id_cargo']);
    }
    if ($DadosForm [0]['id_setor'] == '') {
        unset($DadosForm [0]['id_setor']);
    }
    if ($DadosForm [0]['rg'] == '') {
        unset($DadosForm [0]['rg']);
    }
    if ($DadosForm [0]['cpf'] == '') {
        unset($DadosForm [0]['cpf']);
    }
    if ($DadosForm [0]['assinaturaEmail'] == '') {
        unset($DadosForm [0]['assinaturaEmail']);
    }

    return $DadosForm;
}
