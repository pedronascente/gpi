<?php
/**
 * Created by PhpStorm.
 * User: desenvolvimento02
 * Date: 06/11/2017
 * Time: 10:54
 */
?>
<div class="panel panel-primary">
    <div class="panel-heading">Adicionar Certificado</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-default" style="margin-bottom: 20px;"
                   href="<?php echo BASE_URL ?>/gpi/index.php?pg=54&acao=listar"><span
                            class="glyphicon glyphicon-menu-left"></span> Voltar</a>
            </div>
        </div>
        <?php echo $certificadosFormulario; ?>
    </div>
</div>
<script type="text/javascript">
    $('#formulario').submit(function () {
        var parts = $('#expiracao').val().split('/');
        var date = new Date(parts[2],parts[1]-1,parts[0]);
        var today = new Date();
        if(date <= today){
            alert("A data inserida não pode ser maior ou igual à "+today.getDate()+"/"+(today.getMonth()+1)+"/"+today.getFullYear()+".");
            return false;
        }
        console.log();
    });
</script>
