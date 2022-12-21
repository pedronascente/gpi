<div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="cliente" role="button" data-toggle="collapse" href="#dadosCliente" aria-expanded="true" aria-controls="collapseOne">
        Cliente
    </div>
    <div id="dadosCliente" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="cliente">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td colspan="4" style="background: lightgray"><b>DADOS CLIENTE:</b></td>
                        </tr> 
                        <tr>
                            <td colspan="2"><b>Tipo Pessoa:</b><br><?=!empty($list_cliente ['tipo_pessoa']) ? ($list_cliente ['tipo_pessoa'] == 'f' ? 'Fisica' : 'Juridica') : NULL;?></td>
                            <td><b>Vigência:</b><br>
                                <?php 
                                    switch ($list_cliente ['vigencia']){
                                        case'1': $vigencia='12 Meses';  break;
                                        case'2': $vigencia='24 Meses'; break;
                                        case'3': $vigencia='36 Meses'; break;
                                    }
                                    echo $vigencia;
                                ?>
                            </td>
                            <td><b>Tipo Contratação:</b><br><?= $list_cliente ['tipo_cadastro']=='rastreador' ? "COMODATO" :"VENDA";?></td>
                        </tr>
                        <tr>
                            <td colspan="3"><b>Nome/Razão Social:</b><br><?=!empty($list_cliente ['nome_cliente']) ? $list_cliente ['nome_cliente'] : NULL;?></td>
                            <td><b>CPF/CNPJ:</b><br><?=!empty($list_cliente ['cnpjcpf_cliente']) ? $list_cliente ['cnpjcpf_cliente'] : NULL;?></td>
                        </tr>
                        <tr>
                            <td><b>Insc. Municipal:</b><br><?=!empty($list_cliente ['inscr_municipal']) ? $list_cliente ['inscr_municipal'] : NULL;;?></td>
                            <td><b>RG / Insc. Estadual:</b><br><?=!empty($list_cliente ['rg_cliente']) ? $list_cliente ['rg_cliente'] : NULL;;?></td>
                            <td><b>Estado Civil:</b><br><?=!empty($list_cliente ['estado_civil']) ? $list_cliente ['estado_civil'] : NULL;?></td>
                            <td></td>
                        </tr>
                        
                        <?php  if(!empty($list_cliente ['socio_1'])){?>
                            <tr>
                                <td colspan="4" style="background: lightgray"><b>SÓCIOS:</b></td>
                            </tr>
                            <tr>
                                <td colspan="2"> <b>1° Sócio:</b><br><?=!empty($list_cliente ['socio_1']) ? $list_cliente ['socio_1'] : NULL;?></td>
                                <td colspan="2"><b>CPF 1° Sócio:</b><br><?=!empty($list_cliente ['cpf_socio1']) ? $list_cliente ['cpf_socio1'] : NULL;;?></td>
                            </tr>
                            <tr>
                                <td colspan="2"> <b>2° Sócio:</b><br><?=!empty($list_cliente ['socio_2']) ? $list_cliente ['socio_2'] : NULL;?></td>
                                <td colspan="2"><b>CPF 2° Sócio:</b><br><?=!empty($list_cliente ['cpf_socio2']) ? $list_cliente ['cpf_socio2'] : NULL;?></td>
                            </tr>
                        <?php  }?>
                        
                        <?php  if(!empty($CONTATO1['nome_contato'])|| !empty($CONTATO1['telefone1_contato'])){?>
                            <tr>
                                <td colspan="4" style="background: lightgray"><b>CONTATOS:</b></td>
                            </tr>
                            <tr>
                                <td colspan="2"> <b>1°Contato:</b><br><?=$CONTATO1['nome_contato'];?></td>
                                <td colspan="2"><b>E-mail / 1°Contato:</b><br><?=$CONTATO1['email_contato'];?></td>
                            </tr>
                            <tr>
                                <td><b>Telefone1:</b><br><?=$CONTATO1['telefone1_contato'];?></td>
                                <td><b>Telefone2:</b><br><?=$CONTATO1['telefone2_contato'];?></td>
                                <td><b>Telefone3:</b><br><?=$CONTATO1['telefone3_contato'];?></td>
                                <td></td>
                            </tr>
                        <?php  }else{ ?>
                            <tr>
                                <td colspan="4" style="background: lightgray"><b>CONTATOS:</b></td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>1°Contato:</b><br><?=$list_cliente['contato_cliente'];?></td>
                                <td colspan="2"><b>E-mail / 1°Contato:</b><br><?=$list_cliente['email_cliente'];?></td>
                            </tr>
                            <tr>
                                <td><b>Telefone1:</b><br><?=$list_cliente['telefone_cliente'];?></td>
                                <td><b>Telefone2:</b><br><?=$list_cliente['celular_cliente'];?></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php  } ?>
                        <?php  if(!empty($CONTATO2['nome_contato'])|| !empty($CONTATO2['telefone1_contato'])){?>
                            <tr>
                                <td colspan="2"><b>2°Contato:</b><br><?=$CONTATO2['nome_contato'];?></td>
                                <td colspan="2"><b>E-mail / 2°Contato:</b><br><?=$CONTATO2['email_contato'];?></td>
                            </tr>
                            <tr>
                                <td colspan=""><b>Telefone1:</b><br><?=$CONTATO2['telefone1_contato'];?></td>
                                <td colspan=""><b>Telefone2:</b><br><?=$CONTATO2['telefone2_contato'];?></td>
                                <td colspan=""><b>Telefone3:</b><br><?=$CONTATO2['telefone3_contato'];?></td>
                            </tr>
                        <?php  }?>
                        <tr>
                            <td colspan="4" style="background: lightgray"><b>ENDEREÇO RESIDENCIAL:</b></td>
                        </tr>
                        <tr>
                            <td><b>CEP:</b><br><?=!empty($list_cliente ['cep_cliente']) ? $list_cliente ['cep_cliente'] : NULL;?></td>
                            <td><b>UF:</b><br><?=!empty($list_cliente ['uf_cliente']) ? $list_cliente ['uf_cliente'] : NULL;?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3"><b>Endereço:</b><br><?=!empty($list_cliente ['logradouro_cliente']) ? $list_cliente ['logradouro_cliente'] : NULL;?></td>
                            <td><b>Numero:</b><br><?=!empty($list_cliente ['numero_cliente']) ? $list_cliente ['numero_cliente'] : NULL;?></td>
                        </tr>
                        <tr>
                            <td><b>Cidade:</b><br><?= !empty($list_cliente ['cidade_cliente']) ? $list_cliente ['cidade_cliente'] : NULL;?></td>
                            <td><b>Bairro:</b><br><?= !empty($list_cliente ['bairro_cliente']) ? $list_cliente ['bairro_cliente'] : NULL;?></td>
                            <td><b>Complemento:</b><br><?=!empty($list_cliente ['complemento_cliente']) ? $list_cliente ['complemento_cliente'] : NULL;?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Observação:</b><br><?=!empty($list_cliente ['obs_clientes']) ? $list_cliente ['obs_clientes'] : NULL;?></td>
                        </tr>
                        <?php  if(!empty($ENDERECO_COBRANCA['cep_cobranca'])&& !empty($ENDERECO_COBRANCA['logradouro_cobranca'])){?>
                            <tr>
                                <td colspan="4" style="background: lightgray"><b>ENDEREÇO COBRANÇA:</b></td>
                            </tr>
                            <tr>
                                <td><b>CEP:</b><br><?=$ENDERECO_COBRANCA['cep_cobranca']?></td>
                                <td><b>UF:</b><br><?=$ENDERECO_COBRANCA['uf_cobranca']?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>Endereço:</b><br><?=$ENDERECO_COBRANCA['logradouro_cobranca']?></td>
                                <td><b>Numero:</b><br><?=$ENDERECO_COBRANCA['numero_cobranca']?></td>
                            </tr>
                            <tr>
                                <td><b>Cidade:</b><br><?=$ENDERECO_COBRANCA['cidade_cobranca']?></td>
                                <td><b>Bairro:</b><br><?=$ENDERECO_COBRANCA['bairro_cobranca']?></td>
                                <td><b>Complemento:</b><br><?=$ENDERECO_COBRANCA['complemento_cobranca']?></td>
                                <td></td>
                            </tr>
                        <?php }?>         
                        <?php  if(!empty($ENDERECO_ENTREGA['cep_cobranca'])&& !empty($ENDERECO_ENTREGA['logradouro_cobranca'])){?>
                            <tr>
                                <td colspan="4" style="background: lightgray"><b>ENDEREÇO ENTREGA:</b></td>
                            </tr>
                            <tr>
                                <td><b>CEP:</b><br><?=$ENDERECO_ENTREGA['cep_cobranca']?></td>
                                <td><b>UF:</b><br><?=$ENDERECO_ENTREGA['uf_cobranca']?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>Endereço:</b><br><?=$ENDERECO_ENTREGA['logradouro_cobranca']?></td>
                                <td><b>Numero:</b><br><?=$ENDERECO_ENTREGA['numero_cobranca']?></td>
                            </tr>
                            <tr>
                                <td><b>Cidade:</b><br><?=$ENDERECO_ENTREGA['cidade_cobranca']?></td>
                                <td><b>Bairro:</b><br><?=$ENDERECO_ENTREGA['bairro_cobranca']?></td>
                                <td><b>Complemento:</b><br><?=$ENDERECO_ENTREGA['complemento_cobranca']?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>Aos cuidados de:</b><br><?=$ENDERECO_ENTREGA['contato_cobranca']?></td>
                                <td><b>Telefone:</b><br><?=$ENDERECO_ENTREGA['telefone_cobranca']?></td>
                                <td><b>Celular:</b><br><?=$ENDERECO_ENTREGA['celular_cobranca']?></td>
                            </tr>
                        <?php }?>    
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>