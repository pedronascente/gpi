<?php
#pagina: controllerCadastraClienteRastreador.php
#pagina: frm_cliente.php
#pagina: lst_veiculos.php
#pagina: lst_anexos.php
#pagina: lst_contratos.php
#pagina: frm_cadastraClienteRastreador.php

include_once __DIR__ . '/../../../controllers/controllerCadastraClienteRastreador.php';
$result = filter_has_var(INPUT_GET, "result");
?>

<div class="panel panel-primary  ">
    <div class="panel-heading">Cadatrar Cliente</div>
    <div class="panel-default panel-body ">

        <?php if ($result === '1') {
            echo '<div class="row">';
            echo '<div class="col-xs-12 col-sm-12 col-md-12  col-lg-12">';
            echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign">   Registro excluido com sucesso!</span>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '<ul class="nav nav-tabs">';
        if (!empty($id_cliente)) {
            $totalVeiculo = (!empty($totalVeiculo) ? $totalVeiculo : '00');
            $totalAnexos = (!empty($totalAnexos) ? $totalAnexos : '00');
            $totalContratos = (!empty($totalContratos) ? $totalContratos : '00');
            echo '<li> <a href="#cliente" data-toggle="tab"> Dados do Clientes</a></li>';
            echo '<li> <a href="#veiculos" data-toggle="tab"> Veículo (s) <span class="alert-danger">(' . $totalVeiculo . ')</span> </a> </li>';
            echo '<li> <a href="#anexos" data-toggle="tab"> Anexo(s)<span class="alert-danger">(' . $totalAnexos . ')</span></a></li>';
        }
        echo '<li><a href="#settings" data-toggle="tab"> Listar Contrato(s) <span class="alert-danger">(' . $totalContratos . ')</span></a></li>';
        echo '</ul>';
        echo ' <div class="tab-content">';
        if (!empty($id_cliente)) {
            //FORM : Dados do cliente :
            echo '<div class="tab-pane fade" id="cliente">';
            include_once("frm_cliente.php");
            echo '</div>';
            //FORM : Veiculos :

            include_once('modulos/captacao/src/views/rastreador/listas/lst_veiculos.php');
            echo '</div>';
            //FORM : Anexos
            echo '<div class="tab-pane fade" id="anexos">';
            include_once('frm_anexos.php');
            echo '</div>';
        }
        //FORM : Contratos
        echo '<div class="tab-pane fade" id="settings">';
        include_once('modulos/captacao/src/views/rastreador/listas/lst_contratos.php');
        echo '</div>';
        echo '</div>';
        ?>
    </div>
</div>