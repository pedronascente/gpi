<?php
include ("../../../../../Config.inc.php");

if (!isset($_SESSION['user_info']['permissoes']))
    session_start();

$dadosUrl = filter_input_array(INPUT_GET);
$acao = $dadosUrl ['acao'];
$titulo = ($acao == "editar" || $acao == "autenticar" || $acao == "visualizar") ? 'Atualizar Ramal' : 'Inserir Ramal';
$id = filter_input(INPUT_GET, "id");
$id_a = filter_input(INPUT_GET, "id_a");

$ramal = new Ramal ();
$listBase = $ramal->listBase("distinct");
$listSetorDistinct = $ramal->listSetor(null, "ditinct");

$id != '' ? : null;
$ramalStatus = new RamalStatus ();
$listramalStatus = $ramalStatus->ListaRamalStatus();

$recepcao = in_array(array("tipo_permissao" => "recepcao"), $_SESSION['user_info']['permissoes']);
$recpcaoMaster = in_array(array("tipo_permissao" => "recepcaoMaster"), $_SESSION['user_info']['permissoes']);

if (!$recepcao && !$recpcaoMaster && $acao != "visualizar" && $acao != "autenticar")
    $acao = $acao == "editar" ? "autenticar" : "autenticarCadastro";

if (!empty($id)) {
    $ramalAtualizacoes = $ramal->pegarAtualizacoesRamal($id);
    $ramal->setDados($ramal->selectRamal($id), 'select');
} else if (!empty($id_a)) {
    $ramal->setDados($ramal->selectRamalA($id_a), 'select');
}

$atualizacao = $id != '' ? !empty($ramalAtualizacoes) : false;

$acao = $atualizacao ? "atualizarRamal" : $acao;

$disabled = $acao == "visualizar" || $atualizacao ? "disabled" : "";
?>
<!doctype html>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?= $titulo; ?></h4>
        </div>			<!-- /modal-header -->
        <div class="modal-body">
            <form method="post" id="formularioRamal">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Nome:</label>
                            <input type="text" name="ramal_nome_usuario" value="<?= $ramal->get_ramal_nome_usuario(); ?>" required class="form-control" placeholder="Nome usuário" <?= $disabled; ?> id="ramal_nome_usuario">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>E-mail:</label>
                            <input type="text" name="ramal_email" value="<?= $ramal->get_ramal_email(); ?>" class="form-control" placeholder="Email" <?= $disabled; ?> id="ramal_email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Ramal:</label>
                            <input type="text" name="ramal_ramal" value="<?= $ramal->get_ramal_ramal(); ?>" required class="form-control validaRamal" placeholder="Ramal" id="ramal_ramal" <?= $disabled; ?>>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Telefone:</label>
                            <input type="text" name="ramal_telefone" value="<?= $ramal->get_ramal_telefone(); ?>" class="form-control mask_telefone" placeholder="Telefone" <?= $disabled; ?> id="ramal_telefone">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Base:</label>
                            <select name="ramal_id_base" class="form-control" required <?= $disabled; ?> id="ramal_id_base">
                                <option value="">...Selecione...</option> 
                                <?php foreach ($listBase as $base): ?>
                                    <option value="<?= $base['base_id']; ?>" <?= ($base['base_id'] == $ramal->get_ramal_id_base()) ? 'selected' : null; ?>><?= $base['base_nome']; ?></option> 
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Setor:</label>
                            <select name="ramal_id_setor" required class="form-control selectpicker" <?= $disabled; ?> id="ramal_id_setor">
                                <option value="" selected>...Selecione...</option>
                                <?php foreach ($listSetorDistinct as $setores): ?>
                                    <option value="<?= $setores['setor_id']; ?>" <?= ($setores['setor_id'] == $ramal->get_ramal_id_setor()) ? 'selected' : null; ?>><?= $setores['setor_local']; ?></option> 
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Id Uusário:</label>
                            <input type="text" name="ramal_id_usuario" value="<?= $ramal->get_ramal_id_usuario(); ?>" class="form-control " placeholder="Telefone" <?= $disabled; ?> id="ramal_telefone">
                        </div>
                    </div>
                </div>
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                <div class="row" id="atualizacaoDiv" style="display:none;">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-info">
                            <div class="panel-heading "> Atualização Ramal</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Solicitante: &nbsp; <span id="solicitante"></span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                        <div class="form-group">
                                            <label>Data Solicitação: &nbsp; <span id="data"></span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Status: Em Análise</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-actions">
                            <input type="hidden" name="ramal_id" value="<?= $ramal->get_ramal_id(); ?>"> 
                            <input type="hidden" name="acao" value="<?= $acao; ?>">
                            <input type="hidden" name="ramalAntigo" value="<?= $ramal->get_ramal_ramal(); ?>">

<?php if (isset($acao) && $acao != 'inserir') { ?>
                                <input type="hidden" name="ramal_id" value=<?= $id; ?> />	
                            <?php } ?>

                            <?php if ($acao != "visualizar" && !$atualizacao) { ?>	                    
                                <button type="submit" class="btn btn-primary botaoLoadForm">
                                    Salvar
                                </button>
<?php } else if ($atualizacao) { ?>
                                <button type="button" class="btn btn-success atualizarRamal">
                                    Atualização
                                </button>
<?php } ?>
                            <button type="button" class="btn btn-default" id="voltarAtualizacao" style="display:none;">Voltar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </form>
            <script language="javascript" type="text/javascript" src="modulos/ramal/public/js/min/modal.js"></script>
        </div>
    </div>
</div>