<?php
include_once ("../../../../Config.inc.php");

$obj_upc = new  UsuariosPlanilhaComissao();

if($_POST['acao']=='getEmpresa'){
  
    $nome ="'". $_POST['nome']."'";
    
    $ArrayListEmpresa = $obj_upc->getEmpresa($nome);
    
    die(json_encode($ArrayListEmpresa));
    
}