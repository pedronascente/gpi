<?php
    $array_plano = array(
        'Rastreamento',
        'Rastreamento + Proteção veicular',
        'Rastreamento + Proteção veicular + Assistência Veicular'   
    );
?>
<form action="modulos/captacao/src/controllers/captacao.php" method="post">
    <div class="panel panel-primary">
        <div class="panel-default panel-body">
            <div class="row">
                <div class="col-xs-6 col-sm-4 col-md-4 ">
                    <div class="form-group">
                        <label>Placa:</label>
                        <input  type="text" name="placa" id="placa"  maxlength="8" value="<?= (!empty($veiculo['placa'])) ? strtoupper($veiculo['placa']) : ""; ?>" class="mask_placa form-control"  <?= $statusCadastro == 2 && !empty($veiculo) == 2 ? Funcoes::verificarCamposContratoVeiculo($camposVeiculos, "placa", $id_veiculo) : ""; ?>/>
                    </div>
                </div>  
                 <div class="col-xs-6 col-sm-4 col-md-4 ">
                    <div class="form-group">
                        <label>Combustível:</label>
                        <select required name="combustivel" class="form-control  text-center" <?= $statusCadastro == 2 && !empty($veiculo) == 2 ? Funcoes::verificarCamposContratoVeiculo($camposVeiculos, "combustivel", $id_veiculo) : ""; ?>>
                            <option value="">Selecione...</option>
                            <option value="2" <?= isset($veiculo['combustivel']) && $veiculo['combustivel'] == 2 ? "selected" : ""; ?>>Álcool</option>
                            <option value="3" <?= isset($veiculo['combustivel']) && $veiculo['combustivel'] == 3 ? "selected" : ""; ?>>Bicombustível</option>
                            <option value="4" <?= isset($veiculo['combustivel']) && $veiculo['combustivel'] == 4 ? "selected" : ""; ?>>Diesel</option>
                            <option value="5" <?= isset($veiculo['combustivel']) && $veiculo['combustivel'] == 5 ? "selected" : ""; ?>>GNV</option>
                            <option value="6" <?= isset($veiculo['combustivel']) && $veiculo['combustivel'] == 6 ? "selected" : ""; ?>>Gasolina</option>
                        </select>
                    </div>
                </div>   
                 <div class="col-xs-6 col-sm-4 col-md-4 ">			
                    <div class="form-group">
                        <label>Bloqueio:</label>
                        <select name="bloqueio" class="form-control  text-center" <?= $statusCadastro == 2 && !empty($veiculo) == 2 ? Funcoes::verificarCamposContratoVeiculo($camposVeiculos, "bloqueio", $id_veiculo) : ""; ?>>
                            <option value="s" <?= isset($veiculo['bloqueio']) && $veiculo['bloqueio'] == "s" ? "selected" : null; ?>>SIM</option>
                            <option value="n" <?= isset($veiculo['bloqueio']) && $veiculo['bloqueio'] == "n" ? "selected" : null; ?>>NÃO</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label> Marca:</label>
                        <input type="text" name="marca" id="marca" value="<?= (!empty($veiculo['marca'])) ? strtoupper($veiculo['marca']) : ""; ?>" class="form-control" required <?= $statusCadastro == 2 && !empty($veiculo) == 2 ? Funcoes::verificarCamposContratoVeiculo($camposVeiculos, "marca", $id_veiculo) : ""; ?>/>
                    </div>
                </div>  
               <div class="col-xs-6 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Modelo:</label>
                        <input type="text" name="modelo" id="modelo" maxlength="200" value="<?= (!empty($veiculo['modelo'])) ? strtoupper($veiculo['modelo']) : ""; ?>" class="form-control" required <?= $statusCadastro == 2 && !empty($veiculo) == 2 ? Funcoes::verificarCamposContratoVeiculo($camposVeiculos, "modelo", $id_veiculo) : ""; ?>/>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Ano:</label>
                        <input type="text" name="ano" class="form-control mask_anofab" value="<?= (!empty($veiculo['ano'])) ? strtoupper($veiculo['ano']) : ""; ?>" <?= $statusCadastro == 2 && !empty($veiculo) == 2 ? Funcoes::verificarCamposContratoVeiculo($camposVeiculos, "ano", $id_veiculo) : ""; ?>>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3">			
                    <div class="form-group">
                        <label>Tipo bateria:</label>
                        <select name="tipo_bateria" class="form-control text-center" <?= $statusCadastro == 2 && !empty($veiculo) ? Funcoes::verificarCamposContratoVeiculo($camposVeiculos, "tipo_bateria", $id_veiculo) : ""; ?>>
                            <option value="12V" <?= isset($veiculo['tipo_bateria']) && $veiculo['tipo_bateria'] == "12V" ? "selected" : null; ?>>12 VOLTS</option>
                            <option value="24V" <?= isset($veiculo['tipo_bateria']) && $veiculo['tipo_bateria'] == "24V" ? "selected" : null; ?>>24 VOLTS</option>
                        </select>
                    </div>
                </div>
            </div>    
            <div class="row">
                 <div class="col-xs-4 col-sm-4 col-md-4 ">
                    <div class="form-group">
                        <label> Chassi:</label>
                        <input type="text" name="chassis" id="chassis" maxlength="20" value="<?= (!empty($veiculo['chassis'])) ? $veiculo['chassis'] : ""; ?>" class="form-control" <?= $statusCadastro == 2 && !empty($veiculo) == 2 ? Funcoes::verificarCamposContratoVeiculo($camposVeiculos, "chassis", $id_veiculo) : ""; ?>/>
                    </div>
                </div>  
                <div class="col-xs-4 col-sm-4 col-md-4 ">
                    <div class="form-group">
                        <label>Renavam:</label>
                        <input type="text" name="renavam" id="renavam" value="<?= (!empty($veiculo['renavam'])) ? $veiculo['renavam'] : ""; ?>" class="form-control"  <?= $statusCadastro == 2 && !empty($veiculo) == 2 ? Funcoes::verificarCamposContratoVeiculo($camposVeiculos, "renavam", $id_veiculo) : ""; ?>/>
                    </div>
                </div>  
                <div class="col-xs-4 col-sm-4 col-md-4 ">
                    <div class="form-group">
                        <label>Cor:</label>
                        <input type="text" name="cor" id="cor" size="20" maxlength="20" value="<?= (!empty($veiculo['cor'])) ? strtoupper($veiculo['cor']) : ""; ?>" class="form-control" required <?= $statusCadastro == 2 && !empty($veiculo) == 2 ? Funcoes::verificarCamposContratoVeiculo($camposVeiculos, "cor", $id_veiculo) : ""; ?>/>
                    </div>
                </div>
            </div>    
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 ">
                    <div class="form-group">
                        <label>Tipo de Serviço:</label>
                        <select name="tipo_seguro" class="form-control"  id="_tipo_seguro"  >
                            <?php for ( $i=0;$i<count($array_plano);$i++){ ?>
                                    <option value="<?php echo $array_plano[$i] ?>" <?=(isset($veiculo['tipo_seguro']) && $array_plano[$i]==$veiculo['tipo_seguro'])?"selected":'';?> ><?=$array_plano[$i];?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4"   id="_valor_protecao1" style="display: none">
                    <div class="form-group">
                        <label>Taxa Mensal Proteção Veicular :</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" name="valor_protecao"  size="20" value="<?= (!empty($veiculo['valor_protecao'])) ? $veiculo['valor_protecao'] : ""; ?>" class=" mask_real form-control"  />
                            <span class="input-group-addon">.00</span>
                        </div>
                    </div>
                </div>  
                <div class="col-xs-4 col-sm-4 col-md-4" id="_valor_protecao2" style="display: none">
                    <div class="form-group">
                        <label>Taxa Mensal Assistencial Veicular :</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" name="valor_protecao_assistencial"  size="20" value="<?= (!empty($veiculo['valor_protecao_assistencial'])) ? $veiculo['valor_protecao_assistencial'] : ""; ?>" class=" mask_real form-control"  />
                            <span class="input-group-addon">.00</span>
                        </div>
                    </div>
                </div>  
            </div> 
            <div class="row">
                <div class=" col-xs-4 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label> <?= ($tipo_cadastro == "contrato_promocao") ? 'Valor Equipamento' : 'Taxa Instalação Rastreamento'; ?>:</label>
                        <div class="input-group" >
                            <span class="input-group-addon">$</span>
                            <?php
                            if ($tipo_cadastro == "contrato_promocao") :
                                ?>
                                <input type="text" name="valor_equipamento" value="<?= (!empty($veiculo['valor_equipamento'])) ? $veiculo['valor_equipamento'] : ""; ?>" class=" mask_real  form-control" <?= $statusCadastro == 2 && !empty($veiculo) == 2 ? Funcoes::verificarCamposContratoVeiculo($camposVeiculos, "valor_equipamento", $id_veiculo) : ""; ?> />
                                <?php
                            else :
                                ?>
                                <input type="text" name="taxa_instalacao" id="taxa_instalacao"  value="<?= (!empty($veiculo['taxa_instalacao'])) ? $veiculo['taxa_instalacao'] : ""; ?>" class=" mask_real  form-control" <?= $statusCadastro == 2 && !empty($veiculo) == 2 ? Funcoes::verificarCamposContratoVeiculo($camposVeiculos, "taxa_instalacao", $id_veiculo) : ""; ?>/>
                            <?php
                            endif;
                            ?>
                            <span class="input-group-addon">.00</span>
                        </div> 
                    </div>
                </div>  
                <div class="col-xs-4 col-sm-4 col-md-4 ">
                    <div class="form-group">
                        <label>Taxa Mensal Rastreamento:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" name="taxa_monitoramento" id="taxa_monitoramento" size="20" value="<?= (!empty($veiculo['taxa_monitoramento'])) ? $veiculo['taxa_monitoramento'] : ""; ?>" class=" mask_real form-control"  <?= $statusCadastro == 2 && !empty($veiculo) == 2 ? Funcoes::verificarCamposContratoVeiculo($camposVeiculos, "taxa_monitoramento", $id_veiculo) : ""; ?>/>
                            <span class="input-group-addon">.00</span>
                        </div>
                    </div>
                </div>  
            </div>          
            <div class="row">
                <div class="  col-md-12 ">
                    <div class="form-group">
                        <label>Observações:</label>
                        <textarea cols="46" rows="6" name="obs" id="obs" class="form-control" <?= $statusCadastro == 2 && !empty($veiculo) ? Funcoes::verificarCamposContratoVeiculo($camposVeiculos, "obs", $id_veiculo) : ""; ?>><?= (!empty($veiculo['obs'])) ? strtoupper($veiculo['obs']) : ""; ?></textarea>
                    </div>
                </div>   
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <input type="hidden" name="id_cliente" value="<?= $id_cli; ?>" />  
                        <?php 
                            if (isset($veiculo['id_veiculo'])):
                                echo '<input type="hidden" name="id_veiculo" value="'.$veiculo['id_veiculo'].'" />';
                            endif;
                        ?>
                        <input type="hidden" name="acao" value="<?= (!empty($veiculo['id_veiculo'])) ? "EditarVeiculo" : "InsertVeiculo"; ?>" />
                        <input type="hidden"  id="id_veiculo" value="<?= (!empty($veiculo['id_veiculo'])) ?  $veiculo['id_veiculo']:''; ?>" />
                        <input type="submit" value="<?= (!empty($veiculo['id_veiculo'])) ? "Editar" : "Salvar"; ?>" class="btn btn-primary" />
                        <a href="?pg=31&id=<?= $id_cliente ?>&id_cliente_contrato=<?= $id_cli; ?>#veiculos" class="btn btn-info">Listar Veiculos</a>
                    </div>
                </div>   
            </div> 
        </div>
    </div>
</form>
<script type="text/javascript">
    $(function(){
        var  _glolbal_tipo_seguro = $('#_tipo_seguro').val();       
        if(_glolbal_tipo_seguro =='Rastreamento + Proteção veicular'){
            $('#_valor_protecao2').hide();
            $('input[name="valor_protecao_assistencial"]').val('');
            $('#_valor_protecao1').show();
        }else if(_glolbal_tipo_seguro =='Rastreamento + Proteção veicular + Assistência Veicular'){
            $('#_valor_protecao1').show();
            $('#_valor_protecao2').show();
        }else{
            $('#_valor_protecao1').hide();
            $('#_valor_protecao2').hide();                
        }
        $('#_tipo_seguro').change(function(){
            var _valor = $(this).val();
            if(_valor =='Rastreamento + Proteção veicular'){
               $('#_valor_protecao2').hide();
               $('input[name="valor_protecao_assistencial"]').val('');
               $('#_valor_protecao1').show();
            }else if(_valor =='Rastreamento + Proteção veicular + Assistência Veicular'){
               $('#_valor_protecao1').show();
               $('#_valor_protecao2').show();
            }else{
               $('input[name="valor_protecao"]').val('');
               $('input[name="valor_protecao_assistencial"]').val('');  
               $('#_valor_protecao1').hide();
               $('#_valor_protecao2').hide();
            }
        });
    });
</script>