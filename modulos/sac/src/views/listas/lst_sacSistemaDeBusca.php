<?php if(!empty($dadosDoCliente)){?>
    <table class="table table-bordered table-hover table-striped dataTableBootstrapSemOrdem">
		<thead>
			<tr>
				<th width="5%">Id</th>
	            <th>Placa Veículo</th>
	            <th>CPF / CNPJ</th>
				<th>Nome Cliente</th>
				<th>Editar</th>
			</tr>
		</thead>
		<tbody>
	        <?php
			foreach ( $dadosDoCliente as $k => $li ) {
	
			$complemento = $selectFiltro == "os" ? "&opOs=EditarOs&id_os={$li['veiculos_os_id']}" : "";
			$id_cliente = !empty($li['id_cliente']) ? $li['id_cliente'] : "";
			$placa = !empty($li['placa']) ? $li['placa'] : "-";
			$cnpjcpf_cliente = !empty($li['cnpjcpf_cliente']) ? $li['cnpjcpf_cliente'] : "";
			$nome_cliente = !empty($li['nome_cliente']) ? $li['nome_cliente'] : "";
			?>
			<tr>
				<td><?=$id_cliente;?></td>
				<td><?=$placa;?></td>
				<td><?=$cnpjcpf_cliente;?></td>
				<td><?=$nome_cliente;?></td>
				<td  width="2%" align="center">
					<a href="index.php?pg=10&id=<?=$id_cliente;?>&acao=ListarCliente#cliente" class="btn btn-sm btn-info">
						<span class="glyphicon glyphicon-pencil"></span>
					</a>
				</td>
			</tr>
			<?php }?>
		</tbody>
		<tfoot>
       		<tr><td colspan="5">Registros encontrados: <?=$total;?></td></tr>   
   		</tfoot>
	</table>
<?php 
	$objPaginacao->MontaPaginacao();
} else {
	Funcoes::Nregistro ();
}
?>