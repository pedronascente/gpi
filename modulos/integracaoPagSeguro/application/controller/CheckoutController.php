<?php
include_once "../model/PagSeguro.class.php";
include_once "../model/phpmailer/PHPMailer.class.php";
include_once "../configs/Configs_CheckoutController.php";

if(ITEMID1>=1){
    
    /*
    * -----------------------------------------------------------------
    *  Sandbox :
    * -----------------------------------------------------------------
    */
        //$url['sandbox'] = "https://ws.sandbox.pagseguro.uol.com.br/v2/checkout/";
        //$email['sandbox_email'] = 'eduardo@grupovolpato.com';
        //$token['sandbox_token'] = '9FCBA0E36FBC4632B3784035D1C743B7';
    /*
    * -----------------------------------------------------------------
    *  PagSeguro :
    * -----------------------------------------------------------------
    */
    $url['pagseguro'] = "https://ws.pagseguro.uol.com.br/v2/checkout/";
    $email['pagseguro_email'] = "volpato@grupovolpato.com";
    $token['pagseguro_token'] =   "0B656F51F2584D7C883F04DA5FF6193D";  
    
    //---------------------------------------------------------------------
    
    $data['email']= $email['pagseguro_email'] ;
    $data['token'] = $token['pagseguro_token'];
    $itemAmount1tOTAL = ITEMAMOUNT1TOTAL;
    $data['currency'] = CURRENCY;
    $data['reference'] = REFERENCE;
    $data['itemId1'] = ITEMID1;
    $data['itemDescription1'] = ITEMDESCRIPTION1;
    $data['itemAmount1'] = ITEMAMOUNT1;
    $data['itemQuantity1'] = ITEMQUANTITY1;
    $email_clinete = EMAIL_CLIENTE; 
    $cliente = CLIENTE;
    $nomeEmailResposta = "";
    $emailResposta = "";
    $emailRementente = "volpato@grupovolpato.com";
    $remetente = REMETENTE;
    $asssunto = ASSUNTO; 
    
    /*
    * -------------------------------------------------------------------------     
    * RETORNA O CODIGO DA COMPRA :
    * -------------------------------------------------------------------------
    */

    $pagSeguro = new PagSeguro();
    $xmlCode = $pagSeguro->getCodigoCompra($data,$url['pagseguro']);
    //$CODIGO_SANDBOX = "https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code={$xmlCode}";
    $CODIGO_PAGSEGURO = "https://pagseguro.uol.com.br/v2/checkout/payment.html?code={$xmlCode}";
    $CODIGO_DA_COMPRA =   $CODIGO_PAGSEGURO;

    /*
    * ----------------------------------------------------------------------
    * ENVIA UM EMAIL PRO CLIENTE EFETUAR O PAGAMENTO:
    * ----------------------------------------------------------------------
    */

    if($xmlCode){
        include_once "../views/_corpo_email.php";
        $email = new PHPMailer ();
        //Define que será usado SMTP.
        $email->IsSMTP(); 
        //Define os dados técnicos da Mensagem.
        $email->IsHTML(true);
        $email->CharSet = CHARSET; 
        // Configurações do SMTP:
        $email->SMTPAuth = SMTPAuth;
        //$email->SMTPSecure = 'ssl';
        $email->Host = HOST;
        $email->Port = PORT;
        //Usuário do servidor SMTP.
        $email->Username = USERNAME;
        //Senha do servidor SMTPmente
        $email->Password = PASSWORD;
        //Define a mensagem (Assunto).
        $email->Subject = $asssunto; 
        //Define remetente:
        $email->From = $emailRementente;
        $email->FromName = $remetente;
        //Para quando responder, não vá para o email de autenticação.
        $email->AddReplyTo($emailResposta, $nomeEmailResposta); 
        //Define 0(s) destinatarios:
        $email->AddAddress($email_clinete, $cliente);
        //Corpo da mensagem:
        $email->Body = $html;
        //corpo da mensagem em modo texto:
        $email->AltBody = $html;
        if (!$email->send()) {
	     die(var_dump($email->ErrorInfo));
        }else{
            die(json_encode(array(
                'type'=>'true'
            )));
        }
    }
}