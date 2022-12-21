<div class="panel panel-primary">
    <div class="panel-heading ">Listar Planilhas de Comissões :</div>
    <div class="panel-body">
    <div class="panel-body">
    <?php  include_once __DIR__.'/../formularios/frm_buscaComissoes.php';?>
    <?php  if($lista) {?>
   				 <div class="well well-sm">
					<span class="glyphicon glyphicon-plus-sign"></span> => Adicionar Comissão &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span class="glyphicon glyphicon-pencil"></span> => Editar Planilha &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span class="glyphicon glyphicon-trash"></span> => Excluir Planilha
				</div>
  	<div class="table-responsive">
        <table  class="table table-striped table-bordered  table-hover dataTableBootstrap  " cellspacing="0">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th>Ano</th>
                    <th>Período</th>
                    <th>Nome</th>
					<th>Empresa</th>
                    <th>Status</th>
                    <th>Planilha</th>
                   <th width="5%">Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($lista as $k => $dados) :
                    $objetopcf->sets($dados);?>
                    <tr>
                        <td><?=$objetopcf->get_pcf_id();?></td>
                        <td><?=$objetopcf->get_pcf_ano();?></td>
                        <td><?=$objetopcf->get_pcf_periodo();?></td>
                        <td><?=$objetopcf->get_pcf_nome();?></td>
						<td><?=$objetopcf->get_pcf_empresa();?></td>
                        <td><?=$objetopcf->get_pcf_DescStatus()?></td>
                        <td><?=$objetopcf->pegaNomePanilha();?></td>
                        <td>
                            <table width="120px">
                                    <?php 
                                    if($objetopcf->get_pcf_status() == 0 || $objetopcf->get_pcf_status() == 2){?>
                                        <td align="center">
                                            <a href="index.php?pg=6&id_u=<?= $objetopcf->get_pcf_id() ;?>&acao=AddPedidoComissao&page=cadastrar&id_setor=<?= $objetopcf->get_pcf_id_setor() ;?>" class="btn btn-sm btn-primary">
                                                 <span class="glyphicon glyphicon-plus-sign"></span>
                                            </a>
                                        </td>
                                        <td align="center">
                                            <a class="botaoLoad  btn  btn-sm btn-info" href="index.php?pg=5&id=<?=$objetopcf->get_pcf_id();?>">
                                                <span class="glyphicon glyphicon-pencil"></span>
                                            </a>
                                        </td>
                                        <td align="center">
                                            <a class="botaoLoad delPlanilhaComissao btn  btn-sm btn-danger" id="<?=$objetopcf->get_pcf_id();?>">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a>
                                        </td>
                                        <?php
                                    }
                                    ?>
                                    <td align="center">
                                        <?php  if ($objetopcf->get_pcf_status() == 1) : ?>
                                            <a href="index.php?pg=6&id_u=<?=$objetopcf->get_pcf_id();?>&acao=visualizar&page=cadastrar&id_setor=<?=$objetopcf->get_pcf_id_setor();?>" class="btn btn-sm btn-success">
                                                 Visualizar
                                            </a>
                                        <?php endif; ?>                
                                    </td>
                            </table>
                        </td>
	            </tr>
                    <?php        
                    endforeach;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">Registros encontrados: <?= $total; ?></td>
                </tr>
            </tfoot>
        </table>
        </div>
        <?php } else {
            Funcoes::Nregistro();
        }?>
   </div>
</div>
<?php
/*
* *****************************************************
* ********* RESPONSAVEL POR GERAR A PAGINAÇÃO *********
* *****************************************************
*/
$objPaginacao->MontaPaginacao();
/*
* **************************************************
* ********* DELETA PLANILHA DE COMISSÕES **********
* **************************************************
*/
?>

