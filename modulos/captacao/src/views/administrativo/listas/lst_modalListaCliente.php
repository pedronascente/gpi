<?php
include_once '../../../../../../Config.inc.php';
header('Content-Type: text/html; charset=utf-8');
$idURL = (int) \filter_input(\INPUT_GET, 'id');
$idContratoURL = (int) \filter_input(\INPUT_GET, 'id_contrato');
$cliente_ra = filter_input(INPUT_GET, 'cliente_ra');
$cliente = new Clientes();
$veiculo = new Veiculos();
$formaDePagamento = new FormaDePagamento();
$contratos = new Contratos();

$list_cliente = $cliente->selectClienteEnderecoCobrancaContrato($idURL);
 
$ENDERECO_COBRANCA = $cliente->getEnderecoByTipoEndereco([
    'tabela'=>'endereco_cobranca',
    'id_cliente'=>$idURL,
    'tipo_endereco'=>'endereco_cobranca'
]);
$ENDERECO_ENTREGA = $cliente->getEnderecoByTipoEndereco([
    'tabela'=>'endereco_cobranca',
    'id_cliente'=>$idURL,
    'tipo_endereco'=>'endereco_entrega'
]);
$CONTATO1 = $cliente->getContatoByRaContato([
    'tabela'=>'contato_cliente',
    'id_cliente_contato'=>$idURL,
    'ra_contato'=>1
]);
$CONTATO2 = $cliente->getContatoByRaContato([
    'tabela'=>'contato_cliente',
    'id_cliente_contato'=>$idURL,
    'ra_contato'=>2
]);
$Cliente_id = !empty($list_cliente ['idCliente']) ? $list_cliente ['idCliente'] : NULL;
//FORMA DE PAGAMENTO :
$ArrayListformaDePagamento = $formaDePagamento->selectFormaDePagamentoPorIdCliente($Cliente_id);
//LISTAR TODOS OS VEÍCULO DO CLIENTES :
$list_veiculo = $veiculo->selectIDCliente($idURL);
$totalVeiculo = $veiculo->Read()->getRowCount();
//LISTAR DADOS DO CONTRATO :
$contrato = $contratos->select($idContratoURL);
$contrato_status = !empty($contrato ['status_contrato']) ? $contrato ['status_contrato'] : NULL;
$Contrato_data_contrato_gerado = !empty($contrato ['data_contrato_gerado']) ? funcoes::formataData($contrato ['data_contrato_gerado']) : NULL;
$Contrato_observacoes_contrato = !empty($contrato ['observacoes_contrato']) ? $contrato ['observacoes_contrato'] : NULL;
$Contrato_data_envio = !empty($contrato ['data_envio']) ? $contrato ['data_envio'] : NULL;
$Contrato_tipo_assinatura = !empty($contrato ['tipo_assinatura']) ? $contrato ['tipo_assinatura'] : NULL;
//MEIO DE PAGAMENTO :
$arrFormaPgto = array(
    '1' => 'CART&Atilde;O',
    '2' => 'DEP&Oacute;SITO',
    '3' => 'DINHEIRO',
    '4' => 'BOLETO BANC&Aacute;RIO',
    '5' => 'OUTROS',
    '6' => 'PAGSEGURO'
);
$Cliente_Data_Pagamento = !empty($list_cliente ['data_pagamento']) ? $list_cliente ['data_pagamento'] : NULL;
$Cliente_Melhor_Pagamento = !empty($list_cliente ['diaMelhorPagamento']) ? $list_cliente ['diaMelhorPagamento'] : NULL;
$cliente_Obs_Pagamento = !empty($list_cliente ['obs_diaPagamento']) ? $list_cliente ['obs_diaPagamento'] : NULL;
$Cliente_Meio_Hab = !empty($list_cliente ['forma_pagamento']) ? $arrFormaPgto[$list_cliente['forma_pagamento']] : NULL;
$Cliente_Meio_Men = !empty($list_cliente ['forma_pagamento_mensalidade']) ? $arrFormaPgto[$list_cliente['forma_pagamento_mensalidade']] : NULL;
?>
<style type="text/css">
    .ui-dialog-content {  padding: 0 !important;   margin: 0 !important }
    table { border: 1px solid #FFF }
</style>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Listar Dados</h4>
        </div>
        <div class="modal-body">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <?php include_once 'lst_cliente.php'; ?>
                <?php include_once 'lst_veiculos.php'; ?>
                <?php include_once 'lst_contrato.php'; ?>
                <?php include_once 'lst_forma_de_pagamento.php'; ?>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <form action="modulos/captacao/src/controllers/captacao.php" method="post" class="form-inline">
                            <input type="hidden" name="id_cliente" value="<?=$Cliente_id; ?>"/>
                            <input type="hidden" name="id_contrato" value="<?= $idContratoURL; ?>"/>
                            <input type="hidden" name="cliente_ra" value="<?= $cliente_ra; ?>"/>
                            <input type="hidden" name="acao" value="finalizarContrato"/>
                            <button type="submit" class="btn btn-primary" id="btn_salvar">
                                Finalizar
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalVeiculos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
    <script type="text/javascript" language="javascript">
        $(function () {
            $(".modalOpen").click(function () {
                var modal = $(this).attr("data-target");
                var caminho = $(this).attr("id");
                $(modal).load(caminho);
                $(modal).modal();
            });
            $('#btnEditar').click(function () {
                $('#dataContratoLabel').css('display', 'none');
                $('#dataContratoInput').css('display', 'inline-block');
                $('#formatoAssinaturaLabel').css('display', 'none');
                $('#formatoAssinaturaInput').css('display', 'inline-block');
                $('#divBtnEditar').css('display', 'none');
                $('#divBtnCancelar').css('display', 'inline-block');
                $('.mask_data').mask('00/00/0000');
            });
            $('#btnCancelar').click(function () {
                $('#dataContratoInput').css('display', 'none');
                $('#dataContratoLabel').css('display', 'inline-block');
                $('#formatoAssinaturaInput').css('display', 'none');
                $('#formatoAssinaturaLabel').css('display', 'inline-block');
                $('#divBtnCancelar').css('display', 'none');
                $('#divBtnEditar').css('display', 'inline-block');
            });
        });
    </script>