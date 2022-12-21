<style>
   .filtros > div > div{ padding-bottom: 10px !important;}
</style>
<?php
if (null == $this->input->get() && isset($_COOKIE['filtros'])) {
    $data = json_decode($_COOKIE['filtros'], true);
} else {
    $data = $this->input->get();
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success"  id="_alert_sucess" style="display:none" >
            <strong>Success!</strong> Registros Migrados com Sucesso.
        </div>
        <?php
		if (!empty($respostaAtualizarDados) && $respostaAtualizarDados > 1) { ?> 
                    <div class="alert alert-danger _alert_danger"     >
                        <strong>Atenção!</strong> <?= $respostaAtualizarDados ?> Novos Curriculos encontrados.  
                    </div> 
                    <a href="javascript:void(0)" class="btn btn-danger _alert_danger"  id="btn_migrarDados" ><span class="glyphicon glyphicon-refresh"></span> Atualizar Tabela</a>
                    <div id="__rest" style="display:none"><p><b>Aguarde Sincronizando...</b></p></div>
                    <?php
                }
        ?> 
    </div>
</div>
<h3>RH - Gerênciador de Curriculos Empregaticio</h3>
<div>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseFiltros" aria-expanded="false" aria-controls="collapseExample">
        Filtros
    </button>
    <div class="collapse" id="collapseFiltros">
        <form class="well filtros" action="" method="get">
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            Status
                        </span>
                        <select name="arquivar" class="form-control" >
                            <option value="">Nada Selecionado</option>
                            <option value="1"> Arquivados</option>
                            <option value="0">Novos</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">
                            Nome
                        </span>
                        <input name="nome" type="text" class="form-control" value="<?php echo isset($data['nome']) ? $data['nome'] : ''; ?>">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-addon">
                            CNH
                        </span>
                        <select name="categoria" class="form-control">
                            <option value="">Nada</option>
                            <?php
                            if (!empty($selects['categoria'])) {
                                foreach ($selects['categoria'] as $item) {
                                    $select = ($item == $data['categoria']) ? 'selected' : '';
                                    echo '<option value=' . $item . ' ' . $select . '  >' . $item . '</option>';
                                }
                            } else {
                                echo "<option value=\"\">off</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            Cidade
                        </span>
                        <input name="cidade" type="text" class="form-control" value="<?php echo isset($data['cidade']) ? $data['cidade'] : ''; ?>">
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">
                            Data de Cadastro 
                        </span>
                        <input placeholder="Data Inicio" name="dateCadStart" type="text" class="form-control datepicker" value="<?php echo isset($data['dateCadStart']) ? $data['dateCadStart'] : ''; ?>">
                        <div class="input-group-addon">até</div>
                        <input placeholder="Data Fim" name="dateCadEnd" type="text" class="form-control datepicker" value="<?php echo isset($data['dateCadEnd']) ? $data['dateCadEnd'] : ''; ?>">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            Idade 
                        </span>
                        <input placeholder="inicio" name="idadeStart" type="text" class="form-control" value="<?php echo isset($data['idadeStart']) ? $data['idadeStart'] : ''; ?>">
                        <div class="input-group-addon">até</div>
                        <input placeholder="fim" name="idadeEnd" type="text" class="form-control" value="<?php echo isset($data['idadeEnd']) ? $data['idadeEnd'] : ''; ?>">

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">
                            Cargo
                        </span>
                        <select name="cargoPretendido" class="form-control">
                            <option value="">Nada</option>
                            <?php
                            if (!empty($selects['cargoPretendido'])) {
                                foreach ($selects['cargoPretendido'] as $item) {
                                    $select = ($item == $data['cargoPretendido']) ? 'selected' : '';
                                    echo '<option ' . $select . '  >' . $item . '</option>';
                                }
                            } else {
                                echo "<option value=\"\">off</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">
                            Pretenção
                        </span>
                        <select name="pretencaoSalarial" class="form-control" >
                            <option value="">Nada Selecionado</option>
                            <?php
                            if (!empty($selects['pretencaoSalarial'])) {
                                foreach ($selects['pretencaoSalarial'] as $item) {
                                    $select = ($item == $data['pretencaoSalarial']) ? 'selected' : '';
                                    echo '<option ' . $select . '  >' . $item . '</option>';
                                }
                            } else {
                                echo "<option value=\"\">off</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            Sexo
                        </span>
                        <select name="sexo" class="form-control" >
                            <option value="">Nada Selecionado</option>
                            <option value="Masculino" <?= (@$data['sexo'] === 'Masculino') ? 'selected' : ''; ?> >Masculino</option>
                            <option value="Feminino" <?= (@$data['sexo'] === 'Feminino') ? 'selected' : ''; ?> >Feminino</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon"> Estado </span>
                        <select name="uf" class="form-control" >
                            <option value="" selected="">Nada Selecionado</option>
                            <option value="AC"  <?= (@$data['uf'] === 'AC') ? 'selected' : ''; ?>>Acre</option>
                            <option value="AL"  <?= (@$data['uf'] === 'AL') ? 'selected' : ''; ?>>Alagoas</option>
                            <option value="AP"  <?= (@$data['uf'] === 'AP') ? 'selected' : ''; ?>>Amapá</option>
                            <option value="AM"  <?= (@$data['uf'] === 'AM') ? 'selected' : ''; ?>>Amazonas</option>
                            <option value="BA"  <?= (@$data['uf'] === 'BA') ? 'selected' : ''; ?>>Bahia</option>
                            <option value="CE"  <?= (@$data['uf'] === 'CE') ? 'selected' : ''; ?>>Ceará</option>
                            <option value="DF"  <?= (@$data['uf'] === 'DF') ? 'selected' : ''; ?>>Distrito Federal</option>
                            <option value="ES"  <?= (@$data['uf'] === 'ES') ? 'selected' : ''; ?>>Espírito Santo</option>
                            <option value="GO"  <?= (@$data['uf'] === 'GO') ? 'selected' : ''; ?>>Goiás</option>
                            <option value="MA"  <?= (@$data['uf'] === 'MA') ? 'selected' : ''; ?>>Maranhão</option>
                            <option value="MT"  <?= (@$data['uf'] === 'MT') ? 'selected' : ''; ?>>Mato Grosso</option>
                            <option value="MS"  <?= (@$data['uf'] === 'MS') ? 'selected' : ''; ?>>Mato Grosso do Sul</option>
                            <option value="MG"  <?= (@$data['uf'] === 'MG') ? 'selected' : ''; ?>>Minas Gerais</option>
                            <option value="PA"  <?= (@$data['uf'] === 'PA') ? 'selected' : ''; ?>>Pará</option>
                            <option value="PB"  <?= (@$data['uf'] === 'PB') ? 'selected' : ''; ?>>Paraíba</option>
                            <option value="PR"  <?= (@$data['uf'] === 'PR') ? 'selected' : ''; ?>>Paraná</option>
                            <option value="PE"  <?= (@$data['uf'] === 'PE') ? 'selected' : ''; ?>>Pernambuco</option>
                            <option value="PI"  <?= (@$data['uf'] === 'PI') ? 'selected' : ''; ?>>Piauí</option>
                            <option value="RJ"  <?= (@$data['uf'] === 'RJ') ? 'selected' : ''; ?>>Rio de Janeiro</option>
                            <option value="RN"  <?= (@$data['uf'] === 'RN') ? 'selected' : ''; ?>>Rio Grande do Norte</option>
                            <option value="RS"  <?= (@$data['uf'] === 'RS') ? 'selected' : ''; ?>>Rio Grande do Sul</option>
                            <option value="RO"  <?= (@$data['uf'] === 'RO') ? 'selected' : ''; ?>>Rondônia</option>
                            <option value="RR"  <?= (@$data['uf'] === 'RR') ? 'selected' : ''; ?>>Roraima</option>
                            <option value="SC"  <?= (@$data['uf'] === 'SC') ? 'selected' : ''; ?>>Santa Catarina</option>
                            <option value="SP"  <?= (@$data['uf'] === 'SP') ? 'selected' : ''; ?>>São Paulo</option>
                            <option value="SE"  <?= (@$data['uf'] === 'SE') ? 'selected' : ''; ?>>Sergipe</option>
                            <option value="TO"  <?= (@$data['uf'] === 'TO') ? 'selected' : ''; ?>>Tocantins</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            Bairro
                        </span>
                        <input name="bairro" type="text" class="form-control" value="<?php echo isset($data['bairro']) ? $data['bairro'] : ''; ?>">
                    </div>
                </div>
            </div>

            <div class="alert alert-info">
                Atenção :O campo abaixo é uma forma resumida de realizar suas Pesquisas :
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            Palavra - Chave ex : Nome, Cargo, Cidade, Bairro, UF
                        </span>
                        <input name="palavrachave" type="text" class="form-control" value="" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <input class="btn btn-primary" type="submit" value="Buscar"/>
                    <a href="<?php echo base_url('gerenciar?nome=&categoria=&cidade=&status=&dateCadStart=&dateCadEnd=&idadeStart=&idadeEnd=&cargoPretendido=&pretencaoSalarial='); ?>" class="btn btn-warning">Limpar Filtros</a>
                </div>
            </div>
        </form>
    </div>
    <div id="table" style="padding-top: 10px;">
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th><span>DATA CADASTRO</span></th>
                    <th><span>NOME</span></th>
                    <th><span>CARGO</span></th>
                    <th><span>CIDADE</span></th>
                    <th><span>BAIRRO</span></th>
                    <th><span>CNH</span></th>
                    <th><span>IDADE</span></th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php
                foreach ($content as $key => $value) {
                    $categoria = $value->categoria == 'n' ? '' : $value->categoria;
                    $arrayData = explode(' ', $value->dataCadastro);
                    if ($arrayData[0] == '0000-00-00') {
                        $dataCadastro = $arrayData[0];
                    } else {
                        $dataCadastro = date('d/m/Y', strtotime($arrayData[0]));
                    }
                    ?>
                    <tr>
                        <!--<td class="text-center"><?php //echo $value->candidato_id;  ?></td>    -->         
                        <td class="text-center"><?php echo $dataCadastro; ?></td>
                        <td ><?php echo $value->nome; ?></td>
                        <!--
                        <td class="txt-center"><?php echo $value->rg; ?></td>
                        <td class="txt-center"><?php echo $value->cpf; ?></td>
                        -->
                        <td><?php echo $value->cargoPretendido; ?></td>
                        <td class="txt-center"><?php echo $value->cidade; ?></td>
                        <td class="txt-center"><?php echo $value->bairro; ?></td>
                        <td class="txt-center"><?php echo $categoria; ?></td>
                        <td class="txt-center"><?php echo $value->idade; ?></td>
                        <td class="txt-center">
                            <a href="<?php echo $this->config->base_url('visualizar/' . $value->candidato_id); ?>" class="btn btn-sm btn-success">ver</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-center active" id="_totalRegistro">[ <?= $count ?>  ] Registros encontrados.</td>
                    <td colspan="4" class="text-center active" id="_totalRegistro">[<?= $total_registro; ?>] Total registros na base.</td>
                </tr>	
            </tfoot>
        </table>
    </div>
    <div>
        <?php echo $paginacao; ?>
    </div>
</div>

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
                <a href="<?php echo base_url('excluir/' . @$colaborador['dadosPessoais']->candidato_id); ?>" class="btn btn-success">Excluir</a>
                
                <button type="button" class="btn btn-primary" data-dismiss="modal">Voltar</button>
            </div>
        </div>
    </div>
</div>

<?php
if(!$_SERVER['SERVER_NAME']=="localhost"){
    $servidor= "http://".$_SERVER['SERVER_NAME'].'/gpi/application/ci_update/migrar';
}else{
    $servidor= "http://".$_SERVER['SERVER_NAME'].':81/gpi/application/ci_update/migrar';
}

?>



<script type="text/javascript">
    $(function(){
        
        $('#btn_migrarDados').click(function () {
        $(this).css('display', 'none');
        $('#__rest').show();
        $.post("<?php echo $servidor;?>", {name: "s", }, function (data, status) {
            console.log(data.data)
            if (data.data !== false) {
                alert('Registros Atualizados com sucesso!');
                $('#_alert_sucess').show();
                $('._alert_danger').hide();
                location.reload();
            } else if (data.data !== false) {
                $('#_alert_danger').show();
                $('#_alert_sucess').hide();
                
            }
        }, "json");
    });
        
    });
</script>
