<?php
for ($i = 0; $i < count($_SESSION['user_info']['permissoes']); $i++) {
    $_permissao[] = $_SESSION['user_info']['permissoes'][$i]['tipo_permissao'];
}
if (in_array('sesmt', $_permissao)) {  ?>
    <div class="panel panel-primary">
        <div class="panel-heading ">Sesmt</div>
        <div class="panel-body">
            <div class="card">
                <div class="card-header text-center py-1 RVEQke">
                </div>
                <div class="card-body ">
                    <blockquote class="blockquote">
                        <h1 class="F9yp7e">
                            <b>AVALIAÇÃO PERFIL LABORAL</b>
                        </h1>
                        <p class="c2gzEf">
                            A Ginástica Laboral é a prática de atividades físicas
                            leves no local de trabalho, com o objetivo de prevenir e aliviar dores e incômodos que
                            ocorrem devido às atividades dos colaboradores.
                        </p>
                    </blockquote>
                </div>
            </div>
            <div class="card">
                <div class="card-body ">
                    <blockquote class="blockquote">
                        <p>
                            Com o intuito de melhorar nossa ginástica laboral, gostaríamos que respondesse o questionário:
                        </p>
                        <a href="index.php?pg=72" class="btn btn-success  btn-lg">Clique aqui</a>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
<?php
}

if (in_array('captacao', $_permissao)) {  ?>
    <div class="panel panel-primary">
        <div class="panel-heading ">Notificações</div>
        <div class="panel-body">
            <?php
            $agenda = new AgendaContato;
            $agenda->selectPorUsuarioData([
                'id' => $_SESSION['user_info']['id_usuario'],
                'agenda_contato_status' => 0,
            ]);
            $totalAgendamento = $agenda->Read()->getRowCount();
            $captacao = new Captacao();
            $filtros['id'] = $_SESSION['user_info']['id_usuario'];
            $filtros['status'] = 'novo';
            $captacao->selectCaptacaoUser($filtros, null);
            $total_captacao = $captacao->Read()->getRowCount();
            ?>
            <table class="table  table-striped">
                <thead>
                    <th colspan="2">
                        <h1 style="color: red ; font-size: 16px">Atenção !</h1>
                    </th>
                </thead>
                <tbody>
                    <?php if ($totalAgendamento >= 1) { ?>
                        <tr>
                            <td> Você possui : <b><?= $totalAgendamento; ?></b> Captações Agendada.</td>
                            <td><a href="?pg=18#tabs-2"><span class="glyphicon glyphicon-eye-open" aria-hidden="true" title="Clique aqui para Visualizar"></span></a></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td>Você possui :<b><?= $total_captacao; ?></b> Captações Novas .</td>
                        <td>
                            <a href="?pg=18&status=novo"><span class="glyphicon glyphicon-eye-open" aria-hidden="true" title="Clique aqui para Visualizar"></span></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php
}

if (in_array('desenvolvedor', $_permissao)) {  ?>
    <div class="panel panel-primary">
        <div class="panel-heading "> <strong>Usúarios!</strong> Ativos com menos de 90 dias , sem se Logar.</div>
        <div class="panel-body">
            <iframe src="<?= '/gpi/modulos/agendarTarefas/inativarUsuario.php' ?>" style="border:none ;height:400px;width: 100%;"></iframe>
        </div>
    </div>
    <!--  

<div class="panel panel-primary">
        <div class="panel-heading ">Captações do dia atual.</div>
        <div class="panel-body"> 
            <iframe src="<?= '/gpi/modulos/captacao/src/controllers/log_insert_captacao_' . date('d-m-y') . '.txt'; ?>"  
                style="border:none ;height: 400px;width: 100%;">
                
            </iframe>
        </div>
    </div>

    -->

<?php } ?>