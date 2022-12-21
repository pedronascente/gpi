<?php //namespace C:\wamp\www\gpi\modulos\captacao\src\views\captacao\formularios\frm_edit_formulario_a.php ?>

<style>  ._alert-background{background: antiquewhite}   </style>  
<?php date_default_timezone_set('America/Sao_Paulo'); ?>   
    <form action="modulos/captacao/src/controllers/captacao.php" method="post" id="basic_validate_usuario" novalidate="novalidate"> 
        <div class="panel panel-primary">
            <!-- div class="panel-heading"> Editar captação   </div -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group">
                            <label>Data:</label>
                            <input type="text" class="form-control mask_data"  maxlength="10"  value="<?= $data_cadastro; ?>"  disabled="" >
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3 ">
                        <div class="form-group">
                            <label>Horario:</label>
                            <input type="text"  class=" form-control mask_hora "   maxlength="7"   value="<?= $horario; ?>"  disabled="" >
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-6 ">
                        <div class="form-group">
                            <label>Responsavel:</label>
                            <input type="text"  class="form-control"  value="<?= $captacao_responsavel; ?>"   disabled="" >
                        </div>
                    </div>
                </div>
                <div class="alert _alert-background">
                    <p>Olá bom dia (conforme o horário), seja bem-vindo ao <b>MUNDO MAIS PROTEGIDO DA VOLPATO</b>. Meu nome é (declarar) e eu  sou a/o responsável pelo seu atendimento, com quem eu falo ?</p>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12" >
                        <div class="form-group">
                            <label>Cliente:</label>
                            <input type="text" name="captacao_cliente"  value="<?= $captacao_cliente; ?>" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="alert _alert-background"> 
                    <p> Muito bem sr/sra (repete o nome da pessoa) para que possamos continuar este atendimento, o senhor(a) nos permite registrar o numero do seu telefone de contato para o caso de precisarmos retornar em caso de queda da ligação ?</p>
                </div>                  
                <div class="row">
                    <div class="col-xs-12 col-sm-3  col-md-3">
                        <div class="form-group">
                            <label>Telefone | Celular 1:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-earphone"></span>
                                </span>
                                <input type="text" name="captacao_telefone1"   value="<?= $captacao_telefone1; ?>"  id="captacao_telefone1" class="mask_telefone form-control" required placeholder="Telefone" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3  col-md-3">
                        <div class="form-group">
                            <label>Operadora:</label>
                            <select id="captacao_operadora1" name="captacao_operadora1" class="form-control">
                                <option selected="selected" value=""> -- Selecione -- </option>
                                <option value="Claro" <?= ($captacao_operadora1 == "Claro") ? "selected" : ''; ?> > Claro</option>
                                <option value="Embratel" <?= ($captacao_operadora1 == "Embratel") ? "selected" : ''; ?> >Embratel</option>
                                <option value="OI" <?= ($captacao_operadora1 == "OI") ? "selected" : ''; ?> >OI</option>
                                <option value="TIM"  <?= ($captacao_operadora1 == "TIM") ? "selected" : ''; ?>>TIM</option>
                                <option value="Vivo"  <?= ($captacao_operadora1 == "Vivo") ? "selected" : ''; ?>>Vivo</option>
                                <option value="GVT" <?= ($captacao_operadora1 == "GVT") ? "selected" : ''; ?> >GVT</option>
                                <option value="Net"  <?= ($captacao_operadora1 == "Net") ? "selected" : ''; ?> >Net</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3  col-md-3 ">
                        <div class="form-group">
                            <label>Telefone | Celular 2:</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-earphone"></span>
                                </span>
                                <input type="text" name="captacao_telefone2" id="captacao_telefone2" class="mask_telefone form-control"  value="<?= $captacao_telefone2; ?>"  placeholder="Telefone" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3  col-md-3 ">
                        <div class="form-group">
                            <label>Operadora 2:</label>
                            <select id="captacao_operadora2" name="captacao_operadora2" class="form-control">
                                <option selected="selected" value=""> -- Selecione -- </option>
                                <option value="Claro" <?= ($captacao_operadora2 == "Claro") ? "selected" : ''; ?> > Claro</option>
                                <option value="Embratel" <?= ($captacao_operadora2 == "Embratel") ? "selected" : ''; ?> >Embratel</option>
                                <option value="OI" <?= ($captacao_operadora2 == "OI") ? "selected" : ''; ?> >OI</option>
                                <option value="TIM"  <?= ($captacao_operadora2 == "TIM") ? "selected" : ''; ?>>TIM</option>
                                <option value="Vivo"  <?= ($captacao_operadora2 == "Vivo") ? "selected" : ''; ?>>Vivo</option>
                                <option value="GVT" <?= ($captacao_operadora2 == "GVT") ? "selected" : ''; ?> >GVT</option>
                                <option value="Net"  <?= ($captacao_operadora2 == "Net") ? "selected" : ''; ?> >Net</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12  col-md-12 ">
                        <div class="form-group">
                            <label>E-mail:</label>
                            <div class="input-group">
                                <div class="input-group-addon">@</div>
                                <input type="email" name="captacao_email" id="captacao_email" class="form-control" value="<?= $captacao_email; ?>"  placeholder="Entre com o email" required="" >
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="alert _alert-background"> 
                    <p> O senhor(a) se importaria em nos fornecer a sua data de nascimento (dia/mês) para que possamos lhe enviar uma mensagem em datas especiais?  </p>
                </div> 
                <div class="row">
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <label>Data Nascimento:</label>
                            <input type="text" name="captacao_data_nascimento"  value="<?= $captacao_data_nascimento; ?>" class="form-control mask_data" required />
                        </div>
                    </div>
                </div>
                <div class="alert _alert-background"> 
                    <p> Ok, Obrigado, vamos continuar !</p><br>
                    <p><b> P1 - O motivo da sua ligação é para que o senhor(a) possa conhecer melhor os nossos produtos e serviços ?</b></p>
                    <p> No caso de confirmação, informe e pergunte a ele:</p>
                    <p>A Volpato é especializada em 4 tipos de serviços.</p>
                    <ul>
                        <li>Alarmes monitorados;</li>
                        <li>Rastreamento veicular;</li>
                        <li>Portaria remota;</li>
                        <li>Portaria Presencial;</li>
                    </ul>
                    <br>
                    <p>Quais destes serviços o senhor(a) está interessado em conhecer? Caso o possível cliente declare interesse em rastreamento veicular, portaria remota ou presencial, você deve informar a ele:</p>
                    <p>Certo, senhor(a) repetir o nome, uma pessoa das nossas divisões de (rastreamento veicular ou portaria remota) vai entrar em contato com o senhor(a) através do telefones que o senhor nos forneceu, tudo bem? Depois da confirmação de “ok” do interessado, o nome e os telefones do mesmo devem ser registrados na GPI correspondente. Depois disso, deverá ser aplicado a finalização do atendimento conforme consta no final deste formulário. </p>
                    <p>No caso em que o interesse seja pelo alarme monitorado</p>
                    <p>Normalmente o possível cliente responde sim a esta pergunta, se responder não significa que a ligação não entrou de forma correta e ele (a) quer outra solicitação e então perguntamos:</p>
                    <p><b>Resposta P 1- Não:</b> (Neste caso você vai identificar o motivo da ligação e encaminhar a quem possa resolver) </p>
                    <ul>
                        <li>Muito bem, senhor (a) repete o nome da pessoa. Qual é o motivo do seu contato para que eu  possa transferir para a pessoa certa e que vai lhe ajudar?</li>
                    </ul>
                    <p>A pessoa vai descrever o motivo da ligação e após ouvir você vai direcionar para a pessoa solicitada ou para quem possa resolver a questão ou para o SAC se for algum tipo de reclamação ou solicitação.</p>
                    <p>No momento da transferência você vai descrever para a pessoa de destino aquilo que o cliente disse e vai voltar a ligação do cliente dizendo quem vai continuar o atendimento e que agora já está nos ouvindo, dando a atenção que o cliente merece. Lembrando que o cliente está em posição de áudio conferencia, portanto está ouvindo que que você vai estar dizendo para a pessoal responsável pela solução. </p>
                </div>
                <div class="row">
                    <div class="col-xs-12  col-md-4">
                        <p><b>Resposta P1 – Sim </b></p>
                        <ul><li>O senhor(a) já é cliente de alarmes monitorados da VOLPATO?</li></ul>
                    </div>
                    <div class="col-xs-12  col-md-2">
                        <div class="form-group">
                            <select name="captacao_ja_e_cliente" class="form-control radio_ja_e_cliente" required="">
                                <option value=""> -- Selecione -- </option>
                                <option value="sim"   <?= ($captacao_ja_e_cliente == "sim") ? "selected" : ''; ?>  >SIM</option>
                                <option value="não"   <?= ($captacao_ja_e_cliente == "não") ? "selected" : ''; ?>>NÃO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="include_a"></div>
                <div id="include_c"></div>
                <div class="alert _alert-background"> 
                    <p>Onde o senhor(a) pretende instalar o sistema de proteção VOLPATO?</p>
                </div> 
                <div class="row">
                    <div class="col-xs-12 col-sm-6  col-md-3">
                        <div class="form-group">
                            <label>CEP:</label>
                            <div class="input-group">
                                <input type="text" name="captacao_cep" id="captacao_cep"  value="<?= $captacao_cep; ?>" class="mask_cep _cep form-control" >
                                <div class="input-group-btn buscaCEP">
                                    <a href="javascript:void(0)" class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </a>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="col-xs-12 col-sm-6  col-md-2">
                        <div class="form-group">
                            <label>UF:</label>
                            <input type="text" name="captacao_uf" id="captacao_uf" class="mask_uf  _uf form-control"  required=""  value="<?= $captacao_uf; ?>" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-9  col-md-9">
                        <div class="form-group">
                            <label>Endereco:</label>
                            <input type="text" name="captacao_endereco" id="captacao_endereco" class=" _rua form-control" required=""  value="<?= $captacao_endereco; ?>" >
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3  col-md-2 ">
                        <div class="form-group">
                            <label>Numero:</label>
                            <input type="text" name="captacao_numero" id="captacao_numero" class="form-control"  required=""  value="<?= $captacao_numero; ?>" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4  col-md-4  ">
                        <div class="form-group">
                            <label>Cidade:</label>
                            <input type="text" name="captacao_cidade" id="captacao_cidade" class="form-control _cidade" required=""  value="<?= $captacao_cidade; ?>" >
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4  col-md-4  ">
                        <div class="form-group">
                            <label>Bairro:</label>
                            <input type="text" name="captacao_bairro" id="captacao_bairro" class=" form-control  _bairro"  required=""  value="<?= $captacao_bairro; ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4  ">
                        <div class="form-group">
                            <label>Complemento:</label>
                            <input type="text" name="captacao_complemento" id="captacao_complemento" class="form-control"  value="<?=$captacao_complemento; ?>"  />
                        </div>
                    </div>
                </div>   
                <br>
                <div class="alert _alert-background"> 
                    <p>Bem, vamos continuar! O imóvel no qual o senhor(a) pretende instalar nossos produtos e contratar nossos serviços é:</p>
                </div> 
                <div class="row">
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Residencial" name="captacao_imovel_tipo_imovel"  <?=($captacao_imovel_tipo_imovel=="Residencial")?'checked':'';?>  type="radio" required=""> Residencial</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Cond. Fechado" name="captacao_imovel_tipo_imovel"   <?=($captacao_imovel_tipo_imovel=="Cond. Fechado")?'checked':'';?>     type="radio"  required="">Cond. Fechado</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Apartamento" name="captacao_imovel_tipo_imovel"   <?=($captacao_imovel_tipo_imovel=="Apartamento")?'checked':'';?> type="radio"> Apartamento</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Imovel Rural" name="captacao_imovel_tipo_imovel" <?=($captacao_imovel_tipo_imovel=="Imovel Rural")?'checked':'';?>  type="radio"> Imovel Rural</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Empresarial" name="captacao_imovel_tipo_imovel" <?=($captacao_imovel_tipo_imovel=="Empresarial")?'checked':'';?>  type="radio"> Empresarial</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Comércio" name="captacao_imovel_tipo_imovel" <?=($captacao_imovel_tipo_imovel=="Comércio")?'checked':'';?> type="radio" required="">  Comércio</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Depósito" name="captacao_imovel_tipo_imovel" <?=($captacao_imovel_tipo_imovel=="Depósito")?'checked':'';?> type="radio"> Depósito</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Industria" name="captacao_imovel_tipo_imovel" <?=($captacao_imovel_tipo_imovel=="Industria")?'checked':'';?> type="radio"> Industria</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Serviços" name="captacao_imovel_tipo_imovel" <?=($captacao_imovel_tipo_imovel=="Serviços")?'checked':'';?> type="radio"> Serviços</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Obra" name="captacao_imovel_tipo_imovel" <?=($captacao_imovel_tipo_imovel=="Obra")?'checked':'';?> type="radio"> Obra</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Outros" name="captacao_imovel_tipo_imovel" <?=($captacao_imovel_tipo_imovel=="Outros")?'checked':'';?> type="radio"> Outros</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group">
                            <label>Atividade Principal do local:</label>
                            <input type="text" name="captacao_imovel_atividade_principal"  value="<?=$captacao_imovel_atividade_principal;?> " class="form-control"  required=""  />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12  col-md-2">
                        <div class="form-group">
                            <label>Referencia:</label>   
                            <select name="captacao_imovel_ao_lado_de"  class="form-control" required="">
                                <option value=""> -- Selecione -- </option>
                                <option value="Ao lado de Terreno Badiao" <?=($captacao_imovel_ao_lado_de=="Ao lado de Terreno Badiao")?"selected":'';?>     >Ao lado de Terreno Badiao</option>
                                <option value="Ao lado de Imóvel" <?=($captacao_imovel_ao_lado_de=="Ao lado de Imóvel")?"selected":'';?> >Ao lado de Imóvel</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group">
                            <label>Metragem do Terreno ex (200m2) :</label>
                            <input name="captacao_imovel_metragem"  class="form-control" type="text"  value="<?=$captacao_imovel_metragem;?>" required=""   >
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-3">
                        <div class="form-group">
                            <label>Área construida ex (200m2):</label>
                            <input name="captacao_imovel_area"  class=" form-control" type="text"  value="<?=$captacao_imovel_area;?>"  required="">
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-1">
                        <div class="form-group">
                            <label>Pisos:</label>
                            <input name="captacao_imovel_pisos" class="form-control" type="text" value="<?=$captacao_imovel_pisos;?>"  required="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group">
                            <label>Descrição da área construida:</label>
                            <textarea class="form-control" name="captacao_imovel_descricao_da_ares"><?=$captacao_imovel_descricao_da_ares;?></textarea>
                        </div>   
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group">
                            <label>Estado do Imóvel:</label>
                        </div>
                    </div>
                </div>             
                <div class="row">
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Ocupação regular" name="captacao_imovel_estado" type="radio"  <?=($captacao_imovel_estado=="Ocupação regular")?"checked":"";?>     required="">Ocupação regular</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Desocupada" name="captacao_imovel_estado" type="radio"  <?=($captacao_imovel_estado=="Desocupada")?"checked":"";?>  required="">Desocupada</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Construção Reforma" name="captacao_imovel_estado"   <?=($captacao_imovel_estado=="Construção Reforma")?"checked":"";?> type="radio">Construção Reforma</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Veraneio" name="captacao_imovel_estado"    <?=($captacao_imovel_estado=="Veraneio")?"checked":"";?>   type="radio">Veraneio</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Possui grades nas" name="captacao_imovel_estado"   <?=($captacao_imovel_estado=="Possui grades nas")?"checked":"";?>   type="radio">Possui grades nas</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-10">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Possui Barreira Perimetral total e de dificil transposição"   <?=($captacao_imovel_estado=="Possui Barreira Perimetral total e de dificil transposição")?"checked":"";?>   name="captacao_imovel_estado" type="radio">Possui Barreira Perimetral total e de dificil transposição</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert _alert-background"> 
                    <p>Possui acesso vigiado, tipo serviços de portaria ou vigilância? (se sim especificar horários e prestador dos serviços):</p>
                </div> 
                <div class="row">
                    <div class="col-xs-12  col-md-2">
                        <div class="form-group">
                            <div class="form-group">
                                <select name="captacao_imovel_acesso_vigiado"   id="captacao_imovel_acesso_vigiado"  class="form-control" >
                                    <option value=""> -- Selecione -- </option>
                                    <option value="sim"  <?=($captacao_imovel_acesso_vigiado=="sim")?"selected":'';?> >SIM</option> 
                                    <option value="não"  <?=($captacao_imovel_acesso_vigiado=="não")?"selected":'';?>>NÃO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="include_b"></div>
                <div class="alert _alert-background"> 
                    <p>Possui registro de ocorrências recentes no local? (se sim descrever dinâmica):</p>
                </div> 
                <div class="row" >
                    <div class="col-xs-12  col-md-2">
                        <div class="form-group">
                            <div class="form-group">
                                <select name="captacao_imovel_registro_ocorrencia_local" id="captacao_imovel_registro_ocorrencia_local" class="form-control" required="">
                                    <option value=""> -- Selecione -- </option>
                                    <option value="sim"  <?=($captacao_imovel_registro_ocorrencia_local=="sim")?"selected":'';?> >SIM</option>
                                    <option value="não"  <?=($captacao_imovel_registro_ocorrencia_local=="não")?"selected":'';?> >NÃO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" id="captacao_imovel_descricao_ocorrencia_local" style="display: none">
                            <label>Descrever dinâmica:</label>
                            <textarea class="form-control"  id="captacao_imovel_descricao_ocorrencia_local"   name="captacao_imovel_descricao_ocorrencia_local"><?=$captacao_imovel_descricao_ocorrencia_local;?></textarea>
                        </div>
                    </div>
                </div>    
                <div class="alert _alert-background"> 
                    <p>Possui registro de ocorrências recentes vizinhança? (se sim descrever dinâmica):</p>
                </div> 
                <div class="row">
                    <div class="col-xs-12  col-md-2">
                        <div class="form-group">
                            <div class="form-group">
                                <select name="captacao_imovel_registro_ocorrencia_vizinhanca"  id="captacao_imovel_registro_ocorrencia_vizinhanca"  class="form-control" required="">
                                    <option value=""> -- Selecione -- </option>
                                    <option value="sim" <?=($captacao_imovel_registro_ocorrencia_vizinhanca=="sim")?"selected":'';?> >SIM</option>
                                    <option value="não" <?=($captacao_imovel_registro_ocorrencia_vizinhanca=="não")?"selected":'';?> >NÃO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: none" id="captacao_imovel_descricao_ocorrencia_vizinhanca">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Descrever dinâmica:</label>
                            <textarea class="form-control"   id="captacao_imovel_descricao_ocorrencia_vizinhanca"  name="captacao_imovel_descricao_ocorrencia_vizinhanca"><?=$captacao_imovel_descricao_ocorrencia_vizinhanca;?></textarea>
                        </div>  
                    </div>
                </div>
            </div>
        </div>        
        <div class="panel panel-primary">
            <div class="panel-heading text-center"> ANALISE DE ADERÊNCIA</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12  col-md-12">
                        <label>Possui aderência ?:</label>
                    </div>    
                </div>    
                <div class="row">
                    <div class="col-xs-12  col-md-2">
                        <div class="form-group">
                            <select name="captacao_aderencia_possui" class="form-control"   id="captacao_aderencia_possui"  required="">
                                <option value=""> -- Selecione -- </option>
                                <option value="sim"  <?=($captacao_aderencia_possui=="sim")?"selected":'';?>>SIM</option>
                                <option value="não"  <?=($captacao_aderencia_possui=="não")?"selected":'';?>>NÃO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: none" id="captacao_aderencia_motivo">
                    <div class="col-xs-12  col-md-12">
                        <div class="form-group" >
                            <label>Se não especificar os motivos:</label>
                            <textarea class="form-control" name="captacao_aderencia_motivo"><?=$captacao_aderencia_motivo;?></textarea>
                        </div>   
                    </div>
                </div>
                <div class="alert _alert-background"> 
                    <p>Se Sim conferir a agenda do consultor da região ou da vez e ajustar com a agenda do cliente, buscando sempre estabelecer o turno da manhã ou tarde e fazendo o registro dentro do software de gestão de tal forma que o consultor receba a notificação de agendamento.</p>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <label>Visita agendada para o dia:</label>
                            <input type="text" name="captacao_data_agenda"  class="form-control mask_data "   maxlength="15"  value="<?=$captacao_data_agenda;?>" required=""  >
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3 ">
                        <div class="form-group">
                            <label>Consultor:</label>
                            <input type="text"  name="captacao_consultor"  class=" form-control"  value="<?=$captacao_consultor;?>"  required="" >
                        </div>
                    </div>
                </div>
                <div class="alert _alert-background"> 
                    <p>Neste caso, você deve também fazer o registro dos dados no CRM, completando as informações do cadastro total.  </p>
                    <ul>
                        <li>Uma Ultima pergunta: Como foi que o senhor(a) nos encontrou?</li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-xs-12  col-md-3">
                        <div class="form-group">
                            <select name="captacao_indicador" class="form-control" required="">
                                <option value="" selected="selected"> -- Como conheceu a empresa? -- </option>
                                <option value="indicacao" <?= ($captacao_indicador == "indicacao") ? "selected" : ''; ?>   >Indicação</option>
                                <option value="internet"  <?= ($captacao_indicador == "internet") ? "selected" : ''; ?>  >Internet</option>
                                <option value="facebook"  <?= ($captacao_indicador == "facebook") ? "selected" : ''; ?>  >Facebook</option>
                                <option value="jornal"    <?= ($captacao_indicador == "jornal") ? "selected" : ''; ?>  >Jornal</option>
                                <option value="outdoor"   <?= ($captacao_indicador == "outdoor") ? "selected" : ''; ?>  >Outdoor</option>
                                <option value="outros"    <?= ($captacao_indicador == "outros") ? "selected" : ''; ?>  >Outros</option>
                                <option value="placas"    <?= ($captacao_indicador == "placas") ? "selected" : ''; ?>  >Placas</option>
                                <option value="revista"   <?= ($captacao_indicador == "revista") ? "selected" : ''; ?>  >Revista</option>
                                <option value="Google"    <?= ($captacao_indicador == "Google") ? "selected" : ''; ?> >Google</option>
                                <option value="Outdoor"   <?= ($captacao_indicador == "Outdoor") ? "selected" : ''; ?>>Outdoor</option>
                                <option value="Anuncio"   <?= ($captacao_indicador == "Anuncio") ? "selected" : ''; ?>>Anuncio</option>
                                <option value="Panfleto"  <?= ($captacao_indicador == "Panfleto") ? "selected" : ''; ?>>Panfleto</option>
                                <option value="Visita Prospectiva" <?= ($captacao_indicador == "Visita Prospectiva") ? "selected" : ''; ?>>Visita Prospectiva</option>
                            </select>
                        </div>
                    </div>
                </div>            
                <div class="row">
                    <div class="col-xs-12 col-md-2">
                        <label>Tipo de Cliente:</label>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Comunicativo" name="captacao_tipo_de_cliente" type="radio"    <?=($captacao_tipo_de_cliente=="Comunicativo")?"checked":"";?>  required=""> 1. Comunicativo</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Negociador" name="captacao_tipo_de_cliente" type="radio"  <?=($captacao_tipo_de_cliente=="Negociador")?"checked":"";?>  > 2. Negociador</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Educado" name="captacao_tipo_de_cliente" type="radio"  <?=($captacao_tipo_de_cliente=="Educado")?"checked":"";?> > 3. Educado</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Dedicado" name="captacao_tipo_de_cliente" type="radio" <?=($captacao_tipo_de_cliente=="Dedicado")?"checked":"";?>  > 4. Dedicado</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Nervoso" name="captacao_tipo_de_cliente" type="radio" <?=($captacao_tipo_de_cliente=="Nervoso")?"checked":"";?> > 5. Nervoso</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Grosseiro" name="captacao_tipo_de_cliente" type="radio"  <?=($captacao_tipo_de_cliente=="Grosseiro")?"checked":"";?>  > 6. Grosseiro</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Apressado" name="captacao_tipo_de_cliente" type="radio" <?=($captacao_tipo_de_cliente=="Apressado")?"checked":"";?>  > 7. Apressado</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Detalhista" name="captacao_tipo_de_cliente" type="radio" <?=($captacao_tipo_de_cliente=="Detalhista")?"checked":"";?> > 8. Detalhista</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12  col-md-2">
                        <div class="form-group">
                            <div class="radio-inline">
                                <label><input value="Especialista" name="captacao_tipo_de_cliente" type="radio" <?=($captacao_tipo_de_cliente=="Especialista")?"checked":"";?>  > 9. Especialista</label>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="alert _alert-background"> 
                    <p><b>Finalização do atendimento:</b></p>
                    <p>Depois precisa agradecer junto ao cliente assim:</p>
                    <p>Muito bem sr(a) ..... agora encaminharemos estas informações ao nosso consultor que atende a sua região e vamos nos empenhar muito para que o senhor venha fazer parte da nossa empresa como cliente. </p>
                    <p>Desejamos ao senhor(a) um excelente dia.</p>
                    <p>Se Não, explicar ao cliente os motivos pelos quais não poderemos neste momento prestar os serviços que ele precisa, mas nos colocando a disposição para outras situações futuras. Desejamos ao senhor(a) um excelente dia.</p>
                </div>
            </div>  
        </div> 
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-actions">
                    <input type="hidden" name="acao" value="editaCaptacao"> 
                    <input type="hidden" name="captacao_id" value="<?= $id_captacao; ?>"> 
                    <input type="hidden" name="voltar" value="<?= @$_GET['voltar']; ?>"> 
                    <input type="hidden" name="pg" value="<?= @$_GET['pg']; ?>"> 
                    <button type="submit" class="btn btn-primary "> Salvar</button>
                    <a href="index.php?pg=<?= @$_GET['voltar']; ?>" class="btn btn-info"  title="Voltar"> Voltar </a>
                </div>
            </div>
        </div>
    </form>

<script type="text/javascript">
    $(function () {
        var $ja_e_cliente = $('.radio_ja_e_cliente').val();
        var $captacao_imovel_acesso_vigiado = $('#captacao_imovel_acesso_vigiado').val();
        var $captacao_imovel_registro_ocorrencia_local = $('#captacao_imovel_registro_ocorrencia_local').val();
        var $captacao_imovel_registro_ocorrencia_vizinhanca = $('#captacao_imovel_registro_ocorrencia_vizinhanca').val();
        var $captacao_aderencia_possui = $('#captacao_aderencia_possui').val();

        ja_e_cliente($ja_e_cliente);
        captacao_imovel_acesso_vigiado($captacao_imovel_acesso_vigiado);
        captacao_imovel_registro_ocorrencia_local($captacao_imovel_registro_ocorrencia_local);
        captacao_imovel_registro_ocorrencia_vizinhanca($captacao_imovel_registro_ocorrencia_vizinhanca);
        captacao_aderencia_possui($captacao_aderencia_possui);
        
        $('#captacao_imovel_acesso_vigiado').click(function () {
            var $_valor = $(this).val();
            captacao_imovel_acesso_vigiado($_valor);
        });
        $('#captacao_imovel_registro_ocorrencia_local').click(function () {
            var $_valor = $(this).val();
            captacao_imovel_registro_ocorrencia_local($_valor);
        });
        $('#captacao_imovel_registro_ocorrencia_vizinhanca').click(function () {
            var $_valor = $(this).val();
            captacao_imovel_registro_ocorrencia_vizinhanca($_valor);
        });
        $(".mask_data").mask("00/00/0000");
        $('.radio_ja_e_cliente').change(function () {
            var $_valor = $(this).val();
            ja_e_cliente($_valor);
        });
        
        $('#captacao_aderencia_possui').click(function () {
            var $_valor = $(this).val();
            captacao_aderencia_possui($_valor);
        });
        
        $('.captacao_tipo_servico').change(function () {
            var $_valor = $(this).val();
            if ($_valor == 'Outros (descrever)') {
                $(".captacao_tipo_servico_desc_outros").css('display', 'block');
            } else {
                $(".captacao_tipo_servico_desc_outros").css('display', 'none');
            }
        });
    });
    function ja_e_cliente($_valor) {
        if ($_valor == 'sim') {
            $("#include_a").load('modulos/captacao/src/views/captacao/formularios/includes_formulario_a/include_a.php?id=<?= $id_captacao; ?>', function () {
                $(".mask_anofab").mask("00/00");
                $('.captacao_tipo_servico2').change(function () {
                    var $_valor = $(this).val();
                    if ($_valor == 'Outros (descrever)') {
                        $(".captacao_tipo_servico_desc_outros2").css('display', 'block');
                    } else {
                        $(".captacao_tipo_servico_desc_outros2").css('display', 'none');
                    }
                });
            });
            $("#include_c").html(' ');
        } else if ($_valor == 'não') {
            $("#include_a").html(' ');
            $("#include_c").load('modulos/captacao/src/views/captacao/formularios/includes_formulario_a/include_c.php', function () {
                $('.captacao_tipo_servico').change(function () {
                    var $_valor = $(this).val();
                    if ($_valor == 'Outros (descrever)') {
                        $(".captacao_tipo_servico_desc_outros").css('display', 'block');
                    } else {
                        $(".captacao_tipo_servico_desc_outros").css('display', 'none');
                    }
                });
            });

        }
    };
    function captacao_imovel_acesso_vigiado($_valor){
        if ($_valor == 'sim') {
            $("#include_b").load('modulos/captacao/src/views/captacao/formularios/includes_formulario_a/include_b.php?id=<?= $id_captacao; ?>', function () {
                function buscaCEPCorreios(a, s, o, l, u, r) {
                    if ("" == a.val())
                        return alert("campo cep obrigatorio"), a.focus(), !1;
                    s.val("carregando....."), o.val("carregando....."), l.val("carregando....."), u.val("carregando.....");
                    var c = a.val();
                    $.getScript("http://cep.republicavirtual.com.br/web_cep.php?cep=" + c + "&formato=javascript", function () {
                        var a = unescape(resultadoCEP.logradouro), r = unescape(resultadoCEP.bairro), c = unescape(resultadoCEP.cidade), e = unescape(resultadoCEP.uf);
                        s.val(a), o.val(r), l.val(c), u.val(e)
                    })
                }
                $(".mask_uf").mask("SS"), $(".mask_cep").mask("00000-000"), $(".mask_ddd").mask("(99)"), $(".mask_placa").mask("SSS-9999"), $(".mask_telefone").mask("(00)00000-0090"), $(".mask_cnpj").mask("00.000.000/0000-00"), $(".mask_hora").mask("00:00:00"), $(".mask_anofab").mask("00/00"), $(".mask_cpf").mask("000.000.000-00"), $(".mask_latlong").mask("000.00000"), $(".modalOpen").click(funcoes.carregarModal), $(".buscaCEP").click(function () {
                    buscaCEPCorreios($("._cep"), $("._rua"), $("._bairro"), $("._cidade"), $("._uf"), "buscaCEP")
                });
            });
        } else {
            $("#include_b").html('');
        }
    };
    function captacao_imovel_registro_ocorrencia_local($_valor){
         if ($_valor == 'sim') {
            $("#captacao_imovel_descricao_ocorrencia_local").css('display', 'block');
        } else {
            $("#captacao_imovel_descricao_ocorrencia_local").css('display', 'none');
            
        }
    };          
    function captacao_imovel_registro_ocorrencia_vizinhanca($_valor){
        if ($_valor == 'sim') {
            $("#captacao_imovel_descricao_ocorrencia_vizinhanca").css('display', 'block');
        } else {
            $("#captacao_imovel_descricao_ocorrencia_vizinhanca").css('display', 'none');
           
        }
    };
    function captacao_aderencia_possui($_valor){
        if ($_valor == 'não') {
            $("#captacao_aderencia_motivo").css('display', 'block');
        } else {
            $("#captacao_aderencia_motivo").css('display', 'none');
        }
    };
</script>


