<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="?pg=0">GPI</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php if (in_array($monitoramento, $permissoes) || in_array($supervisorUVA, $permissoes) || in_array($monitoramento2, $permissoes)) { ?>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Monitoramento <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                                <li><a href="index.php?pg=1">Abertura de captação</a></li>
                            <?php if (in_array($monitoramento, $permissoes)) { ?>
                                <li><a href="index.php?pg=26">Acicionamento de viaturas</a></li>
                            <?php } ?>
                            <?php if (in_array($desenvolvedor, $permissoes)|| in_array($monitoramento, $permissoes)) { ?>
                                <li><a href="index.php?pg=51">Sinistros</a></li>
                                <li><a href="index.php?pg=48">Guinchos</a></li>
                                <li><a href="index.php?pg=49">Assistência</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
            <?php } ?>
            <?php if (in_array($arquivo, $permissoes)) { ?>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Arquivo <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?pg=24">Listar</a></li>
                        </ul>
                    </li>
                </ul>
            <?php } ?>
            <?php if (in_array($captacao, $permissoes)) { ?>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Comercial <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?pg=18">Captação</a></li>
							 <li><a href="index.php?pg=70">Detran</a></li>
                            <?php if (!in_array($vendasGuaiba, $permissoes)|| $_SESSION['user_info']['id_usuario'] == 471) { ?>
                                <li><a href="index.php?pg=12">Clientes</a></li>
                                <li><a href="index.php?pg=15#settings">Contratos</a></li>
                            <?php } ?>

                        </ul>
                    </li>
                </ul>
            <?php } ?>
            <?php if (in_array($pedidoComissao, $permissoes) || in_array($confComissao, $permissoes)) { ?>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Comissão <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php if (in_array($pedidoComissao, $permissoes)) { ?>
                                <li><a href="index.php?pg=5">Adicionar</a></li>
                            <?php } ?>
                            <?php if (in_array($confComissao, $permissoes)) { ?>
                                <li><a href="index.php?pg=8">Conferir</a></li>
                                <li><a href="index.php?pg=9">Relatório</a></li>
                                <li><a href="index.php?pg=7">Planilhas Arquivadas</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
            <?php } ?>
            <?php if (in_array($gerente, $permissoes) || in_array($auditoria, $permissoes) || $_SESSION['user_info']['id_usuario'] == 491) { ?>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Ger&ecirc;ncia <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?pg=2">Captação</a></li>
                            <?php if (in_array($gerente, $permissoes) || $_SESSION['user_info']['id_usuario'] == 491) { ?>
                                <li><a href="index.php?pg=58">Migrar captação</a></li>
                                <li><a href="index.php?pg=3">Relatórios</a></li>
                                <li><a href="index.php?pg=57">Gráficos</a></li>
                                <li><a href="index.php?pg=54&acao=listar">Certificados</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
            <?php } ?>
            <?php if (in_array($rh, $permissoes) || in_array($desenvolvedor, $permissoes) || in_array($supervisor, $permissoes)) { ?>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">RH<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php if (in_array($rh, $permissoes)) { ?>
                                <li><a href="index.php?pg=53">Currículos</a></li>
                            <?php } ?>
                            <?php if (in_array($desenvolvedor, $permissoes)) { ?>
                                <li><a href="index.php?pg=4">Usuários</a></li>
                                <li><a href="index.php?pg=53">Currículos</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
            <?php } ?>
            <?php if (in_array($administrativo, $permissoes) || in_array($consulta, $permissoes) || in_array($auditoriaAlertas, $permissoes)) { ?>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Administrativo<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php if (in_array($consulta, $permissoes)) { ?>
                                <li><a href="index.php?pg=12&acao=ex">Consulta Externa </a></li>
                                <li><a href="index.php?pg=14">Consulta Interna </a></li>
                                <?php
                            }
                            if (in_array($administrativo, $permissoes)) {
                                ?>
                                <li><a href="index.php?pg=17">Contratos </a></li>
                                <li><a href="index.php?pg=41&acao=reprovados">Reprovados </a></li>
                            <?php } ?>
                            <?php if (in_array($auditoriaAlertas, $permissoes)) { ?>
                                <li><a href="index.php?pg=52">Auditoria Alertas</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
            <?php } ?>
            <?php if (in_array($desenvolvedor, $permissoes)) { ?>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Log<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?pg=41">Listar</a></li>
                        </ul>
                    </li>
                </ul>
            <?php } ?>
            <?php if (in_array($almoxarifado, $permissoes) || in_array($programacao, $permissoes)) { ?>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Almoxarifado<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php if (in_array($desenvolvedor, $permissoes)) { ?>
                                <li><a href="index.php?pg=46">Chips</a></li>
                            <?php } ?>
                            <?php if (in_array($almoxarifado, $permissoes)) { ?>
                                <li><a href="index.php?pg=47">Produtos</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
            <?php } ?>
			
			<?php if (in_array($sac, $permissoes) || in_array($sac_admin, $permissoes)) { ?>
            <ul class="nav navbar-nav ">
                <li><a href="index.php?pg=60">SAC</a></li>
            </ul>
            <?php  } ?>
			
            <ul class="nav navbar-nav ">
                <li>
                    <form class="navbar-form" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar" name="usuarioRamal">
                            <input type="hidden" name="acao" value="buscarRamal">
                            <input type="hidden" name="pg" value="11">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </li>
            </ul>

            <ul class="nav navbar-nav " style="float: right">
                <li>
                    <a href="javascript:void(0);">Bem vindo , <?php echo ucfirst($_SESSION['user_info']['usuario']); ?></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false" title="Ramal"> <span class="glyphicon glyphicon-cog"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="application/controllers/logar.php?act=2"> Sair </a></li>
                        <li><a id="modulos/usuarios/src/views/formularios/modal_alterar_meus_dados.php?id_u=<?= $_SESSION['user_info']['id_usuario']; ?>&tela=editar" class="modalOpen  " data-target="#modal">Alterar senha</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="index.php?pg=11&acao=listarRamais">Lista Ramais</a></li>
                        <li><a id="modulos/ramal/src/views/formularios/form.php?acao=inserir"  class="botaLoad modalOpen _cursor-pointer" data-target="#modal">Cadastrar Ramal</a>
                        </li>
                        <?php if (in_array($recepcao, $permissoes) || in_array($desenvolvedor, $permissoes)) { ?>
                            <li><a href="index.php?pg=11&acao=atualizarRamal">Atualizações Ramal</a></li>
                        <?php } else if (in_array($recepcaoMaster, $permissoes)) { ?>
                            <li>
                                <a href="index.php?pg=11&acao=atualizarRamal">Atualizações Ramal</a>
                                <a id="modulos/ramal/src/views/formularios/modalRamal.php"   class="botaLoad modalOpen _cursor-pointer" data-target="#modal">Cadastrar Setor/Base</a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>