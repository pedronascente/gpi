<form method="post" action="modulos/captacao/src/controllers/captacao.php" >
    <div class="panel panel-primary">
        <div class=" panel-body">
            <div class="row">
                <div class="col-md-7">
                    <div class="form-group">
                        <label>Nome/Razão Social:</label>
                        <input type="text" name="CLIENTE[nome_cliente]" value="<?= isset($cliente['nome_cliente']) ? $cliente['nome_cliente'] : ""; ?>" class="form-control" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "nome_cliente") : ""; ?> />
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label>CPF/CNPJ:</label>
                        <input type="text" name="CLIENTE[cnpjcpf_cliente]" class="form-control cnpj_cpf <?= $tipoPessoa == "f" ? "mask_cpf" : "mask_cnpj"; ?>" value="<?= isset($cliente['cnpjcpf_cliente']) ? $cliente['cnpjcpf_cliente'] : ""; ?>" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cnpjcpf_cliente") : ""; ?>/>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Data Nascimento:</label>
                        <input type="text" name="CLIENTE[data_nascimento]" class="form-control mask_data"  value="<?= isset($cliente['data_nascimento']) ? $cliente['data_nascimento'] : ""; ?>" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "data_nascimento") : ""; ?>      <?=($cliente['tipo_pessoa']=='f')?'required':'';?> />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>Insc. Municipal:</label>
                        <input type="text" name="CLIENTE[inscr_municipal]" class="form-control" value="<?= isset($cliente['inscr_municipal']) ? $cliente['inscr_municipal'] : ""; ?>"   <?php $tipoPessoa == "f" ? 'required' : ''; ?>   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "inscr_municipal") : ""; ?> />
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label>RG / Insc. Estadual:</label>
                        <input type="text" name="CLIENTE[rg_cliente]" class="rg form-control" maxlength="20" value="<?= isset($cliente['rg_cliente']) ? $cliente['rg_cliente'] : ""; ?>" required  <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "rg_cliente") : ""; ?>/>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label>Estado Civil:</label>
                        <?php $estadoCivil = isset($cliente['estado_civil']) ? $cliente['estado_civil'] : null; ?>
                        <select name="CLIENTE[estado_civil]"  id="estado_civil" class="form-control text-center" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "estado_civil") : ""; ?>>
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
                <div class="col-xs-12 col-md-7">
                    <div class="form-group">
                        <label>Sócio1:</label>
                        <input type="text" name="CLIENTE[socio_1]" class="form-control" value="<?= isset($cliente['socio_1']) ? $cliente['socio_1'] : ""; ?>"   <?php $tipoPessoa == "f" ? 'required' : ''; ?>   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "socio_1") : ""; ?> />
                    </div>
                </div>
                <div class="col-xs-12 col-md-5">
                       <div class="form-group">
                        <label>CPF:</label>
                        <input type="text" name="CLIENTE[cpf_socio1]" class="form-control" value="<?= isset($cliente['cpf_socio1']) ? $cliente['cpf_socio1'] : ""; ?>"   <?php $tipoPessoa == "f" ? 'required' : ''; ?>   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cpf_socio1") : ""; ?> />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-7">
                    <div class="form-group">
                        <label>Sócio2:</label>
                        <input type="text" name="CLIENTE[socio_2]" class="form-control" value="<?= isset($cliente['socio_2']) ? $cliente['socio_2'] : ""; ?>"   <?php $tipoPessoa == "f" ? 'required' : ''; ?>   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "socio_2") : ""; ?> />
                    </div>
                </div>
                <div class="col-xs-12 col-md-5">
                       <div class="form-group">
                        <label>CPF:</label>
                        <input type="text" name="CLIENTE[cpf_socio2]" class="form-control" value="<?= isset($cliente['cpf_socio2']) ? $cliente['cpf_socio2'] : ""; ?>"   <?php $tipoPessoa == "f" ? 'required' : ''; ?>   <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cpf_socio2") : ""; ?> />
                    </div>
                </div>
            </div>
            
            <?php 
              //CONTATOS :
              include_once 'frm_contato.php';
              if ($tipoPessoa == 'J' || $tipoPessoa == 'j') : ?>
                <div class="row">
                    <div class="col-xs-12  col-md-9 ">
                        <div class="form-group">
                            <label> 1° Sócio:</label>
                            <input type="text" name="CLIENTE[socio_1]" class="form-control" value="<?= isset($cliente['socio_1']) ? $cliente['socio_1'] : ""; ?>" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cpf_socio1") : ""; ?>/>
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-3 ">
                        <div class="form-group">
                            <label>CPF:</label>
                            <input type="text" name="CLIENTE[cpf_socio1]" class="form-control  mask_cpf " value="<?= isset($cliente['cpf_socio1']) ? $cliente['cpf_socio1'] : ""; ?>" required <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cpf_socio1") : ""; ?>/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12  col-md-9 ">
                        <div class="form-group">
                            <label>2° Sócio:</label>
                            <input type="text" name="CLIENTE[socio_2]" class="form-control" value="<?= isset($cliente['socio_2']) ? $cliente['socio_2'] : ""; ?>" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "socio_2") : ""; ?>/>
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-3">
                        <div class="form-group">
                            <label>CPF:</label>
                            <input type="text" name="CLIENTE[cpf_socio2]" class="form-control  mask_cpf " value="<?= isset($cliente['cpf_socio2']) ? $cliente['cpf_socio2'] : ""; ?>" <?= $statusCadastro == 2 ? Funcoes::verificarCamposContratoCliente($camposCliente, "cpf_socio2") : ""; ?>/>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>    
<script type="text/javascript">
    $(function(){
        $(".maskCELULAR").mask("(00) 00000-00090");
        $(".maskFIXO").mask("(00) 0000-000090");
    });
</script>
    <?php 
        //FORMA DE PAGAMENTO:
        include_once 'frm_forma_de_pagamento.php';
        
        //ENDERECO RESIDENCIAL:
        include_once 'frm_endereco_residencial.php';
    
        //ENDERECO DE COBRANCA:
        include_once 'frm_endereco_cobranca.php';

        //ENDERECO DE ENTREGA:   
        include_once 'frm_endereco_entrega.php';
    ?>     
    <div class="row">
        <div class="col-xs-12  col-sm-8 col-md-8">
            <input type="hidden" name="CONTATO[0][id_cliente_contato]" value="<?=$id_cliente; ?>" />
            <input type="hidden" name="CONTATO[1][id_cliente_contato]" value="<?=$id_cliente; ?>" />
            <input type="hidden" name="CONTATO[0][ra_contato]" value="1" />
            <input type="hidden" name="CONTATO[1][ra_contato]" value="2" />
            <input type="hidden" name="CLIENTE[id_cliente]" id="id_cliente" value="<?=$id_cliente; ?>" />
            <input type="hidden" name="id" id="id" value="<?= $id_cliente; ?>" />
            <input type="hidden" name="CLIENTE[status_cadastro]" value="<?=$statusCadastro; ?>" />
            <input type="hidden" name="acao" value="cadastroCliente" />
            <input type="submit" value="SALVAR" class="btn btn-primary" />
        </div>
    </div>
</form>
<script type="text/javascript">
    $(function () {
        $(".mask_data").mask("00/00/0000");
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
        $('#_busca_cep_endereco_entrega').click(function () {
            _busca_cep('endereco_entrega');
        });
        $('#_busca_cep_endereco_cobranca').click(function () {
             _busca_cep('endereco_cobranca');
        });
        function _busca_cep($parametro){
            if($parametro=='endereco_entrega'){
                var cep     =  $('#_cep_endereco_entrega');
                var rua     =  $('#_rua_endereco_entrega');
                var bairro  =  $('#_bairro_endereco_entrega');
                var cidade  =  $('#_cidade_endereco_entrega');
                var uf      =  $('#_uf_endereco_entrega');
            }else{
                var cep     =  $('#_cep_endereco_cobranca');
                var rua     =  $('#_rua_endereco_cobranca');
                var bairro  =  $('#_bairro_endereco_cobranca');
                var cidade  =  $('#_cidade_endereco_cobranca');
                var uf      =  $('#_uf_endereco_cobranca');
            }
            if (cep.val() == "") {
                alert('campo cep obrigatorio');
                cep.focus();
                return false;
            } else{
                rua.val("carregando.....");
                bairro.val("carregando.....");
                cidade.val("carregando.....");
                uf.val("carregando.....");
                var q4 = cep.val();
                $.getScript("http://cep.republicavirtual.com.br/web_cep.php?cep=" + q4 + "&formato=javascript", function () {
                    var Rua = unescape(resultadoCEP.logradouro);
                    var Bairro = unescape(resultadoCEP.bairro);
                    var Cidade = unescape(resultadoCEP.cidade);
                    var Uf = unescape(resultadoCEP.uf);
                    rua.val(Rua);
                    bairro.val(Bairro);
                    cidade.val(Cidade);
                    uf.val(Uf);
                });
            }		   			   
        }
    });    
</script>