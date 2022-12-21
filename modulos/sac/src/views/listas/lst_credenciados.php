<div class="panel panel-primary">
    <div class="panel-heading "> Lista Credenciados</div>
    <div class="panel-body"> 
    	<?php if(!empty($lista)){ ?>
    		<table class="table table-bordered table-hover table-striped dataTableBootstrap">
    			<thead>
    				<tr>
    					<th width="15%">Razão Social</th>
    					<th>Nome Fantasia</th>
    					<th>CPF/CNPJ</th>
    					<th>I.E./RG</th>
    					<th>Status</th>
    					<th>Ação</th>
    				</tr>
    			</thead>
    			<tbody>
    				<?php foreach($lista as $k=>$li){ ?>
    					<tr>
    						<td><?=$li->get("credenciado_razao_social");?></td>
    						<td><?=$li->get("credenciado_nome_fantasia");?></td>
    						<td><?=$li->get("credenciado_cpfcnpj");?></td>
    						<td><?=$li->get("credenciado_rg");?></td>
    						<td><?=$li->get("credenciado_status");?></td>
    						<td align="center" width="5%"><a href="index.php?pg=38&acao=listarCredenciado&id=<?=$li->get("credenciado_id");?>#cadastrarCredenciado" class="btn btn-info"><?=!empty($p) ? "Visualizar" : "Editar";?></a></td>
    					</tr>
					<?php  } ?>
    			</tbody>
    			<tfoot>
    				<tr><td colspan="6">Registros: <?=$total;?></td></tr>
    			</tfoot>
    		</table>
    	<?php 
    		$objPaginacao->MontaPaginacao();
		} else {
    			Funcoes::Nregistro();
    	}?>
    	</div>
</div>