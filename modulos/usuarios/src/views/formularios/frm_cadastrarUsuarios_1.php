<?php
//namespace modulos/usuarios/src/views/formularios/frm_cadastrarUsuarios.php;
// PEGA OS DADOS DO GET
$dados = filter_input_array(INPUT_GET);
$acao = isset($dados ['acao']) ? $dados ['acao'] : null;
$result = filter_input(INPUT_GET, "result");
// LISTA OS SETORES
$setor = new Setor ();
$listaSetor = $setor->selectTodosSetores();
$listaCargo = $setor->selectTodosOsCargos();
// SE A FOR EDITAR PEGA OS DADOS DO USUÃ�RIO
$planilha = null;
$u = new Usuarios ();
$permissoes = new Permissao;
$ultimoAcesso = null;
//editar:
if ($acao == 'editar') :
    $usuario = $u->findUserById($dados['id']);
    $ultimoAcesso = $u->selecionarUltimoAcesso($dados ['id']);
endif;

$permissoesUsuario = $_SESSION ['user_info'] ['permissoes'];
$listaGruposPermissao = $permissoes->selectGrupoPermissao();
$grupoUsuario = !empty($dados ['id']) ? $u->selectGrupoPermissao($dados ['id']) : null;
$grupoUsuario = isset($grupoUsuario['id_permissao_grupo']) ? $grupoUsuario['id_permissao_grupo'] : null;
$rh = in_array(array("tipo_permissao"=>"rh"), $_SESSION['user_info']['permissoes']);
if($result == "on"){
?>
<div class="alert alert-success">Registro salvo com sucesso!</div>
<?php }?>
<div class="panel panel-primary">
    <div class="panel-heading ">Cadastrar Usuário</div>
    <div class="panel-body">
        <form id="form_Usuario" name="form_Usuario" method="post" action="modulos/usuarios/src/controllers/usuarios.php" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label>Ativar:</label>
                        <select name="ativo" class="form-control">
                            <option value="1" <?= (isset($usuario) && $usuario ['ativo'] == '1') ? 'selected="selected"' : null; ?>>SIM</option>
                            <option value="2" <?= (isset($usuario) && $usuario ['ativo'] == '2') ? 'selected="selected"' : null; ?>>NÃO</option>
                        </select>
                    </div> 
                </div>	
            </div>	
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-12 ">
                    <div class="form-group">
                        <label>Nome:</label>
                        <input type="text" name="nome" value="<?= (isset($usuario['nome'])) ? $usuario ['nome'] : null; ?>" class="form-control" id="nomeUsuario"/>
                    </div>  
                </div>
                <div class="col-xs-12 col-sm-6 col-md-12">
                    <div class="form-group">
                        <label>E-mail:</label>
                        <input type="email" name="usuario_email" value="<?= (isset($usuario['usuario_email'])) ? $usuario ['usuario_email'] : null; ?>" class="form-control"/>
                    </div>  
                </div>	
            </div>
            <div class="row">	
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                    <div class="form-group">
                        <label>Usuario:</label>
                        <input type="text" id="campoUsuario" name="usuario" value="<?= (isset($usuario['usuario'])) ? $usuario ['usuario'] : null; ?>" class="form-control" required />
                        <input type="hidden" id="usuarioAntigo" name="usuario" value="<?= (isset($usuario['usuario'])) ? $usuario ['usuario'] : null; ?>"  disabled="disabled" />
                    </div> 
                </div>		
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                    <div class="form-group">
                        <label>Senha:</label>
                        <input type="text" id="senha" name="senha" value="<?= (isset($usuario['senha_decode'])) ? $usuario ['senha_decode'] : null; ?>" class="form-control" <?= (isset($usuario['senha'])) ? null : "required"; ?> />
                    </div> 
                </div>	
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                    <div class="form-group">
                        <label>RG:</label>
                        <input id="rg" name="rg" value="<?= (isset($usuario['rg'])) ? $usuario ['rg'] : null; ?>" class="form-control"/>
                    </div> 
                </div>		
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> 
                    <div class="form-group">
                        <label>CPF:</label>
                        <input type="text" id="cpf" name="cpf" value="<?= (isset($usuario['cpf'])) ? $usuario ['cpf'] : null; ?>" class=" form-control mask_cpf"/>
                    </div> 
                </div>
            </div>
            <div class="row">
                
                <div class="col-xs-12 col-sm-6 col-md-4 "> 
                    <div class="form-group">
                        <label>Empresa:</label>
                        <select name="id_empresa" class="form-control" required="">
                            <option value="">-- Selecione --</option>
                            <option value="1">VPSP</option>
                            <option value="2">VH</option>
                            <option value="3">VP - Alarmes</option>
                            <option value="4">VP - Guaíba</option>
                            <option value="5">Volpmann - Matriz</option>
                            <option value="6">Volpmann - Filial</option>
                            <option value="7">Volpato - Matriz</option>
                            <option value="8">Volpato - Tramandaí</option>
                            <option value="9">Volpato - Filial</option>
                            <option value="10">Easyseg</option>
                        </select>
                    </div> 
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 ">
                    <div class="form-group">
                        <label>Cargo:</label>
                        <select name="id_cargo" class="form-control selectpicker" id="mostraRegioes" <?=$rh ? "required" : "";?>>
                            <option value=""></option>
                            <?php
                            if(!empty($listaCargo)){
                            	if(!$rh){
                                    foreach ($listaCargo as $s) {
                                    ?> 
                                        <option value=" <?php echo $s['cargo_id'] ?>" <?= (isset($usuario) && $usuario['id_cargo'] == $s['cargo_id']) ? 'selected' : null; ?>><?= $s['cargo_descricao']; ?></option>
	                        	<?php } 
                            	} else {
                            		
                            	?>
                            		<option value="119" <?= (isset($usuario) && $usuario['id_cargo'] == 119) ? 'selected' : null; ?>>Operador Central I</option>
                            		<option value="147" <?= (isset($usuario) && $usuario['id_cargo'] == 147) ? 'selected' : null; ?>>Supervisor da UVA</option>
                                <?php
                            		
                            	}
	                         }
                             ?>
                        </select>
                    </div>	
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Setor:</label>
                        <select name="id_setor" class="form-control selectpicker" id="mostraRegioes" <?=$rh ? "required" : "";?>>
                            <option value=""></option>
                            <?php
                            if(!empty($listaSetor)){
		                            foreach ($listaSetor as $s) {
		                                ?> 
		                                <option value=" <?php echo $s['setor_id'] ?>" <?= (isset($usuario) && $usuario['id_setor'] == $s['setor_id']) ? 'selected' : null; ?>><?= $s['setor_local']; ?></option>
	                        	<?php } 
	                         }
                             ?>
                        </select>
                    </div>	
                </div>
            </div>
            <div class="row">
              	<div class="col-xs-12 col-sm-6 col-md-12"> 
                    <div class="form-group">
                        <label>Assinatura corpo Email:</label>
                        <div class="input-group">
                            <input type="text" name="assinaturaEmail" id="assinatura" class="form-control file-caption  kv-fileinput-caption fileBar" value="<?=isset($usuario['assinaturaEmail']) ? $usuario['assinaturaEmail'] : null;?>"/>
                            <span class="input-group-btn">
                                <button class="btn btn-default selectFile" type="button"><span class="glyphicon glyphicon-open"></span></button>
                            </span>
                        </div>
                        <input type="file" name="assinatura" class="imagemAssinatura" />
                    </div> 
                </div>
            </div>
            <?php
            if ($acao == "editar") {
                $captacoes = $u->validarCaptacaoVendedor($dados ['id']);
                if ($captacoes == 1) {
                    $estado = new Estado ();
                    $u->selecionarDddsUsuario(array(
                        "id_usuario" => $usuario ['id']
                    ));
                    $validaDDD = $u->Read()->getRowCount();
                    if ($validaDDD != 0)
                        $listaEstado = $u->selectEstadosUsuarios($dados ['id']);
                    else
                        $listaEstado = $estado->select();
                    ?><div class="scrollbar regioes"> <?php
                    
                    foreach ($listaEstado as $es) {
                        if ($validaDDD != 0)
                            $listaDDD = $u->selecionarDddsUsuario(array("id_usuario" => $usuario ['id'], "id_estado" => $es ['estado_id']));
                        else
                            $listaDDD = $estado->selectDDDsEstado($es ['estado_id']);
                        ?>
	                        <div class="table-responsive">
	                            <table class="table table-bordered table-hover table-striped">
	                                <thead>
	                                    <tr>
	                                        <th colspan="4" align="left"><strong>Regiões Atendidas - <?= $es ["estado_nome"]; ?></strong></th>
	                                    </tr>
	                                    <tr>
	                                        <th>Telefone</th>
	                                        <th width="5%">Visualizar</th>
	                                    </tr>
	                                </thead>
	                                <tbody class="">
	
	                                    <?php foreach ($listaDDD as $d) { ?>
	                                        <tr>
	                                            <td>(<?= $d['regiao_ddd']; ?>)&nbsp;<?= $d['regiao_telefone']; ?></td>
	                                            <td>
	                                                <a class="btn btn-sm btn-success modalOpen botaoLoad" id="modulos/usuarios/src/views/listas/iframe_assinatura.php?usuario_id=<?=$usuario['id'];?>&regiao_ddd=<?=$d['regiao_ddd'];?>" data-target="#modalAssinatura">
	                                                     Visualizar
	                                                </a>
	                                            </td>
	                                        </tr>
	                                    <?php } ?>
	                            </table>
	                        </div>
                    <?php } ?>
                    </div>
                <?php } 
                /*
                 * ************************************************************************
                 * ********* MOSTRA AS PLANILHAS DO USUÃ�RIO QUANDO CADASTRADAS **********
                 * ************************************************************************
                 */
                $listaPlanilhas = $u->selectPlanilhaUsuario($usuario['id']);
                if (!empty($listaPlanilhas)) {
                    ?>
                    <div class="table-responsive">
                        <label><a id="modulos/usuarios/src/views/formularios/modal_atribuirPlanilhaComissao.php?id_u=<?= $usuario['id']; ?>&tela=editar\" class="modalOpen btn btn-default botaoLoad" data-target="#modal">Atribuir Planilhas</a></label>
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th colspan="3">Planilhas Comissões</th>
                                </tr>
                                <tr>
                                    <th>ID</th>
                                    <th>Planilha</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listaPlanilhas as $planilha) { ?>
                                    <tr>
                                        <td><?= $planilha['planilha_comissoes_id']; ?></td>
                                        <td><?= $planilha['planilha_comissoes_nome']; ?></td>
                                        <td>
                                            <a href="modulos/usuarios/src/controllers/usuarios.php?acao=deletePlanilhaUsuario&id_usuario=<?= $usuario['id']; ?>&id_planilha=<?= $planilha['planilha_comissoes_id']; ?>" class="btn btn-sm btn-danger">
                                                 Deletar
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                <?php
                } 
                /*
                 * ************************************************************************
                 * ********* MOSTRA AS PERMISSÃ•ES DO USUÃ�RIO QUANDO CADASTRADAS **********
                 * ************************************************************************
                 */

                $listaPermissoes = $u->selectPermissaoUsuario($usuario ['id']);

                if (!empty($listaPermissoes) && in_array(array("tipo_permissao" => "admin"), $permissoesUsuario)) {
                    ?>
                    <label><a id="modulos/usuarios/src/views/formularios/modal_atribuirPermissao.php?id_u=<?=$usuario['id'];?>&tela=editar" class="modalOpen btn btn-default botaoLoad" data-target="#modal">Atribuir Permissões</a></label>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th colspan="3">Permissões</th>
                                </tr>
                                <tr>
                                    <th>ID</th>
                                    <th>Permisssão</th>
                                    <th width="5%"></th>        
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listaPermissoes as $permissao) { ?>
                                    <tr>
                                        <td><?= $permissao['id_permissao'] ?></td>
                                        <td><?= $permissao['tipo_permissao']; ?></td>
                                        <td>
                                            <a href="modulos/usuarios/src/controllers/usuarios.php?acao=deletePermissaoUsuario&id_usuario=<?= $usuario['id']; ?>&id_permissao=<?= $permissao['id_permissao']; ?>" class="btn btn-sm btn-danger">
                                                 Deletar
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                }
            }
            ?>
            <?php if(!empty($ultimoAcesso)){?>
             <br>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                	<label>Último Acesso: <?=Funcoes::formataDataComHora($ultimoAcesso['log_data']);?></label>
                </div>
             </div>
             <br>
            <?php }?>
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="form-actions">
                        <input type="hidden" id="acao" name="acao" value="<?= ($acao == "editar") ? "editar" : "cadastrar_usuario"; ?>" />
                        <input type="hidden" name="id" id="id_usuario" value="<?= isset($usuario ['id']) ? $usuario ['id'] : ""; ?>" />
                        <button type="submit" class="btn btn-primary botaoLoadForm">
                            Salvar
                        </button>
                        <?php if(!$rh){?>
                        	<a href="index.php?pg=4" class="btn btn-info">Voltar</a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
