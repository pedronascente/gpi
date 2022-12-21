<?php


//lst_conferenciaPedidoComissao.php

/*
 * -----------------------------------------------------------------------------
 * Seleciona as planilhas dos vendedores
 * -----------------------------------------------------------------------------
 */


if (!empty($busca)) {
    $objetopcf->setFiltros($busca);
}

$filtros = filter_input_array(INPUT_POST);
$selectFiltro = filter_input(INPUT_POST, "filtro");
$textoFiltro = filter_input(INPUT_POST, "texto");

$objetopcf->selectTodos(null);
$total = $objetopcf->Read()->getRowCount();

//paginação:
$objPaginacao = new paginacao(10, $total, PAG, 10);
$objPaginacao->_pagina = PAGINA;
$objPaginacao->setTabs('#tabs-1');
$limite = $objPaginacao->limit();

$objetopcf->selectTodos($limite);
$lista = $objetopcf->Read()->getResult();
$totalPorPagina = $objetopcf->Read()->getRowCount();
$empresa = new Empresa();
?>

<div class="panel panel-primary">
    <div class="panel-heading">Conferir comissões</div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li><a href="#tabs-1" data-toggle="tab">Lista Planilhas</a></li>
        </ul>
        <div id="my-tab-content" class="tab-content">
            <div id="tabs-1" class="tab-pane fade">
                <div class="panel panel-primary">
                    <div class="panel-heading"></div>
                    <div class="panel-body">
                        <?=
                        ($result == 'on') ? '<div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><div class="alert alert-success"  role="alert">Registro enviado com sucesso!</div></div><br></div>' : null;
                        echo "<div class='row'><div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'><a href=\"modulos/pedidoComissao/src/controllers/pedido_comissao.php?acao=excel&tipo=todos\" class=\"btn btn-default\" >Excel</a></div></div><br>";
                        include_once __DIR__ . '/../formularios/frm_buscaComissoes.php';
                        if ($lista) {
                            ?>
                            <div class="well well-sm">
                                <span class="glyphicon glyphicon-pencil"></span> => Editar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="glyphicon glyphicon-folder-open"></span> => Arquivar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="glyphicon glyphicon-remove"></span> => Reprovar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="glyphicon glyphicon-info-sign"></span> => Inconsistências
                            </div>
                            <div class="table-responsive">
                                <table  class="table table-striped table-bordered  table-hover dataTableBootstrap " cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th  width="5%">ID</th>
                                            <th>Nome</th>
				                            <th>Empresa</th>
                                            <th>Comissão</th>
                                            <th>Setor</th>
                                            <th>Periodo</th>
                                            <th>Ano</th>
                                            <th width="5%" >Ações</th>
                                        </tr>
                                    </thead>  
                                    <tbody>  
                                    <?php
                                        foreach ($lista as $k => $dados) :
                                            $objetopcf->sets($dados);
                                            $total_comissao = $objetopcf->somarComissoes($objetopcf->get_pcf_id()) - $objetopcf->somarDescontos($objetopcf->get_pcf_id());
                                            ?>
                                            <tr align="center" id="<?= $objetopcf->get_pcf_id(); ?>">
                                                <td><?= $objetopcf->get_pcf_id(); ?></td>
                                                <td><?= $objetopcf->get_pcf_nome(); ?></td>
                                                <td>  
                                                            <?php 
                                                                echo '<select name="id_empresa" class="form-control select_alterar_empresa">';
                                                                    foreach($empresa->select() as $value)
                                                                    {
                                                                        $____html = '<option value="'.$value["id_empresa"].'_'.$objetopcf->get_pcf_id().'" ';
                                                                            if($objetopcf->get_pcf_empresa() == $value["nome_empresa"])
                                                                            {
                                                                                $____html.="selected";
                                                                            }
                                                                        $____html.= ' > '.$value["nome_empresa"].'</option>';
                                                                        echo $____html;
                                                                    }
                                                                echo'</select>';
                                                              ?>  
                                                </td>
                                                <td><span class="span_esquerdo"> R$ </span> <span class="span_direito"><?= Funcoes::formartaMoedaReal($total_comissao); ?></span></td>
                                                <td><?= $objetopcf->get_setor(); ?></td>
                                                <td contenteditable="true" class="editarPlanilha" id="pcf_periodo"><?= $objetopcf->get_pcf_periodo(); ?></td>
                                                <td contenteditable="true" class="editarPlanilha" id="pcf_ano"><?= $objetopcf->get_pcf_ano(); ?></td>
                                                <td width="5%">
                                                    <table  width='200px'>
                                                        <tr>
                                                            <td>
                                                                <a href="index.php?pg=6&id_u=<?= $objetopcf->get_pcf_id() ?>&id_setor=<?= $objetopcf->get_pcf_id_setor(); ?>&acao=editarComissao&page=conferencia" class="botaoLoad btn  btn-sm btn-info">
                                                                    <span class="glyphicon glyphicon-pencil"></span>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a  class="botaoLoad  arquivarPlanilha  btn btn-sm btn-success" data-id="<?= $objetopcf->get_pcf_id(); ?>" >
                                                                    <span class="glyphicon glyphicon-folder-open"></span>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a class="botaoLoad modalOpen btn  btn-sm btn-danger" id="modulos/pedidoComissao/src/views/formularios/modal_reprovarPlanilha.php?id_pcf=<?= $objetopcf->get_pcf_id(); ?>" data-target="#modalReprovaPlanilha"> 
                                                                    <span class="glyphicon glyphicon-remove"></span>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a id="modulos/pedidoComissao/src/views/listas/modal_ListaInconsistencia.php?id_planilha=<?= $objetopcf->get_pcf_id(); ?>&tela=1" class="botaoLoad modalOpen btn btn-sm btn-default" data-target="#modalInconsistenciasPlanilha">
                                                                    <span class="glyphicon glyphicon-info-sign"></span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>    
                                            </tr>
                                            <?php
                                        endforeach;
                                        ?>
                                         <script type="text/javascript">
                                             $(function(){
                                                $( ".select_alterar_empresa" ).change(function() {
                                                   var _valores = $(this).val();
                                                   $.post('modulos/usuarios/src/controllers/EditarEmpresaUsuarios.php', {
                                                        valores:_valores, 
                                                        acao:'alterar_empresa'
                                                    }).done(function(response){
                                                         console.log(response.type);
                                                    });
                                                });
                                             });
                                         </script>     
                                    </tbody>
                                    <tfoot>
                                        <tr><td colspan="7">Registros encontrados: <?= $total; ?></td></tr>
                                    </tfoot>
                                </table>
                            </div>
                            <?php
                            $objPaginacao->MontaPaginacao();
                        } else {
                            Funcoes::Nregistro();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalInconsistenciasPlanilha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div class="modal fade" id="modalReprovaPlanilha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" width="100%"></div>
<div class="modal fade" id="modalAjuda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div class="modal fade" id="modalInconsistencias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>