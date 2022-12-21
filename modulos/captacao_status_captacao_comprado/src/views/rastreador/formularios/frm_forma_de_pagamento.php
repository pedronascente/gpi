<div class="panel panel-primary">
    <div class="panel-heading">Forma de Pagamento</div>
    <div class=" panel-body ">
        <?php
        $formaDePagamento = new FormaDePagamento;
        $ArrayListformaDePagamento = $formaDePagamento->selectFormaDePagamentoPorIdCliente($id_cliente);
        if (!empty($ArrayListformaDePagamento)) {
            for ($i = 0; $i < count($ArrayListformaDePagamento); $i++) {
                ?>
                <div class="row">
                    <div class="col-md-12 ">
                        <h4><b><?= ($ArrayListformaDePagamento[$i]['tipoEspecie'] == 'taxa') ? "Taxa de Habilitação" : "Mensalidade"; ?>:</b></h4><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-3 ">
                        <div class="form-group">
                            <label>Tipo de pagamento:</label>
                            <select name="FORMADEPAGAMENTO[<?= $i; ?>][forma_pagamento]"  class="form-control text-center" required=""  id="select_tipo_pagamento_<?= $ArrayListformaDePagamento[$i]['tipoEspecie']; ?>">
                                <option value="Boleto"   <?php
                                if ($ArrayListformaDePagamento[$i]['forma_pagamento'] == 'Boleto') {
                                    echo "selected";
                                }
                                ?> >Boleto</option>
                                <option value="Cartão de Crédito"   <?php
                                if ($ArrayListformaDePagamento[$i]['forma_pagamento'] == "Cartão de Crédito") {
                                    echo "selected";
                                }
                                ?> >Cartão de Crédito</option>
                                <option value="Deposito" <?php
                                if ($ArrayListformaDePagamento[$i]['forma_pagamento'] == "Deposito") {
                                    echo "selected";
                                }
                                ?>>Deposito</option>
                                <option value="Dinheiro" <?php
                                if ($ArrayListformaDePagamento[$i]['forma_pagamento'] == "Dinheiro") {
                                    echo "selected";
                                }
                                ?> >Dinheiro</option>
                                <option value="PagSeguro"<?php
                                if ($ArrayListformaDePagamento[$i]['forma_pagamento'] == "PagSeguro") {
                                    echo "selected";
                                }
                                ?>>PagSeguro</option>
                                <option value="Outros">Outros</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="box-campos-catao-credito-<?= $ArrayListformaDePagamento[$i]['tipoEspecie']; ?>" style="display: none">
                    <div class="row">
                        <div class=" col-md-6 ">     
                            <div class="form-group">
                                <label class="inputLabel">Nome Impresso no Cartão:</label>     
                                <input type="text" name="FORMADEPAGAMENTO[<?= $i; ?>][nomeImpressoNoCartao]"    class="text form-control limpar-campos-<?= $ArrayListformaDePagamento[$i]['tipoEspecie']; ?>" value="<?php echo isset($ArrayListformaDePagamento[$i]) ? $ArrayListformaDePagamento[$i]['nomeImpressoNoCartao'] : ''; ?>">    
                            </div>
                        </div>
                    </div>
                    <div class="row">   
                        <div class="  col-md-3  col-xs-12 ">     
                            <div class="form-group">
                                <label class="inputLabel">Bandeira do Cartão:</label>     
                                <select class="selectField form-control text-center  limpar-campos-<?= $ArrayListformaDePagamento[$i]['tipoEspecie']; ?>"    name="FORMADEPAGAMENTO[<?= $i; ?>][tipoCartao]">         
                                    <option value=""> -- Selecione -- </option>         
                                    <option value="Mastercard"       <?=(isset($ArrayListformaDePagamento[$i]['tipoCartao']) && $ArrayListformaDePagamento[$i]['tipoCartao'] == 'Mastercard') ? 'selected' : ''; ?>>Mastercard</option>         
                                    <option value="Visa"             <?=(isset($ArrayListformaDePagamento[$i]['tipoCartao']) && $ArrayListformaDePagamento[$i]['tipoCartao'] == 'Visa') ? 'selected' : ''; ?>>Visa</option>         
                                    <option value="American express" <?=(isset($ArrayListformaDePagamento[$i]['tipoCartao']) && $ArrayListformaDePagamento[$i]['tipoCartao'] == 'American express') ? 'selected' : ''; ?>>American express</option>         
                                    <option value="Elocard"          <?=(isset($ArrayListformaDePagamento[$i]['tipoCartao']) && $ArrayListformaDePagamento[$i]['tipoCartao'] == 'Elocard') ? 'selected' : ''; ?>>Elocard</option>         
                                    <option value="Hipercard"        <?=(isset($ArrayListformaDePagamento[$i]['tipoCartao']) && $ArrayListformaDePagamento[$i]['tipoCartao'] == 'Hipercard') ? 'selected' : ''; ?>>Hipercard</option>     
                                </select>     
                            </div>
                        </div>
                        <div class=" col-lg-2 col-md-2 col-sm-6">     
                            <div class="form-group">
                                <label class="inputLabel">Número do Cartão:</label>     
                                <input type="text" name="FORMADEPAGAMENTO[<?= $i; ?>][numeroCartao]"  maxlength="16" class="text form-control limpar-campos-<?= $ArrayListformaDePagamento[$i]['tipoEspecie']; ?>" value="<?php echo isset($ArrayListformaDePagamento[$i]['numeroCartao']) ? $ArrayListformaDePagamento[$i]['numeroCartao'] : ''; ?>">     
                            </div>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-md-2">     
                            <div class="form-group">
                                <label class="inputLabel">Mês/Ano (MMAA):</label>     
                                <input type="text" class="text form-control mask_anofab  limpar-campos-<?= $ArrayListformaDePagamento[$i]['tipoEspecie']; ?>" maxlength="5" name="FORMADEPAGAMENTO[<?= $i; ?>][anoMes]" value="<?php echo isset($ArrayListformaDePagamento[$i]['anoMes']) ? $ArrayListformaDePagamento[$i]['anoMes'] : ''; ?>">     
                            </div>
                        </div>
                        <div class="col-md-2">     
                            <div class="form-group">
                                <label class="inputLabel">Qtd. de Parcelas :</label>     
                                <select class="selectField form-control text-center limpar-campos-<?= $ArrayListformaDePagamento[$i]['tipoEspecie']; ?>" name="FORMADEPAGAMENTO[<?= $i; ?>][numerosParcelas]">         
                                    <option value="">-- Selecione --</option>         
                                    <?php for ($A = 1; $A <= 12; $A++) { ?>
                                        <option value="<?= $A; ?> " <?php echo isset($ArrayListformaDePagamento[$i]['numerosParcelas']) && $ArrayListformaDePagamento[$i]['numerosParcelas'] == $A ? 'selected' : ''; ?>><?= $A; ?></option>
                                    <?php } ?> 
                                </select>     
                            </div>
                        </div>
                        <div class=" col-md-1">     
                            <div class="form-group">
                                <label class="inputLabel">CVV:</label>       
                                <input  type="text" class="text form-control limpar-campos-<?= $ArrayListformaDePagamento[$i]['tipoEspecie']; ?>" maxlength="3" name="FORMADEPAGAMENTO[<?= $i; ?>][cvv]" value="<?= $ArrayListformaDePagamento[$i]['cvv'] ?>">     
                            </div>
                        </div>
                    </div>
                </div>   
                <div class="row">
                    <div class=" col-md-2">
                        <label>Data:</label>
                        <div class="input-group input-append date datepicker">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            <input type="text" name="FORMADEPAGAMENTO[<?= $i; ?>][data_pagamento_taxa_mes]" class="form-control limpar-campos-<?= $ArrayListformaDePagamento[$i]['tipoEspecie']; ?>" value="<?php echo isset($ArrayListformaDePagamento[$i]['data_pagamento_taxa_mes']) ? $ArrayListformaDePagamento[$i]['data_pagamento_taxa_mes'] : '' ?>" required="" >
                        </div>
                    </div>
                    <div class=" col-md-2">  
                        <div class="form-group"> 
                            <label class="inputLabel">Melhor dia de Pagamento:</label>     
                            <select name="FORMADEPAGAMENTO[<?= $i; ?>][diaMelhorPagamento]"  class="form-control text-center limpar-campos-<?= $ArrayListformaDePagamento[$i]['tipoEspecie']; ?>" required="">
                                <option value="" selected="">-- Selecione --</option>
                                <?php for ($b = 1; $b <= 31; $b++) { ?>
                                    <option value="<?php echo $b; ?>" <?php echo isset($ArrayListformaDePagamento[$i]['diaMelhorPagamento']) && $ArrayListformaDePagamento[$i]['diaMelhorPagamento'] == $b ? 'selected' : ''; ?>><?php echo $b; ?></option>
                                <?php } ?> 
                            </select>  
                            <input  type="hidden" name="FORMADEPAGAMENTO[<?= $i; ?>][tipoEspecie]" value="<?= $ArrayListformaDePagamento[$i]['tipoEspecie']; ?>">
                        </div>
                    </div>
                    <input type="hidden" name="FORMADEPAGAMENTO[<?= $i; ?>][id_forma_de_pagamento]" class="form-control limpar-campos-<?= $ArrayListformaDePagamento[$i]['tipoEspecie']; ?>" value="<?= $ArrayListformaDePagamento[$i]['id_forma_de_pagamento'] ?>" required="" >
                </div>
            <?php } ?>

        <?php } else { ?>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Meio Pagamento Habilitação:</label>
                        <?php $formaPagamento = isset($cliente['forma_pagamento']) ? $cliente['forma_pagamento'] : ""; ?>
                        <select name="CLIENTE[forma_pagamento]" id="forma_pagamento" class="form-control"   required  <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "forma_pagamento") : ""; ?>>
                            <option value="4" <?php if ($formaPagamento == '4') { ?> selected="selected" <?php } ?>>Boleto</option>
                            <option value="1" <?php if ($formaPagamento == '1') { ?> selected="selected" <?php } ?>>Cartão</option>
                            <option value="2" <?php if ($formaPagamento == '2') { ?> selected="selected" <?php } ?>>Deposito</option>
                            <option value="3" <?php if ($formaPagamento == '3') { ?> selected="selected" <?php } ?>>Dinheiro</option>
                            <option value="6" <?php if ($formaPagamento == '6') { ?> selected="selected" <?php } ?>>PagSeguro</option>
                            <option value="7" <?php if ($formaPagamento == '7') { ?> selected="selected" <?php } ?>>Isento</option>
                            <option value="8" <?php if ($formaPagamento == '8') { ?> selected="selected" <?php } ?>>Isento (Troca de Titularidade)</option>
                            <option value="9" <?php if ($formaPagamento == '9') { ?> selected="selected" <?php } ?>>Funcionario (Desconto em Folha) </option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-2">
                    <label>Data:</label>
                    <div class="input-group input-append date datepicker">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        <input type="text" name="CLIENTE[data_pagamento]" id="data_pagamento" class="form-control" value="<?= (!empty($cliente['data_pagamento'])) ? $cliente['data_pagamento'] : ''; ?>" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "data_pagamento") : ""; ?>/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Meio Pagamento Mensalidade:</label>
                        <?php
                        $formaPagamento = isset($cliente['forma_pagamento_mensalidade']) ? $cliente['forma_pagamento_mensalidade'] : "";
                        $diaPagamento = isset($cliente['diaMelhorPagamento']) ? $cliente['diaMelhorPagamento'] : "";
                        ?>
                        <select name="CLIENTE[forma_pagamento_mensalidade]" class="form-control"   required  <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "forma_pagamento_mensalidade") : ""; ?>>
                            <option value="4" <?php if ($formaPagamento == '4') { ?> selected="selected" <?php } ?>>Boleto</option>
                            <option value="1" <?php if ($formaPagamento == '1') { ?> selected="selected" <?php } ?>>Cartão</option>
                            <option value="2" <?php if ($formaPagamento == '2') { ?> selected="selected" <?php } ?>>Deposito</option>
                            <option value="3" <?php if ($formaPagamento == '3') { ?> selected="selected" <?php } ?>>Dinheiro</option>
                            <option value="6" <?php if ($formaPagamento == '6') { ?> selected="selected" <?php } ?>>PagSeguro</option>
                            <option value="9" <?php if ($formaPagamento == '9') { ?> selected="selected" <?php } ?>>Funcionario (Desconto em Folha)</option>
                            <option value="5" <?php if ($formaPagamento == '7') { ?> selected="selected" <?php } ?>>Outros</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-2">
                    <div class="form-group">
                        <label>Melhor dia de Pagamento:</label>
                        <select name="CLIENTE[diaMelhorPagamento]" id="diaMelhorPagamento" class="form-control" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "diaMelhorPagamento") : ""; ?>>
                            <?php for ($i = 1; $i <= 31; $i++) { ?>
                                <option value="<?= $i; ?>" <?= (int) $diaPagamento == $i ? "selected" : ""; ?>><?= $i; ?></option>
                             <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12  col-sm-12 col-md-12">
                    <div class="form-group">
                        <label>Observação:</label>
                        <textarea  rows="5" name="CLIENTE[obs_diaPagamento]" id="obs_diaPagamento" class="form-control" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "obs_diaPagamento") : ""; ?>><?= isset($cliente['obs_diaPagamento']) ? $cliente['obs_diaPagamento'] : ""; ?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>   
    </div>  
</div>
