<?php  //namespace C:\wamp\www\gpi\modulos\captacao\src\views\captacao\formularios\visualizar_dados_formulario_b.php ?>
<table class="table table-striped table-bordered table-hover">     
    <tbody>
         <tr>
             <td colspan="2"><b>Cliente: </b><?= $captacao_cliente; ?></td>
            <td><b>Interesse:</b> <?=$captacao_interesse; ?></td>
        </tr>
         <tr>
            <td colspan="3"><b>Email: </b><?= $captacao_email; ?></td>
        </tr>
        <tr>
            <td  colspan="2"><b>Status:</b> <?=$captacao_status; ?></td>
            <td><b>Descrição do Status : </b> <?=$motivo_finalizacao; ?></td>
        </tr>
        <tr>
            <td colspan="2"><b>Data Cadastro: </b><?= $data_cadastro; ?></td>
            <td><b>Horário: </b><?= $horario; ?></td>
        </tr>
        <tr>
            <td colspan="2"><b>Telefone1: </b><?= $captacao_telefone1; ?></td>
            <td><b>Telefone2: </b><?= $captacao_telefone2; ?></td>            
        </tr>
        <tr>
            <td colspan="2"><b>Observações: </b><?= $captacao_obs; ?></td>
            <td><b>Origem : </b><?= $captacao_origem; ?></td>
        </tr>
        <tr>
            <td><b>Indicador :</b><?= $captacao_indicador; ?></td>
            <td><b>Vendedor: </b><?= $captacao_vendedor; ?></td>
            <td><b>Quem cadastro? : </b><?= $captacao_quem_cadastro; ?></td>
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
                                 <?php   }
                                 if($_GET['pg']=='19'){
                                     $numero_pagina = 19;
                                 }else{
                                     $numero_pagina = 56;
                                 }
                                 ?>
                                 <a href="index.php?pg=<?= $numero_pagina;?>&id=<?= $id_captacao; ?>&acao=editar&voltar=<?= @$_GET['voltar'];?>" class="btn  btn-default "> Editar  </a>               
                                 <a href="index.php?pg=<?= @$_GET['voltar'];?>" class="btn btn-default"  title="Voltar"> Voltar </a>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
