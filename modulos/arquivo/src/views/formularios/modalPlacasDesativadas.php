<?php 
include_once '../../../../../Config.inc.php';
$placa = filter_input(INPUT_GET, "placa");
$veiculo = (new Arquivo)->selectVeiculoJaCasdastrado($placa);
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
             <h4 class="modal-title">VEÍCULO JÁ CADASTRADO NO SISTEMA!</h4>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
        <?php if(!empty($veiculo['id_veiculo'])){?>
        	<table class="table table-bordered table-hover table-striped">
        		<tr>
        			<th>Placa</th>
        			<th>Cliente</th>
        			<th>CNPJ/CPF</th>
        			<th></th>
        		</tr>
        		<tr>
        			<td><?=!empty($veiculo['placa']) ? $veiculo['placa'] : "";?></td>
        			<td><?=!empty($veiculo['nome_cliente']) ? $veiculo['nome_cliente'] : "";?></td>
        			<td><?=!empty($veiculo['cnpjcpf_cliente']) ? $veiculo['cnpjcpf_cliente'] : "";?></td>
        			<td width="5%" align="center">
        				<form id="formDesativarVeiculo">
        					<input type="hidden" name="id_veiculo" value="<?=$veiculo['id_veiculo'];?>">
        					<input type="hidden" name="veiculo_status" value="2">
        					<input type="submit" class="btn btn-danger" value="Desativar">
        					<input type="hidden" name="acao" value="desativarVeiculo">
        				</form>
        			</td>
        		</tr>
        	</table>
       	<?php }?>
        </div>
    </div>
</div>
<script>
$(function(){
	$("#formDesativarVeiculo").submit(function(e){
		e.preventDefault();

		var formulario = $(this).serialize();

		$.ajax({
            url: "modulos/arquivo/src/controllers/arquivo.php",
            dataType: 'json',
            data: formulario,
            type: 'post',
            success: function (obj) {
                $("#modal").modal("hide");
            }, error: function () {
                alert("Erro ao enviar requisição!");
            }
        })
		
	});
});
</script>