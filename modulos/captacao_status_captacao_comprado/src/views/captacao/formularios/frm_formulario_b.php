<?php      
//namespace C:\wamp\www\gpi\modulos\captacao\src\views\captacao\formularios\frm_formulario_b.php
session_start();      
date_default_timezone_set('America/Sao_Paulo'); 
?>   
<div class="panel panel-primary">
    <div class="panel-heading">QUESTIONÁRIO INICIAL RECEPTIVO  </div>
    <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12  col-md-10" >
                    <div class="form-group">
                        <label>Cliente:</label>
                        <input type="text" name="captacao_cliente" value="" class="form-control" required placeholder="Digite nome do cliente" />
                    </div>
                </div>
                <div class="col-xs-12 col-md-2">
                    <div class="form-group">
                        <label>Data Nascimento:</label>
                        <input type="text" name="captacao_data_nascimento"  value="" class="form-control mask_data"  />
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12  col-md-12 ">
                    <div class="form-group">
                        <label>E-mail:</label>
                        <div class="input-group">
                            <div class="input-group-addon">@</div>
                            <input type="email" name="captacao_email" id="captacao_email" class="form-control" placeholder="Entre com o email"  >
                        </div>
                    </div>
                </div>
            </div>                
            <div class="row">
                <div class="col-xs-12 col-sm-3  col-md-3">
                    <div class="form-group">
                        <label>Telefone | Celular 1:</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-earphone"></span>
                            </span>
                            <input type="text" name="captacao_telefone1" id="captacao_telefone1" class="mask_telefone form-control" required placeholder="Telefone" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3">
                    <div class="form-group">
                        <label>Operadora:</label>
                        <select id="captacao_operadora1" name="captacao_operadora1" class="form-control" >
                            <option selected="selected" value=""> -- Selecione -- </option>
                            <option value="Claro">Claro</option>
                            <option value="Embratel">Embratel</option>
                            <option value="OI">OI</option>
                            <option value="TIM">TIM</option>
                            <option value="Vivo">Vivo</option>
                            <option value="GVT">GVT</option>
                            <option value="Net">Net</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3  col-md-3">
                    <div class="form-group">
                        <label>Telefone | Celular 2:</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-earphone"></span>
                            </span>
                            <input type="text" name="captacao_telefone2" id="captacao_telefone2" class="mask_telefone form-control" placeholder="Telefone" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3  col-md-3">
                    <div class="form-group">
                        <label>Operadora 2:</label>
                        <select id="captacao_operadora2" name="captacao_operadora2" class="form-control">
                            <option selected="selected" value=""> -- Selecione -- </option>
                            <option value="Claro">Claro</option>
                            <option value="Embratel">Embratel</option>
                            <option value="OI">OI</option>
                            <option value="TIM">TIM</option>
                            <option value="Vivo">Vivo</option>
                            <option value="GVT">GVT</option>
                            <option value="Net">Net</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-3  col-md-3">
                    <div class="form-group">
                        <label>Telefone | Celular 3:</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-earphone"></span>
                            </span>
                            <input type="text" name="captacao_telefone3" id="captacao_telefone3" class="mask_telefone form-control" placeholder="Telefone" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3  col-md-3">
                    <div class="form-group">
                        <label>Operadora 3:</label>
                        <select id="captacao_operadora3" name="captacao_operadora3" class="form-control">
                            <option selected="selected" value=""> -- Selecione -- </option>
                            <option value="Claro">Claro</option>
                            <option value="Embratel">Embratel</option>
                            <option value="OI">OI</option>
                            <option value="TIM">TIM</option>
                            <option value="Vivo">Vivo</option>
                            <option value="GVT">GVT</option>
                            <option value="Net">Net</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Indicador:</label>
                        <select name="captacao_indicador" id="captacao_indicador" class="form-control" required="">
                            <option value="" selected="selected"> -- Como conheceu a empresa? -- </option>
                            <option value="indicacao">Indicação</option>
                            <option value="internet">Internet</option>
                            <option value="facebook">Facebook</option>
                            <option value="jornal">Jornal</option>
                            <option value="outdoor">Outdoor</option>
                            <option value="outros">Outros</option>
                            <option value="placas">Placas</option>
                            <option value="revista">Revista</option>
                            <option value="whatsApp">WhatsApp</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4  col-md-4">
                    <div class="form-group">
                        <label>Nivel de Prioridade:</label>
                        <select name="captacao_nivel_prioridade" id="captacao_nivel_prioridade" class="form-control" >
                            <option value=""> -- Selecione -- </option>
                            <option value="normal">Normal</option>
                            <option value="urgente">Urgente</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4  col-md-4">
                    <div class="form-group">
                        <label>Atend:</label>
                        <select name="captacao_atendimento" id="captacao_atendimento" class="form-control">
                            <option value="Fora do Horário">Fora do Horário</option>
                            <option value="Horário Comercial" selected="selected">Horário    Comercial</option>
                            <option value="Turno Manhã">Turno Manhã</option>
                            <option value="Turno Tarde">Turno Tarde</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <div class="form-group" id="box_horario">
                        <label>Horário:</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                            <input type="text" name="captacao_hora_fora_horario" id="captacao_hora_fora_horario" class="mask_hora form-control" />
                        </div>                               
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6  col-md-4">
                    <div class="form-group">
                        <label>CEP:</label>
                        <div class="input-group">
                            <input type="text" name="captacao_cep" id="captacao_cep" class="mask_cep _cep form-control" >
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
                        <input type="text" name="captacao_uf" id="captacao_uf" class="mask_uf  _uf form-control" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-9  col-md-9">
                    <div class="form-group">
                        <label>Endereco:</label>
                        <input type="text" name="captacao_endereco" id="captacao_endereco" class=" _rua form-control" >
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3  col-md-3">
                    <div class="form-group">
                        <label>Numero:</label>
                        <input type="text" name="captacao_numero" id="captacao_numero" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4  col-md-4">
                    <div class="form-group">
                        <label>Cidade:</label>
                        <input type="text" name="captacao_cidade" id="captacao_cidade" class="form-control _cidade" >
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4  col-md-4">
                    <div class="form-group">
                        <label>Bairro:</label>
                        <input type="text" name="captacao_bairro" id="captacao_bairro" class=" form-control  _bairro">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>Complemento:</label>
                        <input type="text" name="captacao_complemento" id="captacao_complemento" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label>Observações:</label>
                        <textarea name="captacao_obs" rows="5" id="captacao_obs"  class="form-control"></textarea>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading "> Clique abaixo para Finalizar abertura de Captação</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <input type="hidden" name="acao" id="acao" value="InsertCaptacao" /> 
                <input type="hidden" name="origem" id="origem" value="monitoramento" /> 
                  <input type="hidden" name="captacao_responsavel"  class="form-control"  value="<?= $_SESSION['user_info']['nome']; ?>">
                <input type="submit"  class="btn btn-danger"  value="Finalizar">
            </div>
        </div>
    </div>
</div>