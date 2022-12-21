<?php
//namespace C:\wamp\www\gpi\modulos\captacao\src\views\contratos\listas\lst_anexosContrato.php
include_once '../../../../../../Config.inc.php';
$id_contrato = filter_input(INPUT_GET, 'id');
$id_cliente = filter_input(INPUT_GET, 'id_cliente');
$nome_cliente = filter_input(INPUT_GET, 'cliente');
$contrato = new Contratos ();
$anexos = new Anexos ();
$cont = $contrato->select($id_contrato);
$listaAnexos = $anexos->selectAnexos($id_contrato, $id_cliente);
$imprimir = '<img src="public/img/botoes/btn_imprimir.png" width="16" >';
?>
<style type="text/css">
    ._stylo {    padding: 5px;  font-size: 14px;  }   a {  text-decoration: none; }
</style>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?= $nome_cliente; ?></h4>
        </div>			
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="list-group">
                            <a href="fpdf/contrato/index.php?id=<?=$id_contrato; ?>" class="list-group-item">
                               <pan class="glyphicon glyphicon-file"></pan> CONTRATO  <span class="badge badge-default badge-pill glyphicon glyphicon-print"> </span>
                            </a>
                            <a href="/gpi/modulos/captacao/src/controllers/fichaAdesao.php?id=<?=$id_contrato; ?>" class="list-group-item">
                               <pan class="glyphicon glyphicon-file"></pan> FICHA DE ADESÃO <span class="badge badge-default badge-pill glyphicon glyphicon-print"> </span>
                            </a>
                            <?php
                                if(!empty($listaAnexos)) {
                                    foreach ($listaAnexos as $k => $anexo) {
                                        $nome_anexo = !empty($anexo ["nome_anexo"])?$anexo ["nome_anexo"]:'';
                                        $tituloAnexo = !empty($anexo['tipo_doc']) ? $anexo['tipo_doc'] : $anexo ["nome_anexo"];
                                        $tipo_pessoa = !empty($anexo['tipo_pessoa']) ? $anexo ['tipo_pessoa'] : NULL;
                                        
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
                                        switch ($tipo_pessoa) {
                                            case 1: $tipo_pessoa = "Cliente"; break;
                                            case 2: $tipo_pessoa = "1° Sócio"; break;
                                            case 3: $tipo_pessoa = "2º Sócio"; break;
                                        }?>
                                        <a class="list-group-item" href="<?= $caminhoArquivo  ?>" title="<?= $anexo['tipo_doc']; ?>" target="_blank">
                                             <img src="<?=$image; ?>" width="45" /> <?= str_replace("_", " ", $tituloAnexo)  ?> 
                                             <span class="badge badge-default badge-pill glyphicon glyphicon-eye-open"> </span>
                                        </a><?php
                                    }
                                }
                            ?>
                            <a class="list-group-item" href="/_MIDIAS_/anexosContrato/baixar_anexo.php?id_contrato=<?= $id_contrato; ?>&id_cliente=<?= $id_cliente; ?>" title="" target="_blank">
                            <span class="glyphicon glyphicon-file"> 
                                BAIXAR TUDO (.zip)
                            </span>
                            </a>
                            <a class="list-group-item" href="application/CODEIGNITER/baixar-ckecklist/<?= $id_cliente; ?>" title="" target="_blank">
                                <span class="glyphicon glyphicon-file"> 
                                    BAIXAR CheckList (.zip)
                                </span>
                            </a>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>