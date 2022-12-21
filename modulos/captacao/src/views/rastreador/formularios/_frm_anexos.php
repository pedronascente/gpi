<?php
switch ($error) :
    case 1 : $msgError = '<p class="alert  alert-warning" > <span class="glyphicon glyphicon-exclamation-sign"> </span>  Por favor, envie arquivos com a extensão: ( .jpg |.pdf |.doc|.docx )</p> ';
        break;
    case 2 : $msgError = '<p class="alert  alert-danger" > <span class="glyphicon glyphicon-exclamation-sign"> </span>   O arquivo no upload é maior do que o limite do PHP</p>';
        break;
    case 3 : $msgError = '<p class="alert  alert-danger"> <span class="glyphicon glyphicon-exclamation-sign"> </span>   O arquivo ultrapassa o limite de tamanho especifiado -> MAX 6Mb </p>';
        break;
    case 4 : $msgError = '<p class="alert  alert-warning"> <span class="glyphicon glyphicon-exclamation-sign"> </span>   O upload do arquivo foi feito parcialmente</p>';
        break;
    case 5 : $msgError = '<p class="alert  alert-danger"> <span class="glyphicon glyphicon-exclamation-sign"> </span>   Não foi feito o upload do arquivo</p>';
        break;
    case 6 : $msgError = '<p class="alert  alert-success"> <span class="glyphicon glyphicon-exclamation-sign"> </span>   Arquivo anexado com sucesso!</p>';
        break;
endswitch;
?> 
<div class="panel panel-info   " >
    <div class="panel-heading">Formulario Anexos</div>
    <div class="panel-default panel-body">        
        <div class="row ">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <?= (!empty($error)) ? $msgError : '<p class="alert  alert-warning" > <span class="glyphicon glyphicon-exclamation-sign"> </span>    É válido somente Arquivos com as extensões  : .jpg |.pdf |.doc|.docx </p>'; ?></p>
            </div>            
        </div>
        <form enctype="multipart/form-data" name="form-anexa-arquivos" action="modulos/captacao/src/controllers/captacao_anexos.php" method="post" id="formAnexos">
            <div class="row">
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" <?= $tipoPessoa == 'f' || $tipoPessoa == 'F' ? "style='display:none;'" : ""; ?>>
                    <div class="form-group">
                        <label>Tipo de Pessoa .:</label>
                        <select name="tipo_pessoa" required <?= $tipoPessoa == 'f' || $tipoPessoa == 'F' ? "disabled" : ""; ?> class="form-control">
                            <option value="">Selecione ...</option>
                            <option value="2">1° Sócio</option>
                            <option value="3">2° Sócio</option>
                       	</select>	
                    </div>
                </div>           
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label>Tipo de Doc .:</label>
                        <select name="tipo_doc" required class="form-control">
                            <option value="">Selecione ...</option>
                            <option value="cnh">CNH</option>
                            <option value="crlv">CRLV</option>
                            <option value="cnpj">CNPJ</option>
                            <option value="rg">RG</option>
                            <option value="contrato_social">Contrato Social</option>
                            <option value="endereco">Endereço</option>
                            <option value="comprovante_pagamento">Comprovante de Pagamento</option>
                            <option value="tabela_fipe">Tabela FIPE</option>
                            <option value="detran">Detran</option>
                            <option value="correio">Correio</option>
                            <option value="outros">Outros</option>
                        </select>
                    </div>            
                </div> 
            </div>            
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="assinatura" id="assinatura" class="form-control file-caption  kv-fileinput-caption fileBar"  disabled="disabled"/>
                            <span class="input-group-btn">
                                <button class="btn btn-default selectFile" type="button"><span class="glyphicon glyphicon-open"></span></button>
                            </span>
                        </div>
                        <input type="file" name="anexos" class="imagemAssinatura"/>
                    </div>            
                </div>            
            </div>   
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="nome_anexo" id="nome_anexo" placeholder="Nome do Arquivo" class="form-control file-caption kv-fileinput-caption fileBar"  required/>
                        </div>
                    </div>            
                </div>            
            </div>   
            <div class="row">
                <div class="row">
                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                        <div class="form-group">
                            <input type="hidden" name="cliente_ra" id="cliente_ra" value="<?= $id_cliente ?>" /> 
                            <input type="hidden" name="id" id="id" value="<?= $id_cli; ?>" /> 
                            <input type="hidden" name="acao" value="InsertArquivos" />
                            <input type="submit" value="Anexar" class="btn btn-primary"/>
                            <a href="?pg=33&id=<?= $id_cliente ?>&id_cliente_contrato=<?= $id_cli; ?>#anexos" class="btn btn-info">ListarAnexos</a>
                        </div>            
                    </div>            
                </div>   
        </form> 
    </div> 
</div>