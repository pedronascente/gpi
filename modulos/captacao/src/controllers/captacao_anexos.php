<?php
header('Content-Type: text/html; charset=utf-8');
include_once ("../../../../Config.inc.php");

@session_start();
$Dados = filter_input_array(INPUT_POST);
$error = null;

if (!empty($Dados) && isset($Dados) && isset($_FILES)) : 
    //$Dados['id_contrato'] = isset($Dados['id_contrato']) ? $Dados['id_contrato'] :0;     
    $arquivo = $_FILES ["anexos"];
    $acao = $Dados ['acao'];
    $Dados['tipo_doc'] = strtoupper($Dados ['tipo_doc']);
    $id_cliente_contrato = !empty($Dados ['id']) ? $Dados ['id'] : '';
    unset($Dados ['acao'], $Dados['id']);
endif;

$Dados['tipo_pessoa'] = isset($Dados['tipo_pessoa']) ? $Dados['tipo_pessoa'] : 1;

if ($acao == "InsertArquivos"){
    $tipo_doc = $id_cliente_contrato . '/' . $Dados ['tipo_doc'] . "_{$Dados['tipo_pessoa']}/";
    $caminho = $arquivo ['tmp_name'];
    $_UP ['extensoes'] = array( "jpg", "jpeg","pdf","doc",  "docx","png" );
    if($arquivo ['error'] !== 0) {
        switch ($arquivo ['error']) :
            case '2' : $error = 2;  break;
            case '3' : $error = 3;  break;
            case '4' : $error = 4;  break;
            case '5' : $error = 5;  break;
        endswitch ;
    }
    $extensao = strtolower(pathinfo($arquivo ["name"], PATHINFO_EXTENSION)); 
    if (in_array($extensao, $_UP ['extensoes'])) {
        if(($Dados['tipo_doc'] == ('TABELA_FIPE')) OR 
            ($Dados['tipo_doc'] == ('NOTA_FISCAL')) OR 
            ($Dados['tipo_doc'] == ('CRLV_DOCUMENTO_PROVISORIO')) OR 
            ($Dados['tipo_doc'] == ('CRLV'))) {
            $nome_arquivo_renomeado =  date("d-m-Y").'-'.$Dados ['tipo_doc'] . '_'  . md5(date("d/m/Y H :i:s")) . "." . $extensao;
        }else {
             $nome_arquivo_renomeado = date("d-m-Y").'-'.$Dados ['tipo_doc'] . '_' .  md5(date("d/m/Y H :i:s")) . "." . $extensao;
        }
		//var_dump($nome_arquivo_renomeado);die;
        $Dados['nome_anexo'] = $tipo_doc . $nome_arquivo_renomeado;
        $Dados ['id_cliente'] = $id_cliente_contrato;
    } else {
         $error = 1;
    }
    if(!empty($nome_arquivo_renomeado) && $error == 0){
        $destino =  _DESTINO_MIDIAS_ . $tipo_doc;
        if (!file_exists($destino)) {
           mkdir($destino, 0777, true);
        }
       if(Funcoes::UploadArquivos($caminho, $nome_arquivo_renomeado, $destino)){
            if (file_exists($destino . $nome_arquivo_renomeado)) {
                     $anexos = new Anexos;
                     $Dados['id_contrato'] = $Dados['id_cliente'];
                     $anexos->insert($Dados);
            }else{
            }
        }else{
        }
    }
    header("Location:../../../../index.php?pg=33&id={$id_cliente_contrato}&error={$error}&id_cliente_contrato={$id_cliente_contrato}#anexos");
} else {
    $error = 1;
    header("Location:../../../../index.php?pg=32&id={$id_cliente_contrato}&error={$error}&id_cliente_contrato={$id_cliente_contrato}#anexos");
}