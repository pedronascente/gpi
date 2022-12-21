<?php include_once __DIR__ . '/../../controllers/controller_lst_solicitacao.php';?>  

<div class="panel panel-primary  ">
    <div class="panel-heading">
     Listar  Solicitações
    </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
        	<?php if($ti || $supervisor || $gerente){?>
            <li><a data-toggle="tab" href="#home">Solicitações Gerais</a></li>
            <?php }?>
            <?php if($ti || $supervisor){?>
            <li><a data-toggle="tab" href="#menu2">Solicitações</a></li>
            <?php }?>
            <li><a data-toggle="tab" href="#menu1">Minhas Solicitações</a></li>
        </ul>
        <div class="tab-content">
            <div id="home" class="tab-pane fade">
                <div class="panel panel-primary">
                    <div class="panel-heading"></div>
                    <div class="panel-body"> 
                        <?php include_once __DIR__ . '/../formularios/frm_solicitacoesGerais.php'; //incluir formulario de busca ?>
                        <?php include_once 'lst_solicitacoesGerais.php'; //incluir lista de resultados ?>
                    </div>
                </div>
            </div>
            <div id="menu1" class="tab-pane fade">
                <div class="panel panel-primary">
                    <div class="panel-heading"></div>
                    <div class="panel-body"><?php include_once 'lst_solicitacoesUsuario.php'; ?></div>
                </div>
            </div>
            <div id="menu2" class="tab-pane fade">
                <div class="panel panel-primary">
                    <div class="panel-heading"></div>
                    <div class="panel-body"><?php include_once 'lst_solicitacoesDesenvolvimento.php'; ?></div>
                </div>
            </div>
        </div><!--tab-content-->
    </div><!--panel-body-->
</div> <!--panel-primary-->

