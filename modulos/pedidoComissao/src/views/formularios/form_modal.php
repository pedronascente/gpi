<?php
$id_setor = filter_input(INPUT_GET, 'id_setor', FILTER_VALIDATE_INT);
$id_usuario = filter_input(INPUT_GET, 'id_u');
$id_pc = filter_input(INPUT_GET, 'id_pc', FILTER_VALIDATE_INT);
$acao = filter_input(INPUT_GET, 'acao', FILTER_DEFAULT);
$page = filter_input(INPUT_GET, 'page', FILTER_DEFAULT);
$tipo = filter_input(INPUT_GET, "tipo");

if (!isset($_SESSION['user_info']))
    @session_start();

//LISTA A COMISSAO
$dados = null;
$titulo = null;

if ($acao == "editarComissao") {
    include ("../../../../../Config.inc.php");
    $pedidoComisao = new PedidoComissao ();
    $dados = $pedidoComisao->selectIdPedidoComissao($id_pc);
    $titulo = "Editar";
} else if ($acao == "AddPedidoComissao") {
    $titulo = "Cadastrar";
} else {
    $titulo = "Visualizar";
}

include_once 'tables/listaDados_tables_relatorios.php';
?>
<?php if ($tipo == "modal") { ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Agenda</h4>
            </div>			
            <div class="modal-body">
<?php } else { ?>
                <div class="panel panel-primary">
                    <div class="panel-heading "><?= $titulo; ?> Comissão</div>
                    <div class="panel-body"> 
<?php } ?>
                    <form method="post" name="form_addPedidoComissao" class="form_addPedidoComissao loadForm" action="modulos/pedidoComissao/src/controllers/pedido_comissao.php">
                        <div class="rows">
<?php
$data = '<div class="row"><div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><div class="form-group"><label>Data:</label><div class="input-group input-append date datepicker"><input type="text" name="pedido_comissao_data" id="pedido_comissao_data" class="form-control" value="' . $pedido_comissao_data . '" required/><div class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></div></div></div></div></div>';
$nome = '<div class="row"><div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"><div class="form-group"><label>Nome do cliente :</label><input type="text" name="pedido_comissao_cliente" id="" value="' . $pedido_comissao_cliente . '" class="form-control" required /></div></div></div>';
$comissao = '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><div class="form-group"><label>Comissão :</label><input type="text" name="pedido_comissao_comissao1" id="" value="' . $pedido_comissao_comissao1 . '" size="14" class="mask_real form-control"  required /></div></div>';
$desconto = '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><div class="form-group"><label>Desconto de Comissão : </label><input type="text" name="pedido_comissao_desc_comissao" value="<' . $pedido_comissao_desc_comissao . '" size="20" class="mask_real form-control" required /></div></div>';
$conta = '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><div class="form-group"><label> Conta :</label><input type="text" name="pedido_comissao_conta"        id="" value="' . $pedido_comissao_conta . '" class="form-control"/></div></div>';
$instVenda = '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><div class="form-group"><label>Ins./Vendas :</label><input type="text" name="pedido_comissao_inst_venda" value="' . $pedido_comissao_inst_venda . '" class="mask_real form-control" /></div></div>';
$mensal = '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><div class="form-group"><label>Mensal :</label><input type="text" name="pedido_comissao_mensal" value="' . $pedido_comissao_mensal . '" class="mask_real form-control" /></div></div>';
$servico = '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><div class="form-group">
			                    <label> Serviço :</label>
			                    <select name="pedido_comissao_servico" class="form-control" required>
			                        <option value="">Selecione</option>  
									<option value="Ampliação" ';
($pedido_comissao_servico == "Ampliação") ? $servico .= 'selected="selected"' : "";
$servico .= ' >Ampliação</option>
			                        <option value="Auditoria" ';
($pedido_comissao_servico == "Auditoria") ? $servico .= 'selected="selected"' : "";
$servico .= ' >Auditoria</option>
									<option value="Instalação" ';
($pedido_comissao_servico == "Instalação") ? $servico .= 'selected="selected"' : "";
$servico .= ' >Instalação</option>
									<option value="Levantamento" ';
($pedido_comissao_servico == "Levantamento") ? $servico .= 'selected="selected"' : "";
$servico .= ' >Levantamento</option>
									<option value="Manutenção" ';
($pedido_comissao_servico == "Manutenção") ? $servico .= 'selected="selected"' : "";
$servico .= ' >Manutenção</option>
									<option value="Plantão" ';
($pedido_comissao_servico == "Plantão") ? $servico .= 'selected="selected"' : "";
$servico .= ' >Plantão</option>
			  						<option value="Retirada" ';
($pedido_comissao_servico == "Retirada") ? $servico .= 'selected="selected"' : "";
$servico .= ' >Retirada</option>
			                    </select>
			                </div></div>';
echo $data;
echo $nome;
switch ($id_setor) :
    case 33 :
        ?> 
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label> Serviço :</label>
                                                <select name="pedido_comissao_servico" class="form-control" required>
                                                    <option value="">Selecione</option>  
                                                    <option value="Alarme Monitorado" <?= ($pedido_comissao_servico == "Alarme Monitorado") ? 'selected="selected"' : ""; ?>>Alarme Monitorado</option>
                                                    <option value="Cerca Elétrica" <?= ($pedido_comissao_servico == "Cerca Elétrica") ? 'selected="selected"' : ""; ?>>Cerca Elétrica</option>
                                                    <option value="CFTV" <?= ($pedido_comissao_servico == "CFTV") ? 'selected="selected"' : ""; ?>>CFTV</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Meio :</label>
                                                <select name="pedido_comissao_captacao" class="form-control">
                                                    <option value="">Selecione...</option>
                                                    <option value="Captação" <?= ($pedido_comissao_servico == "Captação") ? 'selected' : ''; ?>>Captação</option>
                                                    <option value="Prospecção" <?= ($pedido_comissao_servico == "Prospecção") ? 'selected' : ''; ?>>Prospecção</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
        <?= $instVenda; ?>
                                        <?= $mensal; ?>
                                    </div>
                                    <div class="row">
        <?= $comissao; ?>
                                        <?= $conta; ?>
                                        <?= $desconto; ?>
                                    </div>
                                        <?php
                                        break;
                                    case 46 :
                                        ?> 
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Qtd.Veículos :</label>
                                                <select name="pedido_comissao_qtd_veiculo" class="form-control">
        <?php for ($i = 1; $i <= 100; $i++): ?>
                                                        <option value="<?= $i; ?>"
                                                        <?= ($pedido_comissao_qtd_veiculo == $i) ? 'selected' : null; ?>><?= $i ?></option>
                                                            <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Tx. Instalação :</label>
                                                <input type="text" name="pedido_comissao_tx_instalacao" value="<?= $pedido_comissao_tx_instalacao; ?>" size="14" class="mask_real form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
        <?= $mensal; ?>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Placa</label>
                                                <!--<input type="text" name="pedido_comissao_placa" value="<?= $pedido_comissao_placa; ?>" class="mask_placa form-control" />-->
                                                <input type="text" name="pedido_comissao_placa" maxlength="8" value="<?= $pedido_comissao_placa; ?>" class=" form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Desconto: </label>
                                                <input type="text" name="pedido_comissao_desc_comissao" value="<?= $pedido_comissao_desc_comissao; ?>" size="20" class="mask_real form-control" required />
                                            </div>
                                        </div>
        <?= $comissao; ?>
                                    </div>
                                        <?php
                                        break;
                                    case 60 :
                                        ?> <div class="row">
                                    <?= $comissao; ?>
                                    <?= $conta; ?> 
                                    <?= $desconto; ?>
                                    </div>
                                    <?php
                                    break;
                                case 61 :
                                    ?> 

                                    <div class="row">  
        <?= $conta; ?>
                                        <?= $comissao; ?>
                                    </div>
                                    <div class="row">
        <?= $desconto; ?>
                                    </div>
                                    <div class="row">  
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Empresa:</label>
                                                <input type="text" name="pedido_comissao_empresa" value="<?= $pedidoComissao->get_pedido_comissao_empresa(); ?>" class="form-control" />
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="row">  
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Reclamação:</label>
                                                <textarea name="pedido_comissao_reclamacao" class=" form-control"   rows="5" class="form-contro"><?= $pedidoComissao->get_pedido_comissao_reclamacao(); ?></textarea>
                                            </div>
                                        </div>
                                    </div>   
        <?php
        break;
    case 62 :
        ?>
                                    <div class="row">
                                    <?= $comissao; ?>
                                        <?= $servico; ?>
                                    </div>
                                    <div class="row">
        <?= $instVenda; ?>
                                        <?= $mensal; ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Consultor</label>
                                                <input type="text" name="pedido_comissao_consultor" value="<?= $pedido_comissao_consultor; ?>" class="form-control" />
                                            </div>
                                        </div>
        <?= $conta; ?>
                                        <?= $desconto; ?>
                                    </div>
                                        <?php
                                        break;
                                    case 63 :
                                        ?>
                                    <div class="row">
                                    <?= $comissao; ?>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Total Rastreadores:</label>
                                                <input type="text" name="pedido_comissao_total_rastreadores" value="<?= $pedido_comissao_total_rastreadores; ?>" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
        <?= $conta; ?> 
                                        <?= $desconto; ?>
                                    </div>
                                        <?php
                                        break;
                                    case 64 :
                                        ?>
                                    <div class="row">
                                    <?= $comissao; ?>
                                        <?= $instVenda; ?>
                                    </div>
                                    <div class="row">
        <?= $mensal; ?>
                                        <?= $conta; ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Equip /Serviço</label>
                                                <input type="text" name="pedido_comissao_equip_servico" value="<?= $pedido_comissao_equip_servico; ?>" class="form-control" />
                                            </div>	
                                        </div> 
        <?= $desconto; ?>
                                    </div>
                                        <?php
                                        break;
                                    case 65 :
                                        ?>
                                    <div class="row">
                                    <?= $conta; ?>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>N° da OS:</label>
                                                <input type="text" name="pedido_comissao_n_os" value="<?= $pedido_comissao_n_os; ?>" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?= $servico; ?>
                                        <?= $comissao; ?>
                                        <?= $desconto; ?>
                                    </div>
                                        <?php
                                        break;
                                    case 66 :
                                        ?>
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Placa:</label>
                                                <!--<input type="text" name="pedido_comissao_placa" value="<?= $pedido_comissao_placa; ?>" class="mask_placa form-control" />-->
                                                <input type="text" name="pedido_comissao_placa" maxlength="8" value="<?= $pedido_comissao_placa; ?>" class=" form-control" />
                                            </div>
                                        </div>
        <?= $comissao; ?>
                                    </div>
                                    <div class="row">
        <?= $conta; ?>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Observação:</label>
                                                <input type="text" name="pedido_comissao_obs_rastreamento" value="<?= $pedido_comissao_obs_rastreamento; ?>" class="form-control" />
                                            </div>
                                        </div>
        <?= $desconto; ?>
                                    </div>
                                        <?php
                                        break;
                                    case 150 :
                                        ?>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Meio :</label>
                                                <select name="pedido_comissao_captacao" class="form-control">
                                                    <option value="">Selecione...</option>
                                                    <option value="Captação" <?= ($pedido_comissao_servico == "Captação") ? 'selected' : ''; ?>>Captação</option>
                                                    <option value="Prospecção" <?= ($pedido_comissao_servico == "Prospecção") ? 'selected' : ''; ?>>Prospecção</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
        <?= $instVenda; ?>
                                        <?= $mensal; ?>
                                    </div>
                                    <div class="row">
        <?= $comissao; ?>
                                        <?= $conta; ?>
                                        <?= $desconto; ?>
                                    </div>
                                        <?php
                                        break;
                                    case 32:
                                        ?>
                                    <div class="row">
                                        <?= $conta; ?>
                                        <?= $comissao; ?>
                                    </div>	                   
                                    <?php
                                    break;
                            endswitch;
                            ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-actions">
                                        <input type="hidden" name="pedido_comissao_id_usuario" value="<?= $id_usuario; ?>" />
                                        <input type="hidden" name="pedido_comissao_id" value="<?= $id_pc; ?>" /> 
                                        <input type="hidden" name="acao" value="<?= $acao ?>" /> 
                                        <input type="hidden" name="page" value="<?= $page ?>" /> 
                                        <input type="hidden" name="id_setor" value="<?= $id_setor ?>" />

                                        <button type="submit" class="btn btn-primary botaoLoadForm">
                                            Salvar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php if ($tipo == "modal") { ?>
            </div>
            <script  type="text/javascript" src="public/js/funcoes.js"></script>
        <?php } ?>
