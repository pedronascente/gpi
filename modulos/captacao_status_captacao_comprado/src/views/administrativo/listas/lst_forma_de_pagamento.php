<div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="veiculos" role="button" data-toggle="collapse"    href="#ddd" aria-expanded="false" aria-controls="dadosVeiculos">
        Forma de Pagamento
    </div>
    <div id="ddd" class="panel-collapse collapse" role="tabpanel" aria-labelledby="veiculos">
        <div class="panel-body">
            <?php if (!empty($ArrayListformaDePagamento)) { ?>
                <div class="row">
                    <div class="col-xs-12  col-md-12">
                        <table class="table table-striped">
                            <?php foreach ($ArrayListformaDePagamento as $v => $fdp) { ?>
                                <tr style="background: #343434; color: #fff">
                                    <th colspan="3"> <?= ($fdp['tipoEspecie'] == 'taxa') ? 'Taxa de Habilitação' : 'Mensalidade'; ?></th>
                                </tr>
                                <tr>
                                    <td colspan="3" ><b>Forma de pagamento :</b> <?= $fdp['forma_pagamento']; ?></td>
                                </tr>
                                <?php if ($fdp['forma_pagamento'] == 'Cartão de Crédito') { ?>
                                    <tr>
                                        <td colspan="3" ><b>Nome Impresso no Cartão :</b> <?= $fdp['nomeImpressoNoCartao']; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Bandeira do Cartão :</b> <?= $fdp['tipoCartao']; ?></td>
                                        <td><b>Número do Cartão :</b> <?= $fdp['numeroCartao']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Mês/Ano (MMAA) :</b> <?= $fdp['anoMes']; ?></td>
                                        <td><b>Qtd. de Parcelas :</b> <?= $fdp['numerosParcelas']; ?></td>
                                        <td><b>CVV :</b> <?= $fdp['cvv']; ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="2" ><b>Data :</b> <?= $fdp['data_pagamento']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Melhor dia de Pagamento :</b> <?= $fdp['diaMelhorPagamento']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>                                
                    </div>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label>Taxa de Habilitação : &nbsp;</label><?= $Cliente_Meio_Hab; ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label>Data : &nbsp;</label><?= $Cliente_Data_Pagamento; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label> Mensalidade : &nbsp;</label><?= $Cliente_Meio_Men; ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label>Melhor dia pagamento : &nbsp;</label><?= $Cliente_Melhor_Pagamento; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label>Observações : &nbsp;</label><?= $cliente_Obs_Pagamento; ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>