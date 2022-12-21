<?php
//namespace modulos/captacao/src/views/administrativo/listas/lst_contratoGerado.php
$listaContratos = null;
$filtros = filter_input_array(INPUT_GET);
$cliente = filter_input(INPUT_GET, "cliente", FILTER_DEFAULT);
unset($filtros['pg']);
$status = filter_input(INPUT_GET, "status_contrato", FILTER_DEFAULT) == null && empty($filtros) && empty($cliente) && empty($vendedor) ? 1 : filter_input(INPUT_GET, "status_contrato", FILTER_DEFAULT);
$vendedor = filter_input(INPUT_GET, "vendedor", FILTER_DEFAULT);
unset($filtros['pg'], $filtros['pag']);
$lista_clientes = (new Clientes())->selectClienteComContratos();
$lista_usuarios = (new Usuarios())->selectUserComContratos();
$contrato = new Contratos;

$contrato->ListarContratosComFiltros($filtros);
$contrato->ListarContratos($status);
$total = $contrato->Read()->getRowCount();


$total =($total <85)?$total:84;

//var_dump($total); 

// PAGINACAO:
$objPaginacao = new paginacao(50, $total, PAG, 10);
$objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($filtros);
$limite = $objPaginacao->limit();
// LISTAR CONTRATOS :
$listaContratos = $contrato->ListarContratos($status, $limite);
//FORMLULARIO DE BUSCA :
include_once(__DIR__ . '/../formularios/frm_contratoGerado.php');

if ($listaContratos) :
    ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            Lista de Contratos
        </div>
        <div class="panel-body">
            <div class="well well-sm">
                <span class="glyphicon glyphicon-print"></span> => Imprimir &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="glyphicon glyphicon-eye-open"></span> => Visualizar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="glyphicon glyphicon-remove"></span> => Reprovar
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float: right">
                    <select class="form-control selectStatusDefaut" name="status_contrato">
                        <option id="index.php?pg=17&status_contrato=1" <?= $status == 1 ? "selected" : ""; ?>>Em Aberto</option>
                        <option id="index.php?pg=17&status_contrato=2" <?= $status == 2 ? "selected" : null; ?>>Finalizados</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped dataTableBootstrapSemOrdem">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th>Tipo</th>
                            <th>Vigência</th>
                            <th>Status</th>
                            <th>Já é cliente</th>
                            <th>Imprimir</th>
                            <th>Visualizar</th>
                            <th>Reprovar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($listaContratos as $k => $li) :
                            $lista_data_contrato_gerado = date('d/m/Y H:i:s', strtotime($li['data_envio']));
                            $lista_id_contrato = !empty($li['id_contrato']) ? $li['id_contrato'] : NULL;
                            $lista_id_cliente = !empty($li['id_cliente']) ? $li['id_cliente'] : NULL;
                            $lista_status_contrato = !empty($li['status_contrato']) ? $li['status_contrato'] : NULL;
                            $lista_cliente_ra = !empty($li['cliente_ra']) ? $li['cliente_ra'] : NULL;
                            $lista_cliente_tipo = !empty($li['tipo']) ? $li['tipo'] : NULL;
                            $lista_cliente_tipo = $lista_cliente_tipo == "rastreador" ? "COMODATO" : strtoupper($lista_cliente_tipo);
                            $origem = !empty($li['form_origem']) ? $li['form_origem'] : NULL;
                            $vigencia = "";
                            switch ($li['vigencia']) {
                                case "1":$vigencia = "12 meses";break;
                                case "2":$vigencia = "24 meses"; break;
                                case "3":$vigencia = "36 meses";break;
                            }

                            $status_contrato = "";
                            switch ($lista_status_contrato) {
                                case "1": $status_contrato = "Novo";break;
                                case "2": $status_contrato = "Reprovado";break;
                                case "3": $status_contrato = "Finalizado";break;
                            }
                            ?> 
                            <tr align="center">
                                <td><?=$lista_data_contrato_gerado; ?></td>
                                <td><?=$li['nome_cliente']; ?></td>
                                <td><?=$li['nome_usuario']; ?></td>
                                <td><?=$lista_cliente_tipo; ?></td>
                                <td><?=$vigencia;?></td>
                                <td><?=$status_contrato;?></td>
                                <td><?=$li['ja_e_cliente']; ?></td>
                                <td width="2%">
                                    <a class="botaoLoad modalOpen btn btn-sm btn-default" id="modulos/captacao/src/views/contratos/listas/lst_anexosContrato.php?id=<?= $lista_id_contrato; ?>&id_cliente=<?= $lista_id_cliente; ?>&cliente=<?= str_replace(" ", "+", $li['nome_cliente']); ?>" data-target="#modal"> 
                                        <span class="glyphicon glyphicon-print"></span>
                                    </a>
                                </td>
                                <td width="2%">
                                    <?php
                                    $imagem = 'trf1_icone_ver.gif';
                                    switch ($li ['cor_status']) :
                                        case 'a_cor_cinza' : $imagem = '#000';
                                            break;
                                        case 'b_cor_verde' : $imagem = '#006400';
                                            break;
                                        case 'c_cor_amarelo' : $imagem = '#FFD700';
                                            break;
                                        case 'd_cor_laranja' : $imagem = '#FF4500';
                                            break;
                                        case 'e_cor_vermelho' : $imagem = '#FF0000';
                                            break;
                                    endswitch;
                                    ?>
                                    <a id="modulos/captacao/src/views/administrativo/listas/lst_modalListaCliente.php?<?= "id={$lista_id_cliente}&id_contrato={$lista_id_contrato}&cliente_ra={$lista_cliente_ra}"; ?>" class="botaoLoad btn btn-sm btn-contratos modalOpen" data-target="#modalVisualizaContrato" style="color:<?= $imagem; ?>;"> 
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </a>
                                </td>
                                <td width="2%">
                                    <a class="botaoLoad modalOpen btn-sm btn btn-danger" id="modulos/captacao/src/views/contratos/formularios/modalReprovaContrato.php?id_contrato=<?= $lista_id_contrato; ?>&id_cliente=<?= $lista_id_cliente; ?>" data-target="#modal"> 
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                </td>
                            </tr>
                <?php
            endforeach;
            ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9">Registros encontrados: <?= $total; ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
    <?php
    $objPaginacao->MontaPaginacao();
else :
    echo Funcoes::Nregistro();
endif;
?>
        <div class="alert alert-warning"> 
            <strong>Atenção!</strong><br><br> 
            <p>Clique abaixo para Exportar em Excel os Contratos <span style="color:red">Finalizados</span></p><br>
            <hr>
            <form action="modulos/captacao/src/controllers/controllerExportarContrato.php"  method="get">
                <div class="row">
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                        <div class="form-group">
                            <label>Período:</label>
                            <div class="input-group input-append date datepicker">
                                <input type="text" name="dt_inicial" id="dt_inicial" class="form-control  mask_data" value="" required="">
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                        <div class="form-group">
                            <label>até</label>
                            <div class="input-group input-append date datepicker">
                                <input type="text" name="dt_final" class="form-control mask_data" id="dt_final" value="" required="">
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="acao" value="excel2">
                <input type="hidden" name="status_contrato" value="3">
                <button class="btn btn-default" >Exportar Contrato / Excel</button>
            </form>
        </div>
    </div>
</div>