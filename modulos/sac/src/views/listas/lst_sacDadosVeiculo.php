<div class="panel panel-primary">
    <div class="panel-heading ">Veículos</div>
    <div class="panel-body">
    	<div class="row">
    		<div class="col-xs-12 col-sm-6 col-lg-4 col-md-5">
		    	<select name="status_veiculo" class="form-control" id="statusVeiculo">
		    		<option value="1" <?=$statusVeiculo == 1 ? "selected" : "";?>>Ativos</option>
		    		<option value="2" <?=$statusVeiculo == 2 ? "selected" : "";?>>Inativos</option>
		    	</select>
		    	<input type="hidden" id="raCliente" value="<?=$id;?>">
		    </div>
    	</div>
    	<br>
    	<a id="modulos/sac/src/views/formularios/modalVeiculo.php?acao=cadastrarVeiculo&cliente_ra=<?=$id;?>" class="btn btn-default botaoLoad modalOpen" data-target="#modal">Adicionar</a><br><br>
	       <?php if(!empty($listaVeiculos)):?>
	     <div class="well well-sm">
			<span class="glyphicon glyphicon-pencil"></span> => Editar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span class="glyphicon glyphicon-share"></span> => Trocar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span class="glyphicon glyphicon-floppy-save"></span> => Desativar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span class="glyphicon glyphicon-floppy-open"></span> => Ativar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span class="glyphicon glyphicon-trash"></span> => Excluir
		</div>  
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Módulo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Renavam</th>
                    <th>Chassis</th>
                    <th width="10%">Ação</th>
                </tr>
            </thead>    
            <tbody>
	                <?php foreach ( $listaVeiculos as $k => $li ) { ?>
	                <?php 
	                $id_v 		= !empty($li['id_veiculo']) ? $li['id_veiculo'] : "";
	                $placa 		= !empty($li['placa']) 		? $li['placa'] 		: "";
	                $marca 		= !empty($li['marca']) 		? $li['marca'] 		: "";
	                $modelo 	= !empty($li['modelo']) 	? $li['modelo'] 	: "";
	                $renavam 	= !empty($li['renavam']) 	? $li['renavam'] 	: "";
	                $chassis 	= !empty($li['chassis']) 	? $li['chassis'] 	: "";
	                $modulo 	= !empty($li['modulo']) 	? $li['modulo'] 	: "";
	                
	                ?>
                <tr align="center">
                    <td><?=$placa;?></td>
                    <td><?=$modulo;?></td>
                    <td><?=$marca;?></td>
                    <td><?=$modelo;?></td>
                    <td><?=$renavam;?></td>
                    <td><?=$chassis;?></td>
                    <td>
                    	<table  width='180px'>
                    		<tr align="center">
                    			<td>
			                        <a href="index.php?pg=10&id_veiculo=<?=$id_v;?>&acao=ListarCliente&id=<?=$li['cliente_ra'];?>#veiculos" class="btn  btn-sm btn-info botaoLoad"> 
			                            <span class="glyphicon glyphicon-pencil"></span>
			                        </a>
		                       </td>
		                       <?php if(empty($p)){?>
			                       <?php if($li['veiculo_status'] != 2){?>
			                       		<td>
					                        <a id="modulos/sac/src/views/formularios/modalVeiculo.php?id_veiculo_antigo=<?=$id_v;?>&acao=trocarVeiculo" class="btn  btn-sm btn-default botaoLoad modalOpen" data-target="#modal"> 
					                            <span class="glyphicon glyphicon-share"></span>
					                        </a>
					                    </td>
					                    <td>
					                        <a id="modulos/sac/src/views/formularios/modalMotivoStatus.php?id_veiculo=<?=$id_v;?>&status=2" class="btn  btn-sm btn-primary botaoLoad modalOpen" data-target="#modal"> 
					                            <span class="glyphicon glyphicon-floppy-save"></span>
					                        </a>
			                       		</td>
	                        		<?php } else {?>
	                        		 	<td>
					                        <a id="modulos/sac/src/views/formularios/modalMotivoStatus.php?id_veiculo=<?=$id_v;?>&status=1" class="btn  btn-sm btn-success botaoLoad modalOpen" data-target="#modal"> 
					                            <span class="glyphicon glyphicon-floppy-open"></span>
					                        </a>
			                       		</td>
	                        		<?php }?>
	                        		<?php if(empty($li['id_cliente'])){?>
	                        			<td>
					                        <a id="<?=$id_v;?>" class="btn  btn-sm btn-danger botaoLoad deletarVeiculo"> 
					                            <span class="glyphicon glyphicon-trash"></span>
					                        </a>
			                       		</td>
	                        		<?php }?>
	                        	<?php } ?>	
                        	 </tr>
                        </table>
                    </td>
                </tr>
	      <?php } ?>
            </tbody>
        </table>
	 <?php 
	 	$objPaginacao3->MontaPaginacao();
	 	else :
		Funcoes::Nregistro ();
	endif;
	?>
    </div>
</div>
