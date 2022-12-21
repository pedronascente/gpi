<div id="box-avisos" align="center">
    <?php
    if (in_array(array('tipo_permissao' => 'captacao'), $_SESSION ['user_info'] ['permissoes'])) {
        $id_usuario = isset($_SESSION ['user_info'] ['id_usuario']) ? $_SESSION ['user_info'] ['id_usuario'] : NULL;
        $agenda = new AgendaContato;
        $data = date("Y-m-d");
        $data = $data . " 23:59:00";
        $agenda->selectPorUsuarioData(array("id_usuario" => $id_usuario, "data" => $data, "status" => 0));
        $avisosUsuario = 0;
        $avisosUsuario = $agenda->Read()->getRowCount();
        if ($avisosUsuario > 0) {
            ?>


            <a href="index.php?pg=18#tabs-2">Você tem <?= $avisosUsuario; ?> pendências.</a></b>

    <?php }
} ?>

</div>
