<?php

$mostrar_notificacao = false;

for($i=0;$i< count($_SESSION['user_info']['permissoes']);$i++) {
    if($_SESSION['user_info']['permissoes'][$i]['tipo_permissao']=='captacao'){
        $mostrar_notificacao = true;
    }
}

?>

<?php   if (isset($_SESSION['user_info']['id_usuario']) && $_SESSION['user_info']['id_usuario']==471){  ?>
    <div class="panel panel-primary">
        <div class="panel-heading "> <strong>Usúarios!</strong>  Ativos com menos de 90 dias , sem se Logar.</div>
        <div class="panel-body"> 
            <iframe src="<?='/gpi/modulos/agendarTarefas/inativarUsuario.php'?>"  style="border:none ;height: 200PX;width: 100%;"></iframe>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading ">Captações do dia atual.</div>
        <div class="panel-body"> 
            <iframe src="<?= '/gpi/modulos/captacao/src/controllers/log_insert_captacao_' . date('d-m-y') . '.txt'; ?>"  
                style="border:none ;height: 400px;width: 100%;">
                
            </iframe>
        </div>
    </div>

<?php } ?>


<?php  if( $mostrar_notificacao ){ ?>

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
        $captacao = new Captacao ();
        $filtros['id'] = $_SESSION['user_info']['id_usuario'];
        $filtros['status'] = 'novo';
        $captacao->selectCaptacaoUser($filtros, null);
        $total_captacao = $captacao->Read()->getRowCount();
        ?>
        <table class="table  table-striped">
            <thead>
            <th colspan="2"><h1 style="color: red ; font-size: 16px">Atenção !</h1></th>
            </thead>
            <tbody>
                <?php if ($totalAgendamento >= 1) { ?>
                    <tr> 
                        <td> Você possui : <b><?= $totalAgendamento; ?></b>  Captações Agendada.</td>
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

<?php  } ?>
