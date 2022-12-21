<?php
if (!empty($busca)){
    $setFiltros = $objetopcf->setFiltros($busca);
}
$objetopcf->selectTodosArquivados(null);
$total_registro = $objetopcf->Read()->getRowCount();
$objPaginacao = new paginacao(10, $total_registro, PAG, 10);
$objPaginacao->_pagina = PAGINA;
$limite = $objPaginacao->limit();
$objetopcf->selectTodosArquivados($limite);
$lista = $objetopcf->Read()->getResult();
?>
<div class="panel panel-primary">
    <div class="panel-heading ">Planilhas Arquivadas</div>
    <div class="panel-body">
        <a href="modulos/pedidoComissao/src/controllers/pedido_comissao.php?acao=excel&tipo=arquivada" class="btn btn-sm btn-default"><span class="glyphicon-class"> Excel</span></a>
        <?php include_once __DIR__.'/../formularios/frm_buscaComissoes.php';?>
            <?php
            if ($lista) : ?>
            	<div class="table-responsive">
                 <table  class="table table-striped table-bordered  table-hover dataTableBootstrap  " cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th>Nome</th>
                            <th>Comissão</th>
                            <th>Setor</th>
                            <th>Periodo</th>
                            <th>Ano</th>
                            <th width="10%">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($lista as  $dados) :
                            $pcf_id = $dados['pcf_id'];
                            $objetopcf->sets($dados); 
                            $pcf_comissao = $objetopcf->somarComissoes($pcf_id) - $objetopcf->somarDescontos($pcf_id);
                            ?>
                            <tr> 
                                <td><?=$pcf_id;?></td>
                                <td><?=$dados['pcf_nome'];?></td>
                                <td>R$<?=@Funcoes::formartaMoedaReal($pcf_comissao);?> </td>
                                <td><?=$dados['setor_local'];?></td>
                                <td><?=$dados['pcf_periodo'];?></td>
                                <td><?=$dados['pcf_ano'];?></td>
                                <td align="center">
                                    <table>
                                        <tr>
                                            <a href="index.php?pg=6&id_u=<?=$pcf_id;?>&id_setor=<?=$dados['pcf_id_setor'];?>&acao=arquivado&page=arquivo" class="btn  btn-success" title="Visualizar Planilha"> 
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                            </a>
                                            <a href="javascript:void(0)"        id="<?=$pcf_id;?>"  class="btn  btn-primary    _btn_desarquivar_planilha " title="Desarquivar Planilha">
                                                <span class=" glyphicon glyphicon-paste"></span>
                                            </a>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                        ?>
                    </tbody>
                    <tfoot>
                        <tr><td colspan="7"></td></tr>
                    </tfoot>
                </table>
                </div>
                <?php
                $objPaginacao->MontaPaginacao();
            else:
                Funcoes::Nregistro();
            endif;
            ?>
        </div>
</div>
<script type="text/javascript">
    $(function(){
        $('._btn_desarquivar_planilha').click(function(){
            $.ajax({
                url: 'modulos/pedidoComissao/src/controllers/pedido_comissao.php',
                dataType: 'json',type: 'post',
                data: {acao: 'desarquivarPlanilha', pcf_id: $(this).attr('id'),
                },
                success: function (_retorno) {
                    if(_retorno.type== true){
                        alert('Sua Planilha foi  Desarquivar, com Sucesso!');
                        location.reload();
                    }else{
                        alert('Não foi possível Desarquivar sua Planilha, Tente novamente mais Tarde!');
                    }
                },
                error: function () {
                    alert("Erro ao enviar requisição!");
                }
            });
        });
    });
</script>