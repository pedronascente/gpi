<?php  
$id_setor      = filter_input(INPUT_GET, 'id_setor', FILTER_VALIDATE_INT);
$id_usuario    = filter_input(INPUT_GET, 'id_u');
$id_pc         = filter_input(INPUT_GET, 'id_pc', FILTER_VALIDATE_INT);
$acao          = filter_input(INPUT_GET, 'acao', FILTER_DEFAULT);
$page          = empty($page) ? filter_input(INPUT_GET, 'page', FILTER_DEFAULT) :'';
$pcf_ano       = empty($pcf_ano) ? filter_input(INPUT_GET, 'pcf_ano', FILTER_DEFAULT) : $pcf_ano;
$tipo          = filter_input(INPUT_GET, "tipo", FILTER_DEFAULT);
$periodo       = empty($pcf_periodo) ? filter_input(INPUT_GET, 'pcf_periodo', FILTER_DEFAULT) : $pcf_periodo;

if (!isset($_SESSION['user_info'])) {   @session_start();}

$json_file     = file_get_contents($_SESSION['caminho_local'] . "\modulos\pedidoComissao\public\js\periodos.json");
$periodos      = json_decode($json_file, true);
$pcfPeriodo    = str_replace(" ", "", $periodo);
$mesInicial    = @$periodos[explode("/", $pcfPeriodo)[0]];
$mesFinal      = @$periodos[explode("/", $pcfPeriodo)[1]];
$pcf_ano_final = $mesInicial == 11 && $mesFinal == 0 ? $pcf_ano+1 : $pcf_ano;

/*
 * **************************************
 * ********* LISTA A COMISSAO **********
 * **************************************
 */

include_once ("../../../../../Config.inc.php");
$pedidoComissao = new PedidoComissao ();

if ($acao == "editarComissao") {
    $pedidoComissao->selectIdPedidoComissao($id_pc);
    $titulo = "Editar";
} else if ($acao == "AddPedidoComissao"){
    $titulo = "Cadastrar";
} else {
    $titulo = "Visualizar";
}
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <!--<h4 class="modal-title">Agenda</h4>-->
        </div>			
        <div class="modal-body">
            <?php include_once '../formularios/frm_cadastraPedidoComissao.php';?>
        </div><!--modal-body-->
    </div><!--modal-content-->    
</div><!--modal-dialog-->    

<script type="text/javascript" >
  $(function(){
    $(".mask_real").priceFormat({
        prefix : 'R$ ',
        centsSeparator : ',',
        thousandsSeparator : '.'
    });
    $('.datepicker').datepicker({
        format : 'dd/mm/yyyy',
        language : 'pt-BR'
    });
    $(".mask_placa").mask("SSS-9999");
  });
</script>