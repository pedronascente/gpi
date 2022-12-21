<?php if(!empty($id)){?>
<div class="panel panel-primary">
    <div class="panel-heading ">Contatos</div>
    <div class="panel-body">
           <?php  
		   if(!empty($listaContato)):?>
        <div class="table-reponsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <td>Nome</td>
                        <td>Email</td>
                        <td>Telefone(1)</td>
                        <td>Telefone(2)</td>
                        <td>Telefone(3)</td>
                         <?php if(empty($p)){?>
                        <td>Editar</td>
                        <td>Deletar</td>
                        <?php }?>
                    </tr>
                </thead>
                         <?php
                         foreach ( $listaContato as $k => $li ) :
                         ?>
                <tr align="center">
                    <td><?=$li['contato_nome'];?></td>
                    <td><?=$li['contato_email1'];?></td>
                    <td><?=$li['contato_telefone1'];?></td>
                    <td><?=$li['contato_telefone2'];?></td>
                    <td><?=$li['contato_telefone3'];?></td>
                    <?php if(empty($p)){?>
                    <td width="2%">
                        <a id="modulos/sac/src/views/formularios/modalInsertContato.php?id=<?=$li["contato_id"];?>&acao=EditarContato&nivel=<?=$nivelContato;?>" class="modalOpen botaoLoad btn btn-sm btn-info" data-target="#modal"> 
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                    </td>
                    <td width="2%">
                        <a href="modulos/sac/src/controllers/sac.php?id=<?=$li["contato_id"];?>&id_cliente=<?=$id;?>&acao=DeleteContato&contato_nivel=<?=$nivelContato;?>" class="btn btn-danger btn-sm apagarC botaoLoad"> 
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </td>
                    <?php }?>
                </tr>
                       <?php
                        endforeach;
                        ?>
            </table>
        </div>
			 <?php
						
			 else :
					Funcoes::Nregistro ();
			endif;
		?>
		 <?php if(empty($p)){?>
            <a id="modulos/sac/src/views/formularios/modalInsertContato.php?id_cliente=<?=$id;?>&acao=add&nivel=<?=$nivelContato;?>"  class="modalOpen btn btn-default" data-target="#modal">
                Adicionar Contato
            </a>
        <?php }?>	
    </div>
</div>
<?php }?>