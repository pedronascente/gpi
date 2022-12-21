<?php
// namespace C:\wamp\www\gpi\modulos\captacao\src\views\captacao\formularios\config_captacao.php

$dadosFiltro = filter_input_array(INPUT_GET);

$status = !isset($dadosFiltro['status']) ? 'novo' : $dadosFiltro['status'];

$acao = !empty($dadosFiltro ['acao']) ? $dadosFiltro ['acao'] : "";
$captacao_status = !empty($dadosFiltro ['captacao_status']) ? $dadosFiltro ['captacao_status'] : '';
$id_usuario = !empty($dadosFiltro ['vendedor']) ? $dadosFiltro ['vendedor'] : '';
$Filtros = array("captacao_status" => $captacao_status, "id_usuario " => $id_usuario);
$ddd = new Regiao;
$captacao = new Captacao;
$usuario = new Usuarios;

$listaNivelCaptacao = $captacao->selectCaptacaoNiveis();
$listaRegrasNiveisCaptacao = $captacao->selectCaptacaoNiveisRegras("");
$listaInteressesNiveisCaptacao = $captacao->selectCaptacaoNiveisInteresses();

/*
 * *******************************
 * ********** AUDITORIA **********
 * *******************************
 */
$permissao = null;

if (in_array(array("tipo_permissao" => "auditoriaAlarmes"), $_SESSION['user_info']['permissoes'])):
    $permissao = true;
else:
    $permissao = false;
endif;

//CONSULTAR CAPTAÇÃO
if (isset($dadosFiltro['busca'])) {
    $captacao->ListarCaptacaoComFiltro($dadosFiltro['busca']);
}
$captacao->ListarCaptacao(null, $status, $permissao);
$totalR = $captacao->Read()->getRowCount();
$objPaginacao = new paginacao(10, $totalR, PAG, 10);
$objPaginacao->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
$limite = $objPaginacao->limit();
// LISTAR CAPTACAO
$listarCaptacao = $captacao->ListarCaptacao($limite, $status, $permissao);
$total = $captacao->Read()->getRowCount();
/*
 * ***********************************************************************************
 * ********** RESPONSAVEL POR LISTAR OS VENDEDORES COM NIVEIS DE CAPTACAO 1 **********
 * ***********************************************************************************
 */
$usuarioNivelDeCaptacao1 = $usuario->selectUsuariosPorNiveisCaptacao(1);
/*
 * ***********************************************************************************
 * ********** RESPONSAVEL POR LISTAR OS VENDEDORES COM NIVEIS DE CAPTACAO ************
 * ***********************************************************************************
 */
$listaUsuarioComNiveisDeCaptacao = $usuario->selectUsuariosPorNiveisCaptacao(- 1);
$listaUsuariosComPermissaoDeCaptacao = $usuario->selectUsuariosCaptacaoAtiva();
/*
 * **************************************************************
 * ********** RESPONSAVEL LISTAR OS NIVES DE CAPTACAO ***********
 * **************************************************************
 */
$listaNivelCaptacao = $captacao->selectCaptacaoNiveis();
/*
 * **********************************
 * ********** LISTA DE DDD **********
 * **********************************
 */
$arrDDD = $ddd->select();
?>
<style type="text/css">
    .bordaTD > a{ padding: 6px 10px; float: left;}
</style> 

<div class="panel panel-primary">
    <div class="panel-heading">Gerência / Captação</div>
    <div class="panel-body">                
        <ul class="nav nav-tabs" id="tabs"  data-tabs="tabs">
            <li><a href="#tabs-1" data-toggle="tab">Listar Captação</a></li>
            <?php if (!$permissao) { ?>
                <li><a href="#tabs-2" data-toggle="tab">Ativar ou Desativar Vendedor</a></li>
                <?php
            }
            ?>
        </ul>
        <div id="my-tab-content" class="tab-content">
            <div id="tabs-1" class="tab-pane fade">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div id="my-tab-content" class="tab-content">
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <select name="select_filter" class="target form-control" >
                                            <option value="" <?= ($status == '') ? 'selected' : '' ?>>Todos</option>
                                            <option value="novo"  <?= ($status == 'novo') ? 'selected' : '' ?> >Novo</option>
                                            <option value="cancelado" <?= ($status == 'cancelado') ? 'selected' : '' ?>>Cancelado</option>
                                            <option value="comprado" <?= ($status == 'comprado') ? 'selected' : '' ?>>Comprado</option>
                                            <option value="em_agendamento"<?= ($status == 'em_agendamento') ? 'selected' : '' ?>>Em Agendamento</option>
                                            <option value="enviado"<?= ($status == 'enviado') ? 'selected' : '' ?>>Orçamento Enviado</option>
                                            <option value="visita_agendada" <?= ($status == 'visita_agendada') ? 'selected' : '' ?>>Visita Agendada</option>
                                        </select>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    $(".target").change(function () {
                                        var value = $(this).val();
                                        location.href = '?pg=2&status=' + value;
                                    });
                                </script>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <form method="GET" action="" class="">
                                        <div class="form-group">
                                            <input type="hidden" name="pg" value="<?= $dadosFiltro['pg']; ?>">
                                            <input type="hidden" name="status" value="<?= $status; ?>">
                                            <div class="input-group">
                                                <input type="text" name="busca" class="form-control" style="width: 100%">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search    "></span></button>
                                                </div>
                                            </div>
                                        </div>		
                                    </form>
                                </div>
                            </div>
                            <br>
                            <?php
                            if (!empty($listarCaptacao)) {
                                ?>
                                <div class="well well-sm">
                                    <span class="glyphicon glyphicon-trash"></span> => Excluir &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="glyphicon glyphicon-eye-open"></span> => Visualizar 
                                </div>
                                <div class="table-responsive">
                                    <table  class="table table-striped table-bordered  table-hover dataTableBootstrapSemOrdem" cellspacing="0" >
                                        <thead>
                                            <tr>
                                                <th width="5%">Data/Hora</th>
                                                <th>DDD</th>
                                                <th>Telefone</th>
                                                <th>Interesse</th>
                                                <th>Origem</th>
                                                <th>Vendedor</th>
                                                <th>Indicador</th>
                                                <th>Atribuir Para</th>
                                                <th width="5%">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($listarCaptacao as $k => $captacao) :
                                                $interesse = !empty($captacao['ddd1']) ? $captacao['captacao_interesse'] : "";
                                                $data = !empty($captacao['captacao_data_criacao']) ? Funcoes::formataDataComHora($captacao['captacao_data_criacao']) : "";
                                                $ddd = !empty($captacao['ddd1']) ? $captacao['ddd1'] : "";
                                                $origem = !empty($captacao['origem']) ? substr($captacao['origem'], 0, 50) : "";
                                                $cliente = !empty($captacao['captacao_cliente']) ? $captacao['captacao_cliente'] : "";
                                                $telefone = !empty($captacao['captacao_telefone1']) ? $captacao['captacao_telefone1'] : "";
                                                $vendedor = !empty($captacao['vendedor']) ? $captacao['vendedor'] : "";
                                                $usuarioCadastro = !empty($captacao['usuarioCadastro']) ? $captacao['usuarioCadastro'] : "";
                                                $indicador = !empty($captacao['captacao_indicador']) ? $captacao['captacao_indicador'] : "";
                                                ?>
                                                <tr align="center">
                                                    <td width="2%"><?= $data; ?></td>
                                                    <td width="5%" ><?= '(' . $ddd . ')'; ?></td>
                                                    <td width="10%" ><?= $telefone; ?></td>
                                                    <td width="10%" ><?= $interesse; ?></td>
                                                    <td><?= $origem; ?></td>
                                                    <td><?= $vendedor; ?></td>
                                                    <td><?= $indicador; ?></td>
                                                    <td  width="10%" >
                                                        <form name="form-realoca-captacao">
                                                            <select name="cidu" id="cidu" class="form-control selectpicker">
                                                                <option value="" selected="selected">selecione...</option>
                                                                <?php
                                                                $ids = '';
                                                                if ($_SESSION['user_info']['id_usuario'] === '448') {
                                                                    if (isset($listaUsuariosComPermissaoDeCaptacao)) :
                                                                        foreach ($listaUsuariosComPermissaoDeCaptacao as $userCap) :
                                                                            $ids = $userCap ['id'] . "," . $captacao ['captacao_id'];
                                                                            print ' <option value="' . $ids . '">' . $userCap ['usuario'] . '</option> ';
                                                                        endforeach;
                                                                    endif;
                                                                }else {
                                                                    if (isset($listaUsuarioComNiveisDeCaptacao)) :
                                                                        foreach ($listaUsuarioComNiveisDeCaptacao as $userCap) :
                                                                            $ids = $userCap ['id'] . "," . $captacao ['captacao_id'];
                                                                            print ' <option value="' . $ids . '">' . $userCap ['usuario'] . '</option> ';
                                                                        endforeach;
                                                                    endif;
                                                                }
                                                                ?>
                                                            </select> 
                                                            <input type="hidden" name="captacao_status" id="captacao_status" value="novo" />
                                                        </form>
                                                    </td>
                                                    <td  width="2%">
                                                        <table width="80px">
                                                            <tr>
                                                                <?php if (!$permissao) { ?>
                                                                    <td>
                                                                        <form action="modulos/captacao/src/controllers/captacao.php" method="post" name="form-exclui-captacao" class="form-exclui-captacao loadForm">
                                                                            <input type="hidden" name="id_captacao" value="<?= $captacao['captacao_id']; ?>"> 
                                                                            <input type="hidden" name="acao" value="DeleteCaptacao"> 
                                                                            <button type="submit" class="btn btn-sm btn-danger botaoLoadForm">
                                                                                <span class="glyphicon glyphicon-trash"></span>
                                                                            </button>
                                                                        </form>
                                                                    </td>
            <?php
        }
        ?>
                                                                <td>
                                                                    <a href="index.php?pg=55&id=<?= $captacao['captacao_id']; ?>&acao=visualizar&voltar=2" class="btn btn-sm btn-success">
                                                                        <span class="glyphicon glyphicon-eye-open"></span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td> 
                                                </tr>
        <?php
    endforeach;
    ?>	
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="9">
                                                    Registros encontrados: <?= $totalR; ?>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
    <?php
    $objPaginacao->MontaPaginacao();
} else {
    echo Funcoes::Nregistro();
}
?>
                        </div>
                    </div>
                </div>
            </div>
<?php if (!$permissao) { ?>
                <div id="tabs-2" class="tab-pane fade">
                    <div class="panel panel-info">
                        <div class="panel-body">

                            <!--
                              ***********************************************************************************
                              *********** LEIA AS REGRAS ABAIXO PARA INSERIR CORRETAMEMENTE OS FILTROS **********
                              ***********************************************************************************
                            -->

    <?php if (in_array(array("tipo_permissao" => "desenvolvedor"), $_SESSION ['user_info'] ['permissoes'])) { ?>	
                                <!--
                                  ***************************************************
                                  *********** INSERE OS NÍVEIS DE CAPTAÇÃO **********
                                  ***************************************************
                                -->
                                <div class="panel panel-primary">
                                    <div class="panel-heading ">.: Aqui você pode cadastrar niveis de captações</div>
                                    <div class="panel-body"> 
                                        <form method="post" action="modulos/captacao/src/controllers/captacao.php">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label>Descrição:</label>
                                                        <input type="text" name="captacao_niveis_desc" required class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label>Nível:</label>
                                                        <select name="captacao_niveis_ra" class="form-control selectpicker">
        <?php foreach ($listaNivelCaptacao as $na) { ?>
                                                                <option value="<?= $na['captacao_niveis_ra'] ?>;"><?= $na['captacao_niveis_ra'] . " - " . $na['captacao_niveis_ra_desc']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                    <br>
                                                    <div class="form-actions">
                                                        <input type="hidden" value="cadastrarNivelCaptacao" name="acao">
                                                        <button  type="submit" class="btn btn-primary">
                                                            Adicionar
                                                        </button>
                                                    </div>
                                                </div>  
                                                </tr>
                                            </div>
                                        </form>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <tr>
                                                    <td><strong>ID</strong></td>
                                                    <td><strong>Descrição</strong></td>
                                                </tr>
        <?php foreach ($listaNivelCaptacao as $k => $n) { ?>
                                                    <tr>
                                                        <td align="center"><?= $n['captacao_niveis_id']; ?></td>
                                                        <td><?= $n['captacao_niveis_desc']; ?></td>
                                                    </tr>
            <?php
        }
        ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--
                                  **************************************************************
                                  *********** INSERE AS REGRAS DOS NÍVEIS DE CAPTAÇÃO **********
                                  **************************************************************
                                -->
                                <div class="panel panel-primary">
                                    <div class="panel-heading ">.:Aqui você pode cadastrar diversos tipos de Regras ex: (entre 11 e 19),ou (diferente de 11 e 19)</div>
                                    <div class="panel-body"> 
                                        <form method="post" action="modulos/captacao/src/controllers/captacao.php">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                    <div class="form-group">
                                                        <label>Descrição:</label>
                                                        <input type="text" name="captacao_niveis_regras_desc" required  title="preencha uma descrição para nova Regra" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label>Relação:</label>
                                                        <select name="relacao" class="form-control selectpickerNormal">
                                                            <option value="2">Entre</option>
                                                            <option value="1">Diferente</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                                                    <div class="form-group">
                                                        <label>DDD1:</label>
                                                        <input type="text" name="ddd1" required class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                                                    <div class="form-group">
                                                        <label>DDD2:</label>
                                                        <input type="text" name="ddd2" required class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                    <div class="form-actions">
                                                        <br>
                                                        <input type="hidden" value="cadastrarRegraNivelCaptacao" name="acao">
                                                        <input type="hidden" value="2" name="captacao_niveis_regras_nivel">
                                                        <button  type="submit" class="btn btn-primary">
                                                            Adicionar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <form method="post" action="modulos/captacao/src/controllers/captacao.php">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                    <div class="form-group">
                                                        <label>Descrição:</label>
                                                        <input type="text" name="captacao_niveis_regras_desc" required class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                    <div class="form-group">
                                                        <label>DDDs:</label>
                                                        <input type="text" name="ddd" id="txt_filtroDDD2" required class="form-control">
                                                    </div>
                                                </div>
                                                <div>
                                                    <br>
                                                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                                        <select id="slct_filtroDDD2" name="slct_filtroDDD" class="form-control selectpicker">
                                                            <option value="--" selected="selected">--</option> 
        <?php
        if (!empty($arrDDD)) {
            foreach ($arrDDD as $ddd) :
                echo "<option value=\"{$ddd['regiao_ddd']}\">{$ddd['regiao_ddd']}</option>";
            endforeach;
        }
        ?> 
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                    <div class="form-actions">
                                                        <input type="hidden" value="cadastrarRegraNivelCaptacao" name="acao">
                                                        <input type="hidden" value="1" name="captacao_niveis_regras_nivel">
                                                        <button  type="submit" class="btn btn-primary">
                                                            Adicionar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <tr align="center">
                                                    <td><strong>ID</strong></td>
                                                    <td><strong>Descrição</strong></td>
                                                </tr>
        <?php foreach ($listaRegrasNiveisCaptacao as $k => $n) { ?>
                                                    <tr>
                                                        <td align="center"><?= $n['captacao_niveis_regras_id']; ?></td>
                                                        <td><?= $n['captacao_niveis_regras_desc']; ?></td>
                                                    </tr>	
            <?php
        }
        ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--
                                      ******************************************************************
                                      *********** INSERE OS INTERESSES DOS NÍVEIS DE CAPTAÇÃO **********
                                      ******************************************************************
                                -->
                                <div class="panel panel-primary">
                                    <div class="panel-heading ">:Interesses niveis de captação</div>
                                    <div class="panel-body"> 
                                        <form method="post" action="modulos/captacao/src/controllers/captacao.php">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label>Descrição:</label>
                                                        <input type="text" name="captacao_niveis_interesses_desc" required class="form-control" >
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label>Nível:</label>
                                                        <select name="captacao_niveis_interesses_nivel" required style="padding: 0 10px 0;" class="form-control selectpicker">
        <?php
        if (!empty($listaNivelCaptacao)) :
            foreach ($listaNivelCaptacao as $nivel) :
                echo "<option value=\"{$nivel['captacao_niveis_id']}\">{$nivel['captacao_niveis_desc']}</option>";
            endforeach;
        endif;
        ?>       
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                    <br>
                                                    <div class="form-actions">
                                                        <input type="hidden" value="cadastrarInteresseNivelCaptacao" name="acao">
                                                        <button  type="submit" class="btn btn-primary">
                                                            Adicionar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <tr align="center">
                                                    <td><strong>ID</strong></td>
                                                    <td><strong>Descrição</strong></td>
                                                    <td><strong>Niveis</strong></td>
                                                </tr>
        <?php foreach ($listaInteressesNiveisCaptacao as $k => $n) { ?>
                                                    <tr>
                                                        <td class="textAlign"><?= $n['captacao_niveis_interesses_id'] ?></td>
                                                        <td class="textAlign"><?= $n['captacao_niveis_interesses_desc'] ?></td>
                                                        <td class="textAlign"><?= $n['captacao_niveis_desc'] ?></td>
                                                    </tr>		
        <?php }
        ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>

    <?php } ?>

                            <!--
                              *********************************************************************************
                              *********** FORMULARIO RESPONSAVEL POR ADICIONAR OS NIVEIS DE CAPTAÇÃO **********
                              ********************************************************************************* 
                            -->
                            <div class="panel panel-primary">
                                <div class="panel-heading ">.: Atribuir niveis de captação</div>
                                <div class="panel-body"> 
                                    <div class="alert alert-warning " role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span>  Atenção: <br> <br>Sempre que uma Regra estiver  sem um vendedor selecionado. <br>
                                        Todas as  suas captações pertensentes a mesma, serão redirecionadas para um (Vendedor - Auxiliar).</div>

                                    <form method="post" action="modulos/captacao/src/controllers/captacao.php">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <label>Vendedor:</label>
                                                    <select name="captacao_niveis_usuarios_id_usuario" class="form-control selectpicker" required >
                                                        <option value="" selected="selected">-------</option>
    <?php
    foreach ($listaUsuariosComPermissaoDeCaptacao as $userPermissao) :
        echo ' <option value="' . $userPermissao ['id'] . '">' . $userPermissao ['usuario'] . '</option> ';
    endforeach;
    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <label>Nível:</label>
                                                    <select name="captacao_niveis_usuarios_captacao_niveis_id" required  class="form-control selectpicker" id="nivelSwitch">
    <?php
    if (!empty($listaNivelCaptacao)) :
        foreach ($listaNivelCaptacao as $nivel) :
            echo "<option value=\"{$nivel['captacao_niveis_id']}\">{$nivel['captacao_niveis_desc']}</option>";
        endforeach;
    endif;
    ?>
                                                    </select>		
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <label>Regra:</label>
                                                    <select name="captacao_niveis_usuarios_regra_id" class="form-control selectpicker" id="regraSwitch">
    <?php
    if (!empty($listaRegrasNiveisCaptacao)) :
        foreach ($listaRegrasNiveisCaptacao as $nivel) :
            echo "<option value=\"{$nivel['captacao_niveis_regras_id']}\">{$nivel['captacao_niveis_regras_desc']}</option>";
        endforeach;
    endif;
    ?>
                                                    </select>	
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                <br>
                                                <div class="form-actions">
                                                    <input type="hidden" name="acao" value="InsertNivelCaptacaoUsuario"> 
                                                    <button  type="submit" class="btn btn-primary">
                                                        Adicionar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
    <?php
    // listar usuarios :
    if (!empty($listaUsuarioComNiveisDeCaptacao)) :
        ?>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <tr>
                                                    <th colspan="6" align="center">.: Lista de Vendedores com niveis de captação </th>
                                                </tr>
                                                <tr>
                                                    <td>Usuário</td>
                                                    <td>Nível</td>
                                                    <td>Regra</td>
                                                    <td>Status</td>
                                                    <td>Desativar</td>
                                                    <td>Excluir</td>
                                                </tr>
        <?php
        foreach ($listaUsuarioComNiveisDeCaptacao as $k => $li) :
            $status = $li['captacao_niveis_usuarios_ativo'] == 1 ? "Ativo" : "Inativo";
            ?>
                                                    <tr>
                                                        <td align="center"><?= $li['usuario']; ?></td>
                                                        <td align="center"><?= $li['captacao_niveis_desc']; ?></td>
                                                        <td align="center"><?= ($li['captacao_niveis_regras_desc']) ? $li['captacao_niveis_regras_desc'] : "Todos DDDS"; ?></td>
                                                        <td align="center"><?= $status; ?></td>
                                                        <!--RESPONSAVEL POR DELETAR OS NIVEIS DE CAPTACAO DE UM VENDEDOR 'XY'-->
            <?php if ($li['captacao_niveis_usuarios_ativo'] == 1) { ?>
                                                            <td width="2%" align="center">
                                                                <a class="botaoLoad  btn btn-sm btn-primary" href="modulos/captacao/src/controllers/captacao.php?acao=alterarStatusNivelVendedor&captacao_niveis_usuarios_ativo=2&captacao_niveis_usuarios_id=<?= $li['captacao_niveis_usuarios_id'] . "&captacao_niveis_usuarios_id_usuario=" . $li['id']; ?>"><span class="glyphicon glyphicon-ban-circle"></span></a>
                                                            </td>
            <?php } else { ?>
                                                            <td width="2%" align="center">
                                                                <a class="botaoLoad  btn btn-sm btn-success" href="modulos/captacao/src/controllers/captacao.php?acao=alterarStatusNivelVendedor&captacao_niveis_usuarios_ativo=1&captacao_niveis_usuarios_id=<?= $li['captacao_niveis_usuarios_id'] . "&captacao_niveis_usuarios_id_usuario=" . $li['id']; ?>"><span class="glyphicon glyphicon-record"></span></a>
                                                            </td>
            <?php } ?>
                                                        <td width="2%" align="center">
                                                            <a class="botaoLoad deleteCaptacao btn  btn-sm btn-danger" id="<?= $li['captacao_niveis_usuarios_id'] . "_" . $li['id']; ?>"><span class="glyphicon glyphicon-trash"></span></a>
                                                        </td>
                                                    </tr>
            <?php
        endforeach;
        ?>
                                            </table>
                                        </div>
                                                <?php
                                            endif;
                                            ?> 
                                </div>
                            </div>
                            <!--
                              *************************************************************************
                              *********** ATRIBUIR FILTRO DE (DDD) PARA OS VENDEDORES ATIVOS **********
                              *************************************************************************
                            -->
                            <div class="panel panel-primary">
                                <div class="panel-heading ">.: Adicionar Filtros de (DDD) para usuarios com nivel de captação = 1 (rastreamento)</div>
                                <div class="panel-body"> 
                                    <form>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <label>Vendedor:</label>
                                                    <select name="captacao_idu3" id="captacao_idu3"  class="form-control selectpicker">
                                                        <option value="" selected="selected">-------</option>
    <?php
    if (!empty($usuarioNivelDeCaptacao1)) {
        foreach ($usuarioNivelDeCaptacao1 as $usuarioCap1) :
            print ' <option value="' . $usuarioCap1 ['id'] . '">' . $usuarioCap1 ['usuario'] . '</option> ';
        endforeach
        ;
    }
    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" id="td_filtrarDDD">
                                                <br>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <input type="checkbox" id="ck_filtrarDDD" name="ck_filtrarDDD" class=""/>
                                                        </span>
                                                        <input type="text" class="form-control" value="SEM FILTRO DE DDD" readonly id="lable_ckFiltroddd">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="filtroDeDDD">
                                                <div class="form-group">
                                                    <label>FILTRO DE DDD:</label>
                                                    <div class="input-group">
                                                        <input type="text" id="txt_filtroDDD1" size="20" value="" class="form-control"/> 
                                                        <span class="input-group-addon">
                                                            <select id="slct_filtroDDD1" name="slct_filtroDDD" class="">
                                                                <option value="--" selected="selected">--</option> 
    <?php
    if (!empty($arrDDD)) {
        foreach ($arrDDD as $ddd) :
            echo "<option value=\"{$ddd['regiao_ddd']}\">{$ddd['regiao_ddd']}</option>";
        endforeach
        ;
    }
    ?> 
                                                            </select> 
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                <br>
                                                <div class="form-actions">
                                                    <button  type="button" class="btn btn-primary" id="btn_filtroddd" name="btn_filtroddd">
                                                        Confirmar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <br>
                                    <div class="table-responsive">               
                                        <table class="table table-bordered table-hover table-striped" id="tabelaUsuarios">
                                            <tr>
                                                <th colspan="3" align="center">.: Lista de Vendedores com Filtro de (DDD)</th>
                                            </tr>
                                            <tr>
                                                <th>Usuários com nivel de captação 1</th>
                                                <th>SEM FILTRO</th>
                                                <th>COM FILTRO</th>
                                            </tr>
    <?php
    if (!empty($usuarioNivelDeCaptacao1)) {
        foreach ($usuarioNivelDeCaptacao1 as $k => $usuarioNivel1) :
            $listaDDDUsuario = $usuario->selecionarDddsUsuarioString($usuarioNivel1 ['id']);
            $img = ($listaDDDUsuario == "") ? "<img src='public/img/ico_ok.png' width='12px' height='12px' />" : "";
            echo "
                                                         <tr align=\"center\">
                                                            <td>&nbsp;{$usuarioNivel1['usuario']}</td> 
                                                            <td align=\"center\">{$img}</td> 
                                                            <td align=\"center\"> " . $listaDDDUsuario . "</td> 
                                                        </tr> ";
        endforeach;
    }
    ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php }
?>
        </div>	
    </div>
</div>
