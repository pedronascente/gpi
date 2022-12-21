<?php
// namespace : C:\wamp\www\gpi\modulos\captacao\src\views\captacao\listas\lst_captacao.php
$id_usuario = $_SESSION ['user_info'] ['id_usuario'];
$status = filter_input(INPUT_GET, "status", FILTER_DEFAULT) == '' && empty($busca) ? 'novo' : filter_input(INPUT_GET, "status", FILTER_DEFAULT);
$filtros = filter_input_array(INPUT_GET);
unset($filtros['pg'], $filtros['pag']);
$busca = filter_input(INPUT_GET, "busca");
$captacao = new Captacao ();
$filtros['id'] = $id_usuario;
$filtros['status'] = $status;
$captacao->selectCaptacaoUser($filtros, null);
$total_captacao = $captacao->Read()->getRowCount();
$objPaginacaoCap = new paginacao(10, $total_captacao, PAG, 10);
$objPaginacaoCap->_pagina = PAGINA . Funcoes::getParametrosURL($filtros);
$limite = $objPaginacaoCap->limit();
$lista_captacao = $captacao->selectCaptacaoUser($filtros, $limite);
unset($filtros['status']);
$agenda = new AgendaContato;
$agenda->selectPorUsuarioData($filtros);
$totalPaginacao = $agenda->Read()->getRowCount();
$objPaginacao = new paginacao(30, $totalPaginacao, PAG, 10);
$objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($filtros);
$objPaginacao->setTabs("#tabs-2");
$limite = $objPaginacao->limit();
$lista_historico = $agenda->selectPorUsuarioData($filtros, $limite);
$filtros['status'] = "0";
$agenda->selectPorUsuarioData($filtros);
$total_abertos = $agenda->Read()->getRowCount();
$total_abertos = empty($total_abertos) ? 0 : $total_abertos;
$dataInicial = null;
$dataFinal = null;
?>
<div class="panel panel-primary">
    <div class="panel-heading "> Comercial / Captação: </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li><a data-toggle="tab" href="#tabs-1">Captações</a></li>
            <li><a data-toggle="tab" href="#tabs-2">Histórico (<?= $total_abertos; ?>)</a></li>
            <li><a data-toggle="tab" href="#tabs-3">Abrir Captação</a></li>
        </ul>
        <div class="tab-content">
            <div id="tabs-1" class="tab-pane fade">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <tr align="center">
                                <td width="14,28%" <?= ($status == '0') ? Funcoes::colorirLinha(1) : Funcoes::colorirLinha(0); ?> class="bordaTD cursorPointer" id="index.php?pg=18&status=0">Todos</td>
                                <td width="14,28%"<?= ($status == 'novo') ? Funcoes::colorirLinha(1) : Funcoes::colorirLinha(0); ?> class="bordaTD cursorPointer" id="index.php?pg=18&status=novo">Novo</td>
                                <td width="14,28%"<?= ($status == 'cancelado') ? Funcoes::colorirLinha(1) : Funcoes::colorirLinha(0); ?>  class="bordaTD cursorPointer" id="index.php?pg=18&status=cancelado">Cancelado</td>
                                <td width="14,28%"<?= ($status == 'comprado') ? Funcoes::colorirLinha(1) : Funcoes::colorirLinha(0); ?>  class="bordaTD cursorPointer" id="index.php?pg=18&status=comprado">Comprado</td>
                                <td width="14,28%"<?= ($status == 'em_agendamento') ? Funcoes::colorirLinha(1) : Funcoes::colorirLinha(0); ?>  class="bordaTD cursorPointer" id="index.php?pg=18&status=em_agendamento">Em Agendamento</td>
                                <td width="14,28%"<?= ($status == 'enviado') ? Funcoes::colorirLinha(1) : Funcoes::colorirLinha(0); ?>  class="bordaTD cursorPointer" id="index.php?pg=18&status=enviado">Orçamento Enviado</td>
                                <td width="14,28%"<?= ($status == 'visita_agendada') ? Funcoes::colorirLinha(1) : Funcoes::colorirLinha(0); ?>  class="bordaTD cursorPointer" id="index.php?pg=18&status=visita_agendada">Visita Agendada</td>
                            </tr>
                        </table>
                        <br>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float: right">
                                <?php
                                $formularioBusca = new FormularioDeBusca;
                                $formularioBusca->setPg($pg);
                                $formularioBusca->setFiltro('busca');
                                $formularioBusca->setMethod("GET");
                                $formularioBusca->setValue($busca);
                                $formularioBusca->setHiddens(array("status" => $status));
                                $formularioBusca->formBusca();
                                ?>
                            </div>
                        </div>
                        <?php
                        if ($lista_captacao) {
                            ?>
                            <table class="table table-bordered table-hover table-striped dataTableBootstrap">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Cliente</th>
                                        <th>Status</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($lista_captacao as $k => $li) :
                                        $captacao_data = Funcoes::FormataData($li ['captacao_data_criacao']);
                                        $captacao_hora = Funcoes::FormataHora($li ['captacao_data_criacao']);
                                        $captacao_id = !empty($li ['captacao_id']) ? ucfirst($li ['captacao_id']) : '';
                                        $captacao_nivel_prioridade = !empty($li ['captacao_nivel_prioridade']) ? ucfirst($li ['captacao_nivel_prioridade']) : '';
                                        $captacao_cliente = !empty($li ['captacao_cliente']) ? ucfirst(trim($li ['captacao_cliente'])) : '';
                                        $captacao_status = !empty($li ['captacao_status']) ? ucwords(str_replace("_", " ", $li ['captacao_status'])) : '';
                                        ?>   
                                        <tr>
                                            <td width="15%"><?= $captacao_data . ' ' . $captacao_hora; ?></td>
                                            <td><?= Funcoes::addCaracter($captacao_cliente); ?></td>
                                            <td <?php echo($captacao_status == "Novo") ? 'style="color:#F00"' : ''; ?>><?= $captacao_status; ?></td>
                                            <td width="2%"  align="center"><a href="index.php?pg=19&id=<?= $captacao_id; ?>&acao=visualizar&voltar=18#tabs-1" class="btn  btn-success"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                                        </tr>
                                        <?php
                                    endforeach;
                                    ?>   
                                </tbody>
                                <tfoot>
                                    <tr align="center">
                                        <td colspan="4">Registros encontrados: <?= $total_captacao; ?> </td>
                                    </tr>
                                </tfoot>    
                            </table>   
                            <?php
                            $objPaginacaoCap->MontaPaginacao();
                        } else {
                            Funcoes::Nregistro();
                        };
                        ?>
                    </div>
                </div>
            </div>
            <div id="tabs-2" class="tab-pane fade">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <form action="" method="GET">
                            <div class="row">
                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label>Período:</label>
                                        <div class="input-group input-append date datepicker">
                                            <input type="text" name="dt_inicial" id="dt_inicial" class="form-control" value="<?= $dataInicial; ?>" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label>até</label>
                                        <div class="input-group input-append date datepicker">
                                            <input type="text" name="dt_final" class="form-control" id="dt_final" value="<?= $dataFinal; ?>" />
                                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-actions">
                                        <br>
                                        <input type="hidden" value="18" name="pg">
                                        <button type="submit" class="btn btn-primary">Filtrar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php
                        if (!empty($lista_historico)) :
                            ?>
                            <table class="table table-bordered table-hover table-striped dataTableBootstrap">
                                <thead>
                                    <tr>
                                        <th>Data Criação</th>
                                        <th>Data Agendada</th>
                                        <th>Cliente</th>
                                        <th>Motivo</th>
                                        <th>Situação</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($lista_historico as $k => $list) :
                                        $agenda_contato_status = !empty($list['agenda_contato_status']) ? !empty($list['agenda_contato_status']) : 0;
                                        $situacao = $agenda_contato_status == 1 ? "Finalizado" : "Aberto";
                                        $data_criacao = !empty($list ['agenda_contato_data_criacao']) ? Funcoes::formataData($list ['agenda_contato_data_criacao']) : "";
                                        $data_agendada = !empty($list ['agenda_contato_proxima_data']) && !empty($list['agenda_contato_hora']) ? Funcoes::formataData($list ['agenda_contato_proxima_data']) . " " . $list['agenda_contato_hora'] : "";
                                        $cor = $agenda_contato_status != 1 ? 'style="color:#F00"' : null;
                                        $cliente = $list['agenda_contato_cliente'] == " " || empty($list['agenda_contato_cliente']) ? $list['captacao_cliente'] : $list['agenda_contato_cliente'];
                                        $motivo = !empty($list['agenda_contato_motivo']) || !empty($list['agenda_contato_cliente']) ? $list['agenda_contato_motivo'] : "";
                                        ?>
                                        <tr align="center">
                                            <td width="15%" <?= $cor; ?>><?= $data_criacao; ?></td>
                                            <td  <?= $cor; ?>><?= $data_agendada; ?></td>
                                            <td <?= $cor; ?>><?= $cliente; ?></td>
                                            <td <?= $cor; ?>><?= $motivo ?></td>
                                            <td <?= $cor; ?>><?= $situacao; ?></td>
                                            <td width="5%">
                                                <a id="modulos/captacao/src/views/captacao/formularios/modal_captacaoAgenda.php?agenda_contato_id=<?= $list['agenda_contato_id']; ?>&id_captacao=<?= $list['agenda_contato_captacao_id']; ?>" class="botaoLoad modalOpen btn btn-success" data-target="#modal"> 
                                                    Visualizar
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    endforeach;
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr align="center">
                                        <td colspan="6">Registros encontrados: <?= $totalPaginacao; ?> </td>
                                    </tr>
                                </tfoot>       
                            </table>
                            <?php
                            $objPaginacao->MontaPaginacao();
                        else :
                            Funcoes::Nregistro();
                        endif;
                        ?>
                    </div>
                </div>
            </div>
            <div id="tabs-3" class="tab-pane fade">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <form action="modulos/captacao/src/controllers/vendedor_registra_captacao.php" method="post" id="basic_validate_usuario" novalidate="novalidate"> 
                            <div class="row">
                                <div class="col-xs-12 col-sm-12  col-md-12 ">
                                    <div class="form-group">
                                        <label>E-mail:</label>
                                        <input type="email" name="captacao_email" id="btn_verificar_email"  value=""  class="form-control" placeholder="Entre com um  email válido"  required >
                                    </div>
                                </div>
                            </div>     
                            <div class="row">
                                <div class="col-xs-12 col-sm-12  col-md-12" >
                                    <div class="form-group">
                                        <label>Cliente:</label>
                                        <input type="text" name="captacao_cliente" value="" class="form-control" required placeholder="Digite nome do cliente" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-3  col-md-3">
                                    <div class="form-group">
                                        <label>Telefone:</label>
                                        <input type="text" name="captacao_telefone1"  id="captacao_telefone1"  value=""  class="mask_telefone form-control" required placeholder="Telefone" />
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label>Telefone:</label>
                                        <input type="text" name="captacao_telefone2" id="captacao_telefone2"  value=""   class="mask_telefone form-control" placeholder="Telefone" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label>Indicador:</label>
                                        <select name="captacao_indicador" id="captacao_indicador" class="form-control" required="">
                                            <?php   
                                                $captacao_indicador = [
                                                    ''=>' -- Selecione --',
                                                    'indicacao'=>'Indicação',
                                                    'whatsApp'=>'WhatsApp',
                                                    'outros'=>'Outros',
                                                 ];
                                                 foreach ($captacao_indicador as $key => $value) {
                                                     echo '<option value="'.$key.'">'.$value.'</option>';
                                                 }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label>Observações:</label>
                                        <textarea name="captacao_obs" rows="5" id="captacao_obs"  class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <input type="hidden" name="origem" value="monitoramento" /> 
                                    <input type="hidden" name="captacao_responsavel" class="form-control"  value="<?=$_SESSION['user_info']['nome']; ?>">
                                    <input type="hidden" name="captacao_id_usuario"  class="form-control"  value="<?=$_SESSION['user_info']['id_usuario']; ?>">
                                    <input type="hidden" name="id_usuario" class="form-control"  value="<?=$_SESSION['user_info']['id_usuario']; ?>">
                                    <input type="hidden" name="captacao_id" class="form-control"  value="">
                                    <input type="hidden" name="captacao_status" class="form-control"  value="novo">
                                    <input type="hidden" name="captacao_interesse" class="form-control"  value="5">
                                    <input type="hidden" name="acao"  id="acao"  class="form-control"  value="new">
                                    <input type="submit" class="btn btn-danger"  value="Salvar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function(){
    $('#btn_verificar_email').blur(function(){
       var $email=$(this).val(); 
        $.ajax({
            url:"modulos/captacao/src/controllers/vendedor_registra_captacao.php",
            type:"GET",
            dataType:"json",
            data:{
                email:$email,
            },
            success: function (json){
                if(json.captacao!=false){
                   $('input[name="captacao_email"]').val(json.captacao[0].captacao_email);
                   $('input[name="captacao_cliente"]').val(json.captacao[0].captacao_cliente);
                   $('input[name="captacao_telefone1"]').val(json.captacao[0].captacao_telefone1);
                   $('input[name="captacao_telefone2"]').val(json.captacao[0].captacao_telefone2);
                   $('textarea[name="captacao_obs"]').val(json.captacao[0].captacao_obs);
                   $('input[name="captacao_id"]').val(json.captacao[0].captacao_id);
                   $('input[name="acao"]').val('update');
                   $('#captacao_indicador > option').each( function(index, value) {
                        var _valor_option = $(this).attr('value');
                        if(_valor_option==json.captacao[0].captacao_indicador){
                            $(this).attr('selected',true);
                        }
                   });
                }else{
                   $('input[name="captacao_cliente"]').val(" ");
                   $('input[name="captacao_telefone1"]').val(" ");
                   $('input[name="captacao_telefone2"]').val(" ");
                   $('textarea[name="captacao_obs"]').val(" ");
                   $('input[name="acao"]').val('new');
                   $('#captacao_indicador > option').each( function(index, value){
                        $(this).removeAttr('selected');
                   });
                }
            }
        });
    }); 
});
</script>