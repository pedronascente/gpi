<div class="panel panel-primary">
    <div class="panel-body">
        <?php
            $ret = false;
            if (!empty($camposCliente)) {
                if (in_array("anexos", Funcoes::pegarChaveArray($camposCliente, "campos_contrato_name"))) {
                    $ret = true;
                };
            }
        ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" style="margin: 10px 10px 10px 0 ">
                <a href="?pg=32&amp;id=<?= $id_cliente; ?>&id_cliente_contrato=<?= $id_cli; ?>#anexos"
                   class="btn btn-primary">Novo Anexo
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th class="visible-md visible-lg">Arquivo</th>
                        <th>Descrição</th>
                        <th>Tipo Pessoa</th>
                        <th width="2%">Excluir</th>
                    </tr>
                </thead>
                <?php
                if (!empty($listaAnexos)) :
                    foreach ($listaAnexos as $anexo) :
                        $tipo_doc = !empty($anexo['tipo_doc']) ? $anexo ['tipo_doc'] : '';
                        $tipo_pessoa = !empty($anexo['tipo_pessoa']) ? $anexo ['tipo_pessoa'] : '';
                        $nome_anexo = !empty($anexo['nome_anexo']) ? $anexo ['nome_anexo'] : '';
                        $id_anexo = !empty($anexo['id_anexo']) ? $anexo ['id_anexo'] : '';
                        switch ($tipo_pessoa) {
                            case 1: $tipo_pessoa = "Cliente";   break;
                            case 2: $tipo_pessoa = "1° Sócio";  break;
                            case 3: $tipo_pessoa = "2º Sócio";  break;
                        }
                        ?>
                        <tr>
                            <td  width="50"  class="visible-md visible-lg">
                                <?php
                                    $tmp = explode('.', $nome_anexo); 
                                    $fileExtension = end($tmp);
                                    $extensao_arquivo = $fileExtension;
                                    if ($anexo['origem'] == 'gpi') {
                                        $caminhoArquivo = _BUSCAR_MIDIAS_LOCAL_ . $nome_anexo;
                                    } else if ($anexo['origem'] == 'loja') {
                                        $caminhoArquivo = _BUSCAR_MIDIAS_EXTERNA_ . '/' . $nome_anexo;
                                    }
                                    if($extensao_arquivo=='pdf'|| $extensao_arquivo=='docx'){
                                        $image = '/_MIDIAS_/img-pdf.jpg';
                                    }else{
                                        $image  = $caminhoArquivo;
                                    }
                                ?>
                                <a href="<?=$caminhoArquivo; ?>" target="_blank"   title="Clique na Imagem" >
                                    <img src="<?php echo $image; ?>" width="50" />
                                </a>
                            </td>
                            <td><?= $tipo_doc; ?> </td>
                            <td><?= $tipo_pessoa; ?></td>
                            <td align="center">
                                <form action="modulos/captacao/src/controllers/captacao.php" id="form-delete-Anexos" name="form-delete-Anexos" method="post">
                                    <input type="hidden" name="id_cliente" value="<?= $id_cliente; ?>">
                                    <input type="hidden" name="id_anexo" value="<?= $id_anexo; ?>">
                                    <input type="hidden" name="id" id="id" value="<?= $id_cli; ?>" />
                                    <input type="hidden" name="origem"  value="<?= $anexo['origem']; ?>" />
                                    <input type="hidden" name="acao" value="DeleteAnexos">
                                    <button type="submit" value="Excluir" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                else :
                    echo '<tr><td colspan="4">';
                    echo Funcoes::Nregistro();
                    echo '</td></tr>';
                endif;
                ?>
            </table>
        </div>
    </div>
</div>