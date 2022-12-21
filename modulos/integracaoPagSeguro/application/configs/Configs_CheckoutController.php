<?php
define("ITEMID1",  isset($_POST['itemId1']));
define("ITEMAMOUNT1",str_replace(',','.',str_replace('.', '',str_replace('R$ ', '', $_POST["itemAmount1"]))));
define("ITEMQUANTITY1",$_POST["itemQuantity1"]);
define("ITEMDESCRIPTION1",utf8_decode($_POST["itemDescription1"]));
    $itemAmount1tOTAL = (str_replace(',','.',str_replace('.', '',str_replace('R$ ', '', $_POST["itemAmount1"]))) * $_POST["itemQuantity1"] );
define("ITEMAMOUNT1TOTAL",$itemAmount1tOTAL);
define("CURRENCY","BRL");
define("REFERENCE",$_POST["reference"]);
define("EMAIL_CLIENTE",$_POST["email_cliente"]);
define("CLIENTE", ucfirst($_POST["cliente"]));
define("REMETENTE","VOLPATO");
define("ASSUNTO","Solicitacao de Pagamento");

/*
 *------------------------------------------------------------------------------
 * VARIAVEIS DE EMAIL :
 *------------------------------------------------------------------------------
 */
 /*
define("CHARSET", "UTF-8");//"iso-8859-1"
define("SMTPAuth", true);
define("HOST", "smtp.revendavolpato.com");
define("PORT", 587);
define("USERNAME", "revendavolpato@revendavolpato.com");//Usuário do servidor SMTP.
define("PASSWORD", "admin@cairu");//Usuário do servidor SMTP.
 */
 
 

define("CHARSET", "UTF-8");//"iso-8859-1"
define("SMTPAuth", true);
define("HOST", "smtp.rastreadorvolpato.com");
define("PORT", 587);
define("USERNAME", "rastreadorvolpato@rastreadorvolpato.com");//Usuário do servidor SMTP.
define("PASSWORD", "33jps665");//Usuário do servidor SMTP.