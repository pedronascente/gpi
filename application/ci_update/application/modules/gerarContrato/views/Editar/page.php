<h1 class="title_h1">Editar Currículo</h1>
<h4 class="box-title">Dados Pessoais</h4>
<br>

<form action="<?= $this->config->base_url('salvarEdicao') ?>" method="post" >

  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-7">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>Nome:</label> 
        <input class="form-control " type="text" name="DADOSPESSOAIS[nome]" value="<?= $colaborador['dadosPessoais']->nome; ?>" >
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3  ">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>Dat.Nascimento:</label>
        <div class="input-group">
          <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
          <input type="text" name="DADOSPESSOAIS[dataNascimento]" class="form-control datepicker  mask_data  "  value="<?= date('d/m/Y', strtotime($colaborador['dadosPessoais']->dataNascimento)); ?>" > 
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-2">
      <div class="form-group">
        <label><span class="_campoObrigatorio"></span>Status:</label> 
        <select class="form-control " name="DADOSPESSOAIS[status]"   >
          <option value="">Selecione...</option>
          <?php
          if (!empty($selects['status'])) {
            foreach ($selects['status'] as $item) {
              $select = ($item == $colaborador['dadosPessoais']->status) ? 'selected' : '';
              echo '<option value= "' . $item . '" ' . $select . '  >' . $item . '</option>';
            }
          } else {
            echo "<option value=\"\">off</option>";
          }
          ?>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>Área de Atuação:</label> 
        <select class="form-control " name="DADOSPESSOAIS[cargoPretendido]"   >
          <option value="">Selecione...</option>
          <?php
          if (!empty($selects['cargoPretendido'])) {
            foreach ($selects['cargoPretendido'] as $item) {
              $select = ($item == $colaborador['dadosPessoais']->cargoPretendido) ? 'selected' : '';
              echo '<option value= "' . $item . '" ' . $select . '  >' . $item . '</option>';
            }
          } else {
            echo "<option value=\"\">off</option>";
          }
          ?>
        </select>
      </div>
    </div>
    <div class="col-xs-12  col-sm-6 col-md-3">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>Pretensão Salarial:</label> 
        <select class="form-control " name="DADOSPESSOAIS[pretencaoSalarial]"  >
          <option value="">Selecione...</option>
          <?php
          if (!empty($selects['pretencaoSalarial'])) {
            foreach ($selects['pretencaoSalarial'] as $item) {
              $select = ($item == $colaborador['dadosPessoais']->pretencaoSalarial) ? 'selected' : '';
              echo '<option value= "' . $item . '" ' . $select . '  >' . $item . '</option>';
            }
          } else {
            echo "<option value=\"\">off</option>";
          }
          ?>
        </select>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-1">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>Naturalidade:</label> 
        <input class="form-control" type="text" name="DADOSPESSOAIS[naturalidade]" value="<?= $colaborador['dadosPessoais']->naturalidade; ?>" >
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 col-sm-5 col-md-3 ">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>Sexo:</label> 
        <select class="form-control " name="DADOSPESSOAIS[sexo]" >
          <option value="null">Selecione...</option>
          <?php
          if (!empty($selects['sexo'])) {
            foreach ($selects['sexo'] as $item) {
              $select = ($item == $colaborador['dadosPessoais']->sexo) ? 'selected' : '';
              echo '<option value= "' . $item . '" ' . $select . '  >' . $item . '</option>';
            }
          } else {
            echo "<option value=\"\">off</option>";
          }
          ?>
        </select>
      </div>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-4">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>Estado Civil:</label> 
        <select class="form-control " name="DADOSPESSOAIS[estadoCivil]"   >
          <option value="null">Selecione...</option>
          <?php
          if (!empty($selects['estadoCivil'])) {
            foreach ($selects['estadoCivil'] as $item) {
              $select = ($item == $colaborador['dadosPessoais']->estadoCivil) ? 'selected' : '';
              echo '<option value= "' . $item . '" ' . $select . '  >' . $item . '</option>';
            }
          } else {
            echo "<option value=\"\">off</option>";
          }
          ?>
        </select>
      </div>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-3  col-md-offset-2">
      <div class="form-group">
        <label>Filhos:</label> 
        <select class="form-control " name="DADOSPESSOAIS[filhos]"   >
          <option value="null">Selecione...</option>
          <?php
          if (!empty($selects['filhos'])) {
            foreach ($selects['filhos'] as $item) {
              $select = ($item == $colaborador['dadosPessoais']->filhos) ? 'selected' : '';
              echo '<option value= "' . $item . '" ' . $select . '  >' . $item . '</option>';
            }
          } else {
            echo "<option value=\"\">off</option>";
          }
          ?>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-3">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>CPF:</label> 
        <input class="form-control mask_cpf" type="text" name="DOCUMENTACAO[cpf]" value="<?= $colaborador['dadosPessoais']->cpf; ?>" >
      </div>
    </div>
    <div class="col-xs-12  col-sm-6 col-md-3">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>RG:</label> 
        <input class="form-control " type="text" name="DOCUMENTACAO[rg]"  maxlength="14"  value="<?= $colaborador['dadosPessoais']->rg; ?>" >
      </div>
    </div>
    <div class="col-xs-12  col-sm-6 col-md-3">
      <div class="form-group">
        <label>N° Habilitação:</label> 
        <input class="form-control " type="text" name="DOCUMENTACAO[numeroHabilitacao]"  maxlength="50"  value="<?= $colaborador['dadosPessoais']->numeroHabilitacao; ?>" >
      </div>
    </div>	
  </div>

  <div class="row">
    <div class="col-xs-12  col-sm-3 col-md-3 ">
      <div class="form-group">
        <label>CID:</label> 
        <input class="form-control " type="text" name="DADOSPESSOAIS[cid]"  maxlength="10"  value="<?= $colaborador['dadosPessoais']->cid; ?>" >  
      </div>
    </div>
    <div class="col-xs-12  col-sm-6 col-md-2">
      <div class="form-group">
        <label>Categoria:</label> 
        <select class="form-control " name="DOCUMENTACAO[categoria]"   >
          <option value="null">Selecione...</option>
          <?php
          if (!empty($selects['categoria'])) {
            foreach ($selects['categoria'] as $item) {
              $select = ($item == $colaborador['dadosPessoais']->categoria) ? 'selected' : '';
              echo '<option value= "' . $item . '" ' . $select . '  >' . $item . '</option>';
            }
          } else {
            echo "<option value=\"\">off</option>";
          }
          ?>
        </select>
      </div>
    </div>

  </div>


  <h4 class="box-title">Endereço</h4>

  <br>
  <div class="row">
    <div class="col-xs-12 col-md-5">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>CEP:</label> 
        <div class="input-group">

          <input class="form-control mask_cep" type="text" name="ENDERECO[cep]"  value="<?= $colaborador['dadosPessoais']->cep; ?>" >
        </div>
      </div>
    </div>
    <div class="col-xs-6 col-md-1">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>UF:</label> 
        <input class="form-control " type="text"  maxlength="2" name="ENDERECO[uf]" value="<?= $colaborador['dadosPessoais']->uf; ?>" >
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-10">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>Endereço:</label> 
        <input class="form-control " type="text" name="ENDERECO[endereco]"  value="<?= $colaborador['dadosPessoais']->endereco; ?>" >
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-2  ">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>Número/Apto:</label>
        <div class="input-group">
          <input type="text" name="ENDERECO[numeroApartamento]" class="form-control " maxlength="6"  value="<?= $colaborador['dadosPessoais']->numeroApartamento; ?>" > 
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-4">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>Bairro:</label> 
        <input class="form-control " type="text" name="ENDERECO[bairro]" value="<?= $colaborador['dadosPessoais']->bairro; ?>" >
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>Cidade:</label> 
        <input class="form-control " type="text" name="ENDERECO[cidade]" value="<?= $colaborador['dadosPessoais']->cidade; ?>" >
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4">
      <div class="form-group">
        <label>Complemento:</label> 
        <input class="form-control " type="text" name="ENDERECO[complemento]" value="<?= $colaborador['dadosPessoais']->complemento; ?>" >
      </div>
    </div>
  </div>
  <br>
  <h4 class="box-title">Contato</h4>
  <br>
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>Telefone Residêncial:</label> 
        <div class="input-group">
          <span class="input-group-addon "><i class="glyphicon glyphicon-earphone"></i></span>
          <input type="text" name="CONTATO[telefoneResidencial]" class="form-control mask_telefone" value="<?= $colaborador['dadosPessoais']->telefoneResidencial; ?>"  maxlength="14" > 
        </div>
      </div>
    </div>  
    <div class="col-xs-12  col-sm-6 col-md-4">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>Celular:</label> 
        <div class="input-group">
          <span class="input-group-addon "><i class="glyphicon glyphicon-earphone"></i></span>
          <input type="text" name="CONTATO[celular]" class="form-control mask_telefone" value="<?= $colaborador['dadosPessoais']->celular; ?>"   maxlength="14" > 
        </div>
      </div>
    </div>
    <div class="col-xs-12  col-sm-6 col-md-4">
      <div class="form-group">
        <label>Telefone contato:</label> 
        <div class="input-group">
          <span class="input-group-addon "><i class="glyphicon glyphicon-earphone"></i></span>
          <input type="text" name="CONTATO[telefoneContato]" class="form-control mask_telefone "  value="<?= $colaborador['dadosPessoais']->telefoneContato; ?>"  maxlength="14" > 
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12  col-md-12">
      <div class="form-group">
        <label><span class="_campoObrigatorio">*</span>Email:</label> 
        <div class="input-group">
          <span class="input-group-addon "><i class="glyphicon glyphicon-envelope"></i></span>
          <input class="form-control" type="email" name="CONTATO[email]" value="<?= $colaborador['dadosPessoais']->email; ?>" >
        </div>
      </div>
    </div>
  </div>
  <br>
  <h4 class="box-title">Formação</h4>
  <br>
  <?php foreach ($colaborador['formacao'] as $formacao) { ?>
    <section>
      <div class="row ">
        <div class="col-xs-12  col-md-4">
          <div class="form-group">
            <label><span class="_campoObrigatorio">*</span>Formação:</label> 
            <select class="form-control " name="FORMACAO[formacao][]"   >
              <option value="null">Selecione...</option>
              <?php
              if (!empty($selects['formacao'])) {
                foreach ($selects['formacao'] as $item) {
                  $select = ($item == $formacao->formacao) ? 'selected' : '';
                  echo '<option value= "' . $item . '" ' . $select . '  >' . $item . '</option>';
                }
              } else {
                echo "<option value=\"\">off</option>";
              }
              ?>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12   col-md-12">
          <div class="form-group">
            <label><span class="_campoObrigatorio">*</span>Curso:</label> 
            <input class="form-control " type="text" name="FORMACAO[curso][]"  value="<?= $formacao->curso; ?>" >
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12   col-md-12">
          <div class="form-group">
            <label><span class="_campoObrigatorio">*</span>Instituição:</label> 
            <input class="form-control " type="text" name="FORMACAO[instituicao][]"  value="<?= $formacao->instituicao; ?>" >
            <input class="form-control " type="hidden" name="FORMACAO[formacao_id][]"  value="<?= $formacao->formacao_id; ?>" >
          </div>
        </div>
      </div>
    </section>
  <?php } ?>
  <br>
  <h4 class="box-title">Experiências</h4>
  <br>
  <?php foreach ($colaborador['experiencia'] as $EXPERIENCIA) { ?>
    <section>
      <div class="row">
        <div class="col-xs-12 col-md-12">
          <div class="form-group">
            <label><span class="_campoObrigatorio">*</span>Empresa:</label> 
            <input class="form-control" type="text" name="EXPERIENCIAPROFISSIONAL[empresa][]"  value="<?= $EXPERIENCIA->empresa; ?> " >
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12  col-sm-6 col-md-4">
          <div class="form-group">
            <label><span class="_campoObrigatorio">*</span>Data Adimissão:</label> 
            <div class="input-group">
              <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
              <input class="form-control datepicker  mask_data"  type="text" name="EXPERIENCIAPROFISSIONAL[dataAdimissao][]"  value="<?= date('d/m/Y', strtotime($EXPERIENCIA->dataAdimissao)); ?> " >
            </div>
          </div>
        </div>
        <div class="col-xs-12  col-sm-6 col-md-4">
          <div class="form-group">
            <label><span class="_campoObrigatorio">*</span>Data Demissão:</label>
            <div class="input-group">
              <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
              <input class="form-control datepicker  mask_data " type="text" name="EXPERIENCIAPROFISSIONAL[dataDemissao][]"  value="<?= date('d/m/Y', strtotime($EXPERIENCIA->dataDemissao)); ?> " >
            </div>
          </div>
        </div>
        <div class="col-xs-12  col-sm-6 col-md-4">
          <div class="form-group">
            <label><span class="_campoObrigatorio">*</span>Motivo:</label> 
            <select  name="EXPERIENCIAPROFISSIONAL[motivo][]"  class="form-control text-center">
              <option value="null">Selecione...</option>
              <?php
              if (!empty($selects['motivo'])) {
                foreach ($selects['motivo'] as $item) {
                  $select = ($item == $EXPERIENCIA->Motivo) ? 'selected' : '';
                  echo '<option value= "' . $item . '" ' . $select . '  >' . $item . '</option>';
                }
              } else {
                echo "<option value=\"\">off</option>";
              }
              ?>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12  col-md-6">
          <div class="form-group">
            <label><span class="_campoObrigatorio">*</span>Cargo:</label> 
            <input class="form-control " type="text" name="EXPERIENCIAPROFISSIONAL[cargo][]"   value="<?= $EXPERIENCIA->cargo; ?> " >
          </div>
        </div>
        <div class="col-xs-12 col-md-12">
          <div class="form-group">
            <label><span class="_campoObrigatorio">*</span>Atividades:</label> 
            <input class="form-control " type="hidden" name="EXPERIENCIAPROFISSIONAL[experienciaProficional_id][]"  value="<?= $EXPERIENCIA->experienciaProficional_id; ?>" >
            <textarea class="form-control"   rows="5" name="EXPERIENCIAPROFISSIONAL[atividade][]"><?= $EXPERIENCIA->atividade; ?></textarea>
          </div>
        </div>
      </div>  
    </section>
  <?php } ?> 
  <hr>
  <div class="row">
    <div class="col-xs-12   col-md-12">
      <div class="form-group">
        <input type="hidden" name="DADOSPESSOAIS[candidato_id]" value="<?= $colaborador['dadosPessoais']->candidato_id; ?>">
        <button class="btn btn-success "> <span class="glyphicon glyphicon-floppy-save"></span> Salvar</button>
        <a href="<?= $this->config->base_url('visualizar/' . $colaborador['dadosPessoais']->candidato_id) ?>" class="btn btn-danger ">Voltar</a>
      </div>
    </div>
  </div>
</form>
