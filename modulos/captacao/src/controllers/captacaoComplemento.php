<?php

/*
 * -----------------------------------------------------------------------------------------
 * INSTANCIAR OBJETOS : 
 * -----------------------------------------------------------------------------------------
 */

$_GetUF = new GetUF();

/*
 * -----------------------------------------------------------------------------------------
 * FUNÇÕES AUXILIARES: 
 * -----------------------------------------------------------------------------------------
 */
 
function idUsuarioDisponivel($nivelPermissao, $ddd, $captacao) {
    $verifica = FALSE;
    $vendedor_status_off = $captacao->selectMenorIdUsuarioTableUsuario($nivelPermissao, 'off');
    if ($vendedor_status_off) {
        $vendedor = $vendedor_status_off;
    } else {
        $limit = true;
        # VENDEDOR COM STATUS ON MENOR ID:
        $vendedor = $captacao->selectMenorIdUsuarioTableUsuario($nivelPermissao, 'on', $limit);
        # TODOS VENDEDOR COM STATUS ON :
        $todos_vendedores_on = $captacao->selectMenorIdUsuarioTableUsuario($nivelPermissao, 'on', false, $vendedor[0]['id']);
        foreach ($todos_vendedores_on as $k => $v) {
            $captacao->atualizarStatusCaptacao($v['id'], 'off');
        }
    }

    foreach ($vendedor as $result) {
        $regras = $captacao->buscarRegraUsuario($result['id']);
        if (!empty($regras)) {
            foreach ($regras as $regra) {
                if ($regra['captacao_niveis_regras_nivel'] == 2 || ($regra['captacao_niveis_regras_nivel'] == 1 && $regra['captacao_niveis_regras_operacao'] != '51')) {
                    $r = explode("_", $regra ['captacao_niveis_regras_operacao']);
                    $r [0] = (int) $r [0];
                    $r [1] = (int) $r [1];
                    $r [2] = (int) $r [2];
                    // diferente :
                    if ($r[0] == 1) {
                        if ($ddd < $r [1] || $ddd > $r [2]) {
                            $verifica = true;
                            break;
                        }
                        // entre :    
                    } else if ($r[0] == 2) {
                        if ($ddd >= $r [1] && $ddd <= $r [2]) {
                            $verifica = true;
                            break;
                        }
                    }
                    //Verifica as regras de sequência :	
                } else {
                    $r = explode(",", $regra ['captacao_niveis_regras_operacao']);
                    foreach ($r as $reg) {
                        if ($reg == $ddd) {
                            $verifica = true;
                            break;
                        }
                    }
                }
            }
            if ($verifica) {
                break;
            }
        } else {
            $verifica = true;
        }
    }

    if ($verifica) {
        $id_usuario = $result['id'];
    } else {
        $id_usuario = false;
    }
    return $id_usuario;
}

//RESPONSAVEL POR CRIAR UM lOG DAS CAPTACOES :
function gravar_log($Dados) {
    date_default_timezone_set('America/Sao_Paulo');
    $data = date("d-m-y");
    $hora = date("H:i:s");
    $arquivo = "log_insert_captacao_$data.txt";
    $msg = "ID :" . $Dados['captacao_id_usuario'] .
            ",VENDEDOR:" . $Dados['vendedor'] .
            ",INTERESSE:" . $Dados['captacao_interesse'] .
            ',CLIENTE:' . $Dados['captacao_cliente'] .
            ",TELEFONE:" . $Dados['captacao_telefone1'] .
            ",EMAIL:" . $Dados['captacao_email'] .
            ",ORIGEM:" . $Dados['origem']
    ;
    $texto = "[$data] [$hora] $msg \n";
    $manipular = fopen("$arquivo", "a+b");
    fwrite($manipular, $texto);
    fclose($manipular);
}

function getDDD($captacao_telefone1) {
    $ddd = substr($captacao_telefone1, 1, 2);
    return $ddd;
}

function buscaUF($ddd, $_GetUF) {
    $captacao_uf = ($_GetUF->_getUF($ddd)) ? $_GetUF->_getUF($ddd) : 'DESCONHECIDO';
    return $captacao_uf;
}

function buscaFormulario($captacao_interesse) {
    $ARRAY_DATA = ['5', '6'];
    $captacao_formulario = "formulario_b";
    if (!in_array($captacao_interesse, $ARRAY_DATA)) {
        $captacao_formulario = 'formulario_a';
    }
    return $captacao_formulario;
}

function verificar_se_tem_capanha($campanha) {
    if (!empty($campanha)) {
        return true;
    } else {
        return false;
    }
}

function enviarSMS($dados_sms) {
    include_once ("../../../../application/models/classes/api_sms/HumanClientMain.php");
    $captacao_telefone1 = explode(')', $dados_sms['captacao_telefone1']);
    $total_captacao_telefone1 = strlen($captacao_telefone1[1]);
    if ($total_captacao_telefone1 >= 10) {
        $sms_captacao_telefone1 = "(51)" . substr($captacao_telefone1[1], 1);
    } else {
        $sms_captacao_telefone1 = $dados_sms['captacao_telefone1'];
    }
    #  SMS PARA O CLIENTE :
    Funcoes::enviaSMS(array(
        'id_captacao' => $dados_sms['ultimo_id'],
        'mensagem' => 'Obrigado pela preferencia. Em breve um de nossos consultores entrara em contato.  Volpato', 'telefone' => $sms_captacao_telefone1), new Sms, new HumanMultipleSend("volpatoapipos", "bmHvfLRFlr"
    ));
}

function enviar_email($dados_email){
    if (isset($Dados['captacao_email']) && !empty($dados_email['captacao_email'])) {
        $msgCliente = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Obrigado pela prefer&amp;circ;ncia.</title>
                    </head>			
                    <body  style=" color:#1D3E69; font-size:16px; font-family:Arial, Helvetica, sans-serif">
                        <p> Ol&aacute;,</p>
                        <p style="font-size:16px"> Obrigado pela prefer&ecirc;ncia.</p>
                        <p style="font-size:16px">Em breve um de nossos consultores entrar&aacute; em contato.</p>
                        <p style="font-size:16px">Atenciosamente,<br>
                        Grupo Volpato</p>
                        <p style="font-size:16px"><img src="http://revendavolpato.com/saudacoes_gpi/obrigado%20pela%20preferencia%20rodape.png"  width="789" height="94" alt="" border="0"></p>			
                    </body>
                    </html>';
        $DadosEmail ['asssunto'] = utf8_decode("Seja Bem Vindo à Volpato");
        $DadosEmail ['emailRementente'] = 'revendavolpato@revendavolpato.com';
        $DadosEmail ['remetente'] = 'Grupo Volpato';
        $DadosEmail ['emailDestino'] = $dados_email ['captacao_email'];
        $DadosEmail ['nome'] = $dados_email ['captacao_cliente'];
        $DadosEmail ['emailResposta'] = 'volpato@grupovolpato.com';
        $DadosEmail ['nomeEmailResposta'] = "GRUPO VOLPATO";
        $DadosEmail ['Body'] = $msgCliente;
        $RESPOSTA = (Funcoes::EnviarEmail($DadosEmail, $phpmailer)) ? 1 : 0;
    }        
}

/*
 * -----------------------------------------------------------------------------------------
 * PERSISTIR NA BASE DE DADOS TABELA =volpato_novo : 
 * -----------------------------------------------------------------------------------------
 */
$ddd = getDDD($Dados['captacao_telefone1']);
$Dados['captacao_uf'] = buscaUF($ddd, $_GetUF);
$Dados['captacao_formulario'] = buscaFormulario($Dados['captacao_interesse']);

if (!empty($Dados['campanha']) && verificar_se_tem_capanha($Dados['campanha'])) {
    $Dados ['origem'] = $Dados['campanha'];
    unset($Dados['campanha']);
} else {
    unset($Dados['campanha']);
}
# VERIFICA O TIPO DA CAPTACAO (INTERESSE);
$nivelPermissao = $captacao->selectCaptacaoInteresseNivel($Dados['captacao_interesse'])['captacao_niveis_ra'];
$id_vendedor_com_captcao_registrada =  $captacao->get_captacao_por_telefone($Dados['captacao_telefone1']);

if(!empty($id_vendedor_com_captcao_registrada)){
	$Dados['captacao_id_usuario'] = $id_vendedor_com_captcao_registrada['captacao_id_usuario'];
	$dados_sms['captacao_telefone1'] = $Dados['captacao_telefone1'];
	$Dados['captacao_telefone1'] = str_replace(" ", "", str_replace("-", "", $Dados['captacao_telefone1']));
	
	$dados_sms['ultimo_id'] = $captacao->insert($Dados);
	
	$captacao->atualizarStatusCaptacao($menorIdUsuario, 'on');
	
	$Dados['vendedor'] = $usuario->selUsuario($Dados['captacao_id_usuario'])['nome'];
	
	gravar_log($Dados);

	if (!empty($dados_sms['ultimo_id'])) :
		//enviarSMS($dados_sms);
		enviar_email([
			'captacao_email'=>$Dados['captacao_email'],
			'captacao_cliente'=>['captacao_cliente']
		]); 
	else :
		die('Error ao cadastrar uma captacao');
	endif;

	header('location:../../../../index.php?pg=1&r=1');exit;

}else{
	$Dados['captacao_telefone1'] = str_replace(" ", "", str_replace("-", "", $Dados['captacao_telefone1']));
	$dados_sms['captacao_telefone1'] = $Dados['captacao_telefone1'];
	
	# BUSCA VENDEDOR :
	$menorIdUsuario = idUsuarioDisponivel($nivelPermissao, $ddd, $captacao);
	
	# VINCULAR VENDEDOR NA CAPTACAO :
	$Dados['captacao_id_usuario'] = ($menorIdUsuario != FALSE) ? $menorIdUsuario : 707;
	
	$dados_sms['ultimo_id'] = $captacao->insert($Dados);
	
	# ATUALIZAR STATUS_CAPTACAO DA TABELA VENDEDOR:
	$captacao->atualizarStatusCaptacao($menorIdUsuario, 'on');
	$Dados['vendedor'] = $usuario->selUsuario($Dados['captacao_id_usuario'])['nome'];

	gravar_log($Dados);

	if (!empty($dados_sms['ultimo_id'])) :
		//enviarSMS($dados_sms);
		enviar_email(['captacao_email'=>$Dados['captacao_email'],'captacao_cliente'=>['captacao_cliente']]); 
	else :
		die('Error ao cadastrar uma captacao');	
	endif;

	header('location:../../../../index.php?pg=1&r=1');exit;
}
