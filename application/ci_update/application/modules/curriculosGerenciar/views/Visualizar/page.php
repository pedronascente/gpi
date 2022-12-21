<h1 class="title_h1 " >Currículo</h1>
<h4 class="box-title">Dados Pessoais</h4>
<table class="table table-striped">
  <tr>
    <td colspan="2"><strong>Nome:</strong>  <?= $colaborador['dadosPessoais']->nome; ?></td>
    <td><strong>Data Nascimento:</strong>    <?= date('d/m/Y', strtotime($colaborador['dadosPessoais']->dataNascimento)); ?></td>
    <td><strong>Status:</strong>    <?= $colaborador['dadosPessoais']->status; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Cargo Pretendido:</strong> <?= $colaborador['dadosPessoais']->cargoPretendido; ?></td>
    <td><strong>Pretensão Salarial:</strong>  <?= $colaborador['dadosPessoais']->pretencaoSalarial; ?></td>
    <td><strong>Naturalidade:</strong>  <?= $colaborador['dadosPessoais']->naturalidade; ?></td>
  </tr>

  <tr>
    <td colspan="2"><strong>Sexo:</strong> <?= $colaborador['dadosPessoais']->sexo; ?></td>
    <td><strong>Estado Civil:</strong> <?= $colaborador['dadosPessoais']->estadoCivil; ?></td>
    <td colspan="2"><strong>Filhos:</strong> <?= $colaborador['dadosPessoais']->filhos; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>CPF:</strong> <?= $colaborador['dadosPessoais']->cpf; ?></td>
    <td ><strong>RG:</strong>  <?= $colaborador['dadosPessoais']->rg; ?></td>
    <td><strong>N° Habilitação:</strong> <?= $colaborador['dadosPessoais']->numeroHabilitacao; ?> </td>
  </tr>
  <tr>
    <td colspan="1"><strong>Cid:</strong> <?= $colaborador['dadosPessoais']->cid; ?> </td>
    <td colspan="3"><strong>Categoria:</strong> <?= $colaborador['dadosPessoais']->categoria; ?> </td>
  </tr>
</table>

<h4 class="box-title">Endereço</h4>

<table class="table table-striped">
  <tr>
    <td colspan="2"><strong>Cép:</strong> <?= $colaborador['dadosPessoais']->cep; ?></td>
    <td><strong>UF:</strong> <?= $colaborador['dadosPessoais']->uf; ?> </td>
  </tr>
  <tr>
    <td colspan="2"><strong>Endereço:</strong>  <?= $colaborador['dadosPessoais']->endereco; ?> </td>
    <td><strong>N°/Apto:</strong> <?= $colaborador['dadosPessoais']->numeroApartamento; ?></td>
  </tr>
  <tr>
    <td><strong>Bairro:</strong> <?= $colaborador['dadosPessoais']->bairro; ?> </td>
    <td><strong>Cidade :</strong> <?= $colaborador['dadosPessoais']->cidade; ?></td>
    <td><strong>Complemento:</strong> <?= $colaborador['dadosPessoais']->complemento; ?></td>
  </tr>
</table>

<h4 class="box-title">Contato</h4>

<table class="table table-striped">
  <tr>
    <td><strong>Residencial:</strong> <?= $colaborador['dadosPessoais']->telefoneResidencial; ?></td>
    <td><strong>Celular :</strong> <?= $colaborador['dadosPessoais']->celular; ?></td>
    <td><strong>Contato:</strong> <?= $colaborador['dadosPessoais']->telefoneContato; ?></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Email:</strong> <?= $colaborador['dadosPessoais']->email; ?></td>
  </tr>
</table>

<h4 class="box-title">Formação</h4>

<table class="table table-striped">
  <?php
  if (isset($colaborador['formacao'])) {
    foreach ($colaborador['formacao'] as $li) {
      ?>
      <tr>
        <td><strong>Formação:</strong> <?= $li->formacao; ?></td>
        <td><strong>Curso :</strong>  <?= $li->curso; ?></td>
        <td colspan="2"><strong>Instituição:</strong> <?= $li->instituicao; ?></td>
      </tr><?php
    }
  }
  ?>
</table>

<h4 class="box-title">Experiencia Profissional</h4>

<table class="table table-striped">
  <?php
  if (isset($colaborador['experiencia'])) {
    foreach ($colaborador['experiencia'] as $li) {
      ?>
      <tr>
        <td colspan="3"><strong>Empresa:</strong> <?= $li->empresa; ?></td>
      </tr>
      <tr>
        <td><strong>Data Adimissão:</strong>  <?= date('d/m/Y', strtotime($li->dataAdimissao)); ?></td>
        <td><strong>Data Demissão:</strong>  <?= date('d/m/Y', strtotime($li->dataDemissao)); ?></td>
        <td><strong>Motivo:</strong>  <?= $li->Motivo; ?></td>
      </tr>
      <tr>
        <td colspan="3"><strong>Cargo:</strong>  <?= $li->cargo; ?></td>
      </tr>
      <tr>
        <td colspan="3"><strong>Atividades:</strong>  <br>
          <?= $li->atividade; ?>
        </td>
      </tr>
      <?php
    }
  }
  ?>  
</table>

<hr>
<a href="<?= (isset($_COOKIE['actual_link']))?$_COOKIE['actual_link']:$this->config->base_url('gerenciar'); ?>" class="btn btn-success"> Voltar</a>
<a href="<?= $this->config->base_url('editar/' . $colaborador['dadosPessoais']->id_candidato); ?>" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Editar</a>
<button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-sm">Excluir</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm2">Arquivar</button>
<a href="javascript:window.print()"  class="btn btn-default"><span class="glyphicon glyphicon-print"></span> Imprimir</a>


<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmação</h4>
      </div>
      <div class="modal-body">
        Deseja realmente excluir?
      </div>
      <div class="modal-footer">
        <a href="<?php echo base_url('excluir/' . $colaborador['dadosPessoais']->id_candidato); ?>" class="btn btn-success">Sim</a>        
        <button type="button" class="btn btn-primary" data-dismiss="modal">Não</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bs-example-modal-sm2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmação</h4>
      </div>
      <div class="modal-body">
        Deseja realmente Arquivar?
      </div>
      <div class="modal-footer">
        <a href="<?php echo base_url('arquivar/' . $colaborador['dadosPessoais']->id_candidato); ?>" class="btn btn-success">Sim</a>        
        <button type="button" class="btn btn-primary" data-dismiss="modal">Não</button>
      </div>
    </div>
  </div>
</div>
