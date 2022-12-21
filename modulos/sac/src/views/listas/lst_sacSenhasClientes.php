<?php
$cliente->selectLoginCliente($id);
$totalSenha = $cliente->Read()->getRowCount();
$objPaginacao1 = new paginacao(10, $totalSenha, PAG, 10);
$objPaginacao1->_pagina = PAGINA . Funcoes::getParametrosURL($dadosFiltro);
$objPaginacao1->SetTabs('#cliente');
$limite = $objPaginacao1->limit();
$listaSenhas = $cliente->selectLoginCliente($id, $limite);

?>
<div class="panel panel-primary">
    <div class="panel-heading ">Logins</div>
    <div class="panel-body">
        <div class="table-responsive">
            <?php if (!empty($listaSenhas)) { ?>
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Login</th>
                            <th>Senha</th>
                            <?php if(empty($p)){?>
                            <th width="5%">Excluir</th>
                            <?php }?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($listaSenhas as $k => $s) {
                            $id_sistema = isset($s['id']) ? $s['id'] : null;
                            $login = isset($s['login_sistema']) ? $s['login_sistema'] : null;
                            $senha = isset($s['senha_sistema']) ? $s['senha_sistema'] : null;
                            ?>
                            <tr align="center">
                                <td><?= $login; ?></td>
                                <td><?= $senha; ?></td>
                                <?php if(empty($p)){?>
                                <td>
                                    <a id="modulos/sac/src/controllers/sac.php?acao=excluirLogin&id=<?= $id_sistema; ?>&id_cliente=<?= $id; ?>" class="botaoLoad confimarDeleteLink btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                                </td>
                                <?php }?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php
                if (!empty($objPaginacao1))
                    $objPaginacao1->MontaPaginacao();
            } else {
                Funcoes::Nregistro();
            }
            ?>
            <?php if(empty($p)){?>
            <a id="modulos/sac/src/views/formularios/modalInsertSenhas.php?&acao=cadastrarLogin&id_cliente=<?= $id; ?>" class="botaoLoad modalOpen btn btn-default" data-target="#modal">Adicionar Login</a>
        	 <?php }?>
        </div>
    </div>
</div>
