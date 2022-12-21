    <?php
    require_once '../../../../../Config.inc.php';
    $id = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT);
    $dados['pc_id'] = $id ;
    
    //LISTA CONDOMINIO :
    $portariaCondominio = new Condominio;
    $listCondominios = $portariaCondominio->selectCondominio($id); 
    
    //TOTAL DE SERVIÇOS NA BD :
    $portariaCondominioServico = new PortariaCondominioServico;
    $portariaCondominioServico->selectServicosDoCondominio($dados);
    $totalServicos = $portariaCondominioServico->Read()->getRowCount();
    
    //LISTA OS SERVIÇO COM PAGINAÇÃO :
    //$objPaginacaoServico = new paginacao(30,$totalServicos,PAG, 10);
    //$objPaginacaoServico->_pagina = 42;
    //$limiteCondominio = $objPaginacaoServico->limit();
    $dados['limit'] = '0,10'; //$limiteCondominio;
    $listaServico = $portariaCondominioServico->selectServicosDoCondominio($dados);  
    ?>
    <!-- Modal -->
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#condominio"> [ Condominio ] </a></li>
                            <li><a data-toggle="tab" href="#servico"> [ serviços ]</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="condominio" class="tab-pane fade in active">
                                <?php include_once   __DIR__ .  '/../modal/dadosCondominio.php';?>
                            </div>
                            <div id="servico" class="tab-pane fade">
                                 <?php include_once   __DIR__ .  '/../modal/dadosServico.php';?>
                            </div>    
                        </div>    
                    </div>
                </div><!--modal-body-->
            </div><!--modal-content-->
        </div><!--modal-dialog-->
     </div>  <!--myModal-->