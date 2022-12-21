    <?php
    //namespace modulos/captacao/src/views/rastreador/formularios/frm_generico.php
    $controllerCadastraClienteRastreador = "/../../../controllers/controllerCadastraClienteRastreador.php";
    $frm_veiculos                        = "modulos/captacao/src/views/rastreador/formularios/frm_veiculos.php";
    $lst_veiculos                        = "modulos/captacao/src/views/rastreador/listas/lst_veiculos.php";
    $lst_anexos                          = "modulos/captacao/src/views/rastreador/listas/lst_anexos.php";
    $frm_anexos 			 = "modulos/captacao/src/views/rastreador/formularios/frm_anexos.php";
    $lst_contratos                       = "modulos/captacao/src/views/rastreador/listas/lst_contratos.php";
    $frm_cliente                         = "modulos/captacao/src/views/rastreador/formularios/frm_cliente_DESENVOLVIMENTO.php";
    
    include_once __DIR__ . $controllerCadastraClienteRastreador;

    echo'<div class="panel panel-primary">';
    echo'<div class="panel-heading">Cadatrar Cliente</div>';
    echo'<div class="panel-default panel-body ">';
    echo '<ul class="nav nav-tabs">';
    if (!empty($id_cliente)):
            $totalVeiculo = (!empty($totalVeiculo) ? $totalVeiculo : '00');
            $totalAnexos = (!empty($totalAnexos) ? $totalAnexos : '00');
            $totalContratos = (!empty($totalContratos) ? $totalContratos : '00');
            echo '<li> <a href="#cliente" data-toggle="tab"> Dados do Clientes</a></li>';
            echo '<li> <a href="#veiculos" data-toggle="tab"> Veículo<span class="alert-danger">(' . $totalVeiculo . ')</span> </a> </li>';
            echo '<li><a href="#anexos" data-toggle="tab"> Anexo<span class="alert-danger">(' . $totalAnexos . ')</span></a></li>';
    endif;
    echo '<li><a href="#settings" data-toggle="tab">Visualizar Contrato</a></li>';
    echo '</ul>';
    echo ' <div class="tab-content">';
    if (!empty($id_cliente)):
            //FORM : Dados do cliente :
            echo '<div class="tab-pane fade" id="cliente">';
            switch ($pg) {
                    case '15':
                    case '30':
                    case '31':
                    case '32':
                    case '33':
                            include_once($frm_cliente);
                            break;
            }
            echo '</div>';
            //FORM : Veiculos :
            echo '<div class="tab-pane fade" id="veiculos">';
            switch ($pg) {
                    case '15':
                    case '31':
                    case '32':
                            include_once($lst_veiculos);
                            break;
                    case '30':
                    case '33':
                            include_once($frm_veiculos);
                            break;
            }
            echo '</div>';
            //FORM : Anexos
            echo '<div class="tab-pane fade" id="anexos">';
            switch ($pg) {
                    case '15':
                    case '30':
                    case '31':
                    case '33':
                            include_once($lst_anexos);
                            break;
                    case '32':
                            include_once($frm_anexos);
                            break;
            }
            echo '</div>';
    endif;
    //FORM : Contratos
    echo '<div class="tab-pane fade" id="settings">';
    switch ($pg) {
            case '15':
            case '30':
            case '31':
            case '32':
            case '33':
                    include_once($lst_contratos);
                    break;
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';