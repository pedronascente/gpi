<?php
/*
 *---------------------------------------------------------------------------------------------
 * Verifica variaveis de entradas do pagseguro :
 *--------------------------------------------------------------------------------------------- 
 */
if(count($_POST) >0){
    $notificationType =  $_POST['notificationType'];
    $notificationCode =  'B62D41-4FF5F4F5F40B-82248FFFB4E9-610341' ; //$_POST['notificationCode']; 
}else{
    $notificationType = null;
    $notificationCode = null;
}
/*
 *---------------------------------------------------------------------------------------------
 * Verifica variaveis de autenticação do pagseguro :
 *--------------------------------------------------------------------------------------------- 
 */
$pagseguro_email = "volpato@grupovolpato.com";
$pagseguro_token = "0B656F51F2584D7C883F04DA5FF6193D"; 
/*
 *---------------------------------------------------------------------------------------------
 * Envia a consulta para o site pagseguro que irá retornar uma pagina  xml, onde será 
 * transformada em objeto para realizar as consultas DO log :
 *--------------------------------------------------------------------------------------------- 
 */

 $pagSeguro = new PagSeguro();
 
 $url = "https://ws.pagseguro.uol.com.br/v2/transactions/notifications/" . $notificationCode  . "?email=" . $pagseguro_email . "&token=" . $pagseguro_token;
 $transaction = $pagSeguro->getCurl($url);
 
 /*
 *---------------------------------------------------------------------------------------------
 * Caso não ouver registro duplicado . Persistir na base : 
 *--------------------------------------------------------------------------------------------- 
 */
 
 $duplicidade = $pagSeguro->getDuplicidade($transaction->code,$transaction->status);
 if(!$duplicidade){
    $pagSeguro->insertLog($transaction) ;
    $retorno = 'true';
 } else{
     $retorno = 'false';
 }
   

die(
    json_encode(
      array(
           'type'=>$retorno
      )     
    )
 );