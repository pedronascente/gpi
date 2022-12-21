
<?php

    if($_GET['pg']==55){
      
         $valida_pagina = true; 

    }else{

        $valida_pagina = false;

    }

?>

<table class="table table-striped table-bordered table-hover">     
    <tbody>
        <tr>
            <td colspan="4"><b>Interesse:</b><br><?= $captacao_interesse; ?></td>
        </tr>
        <tr>
            <td><b>Data:</b><br><?= $data_cadastro; ?></td>
            <td><b>Horário:</b><br><?= $horario; ?></td>
            <td colspan="2"><b>Responsavel:</b><br><?= $captacao_responsavel; ?></td>
        </tr>
        <tr>
            <td colspan="3"><b>Cliente:</b><br><?= $captacao_cliente; ?></td>
            <td><b>Data Nascimento:</b><br><?= $captacao_data_nascimento; ?></td>
        </tr>
        <tr>
            <td colspan="4"><b>Email:</b><br><?= $captacao_email; ?></td>
        </tr>
        <tr>
            <td><b>Telefone1:</b><br><?= $captacao_telefone1; ?></td>
            <td><b>Operadora1:</b><br><?= $captacao_operadora1; ?></td>
            <td><b>Telefone2:</b><br><?= $captacao_telefone2; ?></td>
            <td><b>Operadora2:</b><br><?= $captacao_operadora2; ?></td>
        </tr>
        <tr>
            <td colspan="4"><b>Já é cliente VOLPATO ?:</b><br><?= $captacao_ja_e_cliente; ?></td>
        </tr>
        <tr>
            <td><b>Tipo de Serviços:</b><br><?= $captacao_tipo_servico; ?></td>
            <td colspan="2"><b>Descrição:</b><br><?= $captacao_tipo_servico_desc_outros; ?></td>
            <td><b>Localização dos serviços atuais (Cidade):</b><br><?= $captacao_localizacao_do_servico_atual; ?></td>
        </tr>
        <tr>
            <td><b>Cliente desde:</b><br><?= $captacao_cliente_desde; ?></td>
            <td colspan="2"><b>Pendencias financeiras:</b><br><?= $captacao_pendencias_financeiras; ?></td>
            <td><b>Ações:</b><br><?= $captacao_acoes; ?></td>
        </tr>
        <tr>
            <td colspan="2"><b>Conceito:</b><br><?= $captacao_conceito; ?></td>
            <td colspan="2"><b>Tipo de Cliente:</b><br><?= $captacao_tipo_de_cliente; ?></td>
        </tr>       
        <tr>
            <td colspan="4"><b>Observações sobre o cliente:</b><br><?= $captacao_obs; ?></td>
        </tr>       
        <tr>
            <td colspan="2"><b>CEP:</b><br><?= $captacao_cep; ?></td>
            <td colspan="2"><b>UF:</b><br><?= $captacao_uf; ?></td>
        </tr>
        <tr>
            <td colspan="3"><b>Logradouro:</b><br><?= $captacao_endereco; ?></td>
            <td><b>Numero:</b><br><?= $captacao_numero; ?></td>
        </tr>
        <tr>
            <td><b>Cidade:</b><br><?= $captacao_cidade; ?></td>
            <td><b>Bairro:</b><br><?= $captacao_bairro; ?></td>
            <td colspan="2"><b>Complemento:</b><br><?= $captacao_complemento; ?></td>
        </tr>
        <tr>
            <td colspan="4"><b>O imóvel no qual o Cliente pretende instalar nossos produtos e contratar nossos serviços é:</b><br> <?= $captacao_imovel_tipo_imovel; ?></td>
        </tr>
        <tr>
            <td colspan="4"><b>Atividade Principal do local:</b><br><?=$captacao_imovel_atividade_principal; ?></td>
        </tr>
        <tr>
            <td><b>Referencia: </b><br><?= $captacao_imovel_ao_lado_de; ?></td>
            <td><b>Metragem do Terreno ex (200m2) :</b><br><?= $captacao_imovel_metragem; ?></td>
            <td><b>Área construida ex (200m2):</b><br><?= $captacao_imovel_area; ?></td>
            <td><b>Pisos:</b><br><?= $captacao_imovel_pisos; ?></td>
        </tr>
        <tr>
            <td colspan="2"><b>Descrição da área construida:</b><br><?= $captacao_imovel_descricao_da_ares; ?></td>
            <td colspan="2"><b>Estado do Imovel:</b><br><?= $captacao_imovel_estado; ?></td>
        </tr>
        <tr>
            <td colspan="4"><b>Possui acesso vigiado ?:</b><br><?= $captacao_imovel_acesso_vigiado; ?></td>
        </tr>
        <tr>
            <td colspan="3"><b>Tipo de serviço vigiado:</b><br><?= $captacao_imovel_tipo_servico_vigiado; ?></td>
            <td><b>Horário:</b><br><?= $captacao_imovel_tipo_servico_vigiado_horario; ?></td>
        </tr>
        <tr>
            <td colspan="2"><b>Possui registro de ocorrências recentes no Local ?:</b><br><?= $captacao_imovel_registro_ocorrencia_local; ?></td>
            <td colspan="2"><b>Descrição da  dinâmica:</b><br><?=$captacao_imovel_descricao_ocorrencia_local; ?></td>
        </tr>                                
        <tr>
            <td colspan="2"><b>Possui registro de ocorrências recentes na Vizinhança ?:</b><br><?= $captacao_imovel_registro_ocorrencia_vizinhanca; ?></td>
            <td colspan="2"><b>Descrição da  dinâmica:</b><br><?= $captacao_imovel_descricao_ocorrencia_vizinhanca; ?></td>
        </tr>
        <tr>
            <td colspan="2"><b>Possui aderência ?:</b><br><?= $captacao_aderencia_possui; ?></td>
            <td colspan="2"><b> Motivo:</b><br><?= $captacao_aderencia_motivo; ?></td>
        </tr>
        <tr>
            <td colspan="4"><b>Como foi que o cliente nos encontrou?</b><br><?= $captacao_indicador; ?></td>
        </tr>
        <tr>
            <td colspan="2"><b>Data Agendada para : </b><br><?= $captacao_data_agenda; ?></td>
            <td colspan="2"><b>Consultor :</b><br><?= $captacao_consultor; ?></td>
        </tr>
        <tr>
            <td colspan="4"><b>Observação adicional :</b><br><?=(null!=$captacao_observacao_adicional)?$captacao_observacao_adicional:''; ?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">
                <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <div class="form-actions">
                                     <?php  
                                         if($vendedor=='sim'){ ?>
                                            <a id="modulos/captacao/src/views/captacao/formularios/modal_ConsultaCliente.php?id=<?= $id_captacao; ?>&acao=modal" class="botaoLoad modalOpen btn btn-default" title="Consultar SPC/SERASA" data-target="#modal"> Consultar </a>
                                            <a id="modulos/captacao/src/views/captacao/formularios/modal_captacaoAgenda.php?id_captacao=<?= $id_captacao; ?>" class="botaoLoad modalOpen btn btn-default" title="Agendar um novo contato" data-target="#modal">Agenda</a>
                                            <a id="modulos/captacao/src/views/captacao/formularios/modal_statusCaptacao.php?id_captacao=<?= $id_captacao; ?>" class="botaoLoad modalOpen btn btn-default" title="Alterar Status captação" data-target="#modal">Status </a><?php   
                                        }
                                        if($_GET['pg']=='19'){

                                                $numero_pagina = 19;

                                        }else{

                                        $numero_pagina = 56;
                                            
                                        }

                                    ?>

                                    <form   action="modulos/captacao/src/controllers/download_pdf_tecnica_alarme.php"  method="post" style=" width:100px; float: left;">                                               
                                        <input type="hidden" name="acao" value="download_pdf_tecnica_alarme"> 
                                        <input type="hidden" name="id_captacao" id="id_captacao" value="<?=$id_captacao;?>"> 
                                        <input type="hidden" name="id_usuario" id="id_usuario" value="<?= $_SESSION['user_info']['id_usuario']; ?>"> 
                                        <button type="submit" class="btn btn-danger"> 
                                            Gerar PDF
                                        </button>                            
                                    
                                    </form>

                                    <a id="modulos/captacao/src/views/captacao/formularios/modal_enviarEmailTecnico.php?id_captacao=<?= $id_captacao; ?>" 
                                        class="botaoLoad modalOpen btn btn-success" 
                                        data-target="#modal">     
                                            Enviar Email  <span class="glyphicon glyphicon-envelope"></span> 
                                    </a>
                                
                                    <a href="index.php?pg=<?= $numero_pagina;?>&id=<?= $id_captacao; ?>&acao=editar&voltar=<?= @$_GET['voltar'];?>" class="btn  btn-primary"> Editar  </a>    

                                    <a href="index.php?pg=<?= @$_GET['voltar'];?>" class="btn btn-info"  title="Voltar"> Voltar </a>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <?php   if($valida_pagina){ ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <form action="modulos/captacao/src/controllers/captacao.php" method="post" name="form-exclui-captacao" class="form-exclui-captacao loadForm"> <input type="hidden" name="id_captacao" value="<?= $id_captacao; ?>">  <input type="hidden" name="acao" value="DeleteCaptacao">   <button type="submit" class="btn btn-sm btn-danger botaoLoadForm">   <span class="glyphicon glyphicon-trash"></span> Deletar  </button> </form>  
                        </div>
                    </div>

                    <?php   }?>
                 </div>
            </td>
        </tr>
    </tfoot>
</table>