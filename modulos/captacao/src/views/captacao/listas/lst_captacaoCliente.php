<?php
//modulos/captacao/src/views/captacao/listas/lst_captacaoCliente.php
include_once __DIR__ . "/../../../controllers/controller_captacaoCliente.php";
$tipo_consulta = filter_has_var(INPUT_GET, "acao");
include_once "modulos/integracaoPagSeguro/application/model/PagSeguro.class.php";
$PagSeguro = new PagSeguro();
$anexo = new Anexos();
if ($tipo_consulta == "ex") :
  include_once "modulos/captacao/src/views/captacao/formularios/frm_captacaoCliente.php";
else:
    $haystack = ['47','302','341','348','625','628','703','718,','726','727','728','729','711'];
    if((in_array($_SESSION['user_info']['id_usuario'], $haystack))){
        echo    '<div class="row">';
        echo    '   <div class="col-md-12"> ';
        echo    '      <a href="?pg=29" class="btn btn-primary">Consultar Administrativo</a>';
        echo    '   </div>';
        echo    '</div>';    
    }
endif;
echo '<br>';
echo'<div class="panel panel-primary ">';
echo '<div class="panel-heading">Comércial / Clientes</div>';
echo '<div class="panel-body">';
if (empty($tipo_consulta)) :
    if (!empty($dadosClientes)) {
        echo'<div class="well well-sm">';
        echo'<span class="glyphicon glyphicon-warning-sign"></span> => Em Análise &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo'<span class="glyphicon glyphicon-pencil"></span> => Cadastrar Cliente &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo'<span class="glyphicon glyphicon-trash"></span> => Excluir';
        echo'</div>';
        echo'<div class="table-responsive">';
        echo'<table class="table table-hover  table-striped table-bordered dataTableBootstrapSemOrdem">';
        echo'<thead>';
        echo'<tr>';
        echo'<th>Data</th>';
        echo'<th>Captação</th>';
        echo'<th>CPF | CNPJ</th>';
        echo'<th>Cliente</th>';
        echo'<th>Motivo</th>';
        echo'<th>Tipo Cadastro</th>';
        echo'<th>Status da Transação</th>';
        echo'<th width="5%">Ações</th> ';
        echo'</tr>';
        echo'</thead>';
        echo'<tbody>';
     foreach ($dadosClientes as $k => $li) :
            $cliente_id = !empty($li ['id_cliente']) ? $li ['id_cliente'] : NULL;
            $cliente_nome = Funcoes::addCaracter($li['nome_cliente']);
            $cliente_motivo_reprovacao = Funcoes::addCaracter($li['motivo_reprovacao_cliente']);
            $cliente_cnpjcpf = !empty($li ['cnpjcpf_cliente']) ? $li ['cnpjcpf_cliente'] : NULL;
            $cliente_data_solicitacao = Funcoes::formataData($li ['data_solicitacao_cliente']);
            $cliente_tipo_status_avaliacao = !empty($li ['tipo_status_avaliacao']) ? $li ['tipo_status_avaliacao'] : NULL;
            $cliente_tipo_cadastro = strtoupper($li ['tipo_cadastro']);
            $cliente_id_contrato = !empty($li ['id_contrato']) ? $li ['id_contrato'] : NULL;
            $cliente_id_cliente_contrato = !empty($li ['id_cliente_contrato']) ? $li ['id_cliente_contrato'] : NULL;
            //Responsavel por buscar status da transacao:
            $statusPagSeguro = $PagSeguro->buscarUltimoStatusTransacao($cliente_id_cliente_contrato);
            if (!$statusPagSeguro === false) {
                $statusTransacao = $statusPagSeguro->statusTransacao;
                //Gerar comprovante de pagamento :
                if ($statusPagSeguro->statusTransacao == 'Paga') {
                    $anexo->GerarComprovantePagamento($cliente_id_cliente_contrato, $cliente_id);
                }
            } else {
                $statusTransacao = 'Aguardando Pagamento';
            }
            $servidor = $_SERVER["SERVER_NAME"] . ':9093' ;
            $rota_captacao = '<a href=" http://' .  $servidor . '/gpi/index.php?pg=19&id=' . $li['id_captacao'] . '&acao=visualizar&voltar=18#tabs-1">Visualizar Captação</a>';
            echo'<tr>';
            echo'<td>' . $cliente_data_solicitacao . '</td>';
            echo'<td>' . $rota_captacao . '</td>';
            echo'<td>' . $cliente_cnpjcpf . '</td>';
            echo'<td>' . $cliente_nome . '</td>';
            echo'<td style="color:#F00">' . $cliente_motivo_reprovacao . '</td>';
            echo'<td>' . $cliente_tipo_cadastro . '</td>';
            echo'<td><b>' . $statusTransacao . '</b></td>';
            echo'<td>';
            echo '<table width="100%">';
            echo '<tr>';
            echo'<td>';
            if ($cliente_tipo_status_avaliacao == 'APROVADO') :
                echo'<a href="index.php?pg=15&id=' . $cliente_id . '&tipoCadastro=' . $cliente_tipo_cadastro . '&id_cliente_contrato=' . $cliente_id_cliente_contrato . '" class="btn btn-xs btn-primary"  title="Cadastrar Cliente" >';
                echo'   <span class="glyphicon glyphicon-pencil"></span>';
                echo'</a>';
            endif;
            echo'</td>';
            if ($cliente_tipo_status_avaliacao === "APROVADO") :
                echo'<td>';
                $ssdfsd = $cliente_id . '_' . $cliente_id_cliente_contrato;
                echo "<a data-toggle=\"modal\" data-target=\"#_modalEnviarSolicitacaoDePagamento\"  onClick=\" modalEnviaPagamento('" . $ssdfsd . "')\" title=\"Enviar Pagamento\"  href=\"javascript:void(0)\"  class=\"btn btn-xs  btn-info\">";
                echo '<span class="glyphicon glyphicon-envelope"></span>';
                echo '</a>';
                echo'</td>';
                echo'<td>';
                if ($statusPagSeguro != false && !$statusPagSeguro->statusTransacao == 'Paga'):
                    echo '<a  data-toggle="modal" data-target="#_modalVisualizarLog" onClick=" visualizarLogs(' . $cliente_id_cliente_contrato . ')"  href="javascript:void(0)" class="btn btn-xs btn-warning" title=" Detalhes da Transação" >';
                    echo '<span class="glyphicon  glyphicon-eye-open"></span>';
                    echo '</a>';
                endif;
                echo '</td>';
            endif;
            echo'<td>';
            if ($cliente_tipo_status_avaliacao == 'APROVADO') :
                echo '<form action="modulos/captacao/src/controllers/captacao.php" method="post" class="deleteConsulta">';
                echo '  <input type="hidden" name="id_cliente" value="' . $cliente_id . '">';
                echo '  <input type="hidden" name="id_cliente_contrato" value="' . $cliente_id_cliente_contrato . '">';
                echo '  <input type="hidden" name="acao" value="deletarConsulta">';
                echo '  <button type="submit"  title="Excluir consulta"  class="btn btn-xs  btn-danger ">';
                echo '      <span class="glyphicon glyphicon-trash"></span>';
                echo '  </button>';
                echo '</form>';
            endif;
            echo '</td>';
            echo '<td>';
            if ($cliente_tipo_status_avaliacao == 'REPROVADO') :
                echo '<form action="modulos/captacao/src/controllers/captacao.php" method="post">';
                echo '  <input type="hidden" name="id_cliente" value="' . $cliente_id . '">';
                echo '  <input type="hidden" name="id_cliente_contrato" value="' . $cliente_id_cliente_contrato . '">';
                echo '  <input type="hidden" name="acao" value="deletarConsulta">';
                echo '  <button type="submit" title="Excluir consulta"  class="btn btn-xs    btn-danger ">';
                echo '      <span class="glyphicon glyphicon-trash"></span>';
                echo '  </button> ';
                echo '</form>';
            endif;
            echo '</td>';
            echo '<td>';
            if ($cliente_tipo_status_avaliacao == "EM ANALIZE") :
                echo'<a href="javascript:void(0)" class="btn btn-xs  btn-warning" title="Aguardando Resposta.">';
                echo '  <span class="glyphicon glyphicon-warning-sign"></span>';
                echo '</a>';
            endif;
            echo '</td>';
            echo'</tr>';
            echo '</table>';
            echo '</td>';
            echo '</tr>';
        endforeach;
        echo'</tbody>';
        echo'</table>';
        echo'</div>';
        $objPaginacao->MontaPaginacao();
    }else {
        Funcoes::Nregistro();
    }
    echo'</div>';
    echo'</div>';
endif;
//MODULO : integracaoPagSeguro:
include_once "modulos/captacao/src/views/captacao/modals/_modalEnviarSolicitacaoDePagamento.php";
include_once "modulos/captacao/src/views/captacao/modals/_modalVisualizarLog.php";
include_once "modulos/integracaoPagSeguro/application/controller/FuncoesJsController.php";
