<div class="panel panel-primary">
    <div class="panel-heading "> Atualizacões Ramais</div>
    <div class="panel-body">
	<div class="well well-sm">
		<span class="glyphicon glyphicon-eye-open"></span> => Visualizar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="glyphicon glyphicon-ok"></span> => Aprovar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="glyphicon glyphicon-remove"></span> => Reprovar
	</div>
<?php if(!empty($listaAtualizacoes)){?>
		<div class="table-responsive">
            <table class="table table-bordered table-hover table-striped dataTableBootstrapSemOrdem">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Ramal</th>
                        <th>Nome</th>
                        <th>Base</th>
                        <th>Setor</th>
                        <th>Telefone</th>
                        <th>Status</th>
                        <th>E-mail</th>
                        <th>Data Solicitação</th>
                        <th>Visualizar</th>
                        <th>Situação</th>
                    </tr>
                </thead>
                <tbody>
                	<?php foreach($listaAtualizacoes as $a){
						$id 					= !empty($a['id']) 								? $a['id']  												: "";  		
						$ramalId 				= !empty($a['ramal_id']) 						? $a['ramal_id']  											: "";  		
						$ramalNovo 				= !empty($a['ramal_ramal']) 					? $a['ramal_ramal']  									: $a['ramalAntigo'];  		
						$ramalNome 				= !empty($a['ramal_nome_usuario']) 				? $a['ramal_nome_usuario']  								: "";  		
						$ramalBase 				= !empty($a['base_nome']) 						? $a['base_nome']  											: "";  		
						$ramalSetor    			= !empty($a['setor_local']) 					? $a['setor_local']  										: "";  		
						$ramalTelefone 			= !empty($a['ramal_telefone']) 					? $a['ramal_telefone']  									: "";  		
						$ramalStatus 			= $a['ramal_status_id'] != 1 					? "Desatualizado" 											: "Atualizado";  		
						$ramalEmail 			= !empty($a['ramal_email']) 					? $a['ramal_email']  										: "";  		
						$ramalData 				= !empty($a['ramal_dt_solicitacao']) 			? Funcoes::formataData($a['ramal_dt_solicitacao'])  		: "";  		
						$ramalSituacao 			= !empty($a['ramal_status_solicitacao']) 		? $a['ramal_status_solicitacao']  							: "";  		
						$ramalNivel				= !empty($a['ramal_nivel_solicitacao']) 		? $a['ramal_nivel_solicitacao']  							: "";  		
						$ramalAntigo 			= ($a['ramalAntigo'] != $ramalNovo)				? 'style="color:#F00"' 										: "";  		
						$ramalNomeAntigo 		= ($a['nomeAntigo'] != $ramalNome)				? 'style="color:#F00"' 										: "";  		
						$ramalBaseAntigo 		= ($a['baseAntiga'] != $a['ramal_id_base']) 	? 'style="color:#F00"' 										: "";  		
						$ramalSetorAntigo 		= ($a['setorAntigo'] != $a['ramal_id_setor']) 	? 'style="color:#F00"' 										: "";  		
						$ramalTelefoneAntigo 	= ($a['telefoneAntigo'] != $ramalTelefone)		? 'style="color:#F00"' 										: "";  		
						$ramalEmailAntigo 		= ($a['emailAntigo'] != $ramalEmail)			? 'style="color:#F00"' 										: "";  		
						
                	?>
                		<tr align="center">
                			<td><?=$ramalNivel == 1 ? "Cadastro" : "Atualização";?></td>
                			<td <?=$ramalAntigo;?>><?=$ramalNovo;?></td>
                			<td <?=$ramalNomeAntigo;?>><?=$ramalNome;?></td>
                			<td <?=$ramalBaseAntigo;?>><?=$ramalBase;?></td>
                			<td <?=$ramalSetorAntigo;?>><?=$ramalSetor;?></td>
                			<td <?=$ramalTelefoneAntigo;?>><?=$ramalTelefone;?></td>
                			<td><?=$ramalStatus;?></td>
                			<td <?=$ramalEmailAntigo;?>><?=$ramalEmail;?></td>
                			<td><?=$ramalData;?></td>
                			<td width="2%"><a class="btn btn-info botaoLoad modalOpen btn-sm" id="modulos/ramal/src/views/formularios/form.php?acao=visualizar&id=<?=$ramalId;?>&id_a=<?=$id;?>" data-target="#modalEditarRamais"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                			<?php if($ramalSituacao == 1){?>
                			<td align="center" width="2%">
                                <table  width='100px' align="center">
                                    <tr>
                                    	<td><a class="btn btn-success btn-sm" href="modulos/ramal/src/controllers/ramal.php?acao=Aprovar&id=<?=$id;?>"><span class="glyphicon glyphicon-ok"></span></a></td>
                						<td><a class="btn btn-danger btn-sm"  href="modulos/ramal/src/controllers/ramal.php?acao=Reprovar&id=<?=$id;?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                                    </tr>
                                </table>
                            </td>
                			<?php } else if($ramalSituacao == 2){?>
                			<td>Reprovada</td>
                			<?php } else {?>
                			<td>Aprovada</td>
                			<?php }?>
                		</tr>
                	<?php }?>
                </tbody>
             </table>
             </div>

<?php } else {
	Funcoes::Nregistro();
} ?>
	</div>
</div>
<div class="modal fade" id="modalEditarRamais" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
