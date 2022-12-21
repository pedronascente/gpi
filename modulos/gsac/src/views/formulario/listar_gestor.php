<div class="row">
	<div class="col-md-12">		
		<div class="panel panel-primary">
			<div class="panel-heading ">Gestores</div>
			<div class="panel-body">
				<div class="row">
					<?php
					if($gestor)
					{	
					    foreach($gestor as $g)
                        {
						    ?>
							<div class="col-md-4">					
								<div class="panel panel-primary">
									<div class="panel-heading "><?=$g->gestor;?></div>
									<div class="panel-body">
										( <?=$g->total_cliente;?> ) Registros encontrados. <hr>
										<a href="<?=$url?>/gpi/index.php?pg=60&coluna=gestor&busca=<?=$g->gestor?>" class="btn btn-danger">Visualizar Clientes</a>
										
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




