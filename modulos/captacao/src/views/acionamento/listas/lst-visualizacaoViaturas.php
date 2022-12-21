<?php
include_once 'modulos/captacao/src/controllers/acionamentoVerificacao.php';
$pagina = \filter_input(INPUT_GET,'pgAnterior',FILTER_DEFAULT);
?>
<div class="panel panel-primary">
    <div class="panel-heading "> Acionamento Viaturas - Visualização    </div>
    <div class="panel-body"> 
        <table  class="table table-striped  table-hover table-responsive ">
            <tbody>
                <tr>
                    <td><strong>Código:</strong></td>	
                    <td><?=(!empty($viaturas_id)) ? $viaturas_id : ""; ?></td>					
                </tr>
                <tr>
                    <td><strong>Data Atendimento:</strong></td>
                    <td><?=(!empty($viaturas_data)) ? $viaturas_data : ""; ?></td>
                </tr>
                <tr>
                    <td><strong>Hora Atendimento:</strong></td>
                    <td><?=(!empty($viaturas_hora)) ? $viaturas_hora : ""; ?></td>
                </tr>
                <tr>
                    <td><strong>Atendente:</strong></td>
                    <td><?=(!empty($viaturas_atendente)) ? $viaturas_atendente : ""; ?></td>
                </tr>
                <tr>
                    <td><strong>Conta:</strong></td>
                    <td><?=(!empty($viaturas_conta)) ? $viaturas_conta : ""; ?></td>
                </tr>		
                <tr>
                    <td><strong>Qual zona disparou?</strong></td>	
                    <td><?= verificaOptions("zona1ouqualquer", $zona1ouqualquer); ?></td>					
                </tr>
                <tr>
                    <td><strong>Numero de disparos?</strong></td>
                    <td><?=verificaOptions("disparos", $disparos); ?></td>
                </tr>
                <tr>
                    <td><strong>Numero de zonas que dispararam?</strong></td>
                    <td><?=verificaOptions("zonas", $zonas); ?></td>
                </tr>
                <tr>
                    <td><strong>Todas as zonas que dispararam restauraram?</strong></td>
                    <td><?=verificaOptions("todaszonas", $todaszonas); ?></td>
                </tr>
                <tr>
                    <td><strong>A zona que disparou possui histórico de disparo nos ultimos 10 dias?</strong></td>
                    <td><?=verificaOptions("trintadias", $trintadias); ?></td>
                </tr>
                <tr>
                    <td><strong>Está acontecendo temporal(ventos fortes, raios, trovões ou chuva muito forte)?</strong></td>
                    <td><?= verificaOptions("temporal", $temporal); ?></td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Pontuação?</strong></td>							
                </tr>						
                <tr>
                    <td colspan="2">
                        <font size="5" color="<?=(!empty($valores["cor"])) ? $valores["cor"] : ""; ?>">
                            <?=(!empty($pontos)) ? $pontos : "" ?> Pontos -
                            <?=(!empty($valores["message"])) ? $valores["message"] : "" ?>  
                        </font>							 
                    </td>							
                </tr>						
            </tbody>	
        </table>	
        <div class="row">
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                <a href="fpdf/acionamento_viaturas/index.php?id=<?= (!empty($viaturas_id)) ? $viaturas_id : ""; ?>" class="btn btn-success " id="btn_gerarPDF">
                    <span class="glyphicon glyphicon-print"></span>  Imprimir
                </a>
                <a href="?pg=<?=$pagina; ?>#tab2" class="btn btn-info">Voltar</a>				
            </div>            
        </div>
    </div>
</div>