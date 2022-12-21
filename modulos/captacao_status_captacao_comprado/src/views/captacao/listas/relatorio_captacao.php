<?php
//namespace C:\wamp\www\gpi\modulos\captacao\src\views\captacao\listas\relatorio_captacao.php
$dados = filter_input_array(INPUT_GET);
$acao = isset($dados ['acao']) ? $dados ['acao'] : "";
//LISTA USUARIOS COM PERMISSÃO DE CAPTAÇÃO:
$objeto_usuario = new Usuarios ();
$usuario_captacao = $objeto_usuario->selUser('captacao');
//LISTA DDD :
$ddd = new Regiao;
$listddd = $ddd->select();
$total = NULL;
$dataInicial = filter_input(INPUT_GET, "dt_inicial");
$dataFinal = filter_input(INPUT_GET, "dt_final");
$nomeCliente = filter_input(INPUT_GET, "nome");
$consultor = filter_input(INPUT_GET, "id_usuario");
$ddd = filter_input(INPUT_GET, "ddd");
$servico = filter_input(INPUT_GET, "servico");
$captacao_status = filter_input(INPUT_GET, "captacao_status");
$tipo_grafico = filter_input(INPUT_GET, "tipo_grafico");
$filtros = $dados;
$filtros['dt_inicial'] = !empty($filtros['dt_inicial']) ? Funcoes::FormatadataSql($filtros['dt_inicial']) : "";
$filtros['dt_final'] = !empty($filtros['dt_final']) ? Funcoes::FormatadataSql($filtros['dt_final']) : "";
$captacao = new Captacao();
$usuario = new Usuarios();
$grafico = null;
$vendedores = $usuario->selecionarVendedores();
$interesses = $captacao->selectCaptacaoNiveisInteresses();
//RETORNA O TOTAL DE REGISTRO NO BANCO:
$relatorioCaptacao = new RelatorioCaptacao ();
switch ($acao) {
    case 'relatorio':
        $relatorioCaptacao->consultar($filtros, null);
        $total = $relatorioCaptacao->Read()->getRowCount();
        //REALIZA PAGINAÇÃO:
        $objPaginacao = new paginacao(10, $total, PAG, 10);
        $objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($dados);
        $limite = $objPaginacao->limit();
        //LISTA DAS CAPTAÇÕES :
        $lista = $relatorioCaptacao->consultar($filtros, $limite);
    break;
}
?>
<div class="panel panel-primary">
    <div class="panel-heading ">Pesquisa Captações</div>
    <div class="panel-body"> 
        <form method="GET" action="index.php?pg=3">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label>Nome do Cliente:</label>
                        <input type="text" name="nome" id="nome" value="<?= $nomeCliente; ?>" class="form-control"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Serviço:</label>
                        <select name="servico" id="servico" class="form-control">
                            <option value="">Todos</option>
                            <?php if(!empty($interesses)){
                            	foreach ($interesses as $i){?>
                            		<option value="<?=$i['captacao_niveis_interesses_id'];?>" <?= $servico == $i['captacao_niveis_interesses_id'] ? "selected" : "";?>><?=$i['captacao_niveis_interesses_desc'];?></option>
                            <?php } }?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Consultor:</label>
                        <select name="id_usuario"  class="form-control">
                            <option value="0" selected="selected">Todos</option>
                            <?php
                            if (isset($usuario_captacao))
                                foreach ($usuario_captacao as $usuario) {
                                    $selected = $usuario['usuario_id'] == $consultor ? "selected" : "";
                                    print "<option value=\"{$usuario['usuario_id']}\" {$selected}>{$usuario['usuario_nome']}</option> ";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="form-group">
                        <?php     
                            $array_list_status_captacao = [
                                'novo'              =>'Novo',
                                'cancelado'         =>'Cancelado',
                                'enviado '          =>'Enviado', 
                                'visita_agendada'   =>'Visita Agendada',
                                'em_agendamento'    =>'Em Agendamento',
                                'comprado'          =>'Comprado',
                                'orcamento_enviado' =>'Orçamento Enviado',
                                'reavaliar'         =>'Reavaliar',
                                'todos'             =>'Todos',
                            ];
                            echo '<label>Status:</label>';
                            echo '<select name="captacao_status" id="captacao_status" class="form-control">';
                            foreach ($array_list_status_captacao as $slug=>$status){
                                $checked = $captacao_status == $slug ? 'selected':'';
                                if($slug=='todos'){
                                    echo '<option value=""  '.$checked.' >'.$status.'</option>';
                                }else{
                                    echo '<option value="'.$slug.'"  '.$checked.' >'.$status.'</option>';
                                }
                            }
                            echo '</select>';
                        ?>
                    </div>
                </div>
            </div>
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
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label>DDD</label>
                        <select name="ddd" id="ddd" class="form-control">
                            <option value="" selected="selected">DDD</option>
                            <?php
                                foreach ($listddd as $v) {
                                    $selected = $v['regiao_ddd'] == $ddd ? "selected" : "";
                                    echo "<option value=\"{$v['regiao_ddd']}\" {$selected}>({$v['regiao_ddd']})</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>            
            <div class="row">
                <br>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-actions">
                        <input type="hidden" name="pg" value="3">
                        <input type="hidden" name="acao" id="acao" value="relatorio"> 
                        <button  type="submit" class="btn btn-primary">
                            Pesquisar
                        </button>
                  </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading ">Exportar Relatório</div>
    <div class="panel-body"> 
        <form action="modulos/captacao/src/controllers/captacao.php">
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label>Período:</label>
                        <div class="input-group input-append date datepicker">
                            <input type="text" name="dt_inicial" id="dt_inicial" class="form-control" required="required"/>
                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label>até</label>
                        <div class="input-group input-append date datepicker">
                            <input type="text" name="dt_final" class="form-control" id="dt_final" required="required"/>
                            <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label>Serviço:</label>
                        <select name="servico" id="servico" class="form-control">
                            <option value="">Todos</option>
                             <?php if(!empty($interesses)){
                            	foreach ($interesses as $i){?>
                            		<option value="<?=$i['captacao_niveis_interesses_id'];?>" <?= $servico == $i['captacao_niveis_interesses_id'] ? "selected" : "";?>><?=$i['captacao_niveis_interesses_desc'];?></option>
                            <?php } }?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                    <div class="form-group">
                        <?php     
                            $array_list_status_captacao = [
                                'novo'              =>'Novo',
                                'cancelado'         =>'Cancelado',
                                'enviado '          =>'Enviado', 
                                'visita_agendada'   =>'Visita Agendada',
                                'em_agendamento'    =>'Em Agendamento',
                                'comprado'          =>'Comprado',
                                'orcamento_enviado' =>'Orçamento Enviado',
                                'reavaliar'         =>'Reavaliar',
                                'todos'             =>'Todos'
                            ];
                            echo '<label>Status:</label>';
                            echo '<select name="captacao_status" id="captacao_status" class="form-control">';
                            foreach ($array_list_status_captacao as $slug=>$status){
                                $checked = $captacao_status == $slug ? 'selected':'';
                                if($slug=='todos'){
                                    echo '<option value=""  '.$checked.' >'.$status.'</option>';
                                }else{
                                    echo '<option value="'.$slug.'"  '.$checked.' >'.$status.'</option>';
                                }
                            }
                            echo '</select>';
                        ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
                    <div class="form-actions">
                        <input type="hidden" name="acao" value="exportarRelatorioCaptacao"> 
                        <br>
                        <button  type="submit" class="btn btn-primary">
                            Gerar Relatório
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading ">Relatorio de captação</div>
    <div class="panel-body"> 
        <?php
        if (!empty($lista)) {
            ?>
            <br>
            <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped dataTableBootstrap">
                <thead>
                    <tr class="_tr">
                        <th>Data/Hora</th>
                        <th>Origem</th>
                        <th>Serviço</th>
                        <th>Cadastro</th>
                        <th>Consultor</th>
                        <th>Prioridade</th>
                        <th>Cliente</th>
                        <th>Cidade/UF</th>
                        <th>DDD</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $vendido = 0;
                    foreach ($lista as $k => $dados) :
                        $origem = !empty($dados ['origem']) ? $dados ['origem'] : "";
                        $captacao_status = !empty($dados ['captacao_status']) ? $dados ['captacao_status'] : "";
                        $captacao_cidade = !empty($dados ['captacao_cidade']) ? $dados ['captacao_cidade'] : "";
                        $captacao_uf = !empty($dados ['captacao_uf']) ? $dados ['captacao_uf'] : "";
                        $captacao_data_criacao = !empty($dados ['captacao_data_criacao']) ? $dados ['captacao_data_criacao'] : "";
                        $nome_consultor = !empty($dados ['nome_consultor']) ? $dados ['nome_consultor'] : "";
                        $captacao_cliente = !empty($dados ['captacao_cliente']) ? $dados ['captacao_cliente'] : "";
                        $captacao_ddd = !empty($dados ['captacao_ddd']) ? $dados ['captacao_ddd'] : "";
                        $captacao_nivel_prioridade = !empty($dados ['captacao_nivel_prioridade']) ? $dados ['captacao_nivel_prioridade'] : "";
                        $usuarioCadastro = !empty($dados['usuarioCadastro']) ? $dados['usuarioCadastro'] : "";
                        $captacao_serviço = !empty($dados['captacao_interesse']) ? ucwords($dados['captacao_interesse']) : "";
                        $vendido += ($captacao_status == 'comprado') ? 1 : "";
                        // ------ BLOCO QUE CONCATENA A CIDADE COM A UF, CASO EXISTA ---------------------
                        $cidade = $captacao_cidade;
                        if (($captacao_cidade) && ($captacao_uf)) {
                            $cidade = $captacao_cidade . "/" . $captacao_uf;
                        }
                        if ((!$captacao_cidade) && ($captacao_uf)) {
                            $cidade = $captacao_uf;
                        }
                        // ------ BLOCO QUE FORMATA DATA PRA EXIBIR NO RELATORIO --------------------------
                        $dataHora = explode(' ', $captacao_data_criacao);
                        $data = Funcoes::formataData($captacao_data_criacao);
                        echo "<tr align=\"center\" " . Funcoes::zebrarTR($k) . " class=\"_selHover\">
                        <td align='center'>" . $data . " " . $dataHora [1] . "</td> 
                        <td>" . $origem . "</td>
                        <td>" . $captacao_serviço . "</td> 
                        <td>" . $usuarioCadastro . "</td> 
                        <td>" . $nome_consultor . "</td> 
                        <td>" . $captacao_nivel_prioridade . "</td> 
                        <td>" . $captacao_cliente . "</td> 
                        <td>" . $cidade . "</td> 
                        <td align='center'>" . $captacao_ddd . "</td> 
                        <td>" . $captacao_status . "</td> 
                </tr>";
                    endforeach
                    ;
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="8" align="center"><?= "( {$total} ) Registros encontrados."; ?></td>
                    </tr>
                </tfoot>
            </table>
            </div>
            <?php
                if ($total > 10) {
                    $objPaginacao->MontaPaginacao();
                }
            ?>
            <br />
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped" border="0">
                    <tr align="center">
                        <td width="202">Captações Recebidas: <?= $total; ?></td>
                        <td width="127">Vendidas: <?= $vendido; ?></td>
                        <td width="167">Aproveitamento: <span><?= number_format((($vendido / $total) * 100), 2, ',', ' ') . " %"; ?></span></td>
                    </tr>
                </table>
            </div>
            <?php
        } else {
            Funcoes::Nregistro();
        }
        ?>
    </div>
</div>