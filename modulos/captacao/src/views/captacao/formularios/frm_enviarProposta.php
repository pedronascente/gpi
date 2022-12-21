<?php
$proposta = new Proposta ();
$objeto_captacao = new Captacao;
$acao = filter_input(INPUT_GET, "acao");
$tipoProposta = $objeto_captacao->setTipoProposta($id_captacao);
$id_proposta = isset($tipoProposta ['proposta_id']) ? $tipoProposta ['proposta_id'] : '';
$lista_veiculos_proposta = $proposta->selectPropostaVeiculoCaptacao($id_proposta);
$totalVeiculos = $proposta->Read()->getRowCount();
$QTDVEICULO = $proposta->somaVeiculos($id_captacao);
$SELECT_TIPO_SERVICO = [
    'a' => 'Rastreamento',
    'b' => 'Rastreamento + Proteção Veícular',
    'c' => 'Rastreamento + Proteção Veícular + Assistência Veícular',
    'd' => 'Rastreamento + Assistência Veícular',
];
$URL_CONTROLLER = "modulos/captacao/src/controllers/proposta.php";
?>
<div class="envia_proposta">
    <?php if ($acaoSessao != 'relatorio' && $acaoSessao != 'auditoria') { ?>
        <form action="<?= $URL_CONTROLLER; ?>" method="post" id="frm_proposta">
            <div class="row">
                <div class="col-xs-2  col-md-2 ">
                    <div class="form-group">
                        <label>Vigência:</label>
                        <select name="vigencia" class="form-control">
                            <option value="12">12</option>
                            <option value="24">24</option>
                            <option value="36">36</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12  col-md-4 ">
                    <div class="form-group">
                        <label>Tipo de Veiculo:</label>
                        <select name="cpv_descricao_veiculo" class="form-control">
                            <option value="carro"> Carro</option>
                            <option value="caminhao" > Caminhão</option>
                            <option value="maquinas"> Máquinas</option>
                            <option value="moto"> Moto</option>
                            <option value="onibus"> Onibus</option>
                            <option value="retroEscavadeira"> Retro escavadeira</option>
                            <option value="trator"> Trator</option>
                            <option value="utilitario">Utilitários</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12  col-md-2 ">
                    <div class="form-group">
                        <label>Quantidade:</label>
                        <select name="cpv_qtd_veiculo" id="cpv_qtd_veiculo" class="form-control">
                            <?php for ($i = 1; $i <= 500; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
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
                        <input type="text" name="cpv_taxa_intalacao" value=""  class=" mask_real form-control" required="">
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 ">
                    <div class="form-group">
                        <label>Tx. Mensal:</label>
                        <input type="text" name="cpv_taxa_valor_mensal" value=""  class=" mask_real form-control" required="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>Tipo de Serviço:</label>
                        <select name="tipo_seguro" class="form-control">
                            <?php
                            foreach ($SELECT_TIPO_SERVICO as $k => $v) {
                                echo "<option value=\"{$k}\"   >{$v}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>                             
            <div class = "row">
                <div class="col-xs-6  col-md-3 ">
                    <div class="form-group">
                        <label>Forma Pgto Mensal:</label>
                        <select name="forma_pagamento" class="form-control">
                            <option value="1">Boleto</option>
                            <option value="2">Cartão</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12  col-md-6 ">
                    <input type="hidden" name="proposta_id_captacao" value="<?= $id_captacao; ?>"> 
                    <input type="hidden" name="acao" value="insert"> 
                    <button type="submit" class="btn btn-primary ">Adicionar</button>
                </div>
            </div>
        </form>  
        <?php
    }
    ?> 
</div>

<br>
<hr>

<?php  if($totalVeiculos >0){  ?>

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
                echo"<tr align=\"center\">";
                echo"<td>" . ucfirst($v['cpv_descricao_veiculo']) . "</td>";
                echo"<td>( {$v['cpv_qtd_veiculo']} )</td>";
                echo"<td>R$ {$v['cpv_taxa_intalacao']}</td>";
                echo"<td>{$mensalidade_cpv_formapagamento}</td>";
                echo"<td>R$ {$v['cpv_taxa_valor_mensal']}</td>";
                echo"<td>R$ {$v['cpv_total_taxa_valor']}</td>";
                echo"<td>";
                    switch ($v['tipo_seguro']) {
                        case"a": echo "Rastreamento"; break;
                        case"b": echo "Rastreamento + Proteção Veícular"; break;
                        case"c": echo "Rastreamento + Proteção Veícular + Assistência Veícular";  break;
                        case"d": echo "Rastreamento + Assistência Veícular";  break;
                    }
                echo"</td>";
                if ($acaoSessao != 'relatorio' && $acaoSessao != 'auditoria') {
                    ?>
                <td>
                    <form action="<?= $URL_CONTROLLER; ?>" name="form-deletaVeiculos" method="post" class="form-deletaVeiculos">
                        <input type="hidden" name="cpv_id" value="<?= $v['cpv_id']; ?>"> 
                        <input type="hidden" name="id_captacao" value="<?= $id_captacao; ?>"> 
                        <input type="hidden" name="acao" value="deletar"> 
                        <button type="submit" class="btn btn-sm btn-danger "><span class="glyphicon glyphicon-trash"></span></button>
                    </form>
                </td><?php
            }
            echo '</tr>';
        endforeach;
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="11" class="text-right"> Registros encontrados [<?= $totalVeiculos; ?>]</td>
            </tr>
            <tr>
                <td colspan="11">
                     <a id="modulos/captacao/src/views/captacao/formularios/modal_enviarPropostaEmail.php?id=<?= $id_proposta; ?>&acao=enviarProoposta&id_captacao=<?= $id_captacao; ?>" class="botaoLoad modalOpen btn btn-danger" data-target="#modal"> <span class="glyphicon glyphicon-envelope"></span>  Enviar Proposta</a>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<?php  } ?>

<script type="text/javascript" language="javascript">
    $(function () {
        //RESPONSAVEL POR PREENCHER CAMPO SELECT DO PLANO ASSISTENCIAL:
        $(".form-deletaVeiculos").submit(function () {
            if (confirmarDelete())
                return true;
            else
                return false;
        });
    });
</script>