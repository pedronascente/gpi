<form method="post" action="modulos/captacao/src/controllers/captacao.php" >
    <div class="panel panel-primary">
        <div class=" panel-body">
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Nome/Razão Social:</label>
                        <input type="text" name="nome_cliente" value="<?= isset($cliente['nome_cliente']) ? $cliente['nome_cliente'] : ""; ?>" class="form-control" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "nome_cliente") : ""; ?> />
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label>CPF/CNPJ:</label>
                        <input type="text" name="cnpjcpf_cliente" class="form-control cnpj_cpf <?= $tipoPessoa == "f" ? "mask_cpf" : "mask_cnpj"; ?>" value="<?= isset($cliente['cnpjcpf_cliente']) ? $cliente['cnpjcpf_cliente'] : ""; ?>" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cnpjcpf_cliente") : ""; ?>/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>Insc. Municipal:</label>
                        <input type="text" name="inscr_municipal" class="form-control" value="<?= isset($cliente['inscr_municipal']) ? $cliente['inscr_municipal'] : ""; ?>"   <?php $tipoPessoa == "f" ? 'required' : ''; ?>   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "inscr_municipal") : ""; ?> />
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label>RG / Insc. Estadual:</label>
                        <input type="text" name="rg_cliente" class="rg form-control" maxlength="20" value="<?= isset($cliente['rg_cliente']) ? $cliente['rg_cliente'] : ""; ?>" required  <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "rg_cliente") : ""; ?>/>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label>Estado Civil:</label>
                        <?php $estadoCivil = isset($cliente['estado_civil']) ? $cliente['estado_civil'] : null; ?>
                        <select name="estado_civil"  id="estado_civil" class="form-control text-center" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "estado_civil") : ""; ?>>
                            <option value="">-- Selecione --</option>
                            <option value="casado"     <?= ($estadoCivil == 'casado') ? 'selected' : ''; ?> >Casado</option>
                            <option value="casada"     <?= ($estadoCivil == 'casada') ? 'selected' : ''; ?>  >Casada</option>
                            <option value="divorciado" <?= ($estadoCivil == 'divorciado') ? 'selected' : ''; ?> >Divorciado</option>
                            <option value="divorciada" <?= ($estadoCivil == 'divorciada') ? 'selected' : ''; ?> >Divorciada</option>
                            <option value="solteiro"   <?= ($estadoCivil == 'solteiro') ? 'selected' : ''; ?> >Solteiro</option>
                            <option value="solteira"   <?= ($estadoCivil == 'solteira') ? 'selected' : ''; ?> >Solteira</option>
                            <option value="viúvo"      <?= ($estadoCivil == 'viúvo') ? 'selected' : ''; ?> >Viúvo</option>
                            <option value="viúva"      <?= ($estadoCivil == 'viúva') ? 'selected' : ''; ?> >Viúva</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class=" col-md-6" >
                    <div class="form-group">
                        <label> Contato:</label>
                        <input type="text" name="contato_cliente" value="<?= isset($cliente['contato_cliente']) ? $cliente['contato_cliente'] : ""; ?>" class="form-control" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "contato_cliente") : ""; ?>/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Telefone:</label>
                        <input type="text" name="telefone_cliente" value="<?= isset($cliente['telefone_cliente']) ? $cliente['telefone_cliente'] : ""; ?>" class=" mask_telefone form-control" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "telefone_cliente") : ""; ?>/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Celular:</label>
                        <input type="text" name="celular_cliente" value="<?= isset($cliente['celular_cliente']) ? $cliente['celular_cliente'] : ""; ?>" class=" mask_telefone form-control" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "celular_cliente") : ""; ?>/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="text" name="email_cliente" id="txt_email" value="<?= isset($cliente['email_cliente']) ? $cliente['email_cliente'] : ""; ?>" class="form-control" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "email_cliente") : ""; ?>/>
                    </div>
                </div>
            </div>
            <?php
            if ($tipoPessoa == 'J' || $tipoPessoa == 'j') :
                ?>
                <div class="row">
                    <div class="col-xs-12  col-md-9 ">
                        <div class="form-group">
                            <label> 1° Sócio:</label>
                            <input type="text" name="socio_1" class="form-control" value="<?= isset($cliente['socio_1']) ? $cliente['socio_1'] : ""; ?>" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cpf_socio1") : ""; ?>/>
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-3 ">
                        <div class="form-group">
                            <label>CPF:</label>
                            <input type="text" name="cpf_socio1" class="form-control  mask_cpf " value="<?= isset($cliente['cpf_socio1']) ? $cliente['cpf_socio1'] : ""; ?>" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cpf_socio1") : ""; ?>/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12  col-md-9 ">
                        <div class="form-group">
                            <label>2° Sócio:</label>
                            <input type="text" name="socio_2" class="form-control" value="<?= isset($cliente['socio_2']) ? $cliente['socio_2'] : ""; ?>" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "socio_2") : ""; ?>/>
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-3 ">
                        <div class="form-group">
                            <label>CPF:</label>
                            <input type="text" name="cpf_socio2" class="form-control  mask_cpf " value="<?= isset($cliente['cpf_socio2']) ? $cliente['cpf_socio2'] : ""; ?>" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cpf_socio2") : ""; ?>/>
                        </div>
                    </div>
                </div>
                <?php
            endif;
            ?>
            <div class="row">
                <div class="col-xs-12 col-md-3 ">
                    <div class="form-group">
                        <label>CEP:</label>
                        <div class="input-group">
                            <input type="text" name="cep_cliente" class="form-control  mask_cep _cep" maxlength="9" placeholder="CEP" value="<?= isset($cliente['cep_cliente']) ? $cliente['cep_cliente'] : ""; ?>" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cep_cliente") : ""; ?>/>
                            <div class="input-group-btn">
                                <a href="javascript:void(0);" class="btn btn-default buscaCEP">
                                    <span class="glyphicon glyphicon-search"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12  col-md-1 ">
                    <div class="form-group">
                        <label>UF:</label>
                        <input type="text" name="uf_cliente"  maxlength="2" class="form-control mask_uf  _uf" value="<?= isset($cliente['uf_cliente']) ? $cliente['uf_cliente'] : ""; ?>" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "uf_cliente") : ""; ?>/>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Cód.Municipio:</label>
                        <input type="text" name="cod_municipio" value="<?= isset($cliente['cli_cod_municipio']) ? $cliente['cli_cod_municipio'] : ""; ?>" class="form-control" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cod_municipio") : ""; ?>/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        <label>Endereço:</label>
                        <input type="text" name="logradouro_cliente" value="<?= isset($cliente['logradouro_cliente']) ? $cliente['logradouro_cliente'] : ""; ?>" class="form-control _rua" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "logradouro_cliente") : ""; ?>/>
                    </div>
                </div>
                <div class=" col-md-2 ">
                    <div class="form-group">
                        <label>Numero:</label>
                        <input type="text" name="numero_cliente"  maxlength="5" value="<?= isset($cliente['numero_cliente']) ? $cliente['numero_cliente'] : ""; ?>" class="form-control" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "numero_cliente") : ""; ?>/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3 ">
                    <div class="form-group">
                        <label>Cidade:</label>
                        <input type="text" name="cidade_cliente" value="<?= isset($cliente['cidade_cliente']) ? $cliente['cidade_cliente'] : ""; ?>" class="form-control _cidade" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cidade_cliente") : ""; ?>/>
                    </div>
                </div>
                <div class="col-xs-12  col-sm-4 col-md-3">
                    <div class="form-group">
                        <label>Bairro:</label>
                        <input type="text" name="bairro_cliente" value="<?= isset($cliente['bairro_cliente']) ? $cliente['bairro_cliente'] : ""; ?>" class="form-control _bairro" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "bairro_cliente") : ""; ?>/>
                    </div>
                </div>
                <div class="col-xs-12  col-sm-4 col-md-3">
                    <div class="form-group">
                        <label>Complemento:</label>
                        <input type="text" name="complemento_cliente" value="<?= isset($cliente['complemento_cliente']) ? $cliente['complemento_cliente'] : ""; ?>" class="form-control" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "complemento_cliente") : ""; ?>/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12  col-md-12">
                    <div class="form-group">
                        <label>Observação:</label>
                        <textarea name="obs_clientes"  rows="5" class=" form-control" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "obs_clientes") : ""; ?>><?= isset($cliente['obs_clientes']) ? $cliente['obs_clientes'] : ""; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--
    ****************************************************
    FORMA DE PAGAMENTO
    *****************************************************
    -->
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
                                        <option value="">-- Selecione --</option>         
                                        <option value="Mastercard"       <?= (isset($ArrayListformaDePagamento[$i]['tipoCartao']) && $ArrayListformaDePagamento[$i]['tipoCartao'] == 'Mastercard') ? 'selected' : ''; ?>>Mastercard</option>         
                                        <option value="Visa"             <?= (isset($ArrayListformaDePagamento[$i]['tipoCartao']) && $ArrayListformaDePagamento[$i]['tipoCartao'] == 'Visa') ? 'selected' : ''; ?>>Visa</option>         
                                        <option value="American express" <?= (isset($ArrayListformaDePagamento[$i]['tipoCartao']) && $ArrayListformaDePagamento[$i]['tipoCartao'] == 'American express') ? 'selected' : ''; ?>>American express</option>         
                                        <option value="Elocard"          <?= (isset($ArrayListformaDePagamento[$i]['tipoCartao']) && $ArrayListformaDePagamento[$i]['tipoCartao'] == 'Elocard') ? 'selected' : ''; ?>>Elocard</option>         
                                        <option value="Hipercard"        <?= (isset($ArrayListformaDePagamento[$i]['tipoCartao']) && $ArrayListformaDePagamento[$i]['tipoCartao'] == 'Hipercard') ? 'selected' : ''; ?>>Hipercard</option>     
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
                            <select name="forma_pagamento" id="forma_pagamento" class="form-control"   required  <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "forma_pagamento") : ""; ?>>
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
                            <input type="text" name="data_pagamento" id="data_pagamento" class="form-control" value="<?= (!empty($cliente['data_pagamento'])) ? $cliente['data_pagamento'] : ''; ?>" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "data_pagamento") : ""; ?>/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Meio Pagamento Mensalidade:</label>
                            <?php
                            $formaPagamento = isset($cliente['forma_pagamento_mensalidade']) ? $cliente['forma_pagamento_mensalidade'] : "";
                            $diaPagamento = isset($cliente['diaMelhorPagamento']) ? $cliente['diaMelhorPagamento'] : "";?>
                            <select name="forma_pagamento_mensalidade" class="form-control"   required  <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "forma_pagamento_mensalidade") : ""; ?>>
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
                            <select name="diaMelhorPagamento" id="diaMelhorPagamento" class="form-control" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "diaMelhorPagamento") : ""; ?>>
                                <?php for ($i = 1; $i <= 31; $i++) { ?>
                                    <option value="<?= $i; ?>" <?= (int) $diaPagamento == $i ? "selected" : ""; ?>><?= $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12  col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Observação:</label>
                            <textarea  rows="5" name="obs_diaPagamento" id="obs_diaPagamento" class="form-control" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "obs_diaPagamento") : ""; ?>><?= isset($cliente['obs_diaPagamento']) ? $cliente['obs_diaPagamento'] : ""; ?></textarea>
                        </div>
                    </div>
                </div>
            <?php } ?>   
        </div>  
    </div>
    <!--
    ****************************************************
        ENDERECO DE COBRANCA
    ****************************************************
    -->
    <div class="panel panel-primary">
        <div class="panel-heading">
            <input type="checkbox" id="seuCheckbox" checked name="endCobranca" <?= $statusCadastro == 2 ? "disabled" : null; ?>> Endereço de Cobrança
        </div>
        <div id="dadosEndereco">
            <div class=" panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <label>CEP:</label>
                            <div class="input-group">
                                <input type="text" name="cep_cobranca" class="form-control mask_cep _cepE required" required maxlength="9" value="<?= isset($cliente['cep_cobranca']) ? $cliente['cep_cobranca'] : ""; ?>" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cep_cobranca") : ""; ?>/>
                                <div class="input-group-btn">
                                    <a href="javascript:void(0);" class="buscaCepEnderecoCobranca btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-1 col-md-1 ">
                        <label>UF:</label>
                        <input type="text" name="uf_cobranca" id="uf_cobranca"  maxlength="2" class="mask_uf  _ufE cobranca form-control required" value="<?= isset($cliente['uf_cobranca']) ? $cliente['uf_cobranca'] : ""; ?>" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "uf_cobranca") : ""; ?>/>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-2">
                        <div class="form-group">
                            <label>Cód. Municipio:</label>
                            <input type="text" name="cod_municipio_cobranca" value="<?= isset($cliente['cod_municipio_cobranca']) ? $cliente['cod_municipio_cobranca'] : ""; ?>" class="cobranca form-control required" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cod_municipio_cobranca") : ""; ?>/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 ">
                        <div class="form-group">
                            <label>Endereço:</label>
                            <input name="logradouro_cobranca" type="text" class="form-control _ruaE cobranca required" value="<?= isset($cliente['logradouro_cobranca']) ? $cliente['logradouro_cobranca'] : ""; ?>" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "logradouro_cobranca") : ""; ?>/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-1 ">
                        <div class="form-group">
                            <label>Numero:</label>
                            <input name="numero_cobranca"   maxlength="5"   type="text" value="<?= isset($cliente['numero_cobranca']) ? $cliente['numero_cobranca'] : ""; ?>" class="form-control cobranca required" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "numero_cobranca") : ""; ?>/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="form-group">
                            <label>Cidade:</label>
                            <input type="text" name="cidade_cobranca" id="cidade_cobranca" value="<?= isset($cliente['cidade_cobranca']) ? $cliente['cidade_cobranca'] : ""; ?>" class="form-control _cidadeE cobranca required" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cidade_cobranca") : ""; ?>/>
                        </div>
                    </div>
                    <div class="col-xs-12  col-sm-4 col-md-3">
                        <div class="form-group">
                            <label>Bairro:</label>
                            <input type="text" name="bairro_cobranca" value="<?= isset($cliente['bairro_cobranca']) ? $cliente['bairro_cobranca'] : ""; ?>" class="form-control _bairroE cobranca required" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "bairro_cobranca") : ""; ?>/>
                        </div>
                    </div>
                    <div class="col-xs-12  col-sm-4 col-md-3">
                        <div class="form-group">
                            <label>Complemento:</label>
                            <input name="complemento_cobranca" type="text" class="form-control cobranca" value="<?= isset($cliente['complemento_cobranca']) ? $cliente['complemento_cobranca'] : ""; ?>" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "complemento_cobranca") : ""; ?>/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12  col-sm-4 col-md-3">
                        <div class="form-group">
                            <label>Contato:</label>
                            <input type="text" name="contato_cobranca" value="<?= isset($cliente['contato_cobranca']) ? $cliente['contato_cobranca'] : ""; ?>" class="form-control cobranca " <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "contato_cobranca") : ""; ?>/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="form-group">
                            <label>Telefone:</label>
                            <input type="text" name="telefone_cobranca" value="<?= isset($cliente['telefone_cobranca']) ? $cliente['telefone_cobranca'] : ""; ?>" class="form-control mask_telefone cobranca "  <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "telefone_cobranca") : ""; ?>/>
                        </div>
                    </div>
                    <div class="col-xs-12  col-sm-4 col-md-3">
                        <div class="form-group">
                            <label>Celular:</label>
                            <input type="text" name="celular_cobranca" value="<?= isset($cliente['celular_cobranca']) ? $cliente['celular_cobranca'] : ""; ?>" class="form-control mask_telefone cobranca "  <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "celular_cobranca") : ""; ?>/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12  col-sm-8 col-md-9">
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="text" name="email_cobranca" value="<?= isset($cliente['email_cobranca']) ? $cliente['email_cobranca'] : ""; ?>" class="form-control cobranca required"  <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "email_cobranca") : ""; ?>/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12  col-sm-8 col-md-8 col-lg-8">
            <input type="hidden" name="id_cliente" id="id_cliente" value="<?= $id_cli; ?>" />
            <input type="hidden" name="id" id="id" value="<?= $id_cliente; ?>" />
            <input type="hidden" name="acao" value="cadastroCliente" />
            <input type="hidden" name="status" value="<?= $statusCadastro; ?>" />
            <input type="hidden" name="endCobranca" value="ativo" id="endCobranca"/>
            <input type="submit" value="SALVAR" class="btn btn-primary" />
        </div>
    </div>
</form>
<script type="text/javascript">
    $(function () {
        if ($("#select_tipo_pagamento_taxa option:selected").val() == "Cartão de Crédito") {
            $("#box-campos-catao-credito-taxa").css('display', 'block');
        };
        if ($("#select_tipo_pagamento_mensalidade option:selected").val() == "Cartão de Crédito") {
            $("#box-campos-catao-credito-mensalidade").css('display', 'block');
        } ;
        $("#select_tipo_pagamento_taxa").change(function () {
            var $option = $(this).val();
            if ($option == "Cartão de Crédito") {
                $("#box-campos-catao-credito-taxa").css('display', 'block');
            } else {
                $("#box-campos-catao-credito-taxa").css('display', 'none');
                $(".limpar-campos-taxa").val('');
            }
        });
        $("#select_tipo_pagamento_mensalidade").change(function () {
            var $option = $(this).val();
            if ($option == "Cartão de Crédito") {
                $("#box-campos-catao-credito-mensalidade").css('display', 'block');
            } else {
                $("#box-campos-catao-credito-mensalidade").css('display', 'none');
                $(".limpar-campos-mensalidade").val('');
            }
        });
    });
</script>