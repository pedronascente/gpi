<div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="veiculos" role="button" data-toggle="collapse"    href="#contrato" aria-expanded="false" aria-controls="dadosVeiculos">
        Contrato
    </div>
    <div id="contrato" class="panel-collapse collapse" role="tabpanel" aria-labelledby="veiculos">
        <form class="panel-body" action="modulos/captacao/src/controllers/captacao.php" method="post">
            <input type="hidden" name="acao" value="editarContrato">
            <input type="hidden" name="id_cliente" value="<?= $contrato['id_cliente'] ?>">
            <input type="hidden" name="idContrato" value="<?= $contrato['id_contrato'] ?>">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-inline">
                    <label>Tipo de Pessoa:&nbsp;</label><label  style="font-weight:normal;"><?=!empty($list_cliente ['tipo_pessoa']) ? ($list_cliente ['tipo_pessoa'] == 'f' ? 'Fisica' : 'Juridica') : NULL;?></label>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-inline">
                    <label>Formato assinatura:&nbsp;</label><label id="formatoAssinaturaLabel"  style="font-weight:normal;">
                        <?php echo ($Contrato_tipo_assinatura == 'ad') ? 'Assinatura Digital' : ''; ?>
                        <?php echo ($Contrato_tipo_assinatura == 'am') ? 'Assinatura Manual' : ''; ?>
                    </label>
                    <div style="display: inline-block; display: none;" id="formatoAssinaturaInput">
                        <select name="tipo_assinatura" class="form-control input-sm">
                            <option value="ad" <?php echo ($Contrato_tipo_assinatura == 'ad') ? 'selected' : ''; ?> >
                                Assinatura Digital
                            </option>
                            <option value="am" <?php echo ($Contrato_tipo_assinatura == 'am') ? 'selected' : ''; ?>>
                                Assinatura Manual
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-inline">
                    <label>Data contrato gerado:&nbsp;</label><label id="dataContratoLabel"   style="font-weight:normal;"><?= $Contrato_data_contrato_gerado; ?></label>
                    <div style="display: inline-block; display: none;" id="dataContratoInput">
                        <div class="input-group input-append date datepicker input-group-sm">
                            <input type="text" name="data" class="form-control mask_data"  value="<?= $Contrato_data_contrato_gerado; ?>" required="required">
                            <span class="input-group-addon add-on"><span  class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12  col-md-3 ">
                    <div class="form-group">
                        <label>Tipo de Contrato:</label>
                        <select name="tipo_cadastro" id="tipo_cadastro" required="" class="form-control">
                            <option value="rastreador"         <?= ($list_cliente ['tipo_cadastro'] == "rastreador") ? "selected" : ""; ?> >Comodato</option>
                            <option value="venda"              <?= ($list_cliente ['tipo_cadastro'] == "venda") ? "selected" : ""; ?> >Venda</option>
                            <option value="contrato_promocao"  <?= ($list_cliente ['tipo_cadastro'] == "contrato_promocao") ? "selected" : ""; ?> >Promoção</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12  col-md-3">
                    <div class="form-group">
                        <label>Vigência:</label>
                        <select name="vigencia" class="form-control">
                            <option value="1" <?= ($list_cliente ['vigencia'] == '1') ? "selected" : ""; ?> >12 meses</option>
                            <option value="2" <?= ($list_cliente ['vigencia'] == '2') ? "selected" : ""; ?> >24 meses</option>
                            <option value="3" <?= ($list_cliente ['vigencia'] == '3') ? "selected" : ""; ?> >36 meses</option>
                        </select>
                    </div>
                </div>									
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-inline">
                    <div id="divBtnCancelar" style="display: none;">
                        <input type="submit" class="btn btn-xs btn-success" value="Salvar">
                        <button type="button" class="btn btn-xs btn-danger" id="btnCancelar">
                            Cancelar
                        </button>
                    </div>
                    <div id="divBtnEditar" style="display: inline-block;">
                        <button type="button" class="btn btn-xs btn-success" id="btnEditar">
                            Editar Contrato
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>