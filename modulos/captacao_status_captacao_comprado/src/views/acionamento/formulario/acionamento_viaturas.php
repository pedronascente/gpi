<?php
$captacao = new Captacao;
$dados = filter_input_array(INPUT_GET);
$data = date('Y-m-d');
$pagina = isset($dados['pg']) ? $dados['pg'] : '';
$captacao->selectViaturas($data);
$total = $captacao->Read()->getRowCount();
$objPaginacao = new paginacao(20, $total, PAG, 20);
$objPaginacao->setTabs("#tab2");
$objPaginacao->_pagina = PAGINA.Funcoes::getParametrosURL($dados);
$limite = $objPaginacao->limit();
$viaturas = $captacao->selectViaturas($data, $limite);
/* @var $dados type Array */
$pontos = !empty($dados['pontos']) ? $dados['pontos'] : null;

if (!empty($pontos)) {
    ?>
    <script type="text/javascript">
        $(function () {
            $(document).ready(function () {
                var pontos = <?php echo $pontos; ?>;
                var modal = "#modal";
                var caminho = "modulos/captacao/src/views/acionamento/formulario/modalAcionamento.php?pontos=" + pontos;
                $(modal).load(caminho);
                $(modal).modal();
            });
        });
    </script>
<?php }
?>
<div class="panel panel-primary">
    <div class="panel-heading "> 
        Monitoramento / Acionamento de viaturas:   
    </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <?php if(!in_array(array("tipo_permissao"=>"supervisorUVA"), $_SESSION['user_info']['permissoes'])){?>
                <li><a data-toggle="tab" href="#tab1">Cadastro</a></li>
            <?php }?>
            <li><a data-toggle="tab" href="#tab2">Visualiza&ccedil;&atilde;o</a></li>
        </ul>
        <div class="tab-content">
        	<?php if(!in_array(array("tipo_permissao"=>"supervisorUVA"), $_SESSION['user_info']['permissoes'])){?>
            <div id="tab1" class="tab-pane fade">
                <div class="panel panel-primary">
                    <div class="panel-heading"></div>
                    <div class="panel-body">
                        <!--FORMULARIO-->
                        <form action="modulos/captacao/src/controllers/acionamento.php" method="post" id="formAcionamento">
                            <div class="form-group">
                                <label>Conta:</label>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                        <input type="text" name="conta" id="conta" maxlength="6" class="form-control"  required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Qual zona disparou?</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="zona1ouqualquer"  value="20.1"/>Zonas de Entrada
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="zona1ouqualquer"  value="30.2"/>Outras zonas + Zonas de Entrada 
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="zona1ouqualquer" value="10.3" />Outras zonas
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>N&uacute;mero de disparos?</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="disparos" value="5.1"/>Um
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="disparos" value="15.2"/>Dois
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="disparos" value="30.3"/>Tr&ecirc;s ou mais.
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>N&uacute;mero de zonas que dispararam?</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="zonas" value="10.1"/>Uma zona
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="zonas" value="30.2" />Duas zonas
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="zonas" value="50.3" />Tr&ecirc;s ou mais zonas.
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Todas as zonas que dispararam restauraram?</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="todaszonas"  value="0.1"/>Sim 
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="todaszonas" value="50.2" />N&atilde;o
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>A zona que disparou possui hist&oacute;rico de disparo nos últimos 10 dias?</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="30dias"  value="-9.1" />Sim 
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="30dias" value="2.2" />N&atilde;o 
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Est&aacute; acontecendo temporal(ventos fortes, raios, trovões ou chuva muito forte)?</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="temporal"  value="-14.1"/>Sim
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="temporal" value="0.2" />N&atilde;o
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="operador" value="<?= !empty($_SESSION['user_info']['nome']) ? $_SESSION['user_info']['nome'] : ""; ?>"/>
                                <input type="hidden" name="acao" id="acao" value="enviaViaturas" /> 
                                <input type="submit" class="btn btn-primary" value="Enviar" />
                            </div>
                        </form>          
                    </div>
                </div>
            </div>
            <?php }?>
            <div id="tab2" class="tab-pane fade">
                <div class="panel panel-primary">
                    <div class="panel-heading"></div>
                    <div class="panel-body">
                        <?php include_once __DIR__ . '/../listas/lst_acionamento_viaturas.php'; ?>
                    </div>
                </div>
            </div>
        </div><!--tab-content-->
    </div><!--panel-body-->
</div>
<?php if ($pontos)  ?>