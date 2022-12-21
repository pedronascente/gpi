<div class="panel panel-primary">
    <div class="panel-heading "> 
        <?=($acao == 'editar' || $acao == 'visualizar' ) ? "Planilha / " . $objetopcf->get_setor() : $objetopcf->get_setor() . ' :'; ?>
    </div>
    <div class="panel-body">
    	<div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float: right">
                <?php
                    $formularioBusca = new FormularioDeBusca;
                    $formularioBusca->setPg($pg);
                    $formularioBusca->setHiddens(array("id_u"=>$id_usuario, "page"=>$page, "id_setor"=>$id_setor));
                    $formularioBusca->setAcao($acao);
                    $formularioBusca->setFiltro('busca');
                    $formularioBusca->setMethod("GET");
                    $formularioBusca->setValue($busca);
                    $formularioBusca->formBusca();
                ?>
            </div>
  	</div>
        <div class="well well-sm">
            <span class="glyphicon glyphicon-pencil"></span> => Editar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="glyphicon glyphicon-trash"></span> => Excluir
        </div>
         <?php
            //MONTAR A TABELA :
            echo '<div class="table-responsive"><table  class="table table-striped table-bordered  table-hover dataTableBootstrap " cellspacing="0">';
            switch ($id_setor) :
                case 33 : include_once __DIR__ . './Comercial_Alarme_Cerca_ Eletrica_ CFTV.php'; $colspan = 12; break;
                case 46 : include_once __DIR__ . './Comercial_Rastreamento_Veicular.php'; $colspan = 12; break;
                case 60 : include_once __DIR__ . './Entregas_de_ Alarmes.php'; $colspan = 8; break;
                case 61 : include_once __DIR__ . './Reversao.php'; $colspan = 10; break;
                case 62 : include_once __DIR__ . './Supervisao_Comercial_Alarmes_Cerca_Eletrica_CFTV.php'; $colspan = 12; break;
                case 63 : include_once __DIR__ . './Supervisao_Comercial_Rastreamento.php'; $colspan = 9; break;
                case 64 : include_once __DIR__ . './Supervisao_Tecnica_SAC_Alarmes_Cerca_Eletrica_CFTV.php';$colspan = 11;  break;
                case 65 : include_once __DIR__ . './Tecnica_Alarmes_Cerca_Eletrica_CFTV.php'; $colspan = 10; break;
                case 66 : include_once __DIR__ . './Tecnica_de_Rastreamento.php'; $colspan = 10; break;
                case 150 : include_once __DIR__ . './Portaria_Virtual.php'; $colspan = 11; break;
                case 32 : include_once __DIR__ . './Reclamacao_Cliente.php'; $colspan = 7; break;
            endswitch;
            //FOOTER : 
            echo '<tfoot>';
            echo '<tr>';
            echo '<td colspan="'.$colspan.'">';
            echo '<span style="float:left">' . $totalPedidoComissao. ' Registros Encontrados. </span>';
            echo '<span style="float:right"> Valor Total R$ '.@Funcoes::formartaMoedaReal($objetopcf->somarComissoes($id_usuario) - $objetopcf->somarDescontos($id_usuario) ).' </span>';
            echo '</tr>';
            echo '</tfoot>';    
            echo '</table></div>';
            $objPaginacao->MontaPaginacao();   
        ?>
        <!--GRUPO DE BOTOES: [ENVIAR][EXEL][PDF][VOLTAR]-->
        <div class="btn-group" role="group" aria-label="...">
            <?php 
                if($lista_pedidoComissao){
                    if($objetopcf->get_pcf_status() != 2 && $acao == "AddPedidoComissao"){
                        echo'<a  id="modulos/pedidoComissao/src/views/listas/modal_ListaInconsistencia.php?id_planilha='.$id_usuario.'" class="btn btn-default modalOpen" title="Enviar Planilha para coferência." data-target="#modalInconsistenciasPlanilha">Enviar</a>';                        
                    } else if ($acao == "AddPedidoComissao"){
                        echo '<a class="btn btn-default enviarPlanilha" id="'.$objetopcf->get_pcf_id().'">Enviar</a>';
                    }
                    if($page == 'arquivo' || $page == "conferencia"){
                        $array_dados_parametros = ["id_u"=>$objetopcf->get_pcf_id(), "tipo"=>"modal","id_s"=>$id_setor, "periodo"=>$objetopcf->get_pcf_periodo(),];
                        $array_dados_btn_adicionar = ['page'=>$page,'pcf_ano'=>$objetopcf->get_pcf_ano(),'acao'=>'AddPedidoComissao','id_setor'=>$objetopcf->get_pcf_id_setor(), 'id_u'=>$objetopcf->get_pcf_id(),'tipo'=>'modal'];
                        $array_dados_btn_excel = ['acao'=>'excel2','id'=>$id_usuario,'id_planilha'=>$id_setor,'titulo'=>ucfirst($objetopcf->get_setor())];
                        $array_dados_btn_pdf = ['id_u'=>$id_usuario,'id_s'=>$id_setor];
                        echo '<a id="modulos/pedidoComissao/src/views/formularios/frm_modal_1.php?'.http_build_query($array_dados_parametros).'" class="modalOpen botaoLoad btn btn-primary" data-target="#modalPedidoComissao">Imprimir por Funcionario Individual</a>';
                        echo '<a id="modulos/pedidoComissao/src/views/formularios/frm_modal.php?'.http_build_query($array_dados_btn_adicionar).'" class="modalOpen botaoLoad btn btn-default" data-target="#modalPedidoComissao">Adicionar</a>';
                        echo '<a href="modulos/pedidoComissao/src/controllers/pedido_comissao.php?'.http_build_query($array_dados_btn_excel).'" class="btn btn-default" title="Exportar em Excel." >Excel</a>';
                        echo '<a href="fpdf/pedido_comissao/index.php?'.http_build_query($array_dados_btn_pdf).'" class="btn btn-default" title="Exportar em PDF" >PDF</a>';
                    }
                }
            ?>
            <a href="<?=$pageHistory;?>" class="btn btn-danger">Voltar</a>
            <?php if($id_setor == 46){?>
                <a href="modulos/pedidoComissao/src/controllers/pedido_comissao.php?acao=gerarComissoes&id_planilha=<?=$id_usuario;?>&page=<?=$page;?>&id_setor=<?=$objetopcf->get_pcf_id_setor();?>" class="btn btn-success">Gerar Comissões</a>
            <?php } ?>
        </div>
    </div>
</div>