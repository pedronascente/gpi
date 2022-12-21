<?php
include_once ('Config.inc.php');
$busca = filter_input(INPUT_GET, "busca");
$ativo = filter_input(INPUT_GET, "ativo") != null ? filter_input(INPUT_GET, "ativo") : 1;
$result = filter_input(INPUT_GET, 'result', FILTER_DEFAULT);
$usuario = new Usuarios();

if (!empty($busca))
    $usuario->setFiltros($busca);

$usuario->selecionarTodos(null, false, $ativo);
$total = $usuario->Read()->getRowCount();

//REALIZA PAGINACAO:
$objPaginacao = new paginacao(10, $total, PAG, 10);
$objPaginacao->_pagina = PAGINA . "&busca=" . $busca . "&ativo=" . $ativo;
$limite = $objPaginacao->limit();

//LISTA DOS USUARIOS :
$lista_usuarios = $usuario->selecionarTodos($limite, false, $ativo);

if ($result == "on") {
    echo'<div class="alert alert-success">Registro salvo com sucesso!</div>';
} 
?>
<div class="panel panel-primary">
    <div class="panel-heading "> Gerenciador de Usuários</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <div class="btn-group" role="group" aria-label="...">
                    <a href="index.php?pg=21" class="btn btn-success">Cadastrar</a>
                    <a id="modulos/usuarios/src/views/formularios/modal_atribuirPermissao.php?tela=cadastrar" class="botaoLoad btn btn-primary modalOpen" data-target="#modal">Permissões</a>
                    <a id="modulos/usuarios/src/views/formularios/modal_cadastrarAssinatura.php" class="botaoLoad btn btn-info modalOpen" data-target="#modal">Assinatura Digital</a>
                    <a id="modulos/usuarios/src/views/formularios/modal_atribuirPlanilhaComissao.php?tela=cadastrar" class="botaoLoad btn btn-default modalOpen" data-target="#modal">Planilhas</a>
                    <a id="modulos/usuarios/src/views/formularios/modal_resetSenha.php" class="botaoLoad btn btn-danger modalOpen" data-target="#modal">Reset</a>
                </div>
            </div>
        </div><br><br>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                <select class="form-control" name="status" id="statusUsuario">
                    <option value="1" <?= $ativo == 1 ? "selected" : ""; ?>>Ativos</option>
                    <option value="2" <?= $ativo == 2 ? "selected" : ""; ?>>Inativos</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="float: right">
                <?php
                $formularioBusca = new FormularioDeBusca;
                $formularioBusca->setPg($pg);
                $formularioBusca->setFiltro('busca');
                $formularioBusca->setMethod("GET");
                $formularioBusca->setValue($busca);
                $formularioBusca->setHiddens(array("ativo" => $ativo));
                $formularioBusca->formBusca();
                ?>
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped dataTableBootstrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nome</th>
                        <th>Setor</th>
                        <th>Cargo</th>
                        <th>Empresa</th>
                        <th>Ativo</th>
                        <th align="center" width="2%">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($lista_usuarios) :
                        foreach ($lista_usuarios as $k => $li) :
                            $id = !empty($li ['id']) ? $li ['id'] : NULL;
                            $usuario = !empty($li ['usuario']) ? $li ['usuario'] : NULL;
                            $nome = !empty($li ['nome']) ? $li ['nome'] : NULL;
                            $ativo = !empty($li ['ativo']) ? $li ['ativo'] : NULL;
                            $setor_local = !empty($li ['setor_local']) ? $li ['setor_local'] : NULL;
                            $cargo = !empty($li ['cargo_descricao']) ? $li ['cargo_descricao'] : NULL;
                            switch ($li ['id_empresa']) {
                                case'1': $empresa = 'VPSP'; break;
                                case'2': $empresa = 'VH'; break;
                                case'3': $empresa = 'VP - Alarmes';break;
                                case'4': $empresa = 'VP - Guaíba'; break;
                                case'5': $empresa = 'Volpmann - Matriz'; break;
                                case'6': $empresa = 'Volpmann - Filial'; break;
                                case'7': $empresa = 'Volpato - Matriz'; break;
                                case'8': $empresa = 'Volpato - Tramandaí';break;
								case'9': $empresa = 'Volpato - Filial'; break;
                                case'10': $empresa = 'Easyseg'; break;
                                default :$empresa = 'nenhuma';
                            }
                            echo "<tr align=\"center\">
                                    <td>{$id}</td>
                                    <td>{$usuario}</td>
                                    <td>{$nome}</td>
                                    <td>{$setor_local}</td>
                                    <td>{$cargo}</td>
                                    <td>{$empresa}</td>
                                    <td> " . (($ativo == 1) ? 'Sim' : 'Não') . " </td>
                                    <td align=\"center\">
                                       <a href=\"index.php?pg=21&id={$id}&acao=editar\"  class=\"btn  btn-sm btn-info\">
                                               <span class='glyphicon glyphicon-pencil'></span>
                                       </a>
                                    </td>
                            </tr>";
                        endforeach
                        ;
                    endif;
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">Registros encontrados: <?= $total; ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php $objPaginacao->MontaPaginacao(); ?>
    </div>
</div>
