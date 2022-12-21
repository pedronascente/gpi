<?php
    $dados = filter_input_array(INPUT_POST);
    $pagina = filter_input(INPUT_GET,'pg',FILTER_DEFAULT);

    $captacao = new Captacao;
    $captacao->selectViaturasAntigas($dados);
    $total = $captacao->Read()->getRowCount();

    $objPaginacao = new paginacao(10, $total, PAG, 10);
    $objPaginacao->_pagina = PAGINA;
    $limite = $objPaginacao->limit();
    $viaturasAntigas = $captacao->selectViaturasAntigas($dados, $limite);
?>

<!--FORMULARIO-->
<?php include_once  __DIR__ . '/../formulario/frm_visualizacaoViaturasAntigas.php';?>    

<!--LISTA DE ARQUIVOS-->
<div class="panel panel-primary">
    <div class="panel-heading "> Listar Dados Antigos </div>
    <div class="panel-body"> 
        <div class="table-responsive">
             <?php 
                if (!empty($viaturasAntigas)) { ?>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Hora</th>
                                <th>Conta</th>
                                <th>Atendente</th>
                                <th>Pontos</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($viaturasAntigas as $k => $li) {
                                    $viaturas_data = Funcoes::FormataData($li ['data']);
                                    $viaturas_hora = !empty($li ['hora']) ? $li ['hora'] : '';
                                    $viaturas_conta = !empty($li ['conta']) ? $li ['conta'] : '';
                                    $viaturas_atendente = !empty($li ['atendente']) ? $li ['atendente'] : '';
                                    $viaturas_pontos = !empty($li ['pontos']) ? $li ['pontos'] : '';
                                    $viaturas_id = !empty($li ['id_viaturas']) ? $li ['id_viaturas'] : '';
                                    ?>  		
                                    <tr>				
                                        <td><?=$viaturas_data ?></td>
                                        <td><?=$viaturas_hora ?></td>
                                        <td><?=$viaturas_conta ?></td>
                                        <td><?=$viaturas_atendente ?></td>
                                        <td><?=$viaturas_pontos ?></td>
                                        <td  width="2%" align="center">
                                            <a href="index.php?pg=27&pgAnterior=<?= $pagina; ?>&id=<?= $viaturas_id ?>" class="btn  btn-success btn-sm">
                                               <span class="glyphicon glyphicon-eye-open"></span>
                                            </a>				
                                        </td>
                                    </tr>	
                                    <?php 
                                } 
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">Registros encontrados: <?=$total; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                    <?php
                    $objPaginacao->MontaPaginacao();
                } else {
                   Funcoes::Nregistro();
                }
            ?>
        </div>
    </div>
</div>   