<?php
header('Content-Type: text/html; charset=utf-8');
include_once ("../../../../Config.inc.php");
@session_start();
$Dados = filter_input_array(INPUT_POST);
if (!empty($Dados) && isset($Dados)) :
    $acao = $Dados ['acao'];
    $id = !empty($Dados ['cliente_ra']) ? $Dados ['cliente_ra'] : '';
    $id_cliente_contrato = !empty($Dados ['id']) ? $Dados ['id'] : '';
    unset($Dados ['acao'], $Dados ['id']);
endif;
$Dados['tipo_pessoa'] = isset($Dados['tipo_pessoa']) ? $Dados['tipo_pessoa'] : 1;
$captacao = new Captacao();
$contrato = new contratos();
$anexos = new Anexos();
//RESPONSAVEL POR ANEXAR ARQUIVOS :
if ($acao == 'InsertArquivos') {
    $Dados ['tipo_doc'] = strtoupper($Dados ['tipo_doc']);
    $tipo_doc = $id_cliente_contrato . '/' . $Dados ['tipo_doc'] . "_{$Dados['tipo_pessoa']}/";
    $arquivo = $_FILES ["anexos"];
    $caminho = $arquivo ['tmp_name'];
    $error = null;
    $_UP = array();
    $_UP ['extensoes'] = array(
        "jpg",
        "jpeg",
        "pdf",
        "doc",
        "docx",
        "png"
    );
    $_IMG['extensoes'] = array(
        "jpg",
        "jpeg",
    );
    // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro:
    if ($arquivo ['error'] !== 0) {
        switch ($arquivo ['error']) :
            case '2' :    $error = 2;    break;
            case '3' :   $error = 3;   break;
            case '4' :      $error = 4;   break;
            case '5' :      $error = 5;     break;
        endswitch
        ;
    }
    $extensao = strtolower(pathinfo($arquivo ["name"], PATHINFO_EXTENSION)); 
    if (in_array($extensao, $_UP ['extensoes'])) {
        //$nome_arquivo = md5(uniqid(time()));
        $nome_arquivo = $Dados ['nome_anexo'];
        $nome_arquivo_renomeado = $Dados ['tipo_doc'] . "_" . $nome_arquivo . "." . $extensao;
        $Dados ['nome_anexo'] = $tipo_doc . $nome_arquivo_renomeado;
        $Dados ['id_cliente'] = $id_cliente_contrato;
    } else {
        $error = 1;
    }
    if (!empty($nome_arquivo_renomeado) && $error == 0) {
        $destino = "../../../../../_MIDIAS_\/anexosContrato/clientes/" . $tipo_doc;
        if (!file_exists($destino)) {
            mkdir($destino, 0777, true);
        }
        Funcoes::UploadArquivos($caminho, $nome_arquivo_renomeado, $destino);
        if (file_exists($destino . $nome_arquivo_renomeado)) {
            if (empty($Dados ['id_contrato'])){
                $Dados ['id_contrato'] = '0';
                $anexos->insert($Dados);
            } else {
                $anexos->insert($Dados);
                $error = 6;
            }
        } else {
            die("Não foi possível enviar o arquivo, tente novamente");
        }
    }
    header("Location:../../../../index.php?pg=32&id={$id}&error={$error}&id_cliente_contrato={$id_cliente_contrato}#anexos");
} else {
    $error = 1;
    header("Location:../../../../index.php?pg=32&id={$id}&error={$error}&id_cliente_contrato={$id_cliente_contrato}#anexos");
}