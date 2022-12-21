<?php
header('Content-Type: text/html; charset=utf-8');
include_once ("../../../../Config.inc.php");

@session_start();
$Dados = filter_input_array(INPUT_POST);

XDbug(array('_mensagem'=>'0)XDbug:: Objetivo : Aneaxar documento de cliente no Contrato.', '_expressao'=>'',));
$error = null;

if (!empty($Dados) && isset($Dados) && isset($_FILES)) : 
    $Dados['id_contrato'] = isset($Dados['id_contrato']) ? $Dados['id_contrato'] :0;     
    XDbug(array('_mensagem'=>'1)XDbug:: Dados de Entrada (POST):', '_expressao'=>$Dados,));     
    $arquivo = $_FILES ["anexos"];
    XDbug(array('_mensagem'=>'2)XDbug:: Dados de Entrada (FILES): ', '_expressao'=>$arquivo,));       
    $acao = $Dados ['acao'];
    XDbug(array('_mensagem'=>'3)XDbug:: Verificar o tipo de acao :', '_expressao'=>$acao,)); 
    $Dados['tipo_doc'] = strtoupper($Dados ['tipo_doc']);
    XDbug(array('_mensagem'=>'4)XDbug:: Converter dados do campo (tipo_doc) para MAIUSCULAS : ', '_expressao'=>array('tipo_doc'=>$Dados['tipo_doc'])));   
    $id_cliente_contrato = !empty($Dados ['id']) ? $Dados ['id'] : '';
    XDbug(array('_mensagem'=>'5)XDbug:: Recuperar id do cliente :', '_expressao'=>$id_cliente_contrato,));  
    unset($Dados ['acao'], $Dados['id']);
endif;

XDbug(array('_mensagem'=>'6)XDbug:: (Delete) Excluir campos (acao,id) do array de entrada:', '_expressao'=>$Dados,));    
$Dados['tipo_pessoa'] = isset($Dados['tipo_pessoa']) ? $Dados['tipo_pessoa'] : 1;
XDbug(array('_mensagem'=>'7)XDbug:: Recuperar tipo de pessoa :', '_expressao'=>$Dados['tipo_pessoa'],));

if ($acao == 'InsertArquivos'){
    XDbug(array('_mensagem'=>'8)XDbug:: Se acao for igual á (InsertArquivos):', '_expressao'=>true,));   
    $tipo_doc = $id_cliente_contrato . '/' . $Dados ['tipo_doc'] . "_{$Dados['tipo_pessoa']}/";
    XDbug(array('_mensagem'=>'9)XDbug:: Renomear o $tipo_doc :"    ', '_expressao'=>$tipo_doc,));       
    $caminho = $arquivo ['tmp_name'];
    XDbug(array('_mensagem'=>'10)XDbug:: Caminho temporario do arquivo  : ', '_expressao'=>$caminho,));       
    $_UP ['extensoes'] = array( "jpg", "jpeg","pdf","doc",  "docx","png" );
    XDbug(array('_mensagem'=>'11)XDbug:: Criar array com extenssoes permitidas :', '_expressao'=>$_UP,));
    if($arquivo ['error'] !== 0) {
        switch ($arquivo ['error']) :
            case '2' : $error = 2;  break;
            case '3' : $error = 3;  break;
            case '4' : $error = 4;  break;
            case '5' : $error = 5;  break;
        endswitch ;
    }
    XDbug(array('_mensagem'=>'12)XDbug::  Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro : ', '_expressao'=>$error,));
    $extensao = strtolower(pathinfo($arquivo ["name"], PATHINFO_EXTENSION)); 
    XDbug(array('_mensagem'=>'13)XDbug:: Pega a extessao  do arquivo:  ', '_expressao'=>$extensao,));
    if (in_array($extensao, $_UP ['extensoes'])) {
        XDbug(array('_mensagem'=>'14)XDbug:: verifica se extenssao é valida ', '_expressao'=>true,));
        if(($Dados['tipo_doc'] == ('TABELA_FIPE')) OR 
            ($Dados['tipo_doc'] == ('NOTA_FISCAL')) OR 
            ($Dados['tipo_doc'] == ('CRLV_DOCUMENTO_PROVISORIO')) OR 
            ($Dados['tipo_doc'] == ('CRLV'))) {
            $nome_arquivo_renomeado = $Dados ['tipo_doc'] . '_' . $nome_arquivo . "_" . date("Ymd") . "_" . date("His") . "." . $extensao;
            XDbug(array('_mensagem'=>'15) XDbug:: SE $Dados[tipo_doc]== TABELA_FIPE,NOTA_FISCAL,CRLV_DOCUMENTO_PROVISORIO,CRLV', '_expressao'=>$nome_arquivo_renomeado,));
        }else {
            $nome_arquivo_renomeado = $Dados ['tipo_doc'] . '_' . $Dados ['cliente_ra'] . "_" . date("Ymd") . "_" . date("His") . "." . $extensao;
            XDbug(array('_mensagem'=>'16)XDbug::  SE campo (tipo_doc) != de  (TABELA_FIPE, NOTA_FISCAL, CRLV_DOCUMENTO_PROVISORIO, CRLV) :', '_expressao'=>$nome_arquivo_renomeado,));
        }
        $Dados['nome_anexo'] = $tipo_doc . $nome_arquivo_renomeado;
        XDbug(array('_mensagem'=>'17)XDbug:: Campo (nome_anexo) recebe os valores concatenados  dos campos ($tipo_doc,$nome_arquivo_renomeado) : ', '_expressao'=>$Dados ['nome_anexo'],)); 
        $Dados ['id_cliente'] = $id_cliente_contrato;
        XDbug(array('_mensagem'=>'18)XDbug::  $Dados [id_cliente] = $id_cliente_contrato: ', '_expressao'=>array('id_cliente'=>$Dados ['id_cliente']),));     
    } else {
         $error = 1;
         XDbug(array('_mensagem'=>'19)XDbug:: Error : ', '_expressao'=>$error,'_die'=>true)); 
    }
    if(!empty($nome_arquivo_renomeado) && $error == 0){
        XDbug(array('_mensagem'=>'20)XDbug:: Se o arquivo foi renomeado , e nao contem erro na aplicacao :  ', '_expressao'=>true,));
        //___ANEXOS
        $destino =  "../../../../../_MIDIAS_/anexosContrato/clientes/" . $tipo_doc;
        
        XDbug(array('_mensagem'=>'21)XDbug:: Informa o destino do arquivo :', '_expressao'=>$destino,));
        if (!file_exists($destino)) {
        XDbug(array('_mensagem'=>'22)XDbug:: Verifica se existe pastas dos arquivos : ', '_expressao'=>false));     
           mkdir($destino, 0777, true);
           XDbug(array('_mensagem'=>'23)XDbug:: Criar pastas  : ', '_expressao'=>$destino));     
        }
       if(Funcoes::UploadArquivos($caminho, $nome_arquivo_renomeado, $destino)){
       XDbug(array('_mensagem'=>'24)XDbug:: Upload do Arquivo  : ', '_expressao'=>true,));   
            if (file_exists($destino . $nome_arquivo_renomeado)) {
                     $anexos = new Anexos;
                     $anexos->insert($Dados);
                     XDbug(array('_mensagem'=>'28)XDbug:: (INSERT) tabela anexos :', '_expressao'=>$anexos ,));
            }else{
              XDbug(array('_mensagem'=>'31)XDbug:: Error :', '_expressao'=>"Não foi possível enviar o arquivo, tente novamente",'_die'=>true));
            }
        }else{
            XDbug(array('_mensagem'=>'32)XDbug:: Error : ', '_expressao'=>"Nao foi possivel realizar",'_die'=>true));
        }
    }
    XDbug(array('_mensagem'=>'33)XDbug::Success !  ', '_expressao'=>true,'_die'=>true));
    header("Location:../../../../index.php?pg=32&id={$id_cliente_contrato}&error={$error}&id_cliente_contrato={$id_cliente_contrato}#anexos");
} else {
    $error = 1;
    header("Location:../../../../index.php?pg=32&id={$id_cliente_contrato}&error={$error}&id_cliente_contrato={$id_cliente_contrato}#anexos");
}

function XDbug($array){
    $_mensagem = $array['_mensagem'];
    $_expressao = $array['_expressao'];
    $_die = isset($array['_die'])?$array['_die']: null;
    
    echo"<h4>{$_mensagem}</h4>";
        var_dump($_expressao);
    echo'<hr>';
    if($_die===true){
        die;
    }
}