<div class="panel panel-primary">
    <div class="panel-heading ">Dados Funcionário :</div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr align="center">
                        <th>Nome</th>
                        <th>Matrícula</th>
                        <th>CTPS</th>
                        <th>Período</th>
                        <th>Ano</th>
                    </tr>
                </thead>
                <tbody>
                    <tr align="center">
                        <td><?=$objetopcf->get_pcf_nome();?></td>
                        <td><?=$objetopcf->get_pcf_matricula();?></td>
                        <td><?=$objetopcf->get_pcf_ctps();?></td>
                        <td><?=$objetopcf->get_pcf_periodo();?></td>
                        <td><?=$objetopcf->get_pcf_ano();?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <input type="hidden" value="<?= $totalPedidoComissao; ?>" name="totalPedidoComissao" id="total">
     </div>
</div><!--panel-primary-->