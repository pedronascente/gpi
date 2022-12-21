<?php
    if($_GET['pg']==55){ 
         $valida_pagina = true; 
    }else{
        $valida_pagina = false;
    }
?>
<table class="table table-striped table-bordered table-hover" style="max-width: 100%;">     
    <tbody>
        <tr>
             <td><b>Interesse:</b><br><?= $captacao_interesse;?></td>
             <td><b>Data Cadastro:</b><br><?= $data_cadastro .' '.$horario;?></td>
             <td><b>Status:</b><br> <?= $captacao_status; ?></td>
        </tr>
        </tr>
        <tr>
            <td colspan="3"><b>Cliente:</b><br><?= $captacao_cliente; ?></td>
        <tr>
             <td><b>Telefone1:</b><br><?= $captacao_telefone1;?></td>
             <td><b>Telefone2:</b><br> <?= $captacao_telefone2;?></td>
             <td</td>
        </tr>
        <tr>
             <td colspan="3"><b>Email:</b><br><?= $captacao_email;  ?></td>
        </tr>
        <tr>
             <td  colspan="3" ><b>Vendedor:</b><br> <?= $captacao_vendedor;?></td>
        </tr>
        <tr>
             <td><b>Origem:</b><br> <?= $captacao_origem; ?></td>
             <td><b>Indicador:</b><br> <?= $captacao_indicador; ?></td>
             <td></td>
        </tr>
         <tr>
             <td colspan="3"><b>Observação:</b><br> <?= $captacao_obs;?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">
                <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <div class="form-actions">
                                 <?php  if($vendedor=='sim'){ ?>
                                    <a id="modulos/captacao/src/views/captacao/formularios/modal_ConsultaCliente.php?id=<?= $id_captacao; ?>&acao=modal" class="botaoLoad modalOpen btn btn-danger" title="Consultar SPC/SERASA" data-target="#modal"> Consultar  SPC | SERASA</a>
                                    <a id="modulos/captacao/src/views/captacao/formularios/modal_captacaoAgenda.php?id_captacao=<?= $id_captacao; ?>" class="botaoLoad modalOpen btn btn-default" title="Agendar um novo contato" data-target="#modal">Agenda</a>
                                    <a id="modulos/captacao/src/views/captacao/formularios/modal_statusCaptacao.php?id_captacao=<?= $id_captacao; ?>" class="botaoLoad modalOpen btn btn-default" title="Alterar Status captação" data-target="#modal">Status </a>
                                 <?php  }
                                 if($_GET['pg']=='19'){
                                     $numero_pagina = 19;
                                 }else{
                                     $numero_pagina = 56;
                                 }
                                 ?>

                                 <a href="index.php?pg=<?= $numero_pagina;?>&id=<?= $id_captacao; ?>&acao=editar&voltar=<?= @$_GET['voltar'];?>" class="btn  btn-primary"> Editar  </a>               
                                 <a href="index.php?pg=<?= @$_GET['voltar'];?>" class="btn btn-default"  title="Voltar"> Voltar </a>
                                  <br><br>
                                 <?php   if($valida_pagina){ ?>
                                  <form action="modulos/captacao/src/controllers/captacao.php" method="post" name="form-exclui-captacao" class="form-exclui-captacao loadForm "> <input type="hidden" name="id_captacao" value="<?= $id_captacao; ?>">  <input type="hidden" name="acao" value="DeleteCaptacao">   <button type="submit" class="btn  btn-danger botaoLoadForm">   <span class="glyphicon glyphicon-trash"></span> Deletar  </button> </form> 
                                  <?php   }?>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
<!--
C:\wamp\www\gpi\modulos\captacao\src\views\captacao\formularios\visualizar_dados_formulario_b.php
-->