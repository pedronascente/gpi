<?php
include_once ('../../../../Config.inc.php');

@session_start();

$DadosForm = filter_input_array(INPUT_POST) != null ? filter_input_array(INPUT_POST) : filter_input_array(INPUT_GET);

$acao = isset($DadosForm ['acao']) ? $DadosForm ['acao'] : null;

unset($DadosForm['acao']);

$arquivos = new Arquivo();
$veiculo = new Veiculos();
$cliente = new Clientes();

switch ($acao) {
    case "cadastrarCliente": 
        $id = null;    
        $DadosForm['email_cliente'] = !empty($DadosForm['email_cliente']) ? $DadosForm['email_cliente'] : '';
        $DadosForm['logradouro_cliente'] = !empty($DadosForm['logradouro_cliente']) ? $DadosForm['logradouro_cliente'] : '';
        $DadosForm['bairro_cliente'] = !empty($DadosForm['bairro_cliente']) ? $DadosForm['bairro_cliente'] : '';
        $DadosForm['cidade_cliente'] = !empty($DadosForm['cidade_cliente']) ? $DadosForm['cidade_cliente'] : '';
        $DadosForm['uf_cliente'] = !empty($DadosForm['uf_cliente']) ? $DadosForm['uf_cliente'] : '';
        $DadosForm['cep_cliente'] = !empty($DadosForm['cep_cliente']) ? $DadosForm['cep_cliente'] : '';
        $DadosForm['data_pagamento'] = !empty($DadosForm['data_pagamento']) ? $DadosForm['data_pagamento'] : '';
		$DadosForm['forma_pagamento'] = !empty($DadosForm['forma_pagamento']) ? $DadosForm['forma_pagamento'] : '';
        $result = $cliente->insert("clientes", $DadosForm);
       
        if (!empty($result)) {
            $id = $arquivos->insertArquivo(array("arquivo_cliente" => $result));
            $log['arquivo_log_motivo'] = "Cadastro Cliente";
            $log['arquivo_log_obs'] = "CPF/CNPJ: " . $DadosForm['arquivo_clientes_cpfcnpj'];
            $log['arquivo_log_supervisor'] = $_SESSION['user_info']['id_usuario'];
            $log['arquivo_log_data'] = date("Y-m-d H:i:s");
            $log['arquivo_log_tipo'] = 1;
            $log['arquivo_log_arquivo'] = $id;
            $arquivos->insertArquivoLog($log);
        }
        header("Location: ../../../../index.php?pg=24&id=" . $id."#cadastro");
    break;

    case "editarCliente":
         
        $DadosForm['cnpjcpf_cliente'] = !empty($DadosForm['cnpjcpf_cliente']) ? $DadosForm['cnpjcpf_cliente'] : '';
        $DadosForm['nome_cliente'] = !empty($DadosForm['nome_cliente']) ? $DadosForm['nome_cliente'] : '';
        $DadosForm['id_cliente'] = !empty($DadosForm['id_cliente']) ? $DadosForm['id_cliente'] : '';
        $result = $cliente->updateCliente("clientes", $DadosForm);

        /*
        echo '<pre>';
        var_dump($result);
        print_r($DadosForm);
        echo '</pre>';
        die();
        */

       header("Location: ../../../../index.php?pg=24#lista");
    break;



    case "cadastrarPlaca":
        $tela = $DadosForm['acaoAtual'];
        $id = $DadosForm['arquivo_id'];
        unset($DadosForm['acaoAtual'], $DadosForm['arquivo_id']);

        $verifica = 1; 

        $arquivos->verificaPlaca($DadosForm['placa']);

        if($arquivos->Read()->getRowCount() == 0){

           if(empty($id)){
              $id = $arquivos->insertArquivo(array("arquivo_cliente" => $DadosForm['cliente_ra']));
          }

          $result = $veiculo->insert($DadosForm);
          if (!empty($result)) {
           $log['arquivo_log_motivo'] = "Cadastro Placa";
           $log['arquivo_log_obs'] = "Placa: " . $DadosForm['placa'];
           $log['arquivo_log_supervisor'] = $_SESSION['user_info']['id_usuario'];
           $log['arquivo_log_data'] = date("Y-m-d H:i:s");
           $log['arquivo_log_tipo'] = 1;
           $log['arquivo_log_arquivo'] = $id;
           $arquivos->insertArquivoLog($log);
       }
       $verifica = 0;
    }
    die(
        json_encode(
            array("type"=>$verifica, "id"=>$id, "placa"=>$DadosForm['placa']
            )
        )
    );
break;

case "insertArquivo":

$armario = explode("_", $DadosForm['arquivo_arquivo']);
$gaveta = explode("_", $DadosForm['arquivo_gaveta']);

unset($DadosForm['arquivo_arquivo']);

$DadosForm['arquivo_gaveta'] = preg_replace("/[^0-9]/", "", $gaveta[0]);

if(empty($DadosForm['arquivo_id'])){

    unset($DadosForm['arquivo_id']);

    $result = $arquivos->insertArquivo($DadosForm);
}
else{
   $result = $arquivos->updateArquivo($DadosForm);
}

$DadosForm['arquivo_id'] = empty($DadosForm['arquivo_id']) ? $result : $DadosForm['arquivo_id'];

if (!empty($result)) {

    $log[0]['arquivo_log_motivo'] = "Cadastro armário";
    $log[0]['arquivo_log_obs'] = "Armario: " . $armario[1];
    $log[0]['arquivo_log_supervisor'] = $_SESSION['user_info']['id_usuario'];
    $log[0]['arquivo_log_data'] = date("Y-m-d H:i:s");
    $log[0]['arquivo_log_tipo'] = 1;
    $log[0]['arquivo_log_arquivo'] = $DadosForm['arquivo_id'];

    $log[1]['arquivo_log_motivo'] = "Cadastro gaveta";
    $log[1]['arquivo_log_obs'] = "Gaveta: " . $gaveta[1];
    $log[1]['arquivo_log_supervisor'] = $_SESSION['user_info']['id_usuario'];
    $log[1]['arquivo_log_data'] = date("Y-m-d H:i:s");
    $log[1]['arquivo_log_tipo'] = 1;
    $log[1]['arquivo_log_arquivo'] = $DadosForm['arquivo_id'];

    $log[2]['arquivo_log_motivo'] = "Cadastro pasta";
    $log[2]['arquivo_log_obs'] = "Pasta: " . $DadosForm['arquivo_pasta'];
    $log[2]['arquivo_log_supervisor'] = $_SESSION['user_info']['id_usuario'];
    $log[2]['arquivo_log_data'] = date("Y-m-d H:i:s");
    $log[2]['arquivo_log_tipo'] = 1;
    $log[2]['arquivo_log_arquivo'] = $DadosForm['arquivo_id'];

    if (!empty($log)) {
       foreach ($log as $l)
          $arquivos->insertArquivoLog($l);
  }

}

header("Location: ../../../../index.php?pg=24");
break;

case "verificarCPFCNPJ":
$cliente =  $arquivos->verificarCPFCNPJ($DadosForm['cpf_cnpj']);
$total = $arquivos->Read()->getRowCount();
$cliente['arquivo_id'] = !empty($cliente['arquivo_id']) ? $cliente['arquivo_id'] : 0;
$veiculos = null;
if($total>=1)
  $veiculos = $veiculo->selectVeiculosPorCliente($cliente['id_cliente'], null, null, true);

die(json_encode(array("count"=>$total, "cliente"=>$cliente, "veiculos"=>$veiculos)));
break;

case "deletarPlaca":

$result = $veiculo->verificaVeiculoContrato($DadosForm['id']);

if($result < 1){

    $veiculo->deleteVeiculo($DadosForm['id']);

    $log['arquivo_log_motivo'] = "Placa deletada";
    $log['arquivo_log_obs'] = "Placa: " . $DadosForm['desc'];
    $log['arquivo_log_supervisor'] = $_SESSION['user_info']['id_usuario'];
    $log['arquivo_log_data'] = date("Y-m-d H:i:s");
    $log['arquivo_log_tipo'] = 1;
    $log['arquivo_log_arquivo'] = $DadosForm['id_arquivo'];

    $arquivos->insertArquivoLog($log);
}

die(json_encode(array("type"=>$result)));
break;

case "editar":
$arquivo = $arquivos->limparArray($arquivos->select(null, array("filtro" => "id_arquivo", "texto" => $DadosForm['arquivo_id'])));

$armario = explode("_", $DadosForm['arquivo_arquivo']);
$gaveta = explode("_", $DadosForm['arquivo_gaveta']);
$DadosForm['arquivo_gaveta'] = $gaveta[0];

$log = null;
//Se forem alterados os dados cadastra no log

if($arquivo['arquivo_armario_id'] == ""){
   $log[0]['arquivo_log_motivo'] = "Cadastro armário";
   $log[0]['arquivo_log_obs'] = "Armario: " . $armario[1];
   $log[0]['arquivo_log_supervisor'] = $_SESSION['user_info']['id_usuario'];
   $log[0]['arquivo_log_data'] = date("Y-m-d H:i:s");
   $log[0]['arquivo_log_tipo'] = 1;
   $log[0]['arquivo_log_arquivo'] = $DadosForm['arquivo_id'];

} else if ($arquivo['arquivo_armario_id'] != $armario[0]) {
    $log[0]['arquivo_log_motivo'] = "Alteração armário";
    $log[0]['arquivo_log_obs'] = "Armário: " . $armario[1];
    $log[0]['arquivo_log_supervisor'] = $_SESSION['user_info']['id_usuario'];
    $log[0]['arquivo_log_data'] = date("Y-m-d H:i:s");
    $log[0]['arquivo_log_tipo'] = 1;
    $log[0]['arquivo_log_arquivo'] = $DadosForm['arquivo_id'];
}


if($arquivo['arquivo_gaveta'] == ""){
 $log[1]['arquivo_log_motivo'] = "Cadastro gaveta";
 $log[1]['arquivo_log_obs'] = "Gaveta: " . $gaveta[1];
 $log[1]['arquivo_log_supervisor'] = $_SESSION['user_info']['id_usuario'];
 $log[1]['arquivo_log_data'] = date("Y-m-d H:i:s");
 $log[1]['arquivo_log_tipo'] = 1;
 $log[1]['arquivo_log_arquivo'] = $DadosForm['arquivo_id'];

} else if ($arquivo['arquivo_gaveta'] != $DadosForm['arquivo_gaveta']) {
    $log[1]['arquivo_log_motivo'] = "Alteração gaveta";
    $log[1]['arquivo_log_obs'] = "Gaveta: " . $gaveta[1];
    $log[1]['arquivo_log_supervisor'] = $_SESSION['user_info']['id_usuario'];
    $log[1]['arquivo_log_data'] = date("Y-m-d H:i:s");
    $log[1]['arquivo_log_tipo'] = 1;
    $log[1]['arquivo_log_arquivo'] = $DadosForm['arquivo_id'];
}

if($arquivo['arquivo_pasta'] == ""){
 $log[2]['arquivo_log_motivo'] = "Cadastro pasta";
 $log[2]['arquivo_log_obs'] = "Pasta: " . $DadosForm['arquivo_pasta'];
 $log[2]['arquivo_log_supervisor'] = $_SESSION['user_info']['id_usuario'];
 $log[2]['arquivo_log_data'] = date("Y-m-d H:i:s");
 $log[2]['arquivo_log_tipo'] = 1;
 $log[2]['arquivo_log_arquivo'] = $DadosForm['arquivo_id'];

} else if ($arquivo['arquivo_pasta'] != $DadosForm['arquivo_pasta']) {
    $log[2]['arquivo_log_motivo'] = "Alteração pasta";
    $log[2]['arquivo_log_obs'] = "Pasta: " . $DadosForm['arquivo_pasta'];
    $log[2]['arquivo_log_supervisor'] = $_SESSION['user_info']['id_usuario'];
    $log[2]['arquivo_log_data'] = date("Y-m-d H:i:s");
    $log[2]['arquivo_log_tipo'] = 1;
    $log[2]['arquivo_log_arquivo'] = $DadosForm['arquivo_id'];
}

unset($DadosForm['arquivo_arquivo']);
$result = $arquivos->updateArquivo($DadosForm);

if (!empty($result) && !empty($log)) {
    foreach ($log as $l)
        $arquivos->insertArquivoLog($l);
}

header("Location: ../../../../index.php?pg=24&acao=editar&id=" . $DadosForm['arquivo_id']."#cadastro");
break;

case "deletarArquivo":
$result = $arquivos->verficarArquivosLog($DadosForm['id_arquivo']);
if ($result == 0)
    $arquivos->deleteArquivo($DadosForm['id_arquivo']);
die(json_encode(array("type"=>$result)));
break;

case "cadastrarLog":
$id = $arquivos->insertArquivoLog($DadosForm);
die(json_encode(array("result"=>$id)));
break;

case "adicionarArquivo":
$arquivos->selectArquivoArmarioTexto($DadosForm['texto']);
$result = 'erro';
if($arquivos->Read()->getRowCount() == 0)
  $result = $arquivos->arquivoInsertArmario(array("arquivo_armario_desc" => $DadosForm['texto']));
die(json_encode(array("type"=>$result)));
break;

case "adicionarGaveta":
$arquivos->selectArquivoGavetaTexto($DadosForm['texto'], $DadosForm['id']);
$result = 'erro';
if($arquivos->Read()->getRowCount() == 0)
  $result = $arquivos->arquivoInsertGaveta(array("arquivo_gaveta_desc" => $DadosForm['texto'], "arquivo_gaveta_armario" => preg_replace("/[^0-9]/", "", $DadosForm['id'])));
die(json_encode(array("type"=>$result)));
break;

case "selecionarGavetas":
$gavetas = null;
$tela = $DadosForm['tela'];
if(!empty($DadosForm['id']))
   $gavetas = $arquivos->selectArquivoGaveta($DadosForm['id']);
$options = "";
if(!empty($gavetas)){
   foreach ($gavetas as $gaveta) {
       $value = $tela == "cadastrar" ? $gaveta['arquivo_gaveta_id'] . '_' . $gaveta['arquivo_gaveta_desc'] : $gaveta['arquivo_gaveta_id'];
       $options .= '<option value="' . $value . '">' . $gaveta['arquivo_gaveta_desc'] . '</option>';
   }
}
die(json_encode(array("options"=>$options)));
break;

case "deletarArmario":
$arquivos->select(null, array("id_armario" => $DadosForm['id']));
$result = $arquivos->Read()->getRowCount();
if ($result == 0)
    $arquivos->arquivoDeleteArmario($DadosForm['id']);
die(json_encode(array("type"=>$result)));
break;

case "deletarGaveta":
$arquivos->select(null, array("id_gaveta" => $DadosForm['id']));
$result = $arquivos->Read()->getRowCount();
if ($result == 0)
    $arquivos->arquivoDeleteGaveta($DadosForm['id']);
die(json_encode(array("type"=>$result)));
break;

case "selectLog":
$log = $arquivos->selectLog(null, $_POST['id']);
$log = $arquivos->limparArray($log);
$log['arquivo_log_data'] = Funcoes::formataDataComHora($log['arquivo_log_data']);
die(json_encode($log));
break;

case "desativarVeiculo":
$veiculo->updateVeiculo($DadosForm);
$ve = $arquivos->selectVeiculoJaCasdastrado(null, $DadosForm['id_veiculo']);
$ve['id'] = $ve['cliente_ra'];
Funcoes::gerarLogCadastro(new Log, "Desativar Veículo", $ve, 1);
die(json_encode(array("type"=>"success")));
break;

case "trocarStatusVeiculo":
$arquivo_id = $DadosForm['arquivo_id'];
$placa 		= $DadosForm['placa'];

unset($DadosForm['arquivo_id']);
$veiculo->updateVeiculo($DadosForm);

$status = $DadosForm['veiculo_status'] == 1 ? "reativado" : "desativado";

$log['arquivo_log_motivo'] = "Mudança de Status Veículo";
$log['arquivo_log_obs'] = "O veículo de placa {$placa} foi {$status}";
$log['arquivo_log_supervisor'] = $_SESSION['user_info']['id_usuario'];
$log['arquivo_log_data'] = date("Y-m-d H:i:s");
$log['arquivo_log_tipo'] = 1;
$log['arquivo_log_arquivo'] = $arquivo_id;

$arquivos->insertArquivoLog($log);

header("Location: ../../../../index.php?pg=24&acao=editar&id=" . $arquivo_id ."#cadastro");
break;
}