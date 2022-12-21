<?php
/**
 * Created by PhpStorm.
 * User: desenvolvimento02
 * Date: 06/11/2017
 * Time: 10:54
 */
?>

<div class="panel panel-primary">
    <div class="panel-heading">Listar Certificados</div>
    <div class="panel-body">
        <?php echo $alert; ?>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-default" style="margin-bottom: 20px;" href="<?php echo BASE_URL ?>/gpi/index.php?pg=54&acao=formulario&tipo=adicao"><span class="glyphicon glyphicon-plus"></span> Novo Certificado</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="well well-sm">
                    <span class="glyphicon glyphicon-download"></span> => Download &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-pencil"></span> => Editar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-th-list"></span> => Renovar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-envelope"></span> => Enviar Email
                </div>
            </div>
        </div>
        <?php echo $certificadosTabela; ?>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

</script>
