<?php
//namespace C:\wamp\www\gpi\modulos\captacao\src\views\captacao\formularios\frm_enviarProposta.php
$proposta = new Proposta ();
$acao = filter_input(INPUT_GET, "acao");
$lista_veiculos_proposta = $proposta->selectPropostaVeiculoCaptacao($id_proposta);
$totalVeiculos = $proposta->Read()->getRowCount();
$QTDVEICULO = $proposta->somaVeiculos($id_captacao);
if ($id_proposta >= 0) :
    $PL = $proposta->selectPlanoAssistencial($id_proposta);
endif;
if ($acao == 'editar') :
    $veiculo = $proposta->selectPropostaVeiculo($id_cpv);
    $cpv_descricao_veiculo = !empty($veiculo['cpv_descricao_veiculo']) ? $veiculo['cpv_descricao_veiculo'] : '';
    $cpv_qtd_veiculo = !empty($veiculo ['cpv_qtd_veiculo']) ? $veiculo ['cpv_qtd_veiculo'] : '';
endif;
$SELECT_TIPO_SERVICO = [
    'a' => 'Rastreamento',
    'b' => 'Rastreamento + Proteção Veícular',
    'c' => 'Rastreamento + Proteção Veícular + Assistência Veícular',
];
?>
<div class="envia_proposta">
    <?php if ($acaoSessao != 'relatorio' && $acaoSessao != 'auditoria') { ?>
        <form action="modulos/captacao/src/controllers/proposta1.php" method="post" id="frm_proposta">
            <div class="row">
                <div class="col-xs-2  col-md-2 ">
                    <div class="form-group">
                        <label>Vigência:</label>
                        <select name="vigencia" class="form-control">
                            <option value="12" <?= (isset($veiculo['vigencia']) && $veiculo['vigencia'] == '12') ? 'selected' : ''; ?> >12</option>
                            <option value="24" <?= (isset($veiculo['vigencia']) && $veiculo['vigencia'] == '12') ? 'selected' : ''; ?> >24</option>
                            <option value="36" <?= (isset($veiculo['vigencia']) && $veiculo['vigencia'] == '12') ? 'selected' : ''; ?> >36</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12  col-md-4 ">
                    <div class="form-group">
                        <label>Tipo de Veiculo:</label>
                        <select name="cpv_descricao_veiculo" class="form-control">
                            <option value="carro" <?= ($cpv_descricao_veiculo == 'carro') ? 'selected' : ''; ?>> Carro</option>
                            <option value="caminhao" <?= ($cpv_descricao_veiculo == 'caminhao') ? 'selected' : ''; ?>> Caminhão</option>
                            <option value="maquinas" <?= ($cpv_descricao_veiculo == 'maquinas') ? 'selected' : ''; ?>> Máquinas</option>
                            <option value="moto" <?= ($cpv_descricao_veiculo == 'moto') ? 'selected' : ''; ?>> Moto</option>
                            <option value="onibus" <?= ($cpv_descricao_veiculo == 'onibus') ? 'selected' : ''; ?>> Onibus</option>
                            <option value="retroEscavadeira" <?= ($cpv_descricao_veiculo == 'retroEscavadeira') ? 'selected' : ''; ?>> Retro escavadeira</option>
                            <option value="trator" <?= ($cpv_descricao_veiculo == 'trator') ? 'selected' : ''; ?>> Trator</option>
                            <option value="utilitario" <?= ($cpv_descricao_veiculo == 'utilitario') ? 'selected' : ''; ?>> Utilitários</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12  col-md-2 ">
                    <div class="form-group">
                        <label>Quantidade:</label>
                        <select name="cpv_qtd_veiculo" id="cpv_qtd_veiculo" class="form-control">
                            <?php for ($i = 1; $i <= 100; $i++): ?>
                                <option value="<?= $i ?>" <?= ($cpv_qtd_veiculo == $i) ? 'selected' : ''; ?>><?= $i ?></option>
                                <?php
                            endfor;
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-3 ">
                    <div class="form-group">
                        <label>Tx. Instalação:</label>
                        <input type="text" name="cpv_taxa_intalacao" value="<?= !empty($veiculo['cpv_taxa_intalacao']) ? $veiculo['cpv_taxa_intalacao'] : '0.00'; ?>" class=" mask_real form-control">
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 ">
                    <div class="form-group">
                        <label>Tx. Mensal:</label>
                        <input type="text" name="cpv_taxa_valor_mensal" value="<?= !empty($veiculo['cpv_taxa_valor_mensal']) ? $veiculo['cpv_taxa_valor_mensal'] : '0.00'; ?>" class=" mask_real form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-6 ">
                    <div class="form-group">
                        <label>Tipo de Serviço:</label>
                        <select name="tipo_seguro" class="form-control">
                            <?php
                            $tipo_seguro = !empty($veiculo['tipo_seguro']) ? $veiculo['tipo_seguro'] : null;
                            foreach ($SELECT_TIPO_SERVICO as $k => $v) {
                                ?>
                                <option value="<?= $k; ?>" <?= ($k == $tipo_seguro) ? 'selected' : ''; ?>><?= $v ?></option>
    <?php } ?>
                        </select>
                    </div>
                </div>
            </div>                             
            <div class = "row">
                <div class="col-xs-6  col-md-6 ">
                    <div class="form-group">
                        <label>Forma Pgto Mensal:</label>
                        <select name="forma_pagamento" class="form-control">
                            <option value="1" <?= (isset($veiculo['forma_pagamento']) && $veiculo['forma_pagamento'] == '1') ? 'selected' : ''; ?>>Boleto</option>
                            <option value="2" <?= (isset($veiculo['forma_pagamento']) && $veiculo['forma_pagamento'] == '2') ? 'selected' : ''; ?>>Cartão</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12  col-md-6 ">
    <?php if (isset($id_cpv)) {
        echo '<input type="hidden" name="id_cpv" value="' . $id_cpv . '">';
    } ?>
                    <input type="hidden" name="acao" value="<?= ($acao != 'editar') ? 'insert' : 'editar'; ?>"> 
                    <input type="hidden" name="proposta_id" value="<?= $id_proposta; ?>" id="proposta_id"> 
                    <input type="hidden" name="id_captacao" value="<?= $id_captacao; ?>"> 
                    <input type="hidden" name="proposta_tipo_proposta" value="0"> 
                    <button type="submit" class="btn btn-primary "><?= ($acao != 'editar') ? 'Adicionar' : 'Editar'; ?></button>
                </div>
            </div>
        </form>  
        <?php
    }
    //FORMULARIO RESPONSAVEL POR REGISTRARO PLANO ASSISTENCIAL 
    if ($QTDVEICULO ['QTDVEICULO'] > 0) :
        ?>
        <form action="modulos/captacao/src/controllers/proposta1.php" name="form-planoAssistencial" method="post" class="loadForm" style="display:none;">
            <div class="row">
                <div class="col-xs-12  col-md-4 ">
                    <div class="panel panel-default">
                        <div class="panel-heading">Plano Assistêncial</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12  col-md-3 ">
                                    <div class="form-group">
                                        <label>Qtde:</label>
                                        <select name="cpv_qtd_plano_assistencial" id="qtd_pls" class="form-control">
                                            <?php for ($a = 1; $a <= $QTDVEICULO ['QTDVEICULO']; $a ++) : ?>
                                                <option value="<?= $a; ?>"<?= (isset($PL['cpv_qtd_plano_assistencial']) && $PL['cpv_qtd_plano_assistencial'] == $a) ? 'selected' : ''; ?>> <?= $a; ?></option>
                                                    <?php
                                                endfor;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12  col-md-6">
                                    <div class="form-group">
                                        <label>Valor/Unit.:</label>
                                        <input type="text" name="cpv_vlr_mes_plano_assistencial" class="form-control mask_real" value="<?= !empty($PL['cpv_vlr_mes_plano_assistencial']) ? $PL['cpv_vlr_mes_plano_assistencial'] : '29.90'; ?>">
                                    </div>
                                </div>
                                <div class="col-xs-12  col-md-3 col-lg-3">
                                    <br>
                                    <div class="form-actions">
                                        <input type="hidden" name="id_proposta" id="id_proposta" value="<?= $id_proposta; ?>"> 
                                        <input type="hidden" name="id_captacao" value="<?= $id_captacao; ?>"> <input type="hidden" name="acao" id="acao" value="insrtPLS"> 

                                        <button type="submit" class="btn btn-primary ">
                                            Adicionar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>   
    <?php
endif;
?> 
</div>
<?php
//LISTAR OS VEICULOS DA PROPOSTA :
if ($totalVeiculos >= 1) :
    if ($PL['cpv_qtd_plano_assistencial']) : ?>
        <div class="envia_proposta table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th colspan="3" align="center">Plano Assistencial</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $totalPlanoAssistencial = ($PL ['cpv_qtd_plano_assistencial'] * $PL ['cpv_vlr_mes_plano_assistencial']);
                        echo "
                        <tr align=\"center\">
                            <td>Quantidade : {$PL['cpv_qtd_plano_assistencial']}</td>
                            <td>Valor Unitário R$ " . Funcoes::formartaMoedaReal($PL ['cpv_vlr_mes_plano_assistencial']) . "</td>
                            <td>Total R$ " . Funcoes::formartaMoedaReal($totalPlanoAssistencial) . " </td>
                        </tr>";
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    endif;
?>
<br>
<br>
    <div class="well well-sm">
        <span class="glyphicon glyphicon-pencil"></span> => Editar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="glyphicon glyphicon-trash"></span> => Excluir
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Tipo de Veículo</th>
                    <th>Quantidade</th>
                    <th>Taxa Instalação</th>
                    <th>Forma Pgto Mensal</th>
                    <th>Mensalidade</th>
                    <th>Total</th>
                    <th>Tipo de Serviço</th>
                    <?php
                    if ($acaoSessao != 'relatorio' && $acaoSessao != 'auditoria') {
                        echo ' <th width="5%" colspan="2">Ações</th>';
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($lista_veiculos_proposta as $k => $v) :
                    $mensalidade_cpv_formapagamento = !empty($v["forma_pagamento"]) ? ($v["forma_pagamento"] == 1 ? "Boleto" : "Cartão") : "";
                    ?>
                    <tr align="center">
                        <td><?= $v['cpv_descricao_veiculo'] ?></td>
                        <td>( <?= $v['cpv_qtd_veiculo']; ?> )</td>
                        <td>R$ <?= $v['cpv_taxa_intalacao']; ?></td>
                        <td> <?= $mensalidade_cpv_formapagamento; ?></td>
                        <td>R$ <?= $v['cpv_taxa_valor_mensal']; ?></td>
                        <td>R$ <?= $v['cpv_total_taxa_valor'] ?></td>
                        <td>
                            <?php
                            switch ($v['tipo_seguro']) {
                                case"a": echo "Rastreamento";
                                    break;
                                case"b": echo "Rastreamento + Proteção Veícular";
                                    break;
                                case"c": echo "Rastreamento + Proteção Veícular + Assistência Veícular";
                                    break;
                            }
                            ?>
                        </td>
                            <?php if ($acaoSessao != 'relatorio' && $acaoSessao != 'auditoria') { ?>
                            <td>
                                <form action="modulos/captacao/src/controllers/proposta1.php" name="form-deletaVeiculos" method="post" class="form-deletaVeiculos">
                                    <input type="hidden" name="" value=""> <input type="hidden" name="id_cpv" value="<?= $v['cpv_id']; ?>"> 
                                    <input type="hidden" name="id_captacao" value="<?= $id_captacao; ?>"> 
                                    <input type="hidden" name="acao" value="deletar"> 
                                    <button type="submit" class="btn btn-sm btn-danger "><span class="glyphicon glyphicon-trash"></span></button>
                                </form>
                            </td>
                        <?php
                    }
                    ?>
                    </tr>
                <?php
            endforeach;
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="11">(<?= $totalVeiculos; ?>) Registros encontrados</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php 
        if ($acaoSessao != 'relatorio' && $acaoSessao != 'auditoria') { ?>
            <div class="row">
               <div class="col-xs-12 col-md-12">
                   <div class="form-actions">
                       <a id="modulos/captacao/src/views/captacao/formularios/modal_enviarPropostaEmail.php?id=<?= $id_proposta; ?>&acao=enviarProoposta&id_captacao=<?= $id_captacao; ?>" class="botaoLoad modalOpen btn btn-success" data-target="#modal"> <span class="glyphicon glyphicon-envelope"></span>  Enviar </a>
                   </div>
               </div>
           </div> <?php
        }
    endif;
?>
<script type="text/javascript" language="javascript">
    $(function () {
        //RESPONSAVEL POR PREENCHER CAMPO SELECT DO PLANO ASSISTENCIAL:
        $(".form-deletaVeiculos").submit(function () {
            if (confirmarDelete())
                return true;
            else
                return false;
        });
        $(".tipoProposta").click(function () {
            var tipo = $(this).val();
            var id = $("#proposta_id").val();
            $.ajax({
                url: 'modulos/captacao/src/controllers/proposta1.php',
                type: 'POST',
                dataType: 'text',
                data: {proposta_id: id, proposta_tipo_proposta: tipo, acao: "updateProposta"},
                success: function (json) {
                }
            });
        });
        $("#cpv_qtd_veiculo").change(function () {
            var valor = $(this).val();
            var options = '';
            for (var i = 1; i <= valor; i++) {
                options += '<option value="' + i + '">' + i + '</option>';
            }
            ;
            $("#qtd_pls").html(options);
        });
    });
</script>