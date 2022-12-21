<?php

header('Content-Type: text/html; charset=utf-8');
include_once ('../../../../Config.inc.php');

$dados_post = explode('_', $_POST['valores']);

$empresa = new Empresa();
$objetopcf = new PedidoComissaoFuncionario;


$id_empresa = Funcoes::removerCodigoMalicioso($dados_post[0]);
$id = Funcoes::removerCodigoMalicioso($dados_post[1]);

$sel_empresa = $empresa->selecionarEmpresaById($id_empresa);  

$erererer = $objetopcf->atualizarEmpresa([
      'pcf_empresa' => $sel_empresa['nome_empresa'],
      'id' => $id
]);

// OBJETO USUARIO
die(json_encode(array(
'type' => 'success'
)));

