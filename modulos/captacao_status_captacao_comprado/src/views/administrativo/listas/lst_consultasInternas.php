<meta HTTP-EQUIV="Refresh" CONTENT="60; ">
<?php
$id_usuario = $_SESSION ['user_info'] ['id_usuario'];
$cliente = new Clientes ();
//LISTA CONSULTA DE CLIENTE DE RASTREADOR :
$cliente->selectClienteUsuario(null);
$totalClienteRastreador = $cliente->Read()->getRowCount();
$objPaginacaoRastreador = new paginacao(10, $totalClienteRastreador, PAG, 10);
$objPaginacaoRastreador->_pagina = PAGINA;
$limite = $objPaginacaoRastreador->limit();
$dadosClienteRastreador = $cliente->selectClienteUsuario($limite);
?>
<div class="panel panel-primary">
    <div class="panel-heading ">Lista de Clientes</div>
    <div class="panel-body">
        <?php if (!empty($dadosClienteRastreador)) { ?>
            <div class="well well-sm">
                <span class="glyphicon glyphicon-ok"></span> => Aprovar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="glyphicon glyphicon-remove"></span> => Reprovar
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Vendedor</th>
                            <th>CNPJ / CPF</th>
                            <th>Cliente</th>
                            <th>Tipo Cadastro</th>
                            <th width="10%" colspan="2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($dadosClienteRastreador as $k => $li) {
                            $cliente_data_solicitacao_cliente = !empty($li ['data_solicitacao_cliente']) ? $li ['data_solicitacao_cliente'] : NULL;
                            $cliente_tipo_cadastro = !empty($li ['tipo_cadastro']) ? $li ['tipo_cadastro'] : NULL;
                            $cliente_vendedor = !empty($li ['nome']) ? $li ['nome'] : NULL;
                            $cliente_cnpjcpf = !empty($li ['cnpjcpf_cliente']) ? $li ['cnpjcpf_cliente'] : NULL;
                            $cliente_nome = !empty($li ['nome_cliente']) ? $li ['nome_cliente'] : NULL;
                            $cliente_id = !empty($li ['id_cliente_contrato']) ? $li ['id_cliente_contrato'] : NULL;
                            ?>
                            <tr>
                                <td><?= Funcoes::formataData($cliente_data_solicitacao_cliente); ?></td>
                                <td><?= Funcoes::addCaracter($cliente_vendedor); ?></td>
                                <td><?= $cliente_cnpjcpf; ?></td>
                                <td><?= Funcoes::addCaracter($cliente_nome); ?></td>
                                <td><?= $cliente_tipo_cadastro; ?></td>
                                <td width="2%">
                                    <a href="modulos/captacao/src/controllers/captacao.php?acao=AprovarConsulta&id_cliente=<?= $cliente_id ?>&id_status=2" class="botaoLoad btn btn-sm btn-success"><span class="glyphicon glyphicon-ok"></span></a>
                                </td>
                                <td width="2%">  
                                    <a id="modulos/captacao/src/views/administrativo/formularios/modalReprovaCliente.php?id=<?= $cliente_id; ?>&tipoCadastro=Rastreador" class="botaoLoad modalOpen btn btn-sm btn-danger" data-target="#modal"><span class="glyphicon glyphicon-remove"></span></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php
            $objPaginacaoRastreador->MontaPaginacao();
        } else {
            Funcoes::Nregistro();
        }
        ?>
    </div>
</div>