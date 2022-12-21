<?php
//mamespace C:\wamp\www\gpi\modulos\captacao\src\controllers\captacaoComplemento.php
$_array_captacao_interesse = array("5", "6");

if(!in_array($Dados['captacao_interesse'],$_array_captacao_interesse)){
   $Dados['captacao_formulario']  = 'formulario_a';
}

# VERIFICA A ORIGEM DA CAPTACAO :
if ($Dados ['origem'] !== 'monitoramento') {
    $origem = $Dados ['origem'];
    $Dados ['id_usuario'] =0;
} else {
    $Dados ['origem'] = "monitoramento";
    $Dados ['id_usuario'] = @$_SESSION['user_info']['id_usuario'];
}

# BUSCA TIPO DE CAPTACAO :(1 , 2 , 3, 4, 5 , ...)
$nivelPermissao = $captacao->selectCaptacaoInteresseNivel($Dados ['captacao_interesse']);
$nivelPermissao = !empty($nivelPermissao['captacao_niveis_ra']) ? $nivelPermissao['captacao_niveis_ra'] : "";

# BUSCA O MENOR ID DISPONIVEL :
$menorIdUsuario = idUsuarioDisponivel($nivelPermissao, $ddd);

if($menorIdUsuario){
    $captacao->atualizarStatusCaptacao($menorIdUsuario,'on');  
}else{
     $usuario_com_status_captacao_off = $captacao->buscarRegraUsuario000($nivelPermissao, 'on');
     foreach ($usuario_com_status_captacao_off as $usuario){
        switch ($usuario['captacao_niveis_regras_operacao']):
           case '51': $captacao->atualizarStatusCaptacao($usuario['id'],'off');      break;
           case '2_51_55':  $captacao->atualizarStatusCaptacao($usuario['id'],'off');   break;
           case '2_41_55': $captacao->atualizarStatusCaptacao($usuario['id'],'off');      break;
           case '2_41_49': $captacao->atualizarStatusCaptacao($usuario['id'],'off');      break;
           case '1_51_55':  $captacao->atualizarStatusCaptacao($usuario['id'],'off');    break;
           case '1_41_55':  $captacao->atualizarStatusCaptacao($usuario['id'],'off');    break;   
       endswitch;
     }
     $menorIdUsuario = idUsuarioDisponivel($nivelPermissao, $ddd);
}

if($menorIdUsuario== false){
    $menorIdUsuario = 707;
}

# ATRIBUIR O MENOR ID DISPONIVEL NA CAPTACAO :
$Dados['captacao_id_usuario'] =  isset($menorIdUsuario['id'])?$menorIdUsuario['id']:$menorIdUsuario;

# Gravar Log :
if ($Dados) {
    
	$usuario = @$usuario->selUsuario($Dados ['captacao_id_usuario']);
	
	//var_dump($usuario); die;
	
    $nome_usuario = $usuario['nome'];
    Logger($Dados, $nome_usuario);
}

$captacao->insert($Dados);

//RESPONSAVEL POR DISTRIBUIR AS CAPTACOES DE ACORDO COM AS REGRAS IMPOSTAS PELO SISTEMA :
function idUsuarioDisponivel($nivelPermissao, $ddd) {
    $verifica = FALSE;
    $captacao = new Captacao;
    # BUSCA ID :
    $usuario_com_status_captacao_off = $captacao->selectMenorIdUsuarioTableUsuario($nivelPermissao, 'off',$ddd);
    if (empty($usuario_com_status_captacao_off)) {
        $usuario_com_status_captacao_on = $captacao->selectMenorIdUsuarioTableUsuario($nivelPermissao, 'on',$ddd);
        foreach ($usuario_com_status_captacao_on as $id_usuario) {
            $captacao->atualizarStatusCaptacao($id_usuario['id'], 'off');
        }
        $usuario_com_status_captacao_off = $captacao->selectMenorIdUsuarioTableUsuario($nivelPermissao, 'off',$ddd);
    }
    
    if ($usuario_com_status_captacao_off) {
      //$id_usuario = 707;//VENDEDOR - AUXILIAR.
       foreach ($usuario_com_status_captacao_off as $result) {
            $regras = $captacao->buscarRegraUsuario($result['id']);
            if (!empty($regras)) {
                foreach ($regras as $regra) {
                    //Verifica as regras de relção
                    if ($regra['captacao_niveis_regras_nivel'] == 2 || $regra['captacao_niveis_regras_nivel'] == 1 && $regra['captacao_niveis_regras_operacao']!='51') {
                        $r = explode("_", $regra ['captacao_niveis_regras_operacao']);
                        $r [0] = (int) $r [0];
                        $r [1] = (int) $r [1];
                        $r [2] = (int) $r [2];
                        // diferente :
                        if ($r [0] == 1) {
                            if ($ddd < $r [1] || $ddd > $r [2]) {
                                $verifica = true;
                                break;
                            }
                            // entre :    
                        } else {
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
    }
    //Verifica se o usuário pode receber essa captação
    if ($verifica) {
        $id_usuario = $result['id'];
    }else{
        $id_usuario =  false;  //$id_usuario = 707;//VENDEDOR - AUXILIAR.
    }
    
     return $id_usuario;
    
 }

//RESPONSAVEL POR CRIAR UM lOG DAS CAPTACOES :
function Logger($Dados, $nome_usuario) {
    date_default_timezone_set('America/Sao_Paulo');
    $data = date("d-m-y");
    $hora = date("H:i:s"); 
    //Nome do arquivo: 
    $arquivo = "log_insert_captacao_$data.txt";
    $msg = "ID :".$Dados['captacao_id_usuario'].",VENDEDOR:".$nome_usuario.",INTERESSE:".$Dados['captacao_interesse'].',CLIENTE:'.$Dados['captacao_cliente'].",TELEFONE:".$Dados['captacao_telefone1'].",EMAIL:".$Dados['captacao_email'].",ORIGEM:".$Dados['origem'].",INDICADOR:".$Dados['captacao_indicador'];
    //Texto a ser impresso no log: 
    $texto = "[$data] [$hora] $msg \n";
    $manipular = fopen("$arquivo", "a+b");
    fwrite($manipular, $texto);
    fclose($manipular);
}