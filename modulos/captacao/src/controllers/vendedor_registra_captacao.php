<?php
//namespace C:\wamp\www\gpi\modulos\captacao\src\controllers\vendedor_registra_captacao.php
include_once("../../../../Config.inc.php");
$EMAIL=isset($_GET['email'])?$_GET['email']:NULL;
$captacao= new Captacao;
if($EMAIL){   
    $cliente=$captacao->getByEmail($EMAIL);
    $verificar_cliente=count($cliente);  
    if($verificar_cliente>=1){
        $return_json=$cliente;
    }else{
        $return_json=false;
    }
    die(json_encode(['captacao'=>$return_json]));  
}else{
    date_default_timezone_set('America/Sao_Paulo');
    $Dados=filter_input_array(INPUT_POST);
    $acao=$Dados['acao'];
    unset($Dados['acao']);
   
    if($acao=="new"){
        $get_uf = new GetUF();
        $Dados['captacao_data_criacao'] = date('Y-m-d H:i:s');
        $ddd = substr($Dados['captacao_telefone1'], 1, 2); //PEGAR O DDD DO TELEFONE :
        $Dados['captacao_uf'] = ($get_uf->_getUF($ddd)) ? $get_uf->_getUF($ddd) :'DESCONHECIDO';
        
        unset($Dados['captacao_id']);
        $captacao->insert($Dados);
        $ultimo_id=$captacao->Create()->getResult();
    }else if($acao=="update"){
        unset($Dados['origem'],$Dados['captacao_indicador']);
        $captacao->updateCaptacao($Dados);
    }
    header('location:../../../../index.php?pg=18#tabs-1');  
}