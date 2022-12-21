<?php
// namespace  C:\wamp\www\gpi\modulos\captacao\src\controllers\controllerCadastraClienteRastreador.php
$dadosUrl = filter_input_array(INPUT_GET);
$id_contrato = null;
$id_veiculo = filter_input(INPUT_GET, 'id_veiculo');
$id_cli = filter_input(INPUT_GET, 'id_cliente_contrato');
$error = filter_input(INPUT_GET, 'error');
$id_cliente = filter_input(INPUT_GET, 'id');
$id_usuario = $_SESSION['user_info']['id_usuario'];
$clientes = new Clientes;
$contrato = new Contratos;
$veiculos = new Veiculos;
$captacao = new Captacao;
$anexo = new Anexos;
//SELECT CLIENTE:
if (!empty($id_cliente)) {
    $cliente = $clientes->selectClienteEnderecoCobrancaContrato($id_cli);
    $ENDERECO_COBRANCA = $clientes->getEnderecoByTipoEndereco([
        'tabela'=>'endereco_cobranca',
        'id_cliente'=>$id_cli,
        'tipo_endereco'=>'endereco_cobranca'
    ]);
    $ENDERECO_ENTREGA = $clientes->getEnderecoByTipoEndereco([
        'tabela'=>'endereco_cobranca',
        'id_cliente'=>$id_cli,
        'tipo_endereco'=>'endereco_entrega'
    ]);
    $CONTATO1 = $clientes->getContatoByRaContato([
        'tabela'=>'contato_cliente',
        'id_cliente_contato'=>$id_cli,
        'ra_contato'=>1
    ]);
    $CONTATO2 = $clientes->getContatoByRaContato([
        'tabela'=>'contato_cliente',
        'id_cliente_contato'=>$id_cli,
        'ra_contato'=>2
    ]);
    
}

if (!empty($id_cli)) {
    $con = $contrato->selectPorCliente($id_cli);
}

$statusCadastro = !empty($con['status_contratro']) ? $con['status_contratro'] : (isset($cliente['status_cadastro']) ? $cliente['status_cadastro'] : "");
$camposCliente = null;
$camposVeiculos = null;
if ($statusCadastro == 2) {
    $camposCliente = $clientes->selectCamposContratoReprovado($id_cli, 1);
    $camposVeiculos = $clientes->selectCamposContratoReprovado($id_cli, 2);
}

//RESPONSAVEL POR LISTAR CONTRATOS:
if (!empty($id_usuario)) :
//    $contrato->listarContratosUsuario($id_usuario);
//    $totalContratos = $contrato->Read()->getRowCount();
//    $objPaginacaoContratos = new paginacao(10, $totalContratos, PAG, 10);
//    $objPaginacaoContratos->_pagina = PAGINA . '&id_cliente_contrato=' . $id_cli . "&id=" . $id_cliente;
//    $objPaginacaoContratos->SetTabs('#contratos');
//    $limite = $objPaginacaoContratos->limit();
      $listaContratos = $contrato->listarContratosUsuario($id_usuario,100);
endif;

//SELECT TIPO DE CADASTRO:
if (!empty($id_cli)) :
    $tipo_cadastro = isset($cliente['tipo']) ? $cliente['tipo'] : NULL;
endif;

//SELECT VEICULO  :
if (!empty($id_veiculo)) :
    $veiculo = $veiculos->select($id_veiculo);
    $totalVeiculo = $veiculos->Read()->getRowCount();
endif;

//SELECT VEICULOS :
if (!empty($id_cli)) :
    $veiculos->selectPorContrato($id_cli);
    $totalVeiculo = $veiculos->Read()->getRowCount();
    $objPagiacaoVeiculo = new paginacao(16, $totalVeiculo, PAG, 16);
    $objPagiacaoVeiculo->_pagina = PAGINA . '&id_cliente_contrato=' . $id_cli . "&id=" . $id_cliente;
    $objPagiacaoVeiculo->SetTabs('#veiculos');
    $limite = $objPagiacaoVeiculo->limit();
    $list_veiculos = $veiculos->selectPorContrato($id_cli, $limite);
endif;

//SELECT ANEXOS:
if (!empty($id_cliente)) :
    $listaAnexos = $anexo->selectAnexosClientes($id_cli);
    $totalAnexos = $anexo->Read()->getRowCount();
endif;

$tipoPessoa = isset($cliente ['tipo_pessoa']) ? $cliente ['tipo_pessoa'] : "";
