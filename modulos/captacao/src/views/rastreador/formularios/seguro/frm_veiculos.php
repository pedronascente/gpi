<form action="modulos/captacao/src/controllers/captacao.php" method="post">
    <div class="panel panel-primary">
        <div class="panel-default panel-body">
            <div class="row">
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label>Nº Cotação ou, Proposta:</label>
                        <input  
                            type="text" 
                            name="numero_cotacao_do_seguro" 
                            maxlength="10" 
                            class="form-control"
                            value="<?=isset($veiculo['numero_cotacao_do_seguro'])?$veiculo['numero_cotacao_do_seguro']:'';?>"  
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 ">
                    <div class="form-group">
                        <label>Placa:</label>
                        <input  
                            type="text" 
                            name="placa" 
                            style="text-transform:uppercase" 
                            maxlength="10" 
                            class="form-control"
                            value="<?=isset($veiculo['placa'])?$veiculo['placa']:'';?>"  
                        />
                    </div>
                </div>  
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Combustível:</label>
                        <select required name="combustivel" class="form-control  text-center">
                            <option value="">Selecione...</option>
                            <?php
                                $_ArrayListCombustivel = [
                                    2=>'Álcool',
                                    3=>'Bicombustível',
                                    4=>'Diesel',
                                    5=>'GNV',
									6=>'Gazolina',
                                ];
                                foreach($_ArrayListCombustivel as $k => $v){ ?>
                                    <option value="<?=$k;?>" 
                                        <?php   
                                            if(isset($veiculo)){
                                                if($k == $veiculo['combustivel']) { 
                                                    echo 'selected'; 
                                                }
                                            }  
                                        ?> 
                                    ><?=$v?></option><?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
               <div class="col-md-4">         
                    <div class="form-group">
                        <label>Bateria:</label>
                        <select name="tipo_bateria" class="form-control text-center">
                            <?php
                                $_Array_list_bateria = [
                                    "12V" => "12 VOLTS",
                                    "24V" => "24 VOLTS",
                                ];
                                foreach($_Array_list_bateria as $k => $v){ ?>
                                    <option value="<?=$k;?>" <?=(isset($veiculo['tipo_bateria'])) && ($veiculo['tipo_bateria'] == $k) ? "selected" : ''; ?> ><?=$v?></option>
                                   <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label> Marca:</label>
                        <input 
                            type="text" 
                            name="marca"  
                            class="form-control" 
                            value="<?=(isset($veiculo['marca'])?$veiculo['marca']:'');?>"
							required=""
                        />
                    </div>
                </div>  
               <div class="col-md-4">
                    <div class="form-group">
                        <label>Modelo:</label>
                        <input 
                            type="text" 
                            name="modelo"  
                            maxlength="200" 
                            class="form-control"     
                            value="<?=(isset($veiculo['modelo'])) ? $veiculo['modelo']:'';?>"
							required=""
                        />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Ano:</label>
                        <input 
                            type="text" 
                            name="ano" 
                            class="form-control mask_anofab"
                            value="<?=(isset($veiculo['ano'])) ? $veiculo['ano']:'';?>"   
                        />
                    </div>
                </div>
            </div>    
            <div class="row">
                 <div class="col-xs-4 col-sm-4 col-md-4 ">
                    <div class="form-group">
                        <label> Chassi:</label>
                        <input 
                            type="text" 
                            name="chassis" 
                            maxlength="20" 
                            class="form-control"
                            value="<?=(isset($veiculo['chassis'])?$veiculo['chassis']:'');?>" 
                        />
                    </div>
                </div>  
                <div class="col-xs-4 col-sm-4 col-md-4 ">
                    <div class="form-group">
                        <label>Renavam:</label>
                        <input 
                            type="text" 
                            name="renavam" 
                            class="form-control" 
                            value="<?=(isset($veiculo['renavam'])?$veiculo['renavam']:'');?>"
                        />
                    </div>
                </div>  
                <div class="col-xs-4 col-sm-4 col-md-4 ">
                    <div class="form-group">
                        <label>Cor:</label>
                        <input 
                            type="text" 
                            name="cor" 
                            class="form-control"  
                            required=""  
                            value="<?=(isset($veiculo['cor']))?$veiculo['cor']:'';?>" 
                        />
                    </div>
                </div>
            </div>   
            <div class="row">
                <div class="  col-md-12 ">
                    <div class="form-group">
                        <label>Observações:</label>
                        <textarea cols="46" rows="6" name="obs" id="obs" class="form-control"><?=(isset($veiculo['obs']))?$veiculo['obs']:'';?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="  col-md-12 ">
                    <?php  
                         //FORMA DE PAGAMENTO:
                        include_once __DIR__ .'/frm_forma_de_pagamento.php';
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <input type="hidden" name="id_cliente" value="<?=$id_cli;?>" />  
                        <input type="submit" value="Salvar" class="btn btn-primary" />
                        <?php
                            if(isset($veiculo) && !empty($id_veiculo)){
                                echo '<input type="hidden" name="acao" value="edit_veiculo_seguro"/>';
                                echo '<input type="hidden" name="id_veiculo" value="'.$veiculo['id_veiculo'].'"/>';
                            }else{
                                echo '<input type="hidden" name="acao" value="insert_veiculo_seguro" />';
                            }
                        ?>
                        <a href="?pg=31&id=<?=$id_cliente;?>&id_cliente_contrato=<?=$id_cli;?>#veiculos" 
                            class="btn btn-info">
                                Listar Veiculos
                        </a>
                    </div>
                </div>   
            </div> 
        </div>
    </div>
</form>