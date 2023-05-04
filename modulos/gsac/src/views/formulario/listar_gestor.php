<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading ">Gestores</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<a href="/gpi/index.php?pg=65" class="btn btn-primary">Cadastrar Gestor</a>
					</div>
				</div>

				<hr>
				<div class="row">
					<?php
					if ($gestores) {
						foreach ($gestores as $g) {
					?>
							<div class="col-md-4">
								<div class="panel panel-primary">
									<div class="panel-heading "><?= $g->gestor; ?></div>
									<div class="panel-body">
										( <?= $g->total_cliente; ?> ) Registros encontrados.
										<hr>
										<a href="/gpi/index.php?pg=66&gestor_id=<?= $g->id; ?>" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-pencil"></span> Editar Gestor</a>
										<a href="javascript:void(0)" data-id="<?= $g->id; ?>" class="btn  btn-sm btn-danger btn_excluir_gestor">Excluir Gestor</a>
										<a href="/gpi/index.php?pg=60&coluna=gestor&busca=<?= $g->gestor ?>" class="btn  btn-sm btn-warning">Visualizar Cliente</a>
									</div>
								</div>
							</div>
					<?php
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javaScript">
	$(function(){
		$('.btn_excluir_gestor').click('', function(){
			var id = $(this).attr('data-id');
			if(confirm('Deseja excluir este arquivo?')){
				$(this).attr('href', function(){
				   return  'index.php?pg=81&id='+id;
 				});
			}
		});
	});
</script>