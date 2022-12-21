<?php
header('Content-Type: text/html; charset=utf-8');
$acao = isset($_GET['acao']) ? $_GET['acao'] : NULL;
if(!$acao){
    die('Você não tem permissão para acessar está pagina!');    
}
include_once ("../../../../Config.inc.php");
$contrato  = new Contratos();
switch ($acao){
    case 'excel' :
        $ArrayListResult = $contrato->exportarContratoCupomValido($_GET['dt_inicial'],$_GET['dt_final']);
        if(empty($ArrayListResult)){
            echo '<center>'; 
                echo '<br><br><h2>Nenhum registro encontrado!</h2><br><br>'; 
                echo "<a href=\"/gpi/index.php?pg=17\">Voltar</a>";
            echo '</center>';
            die();
        }        
        $html = '                                                                    
        <table width="100%" border="1">
            <caption>
                <h2>Contratos de Clientes com Cupom de Desconto. </h2>
            </caption>
            <thead>
                <tr align="left">
                    <th>Data</th>
                    <th>Cupom de Desconto</th>
                    <th>Número / Contrato</th>
                    <th>Status</th>
                </tr>    
            </thead>
            <tbody>';
                if ($ArrayListResult):
                      foreach ($ArrayListResult as $contrato) :
                        $data  =  date('d/m/Y', strtotime($contrato['DATA_ENVIO']));
                        $lista_status_contrato = $contrato['STATUS'] ;
                        switch ($lista_status_contrato) {
                            case "1": $status_contrato = "Novo";break;
                            case "2": $status_contrato = "Reprovado";break;
                            case "3": $status_contrato = "Finalizado";break;
                        }
                        $html .= '
                        <tr align="left">
                            <th>'.$data.'</th>
                            <th>'.$contrato["CUPOM"].'</th>
                            <th>'.$contrato["NUMERO_CONTRATO"].'</th>
                            <th>'.$status_contrato.'</th>
                        </tr>';
                    endforeach;
                endif;
                $html .= '
            </tbody>
        </table>';
        Funcoes::exportExel($html, "contratoComCuponsValidos.xls");
    break;

    /*
     * @Description MEHOD RESPONSAVEL POR EXPORTAR CONTRATOS QUE ATENDEM AS SEGUINTES REGRAS.
     * @param status_contrato = 3;
     * @param data_finalizacao_contrato = data_inicial
     * @param data_finalizacao_contrato = data_fim
     * @return excel
     */
    case'excel2':
        $ArrayListResult = $contrato->getTempoDeFinalizacao($_GET['dt_inicial'],$_GET['dt_final']);
        if(empty($ArrayListResult)){
            echo '<center>'; 
                echo '<br><br><h2>Nenhum registro encontrado!</h2><br><br>'; 
                echo "<a href=\"/gpi/index.php?pg=17\">Voltar</a>";
            echo '</center>';
            die();
        }        
        $html = '                                                                    
        <table width="100%" border="1">
            <caption>
                <h2>Contratos Finalizados </h2>
            </caption>
            <thead>
                <tr align="left">
                    <th>NUMERO CONTRATO</th>
                    <th>CLIENTE</th>
                    <th>DATA CONTRATO GERADO</th>
                    <th>DATA CONTRATO FINALIZADO</th>
                    <th>TOTAL EM DIA</th>
                    <th>TOTAL EM HORAS</th>
                </tr>    
            </thead>
            <tbody>';
                if ($ArrayListResult):
                      foreach ($ArrayListResult as $contrato) :
                        $html .= '
                        <tr align="left">
                           <th>'.$contrato["NUMERO_CONTRATO"].'</th>
                           <th>'.$contrato["CLIENTE"].'</th>
                           <th>'.$contrato["DATA_CONTRATO_GERADO"].'</th>
                           <th>'.$contrato["DATA_CONTRATO_FINALIZADO"].'</th>
                           <th>'.$contrato["TOTAL_EM_DIA"].'</th>
                           <th>'.$contrato["TOTAL_EM_HORAS"].'</th>
                        </tr>';
                    endforeach;
                endif;
                $html .= '
            </tbody>
        </table>';
               
        Funcoes::exportExel($html, "relatorio_contrato_finalizado_tempo_gasto.xls");
    break;





}