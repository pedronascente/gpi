<?php
include_once '../../../../../../Config.inc.php';

$idURL = (int) \filter_input(\INPUT_GET, 'id');
$veiculos = new Veiculos ();
$veiculo = $veiculos->select($idURL);
$veiculo_id = !empty($veiculo ['id_veiculo']) ? $veiculo ['id_veiculo'] : NULL;
$veiculo_marca = !empty($veiculo ['marca']) ? $veiculo ['marca'] : NULL;
$veiculo_modelo = !empty($veiculo ['modelo']) ? $veiculo ['modelo'] : NULL;
$veiculo_cor = !empty($veiculo ['cor']) ? $veiculo ['cor'] : NULL;
$veiculo_chassis = !empty($veiculo ['chassis']) ? $veiculo ['chassis'] : NULL;
$veiculo_ano = !empty($veiculo ['ano']) ? $veiculo ['ano'] : NULL;
$veiculo_renavam = !empty($veiculo ['renavam']) ? $veiculo ['renavam'] : NULL;
$veiculo_placa = !empty($veiculo ['placa']) ? $veiculo ['placa'] : NULL;
$veiculo_obs = !empty($veiculo ['obs']) ? $veiculo ['obs'] : NULL;
$veiculo_tipo_bateria = !empty($veiculo ['tipo_bateria']) ? $veiculo ['tipo_bateria'] : NULL;
$veiculo_equipamento = !empty($veiculo ['equipamento']) ? $veiculo ['equipamento'] : NULL;
$veiculo_taxa_instalacao = !empty($veiculo ['taxa_instalacao']) ? $veiculo ['taxa_instalacao'] : NULL;
$veiculo_taxa_monitoramento = !empty($veiculo ['taxa_monitoramento']) ? $veiculo ['taxa_monitoramento'] : NULL;
$veiculo_valor_protecao = !empty($veiculo ['valor_protecao']) ? $veiculo ['valor_protecao'] : NULL;
$valor_protecao_assistencial = !empty($veiculo ['valor_protecao_assistencial']) ? $veiculo ['valor_protecao_assistencial'] : NULL;
$veiculo_combustivel = !empty($veiculo ['combustivel']) ? $veiculo ['combustivel'] : NULL;
switch($veiculo_combustivel){
    case 1: $veiculo_combustivel = "Combustível";break;
    case 2: $veiculo_combustivel = "Álcool";break;
    case 3: $veiculo_combustivel = "Bicombustível"; break;
    case 4: $veiculo_combustivel = "Diesel"; break;
    case 5: $veiculo_combustivel = "GNV";break;
    case 6: $veiculo_combustivel = "Gasolina";break;
}
$veiculo_seguro = ($veiculo ['seguro'] == 's') ? 'Sim' : 'Não';
$veiculo_tipo_seguro = $veiculo ['tipo_seguro'];
$bloqueio = ($veiculo ['bloqueio']=='s')?'SIM':'NÃO';

?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="modalClose close" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Dados Veiculos</h4>
        </div>			
        <div class="modal-body">
            <table  class="table table-striped"  borde="1" width="100%">
                <tr>
                    <td><b>PLACA:</b><br><?=$veiculo_placa;?></td>
                    <td><b>CHASSI:</b><br><?=$veiculo_chassis;?></td>
                    <td><b>MARCA  / MODELO:</b><br><?=$veiculo_marca;?>/<?=$veiculo_modelo;?></td>
                </tr>
                <tr>
                    <td><b>RENAVAN:</b><br><?=$veiculo_renavam;?></td>
                    <td><b>ANO:</b><br><?=$veiculo_ano;?></td>
                    <td><b>COR:</b><br><?=$veiculo_cor;?></td>
                </tr>
                <tr>
                    <td><b>BATERIA:</b><br><?=$veiculo_tipo_bateria;?></td>
                    <td><b>BLOQUEIO:</b><br><?=$bloqueio;?></td>
                    <td><b>COMBUSTIVEL:</b><br><?=$veiculo_combustivel;?></td>
                </tr>
                <tr>
                    <td colspan="3"><b>SERVIÇO:</b><br><?=$veiculo_tipo_seguro;?></td>
                </tr>
                <?php
                     if($veiculo_tipo_seguro=='Rastreamento'){
                        echo'
                        <tr>    
                            <td><B>DESCRIÇÃO:</B><br>' .  strtoupper($veiculo_tipo_seguro) .'</td>
                            <td><B>TAXA MENSAL:</B><br> R$'.$veiculo_taxa_monitoramento.'</td>     
                            <td><B>TAXA HABILITAÇÃO  :</B><br> R$'.$veiculo_taxa_instalacao.'</td>
                        </tr>';  
                    }     
                    if($veiculo_tipo_seguro=='Rastreamento + Proteção veicular'){
                        echo'
                        <tr>    
                            <td><B>DESCRIÇÃO:</b><br>RASTREAMENTO</td>
                            <td><b>TAXA MENSAL:</b><br> R$'.$veiculo_taxa_monitoramento.'</td> 
                            <td><b>TAXA HAbILITAÇÃO  :</b><br> R$'.$veiculo_taxa_instalacao.'</td>
                        </tr>    
                        <tr>    
                            <td><b>DESCRIÇÃO:</b><br> PROTEÇÃO VEICULAR</td>
                            <td><b>TAXA MENSAL:</b><br> R$'.$veiculo_valor_protecao.'</td>
                            <td></td>
                        </tr>';  
                    }         
                    if($veiculo_tipo_seguro=='Rastreamento + Proteção veicular + Assistência Veicular'){
                        echo'
                        <tr>    
                            <td><b>DESCRIÇÃO:</b><br>RASTREAMENTO</td>
                            <td><b>TAXA MENSAL:</b><br> R$'.$veiculo_taxa_monitoramento.'</td> 
                            <td><b>TAXA HAbILITAÇÃO  :</b><br> R$'.$veiculo_taxa_instalacao.'</td>
                        </tr>
                        <tr>    
                            <td><b>SERVIÇO:</b><br> PROTEÇÃO VEICULAR</td>
                            <td><b>TAXA MENSAL:</b><br> R$'.$veiculo_valor_protecao.'</td> 
                            <td></td> 
                        </tr>
                        <tr>    
                            <td> <b>SERVIÇO:</b><br> ASSISTÊNCIA VEICULAR</td>
                            <td><b>TAXA MENSAL:</b><br> R$'.$valor_protecao_assistencial.'</td> 
                            <td></td> 
                        </tr>';  
                    }      
                ?>
                <tr>
                    <td colspan="3"><b>OBSERVAÇÃO</b><br><?=$veiculo_obs;?></td>
                </tr>
                
                <tr>
                    <td  colspan="3"><br><button type="button" class="btn btn-danger modalClose">Fechar</button></td>
                </tr>
            </table>	   
        </div>
    </div>
<script type="text/javascript" language="javascript">
  $(function () {
        $(".modalClose").click(function(){
            $("#modalVeiculos").modal("hide");
        });
  });
</script>