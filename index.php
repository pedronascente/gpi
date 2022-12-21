<?php
include_once("bootstrap.php");
include_once("Config.inc.php");
$caminho_site = "/gpi/";
$permissoes = $_SESSION ['user_info'] ['permissoes'];
$monitoramento['tipo_permissao'] = 'monitoramento';
$admin['tipo_permissao'] = 'admin';
$administrativo['tipo_permissao'] = 'administrativo';
$captacao['tipo_permissao'] = 'captacao';
$gerente['tipo_permissao'] = 'gerente';
$pedidoComissao['tipo_permissao'] = 'pedido_comissao';
$confComissao['tipo_permissao'] = 'conf_comissao';
$sac['tipo_permissao'] = 'sac';
$sac_admin['tipo_permissao'] = 'sac_admin';
$rh['tipo_permissao'] = 'rh';
$auditoria['tipo_permissao'] = 'auditoriaAlarmes';
$auditoriaAlertas['tipo_permissao'] = 'auditoriaAlertas';
$consulta['tipo_permissao'] = 'consultaCaptacao';
$recepcao['tipo_permissao'] = 'recepcao';
$desenvolvedor['tipo_permissao'] = 'desenvolvedor';
$almoxarifado['tipo_permissao'] = 'almoxarifado';
$programacao['tipo_permissao'] = 'programacao';
$supervisor['tipo_permissao'] = 'supervisor';
$suporte['tipo_permissao'] = 'suporte';
$arquivo['tipo_permissao'] = 'arquivo';
$recepcaoMaster['tipo_permissao'] = 'recepcaoMaster';
$supervisorUVA['tipo_permissao'] = 'supervisorUVA';
$monitoramento2['tipo_permissao'] = "monitoramento2";
$vendasGuaiba['tipo_permissao'] = "vendasGuaiba";
$sidebar = !empty($_COOKIE['sidebar']) ? $_COOKIE['sidebar'] : "";
$parametros = $_SERVER['QUERY_STRING'];
$ret = !empty($_REQUEST['ret']) ? $_REQUEST['ret'] : '';
// * REGISTRAR COMPONENTES JQUERY :
$JQUERY_pagimasQueUsamDataTable = array('26', '18', '7', '5', '8', '2', '4', '11', '17', '19', '9');
$JQUERY_bootstrapDatepicker = array('54','52','51','50', '47', '41','33', '19','18','17','15','9','6','3');
$JQUERY_bootstrapSelect = array('17', '19', '6', '30', '32', '18', '19');
$JQUERY_fusioncharts = array('50');
$JQUERY_usuarios = array('4', '21');
$JQUERY_pedidoComissao = array('5', '6', '7', '8', '9');
$JQUERY_monitoramento = array('51');
$JQUERY_monitoramento2 = array('48', '49');
$JQUERY_compras = array('46', '47');
$JQUERY_clientes = array('43', '50');
$JQUERY_servicoCondominio = array('42');
$JQUERY_sac = array('10', '38');
$JQUERY_ramal = array('11');
$JQUERY_solicitacoesGerais = array('23');
$JQUERY_arquivo = array('24');
$JQUERY_m_reprovarCliente = array('12', '13', '14');
$JQUERY_captacao = array('1', '2', '3', '26', '18');
$JQUERY_contrato = array('17');
$JQUERY_validar_formulario = array('1','18');
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="author"   content="Pedro nascente : email: nascente3d@hotmail.com">
        <meta content="initial-scale=1, width=device-width" name=viewport>
        <link rel="shortcut icon" type="image/x-icon" href="<?= $caminho_site ?>/public/img/ico/48x48xgpi.ico">
        <link type="text/css" rel="stylesheet" href="<?= $caminho_site ?>public/css/main.css" />
        <script type="text/javascript" src="<?= $caminho_site ?>public/js/vendor/jquery/jquery.v1.11.3.min.js"></script>
        <script type="text/javascript" src="<?= $caminho_site ?>public/js/vendor/bootstrap/min/bootstrap.min.js"></script>
        <title>GPI - Gestão de Processos Internos</title>
    </head>
    <body class="gpi_classic" >
        <div class="container-fluid">
            <?php
            if ($ret == 'success') {
                echo "<p class=\"alert alert-success \"><span class=\"glyphicon glyphicon-info-sign\" aria-hidden=\"true\"></span> Registrado com Sucesso .</p> ";
            } elseif ($ret == 'warning') {
                echo "<p class=\"alert alert-warning\"><span class=\"glyphicon glyphicon-info-sign\" aria-hidden=\"true\"></span> Registro Alterado  com Sucesso .</p> ";
            } elseif ($ret == 'danger') {
                echo "<p class=\"alert alert-warning\"><span class=\"glyphicon glyphicon-info-sign\" aria-hidden=\"true\"></span> Registro Excluido  com Sucesso .</p> ";
            }
            include_once'./application/views/layouts/nav.php';
            ?>   
            <section>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php   new Url($pg); ?>
                    </div>
                </div>
            </section>
            <footer class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Copyright &copy; <?= date('Y') ?> - Todos os direitos reservados / Grupo Volpato</div>
            </footer>
            <!-- MODAL ALTERAR SENHA -->
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
            <div class="modal fade" id="modalVisualizaContrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
        </div>
        <?php if (in_array($pg, $JQUERY_pagimasQueUsamDataTable)) { ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $caminho_site; ?>public/css/vendor/dataTables.bootstrap.min.css" />
            <link type="text/css" rel="stylesheet" href="<?php echo $caminho_site; ?>public/css/vendor/buttons.dataTables.min.css" />            
            <script type="text/javascript">
                $(function () {
                    $(".dataTableBootstrap").DataTable({
                        "order": [[0, "desc"]], "paging": false, "bFilter": false, "bInfo": false, "dom": 'Bfrtip', "buttons": [{extend: 'print', text: 'Imprimir'}, {extend: 'copyHtml5', text: 'Copiar'}, 'excelHtml5', ]
                    });
                    $(".dataTableBootstrapSemOrdem").DataTable({
                        "aaSorting": [], "paging": false, "bFilter": false, "bInfo": false, "dom": 'Bfrtip', "buttons": [{extend: 'print', text: 'Imprimir'}, {extend: 'copyHtml5', text: 'Copiar'}, 'excelHtml5', ]
                    });
                });
            </script>
            <script type="text/javascript" src="<?= $caminho_site; ?>public/js/vendor/dataTable/jquery.dataTables.min.js"></script>
            <script type="text/javascript" src="<?= $caminho_site; ?>public/js/vendor/dataTable/dataTables.bootstrap.min.js"></script>
            <script type="text/javascript" src="<?= $caminho_site; ?>public/js/vendor/dataTable/buttons/dataTables.buttons.min.js"></script>
            <script type="text/javascript" src="<?= $caminho_site; ?>public/js/vendor/dataTable/buttons/buttons.print.min.js"></script>
            <script type="text/javascript" src="<?= $caminho_site; ?>public/js/vendor/dataTable/buttons/buttons.html5.min.js"></script>
            <script type="text/javascript" src="<?= $caminho_site; ?>public/js/vendor/dataTable/buttons/jszip.min.js"></script>
            <script type="text/javascript" src="<?= $caminho_site; ?>public/js/vendor/dataTable/buttons/dataTables.tableTools.js"></script>
            <?php
        }
        if (in_array($pg, $JQUERY_bootstrapSelect)) {
            echo '<script  type="text/javascript" src="' . $caminho_site . 'public/js/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>';
            echo '<script  type="text/javascript" src="' . $caminho_site . 'public/js/vendor/bootstrap-select/dist/js/i18n/defaults-pt_BR.min.js"></script>';
            echo '<script type="text/javascript">
                        $(function(){
                            $(".selectpicker").selectpicker({"liveSearch": true, "showIcon": true, "size": 10});
                        });
                     </script>';
        }
        if (in_array($pg, $JQUERY_bootstrapDatepicker)) {
            echo '<script type="text/javascript">
                        $(function(){
                            $(".datepicker").datepicker({format:"dd/mm/yyyy",language:"pt-BR"})
                        });
                     </script>';
            echo '<link type="text/css" rel="stylesheet" href="' . $caminho_site . 'public/css/vendor/bootstrap/min/bootstrap-datepicker3.min.css" />';
            echo '<script  type="text/javascript" src="' . $caminho_site . 'public/js/vendor/bootstrap/bootstrap-datepicker-master/js/bootstrap-datepicker.min.js"></script>';
            echo '<script  type="text/javascript" src="' . $caminho_site . 'public/js/vendor/bootstrap/bootstrap-datepicker-master/js/locales/bootstrap-datepicker.pt-BR.js"></script>';
        }
        if (in_array($pg, $JQUERY_usuarios)) {
            echo '<script language="javascript" type="text/javascript" src="' . $caminho_site . 'modulos/usuarios/public/js/usuarios.js"></script>';
        }
        if (in_array($pg, $JQUERY_pedidoComissao)) {
            echo '<script language="javascript" type="text/javascript" src="' . $caminho_site . 'modulos/pedidoComissao/public/js/pedido_comissao.js"></script>';
        }
        if (in_array($pg, $JQUERY_monitoramento)) {
            echo '<script language="javascript" type="text/javascript" src="' . $caminho_site . 'modulos/monitoramento/public/js/monitoramento.js"></script>';
        }
        if (in_array($pg, $JQUERY_monitoramento2)) {
            echo '<script src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>';
            echo '<script language="javascript" type="text/javascript" src="' . $caminho_site . 'modulos/monitoramento/public/js/monitoramento.js"></script>';
        }
        if (in_array($pg, $JQUERY_compras)) {
            echo '<script language="javascript" type="text/javascript" src="' . $caminho_site . 'modulos/compras/public/js/compras.js"></script>';
        }
        if (in_array($pg, $JQUERY_clientes)) {
            echo '<script language="javascript" type="text/javascript" src="' . $caminho_site . 'modulos/clientes/public/js/clientes.js"></script>';
        }
        if (in_array($pg, $JQUERY_servicoCondominio)) {
            echo '<script language="javascript" type="text/javascript" src="' . $caminho_site . 'modulos/clientes/public/js/clientes.js"></script>';
        }
        if (in_array($pg, $JQUERY_sac)) {
            echo '<script type="text/javascript" src="' . $caminho_site . 'modulos/sac/public/js/sac.js"></script>';
        }
        if (in_array($pg, $JQUERY_ramal)) {
            echo '<script language="javascript" type="text/javascript" src="' . $caminho_site . 'modulos/ramal/public/js/min/ramal.js"></script>';
        }
        if (in_array($pg, $JQUERY_m_reprovarCliente)) {
            echo '<script language="JavaScript" type="text/javascript" src="' . $caminho_site . 'modulos/captacao/public/js/m_reprovarCliente.js"></script>';
        }
        if (in_array($pg, $JQUERY_arquivo)) {
            echo '<script language="JavaScript" type="text/javascript" src="' . $caminho_site . 'modulos/arquivo/public/js/min/arquivo.js"></script>';
        }
        if (in_array($pg, $JQUERY_solicitacoesGerais)) {
            echo '<script type="text/javascript" src="' . $caminho_site . 'modulos/desenvolvimento/src/public/js/frm_solicitacoesGerais.js"></script>';
        }
        if (in_array($pg, $JQUERY_contrato)) {
            echo '<script language="javascript" type="text/javascript" src="' . $caminho_site . 'modulos/captacao/public/js/contrato.js"></script>';
        }
        if (in_array($pg, $JQUERY_captacao)) {
            echo '<script language="javascript" type="text/javascript" src="' . $caminho_site . 'modulos/captacao/public/js/min/captacao.js"></script>';
        }
        ?> 
        <script  type="text/javascript" src="<?= $caminho_site ?>public/js/vendor/jquery/plugins/jquery.mask.min.js"></script>
        <script  type="text/javascript" src="<?= $caminho_site ?>public/js/vendor/jquery/plugins/jquery.price_format.1.4_min.js"></script>
        <script  type="text/javascript" src="<?= $caminho_site ?>public/js/funcoes.min.js"></script>   
        <script  type="text/javascript" src="<?= $caminho_site ?>public/js/vendor/jquery/plugins/jquery.validate.js"></script>
        <?php   
            if (in_array($pg, $JQUERY_validar_formulario)) { ?>
                <script type="text/javascript" src="<?= $caminho_site ?>public/js/vendor/jquery/plugins/matrix.form_validation.js"></script>
                <link type="text/css" rel="stylesheet" href="<?= $caminho_site ?>public/js/vendor/jquery/plugins/matrix-style.css" /><?php  
            }
        ?>  
    </body>
</html>
