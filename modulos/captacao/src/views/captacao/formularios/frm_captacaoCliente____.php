<?php
// namespace C:\wamp\www\gpi\modulos\captacao\src\views\captacao\formularios\frm_captacaoCliente.php
include_once __DIR__ . '/../../../controllers/controller_captacaoCliente.php'; ?>
<div class="panel panel-primary">
    <div class="panel-heading">
       Formulário - Consultar SPC/SERASA
    </div>
    <div class="panel-body">
       <?php   if(isset($_GET['consulta'])&&$_GET['consulta']=='administrativo'){ ?>
                <form action="modulos/captacao/src/controllers/captacao.php" method="post" class="loadForm" id="consultarCPF">
                    <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>
                                        <ul class="nav nav-pills">
                                            <li role="presentation" class="active tipoPessoa" id="f"><a>Física</a></li>
                                            <li role="presentation" class="tipoPessoa" id="j"><a>Júridica</a></li>
                                        </ul>
                                    </label>	
                                </div>
                            </div>
                        </div>
                        <?php if($tipo_consulta != "ex"){?>
                            <div class="row">
                               <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3">
                                   <div class="form-group">
                                       <label>Captação:</label>	
                                       <select name="id_captacao" class="form-control selectpicker">
                                           <option value="" selected>Selecione</option>
                                           <?php 
                                               if(!empty($listaCaptacaoAbertas)){
                                                   foreach ($listaCaptacaoAbertas as $cap){?>
                                                       <option value="<?=$cap['captacao_id']?>"><?=$cap['captacao_cliente']?></option><?php 
                                                   }
                                               }
                                           ?>
                                       </select>
                                   </div>
                               </div>
                           </div>
                       <?php }?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3">
                                <div class="form-group">
                                        <label>Tipo de Cadastro:</label>
                                        <select name="tipo_cadastro" id="tipo_cadastro" required class="form-control">
                                            <option selected="selected" value="rastreador">Contrato Comodato</option>
                                            <option value="venda">Contrato Venda</option>
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3" id="vigencia">
                                <div class="form-group">
                                        <label>Vigência:</label>
                                        <select name="vigencia" class="form-control">
                                            <option selected="selected" value="1">12 meses</option>
                                            <option value="2">24 meses</option>
                                            <option value="3">36 meses</option>
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3">
                                <div class=" form-group">   
                                    <label>CPF/CNPJ:</label>
                                    <input type="text" name="cnpjcpf_cliente" id="cpf_cnpj" required class="mask_cpf form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-10 col-md-6 col-lg-6">
                                <div class=" form-group">   
                                    <label id="title_nome">Nome:</label>
                                    <input type="text" name="nome_cliente" required class="form-control">
                                </div>
                            </div>   
                       </div>
            <?php 
            $required ='';
            if ($tipo_consulta == 'ex') :?>
                <div class=" form-group">   
                    <div class="row">
                        <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3">
                            <label>Usuario:</label>
                            <?php
                                $required = 'required';
                                $usuario = new Usuarios;
                                $lista_usuarios = $usuario->selUser('vendas');
                                echo
                                '<select name="id_usuario" id="id_usuario" class="form-control selectpicker"  ' . $required . '  >';
                                    echo '
                                     <option value="" selected="selected">selecione um Usuario</option>';
                                        if ($lista_usuarios) :
                                            foreach ($lista_usuarios as $li) :
                                                $usuario_id = !empty($li ['usuario_id']) ? $li ['usuario_id'] : NULL;
                                                $usuario_nome = !empty($li ['usuario_nome']) ? $li ['usuario_nome'] : NULL;
                                                echo ' <option value="' . $usuario_id . '">' . $usuario_nome . '</option>';
                                            endforeach;
                                        endif;
                                    echo
                                '</select>';
                            ?>
                        </div>
                    </div>
                </div>
                <div class=" form-group _radio_ ">
                    <label>Status Cliente:</label>
                    <div class="radio">
                        <label>
                            <input type="radio" id="radio3" name="radioApRp" class="radio_AprovaReprova" checked="checked" value="aprovado">  Aprovado
                        </label>    
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" id="radio4" name="radioApRp" class="radio_AprovaReprova" value="reprovado"> Reprovado
                        </label>
                    </div>    
                </div>
                <div class=" form-group _radio_ "  id="boxMotivoReprovacao"  style="display: none" >
                    <div class="row">
                        <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3">
                            <label>Motivo Reprovado :</label>
                            <select name="motivo_reprovacao_cliente" class="form-control"   <?=$required;?> disabled="disabled" id="selectReprovado">
                                <option value="">Selecione</option>
                                <option value="CNPJ Invalido">CNPJ Invalido</option>
                                <option value="Dados com restricoes">Dados com restricoes</option>
                                <option value="CPF Invalido">CPF Invalido</option>
                                <option value="Nome Incompleto">Nome Incompleto</option>
                                <option value="Nome Incorreto">Nome Incorreto</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php
            else :?>
                <div class=" form-group _radio_ ">
                    <label>Status Cliente:</label>
                    <div class="radio">
                        <label>
                            <input type="radio" id="radio3" name="radioApRp" class="radio_AprovaReprova" checked="checked" value="aprovado">  Aprovado
                        </label>    
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" id="radio4" name="radioApRp" class="radio_AprovaReprova" value="reprovado"> Reprovado
                        </label>
                    </div>    
                </div>
                <div class=" form-group _radio_ "  id="boxMotivoReprovacao"  style="display: none" >
                    <div class="row">
                        <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3">
                            <label>Motivo Reprovado :</label>
                            <select name="motivo_reprovacao_cliente" class="form-control"   <?=$required;?> disabled="disabled" id="selectReprovado">
                                <option value="">Selecione</option>
                                <option value="CNPJ Invalido">CNPJ Invalido</option>
                                <option value="Dados com restricoes">Dados com restricoes</option>
                                <option value="CPF Invalido">CPF Invalido</option>
                                <option value="Nome Incompleto">Nome Incompleto</option>
                                <option value="Nome Incorreto">Nome Incorreto</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?=$_SESSION ['user_info'] ['id_usuario'];?>">
                </div>
                <?php
            endif;
            ?>
            <div class="form-group">
                <input type="hidden" name="redirect"  value="redirect">
                <input type="hidden" name="tipo_pessoa"  id="textoTipoPessoa" value="f">  
                <input type="hidden" name="acao" value="consultaSPCSERASA"> 
                <input type="hidden" name="tipoFrm" value="<?= $tipo_consulta == 'ex' ? 'aprovar' : 'consultar'; ?>">
                <input type="submit" value="<?=$tipo_consulta == 'ex' ? 'Salvar' : 'Consultar'; ?>" class="btn btn-primary">
                    <a href="?pg=12&redirect=on&id=" class="btn btn-info ">Voltar</a>
                    <?php
                    if (isset($redirect) && $redirect == 'on') {
                        echo "<a href=\"index.php?pg=19&id={$id_captacao}\" class=\"btn btn-info \">Voltar</a>";
                    }
                    ?>
            </div>
        </form>
       <?php  }else{ ?>
        <form action="modulos/captacao/src/controllers/captacao.php" method="post" class="loadForm" id="consultarCPF">
            <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>
                                <ul class="nav nav-pills">
                                    <li role="presentation" class="active tipoPessoa" id="f"><a>Física</a></li>
                                    <li role="presentation" class="tipoPessoa" id="j"><a>Júridica</a></li>
                                </ul>
                            </label>	
                        </div>
                    </div>
                </div>
                <?php if($tipo_consulta != "ex"){?>
            	 <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Captação:</label>	
                            <select name="id_captacao" class="form-control selectpicker">
                            	<option value="" selected>Selecione</option>
                            	<?php if(!empty($listaCaptacaoAbertas)){
                            			foreach ($listaCaptacaoAbertas as $cap){?>
                            			<option value="<?=$cap['captacao_id']?>"><?=$cap['captacao_cliente']?></option>
                            	<?php }}?>
                            </select>
                        </div>
                    </div>
                </div>
            <?php }?>
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3">
                    	<div class="form-group">
	                        <label>Tipo de Cadastro:</label>
	                        <select name="tipo_cadastro" id="tipo_cadastro" required class="form-control">
	                            <option selected="selected" value="rastreador">Contrato Comodato</option>
	                            <option value="venda">Contrato Venda</option>
	                        </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3" id="vigencia">
                    	<div class="form-group">
	                        <label>Vigência:</label>
	                        <select name="vigencia" class="form-control">
	                            <option selected="selected" value="1">12 meses</option>
	                            <option value="2">24 meses</option>
	                            <option value="3">36 meses</option>
	                        </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3">
                        <div class=" form-group">   
                            <label>CPF/CNPJ:</label>
                            <input type="text" name="cnpjcpf_cliente" id="cpf_cnpj" required class="mask_cpf form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                       <div class="col-xs-12 col-sm-10 col-md-6 col-lg-6">
                           <div class=" form-group">   
                           <label id="title_nome">Nome:</label>
                           <input type="text" name="nome_cliente" required class="form-control">
                           </div>
                   </div>   
               </div>
            <?php 
            $required ='';
            if ($tipo_consulta == 'ex') :?>
                <div class=" form-group">   
                    <div class="row">
                        <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3">
                            <label>Usuario:</label>
                            <?php
                                $required = 'required';
                                $usuario = new Usuarios;
                                $lista_usuarios = $usuario->selUser('vendas');
                                echo
                                '<select name="id_usuario" id="id_usuario" class="form-control selectpicker"  ' . $required . '  >';
                                    echo '
                                     <option value="" selected="selected">selecione um Usuario</option>';
                                        if ($lista_usuarios) :
                                            foreach ($lista_usuarios as $li) :
                                                $usuario_id = !empty($li ['usuario_id']) ? $li ['usuario_id'] : NULL;
                                                $usuario_nome = !empty($li ['usuario_nome']) ? $li ['usuario_nome'] : NULL;
                                                echo ' <option value="' . $usuario_id . '">' . $usuario_nome . '</option>';
                                            endforeach;
                                        endif;
                                    echo
                                '</select>';
                            ?>
                        </div>
                    </div>
                </div>
                <div class=" form-group _radio_ ">
                    <label>Status Cliente:</label>
                    <div class="radio">
                        <label>
                            <input type="radio" id="radio3" name="radioApRp" class="radio_AprovaReprova" checked="checked" value="aprovado">  Aprovado
                        </label>    
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" id="radio4" name="radioApRp" class="radio_AprovaReprova" value="reprovado"> Reprovado
                        </label>
                    </div>    
                </div>
                <div class=" form-group _radio_ "  id="boxMotivoReprovacao"  style="display: none" >
                    <div class="row">
                        <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3">
                            <label>Motivo Reprovado :</label>
                            <select name="motivo_reprovacao_cliente" class="form-control"   <?=$required;?> disabled="disabled" id="selectReprovado">
                                <option value="">Selecione</option>
                                <option value="CNPJ Invalido">CNPJ Invalido</option>
                                <option value="Dados com restricoes">Dados com restricoes</option>
                                <option value="CPF Invalido">CPF Invalido</option>
                                <option value="Nome Incompleto">Nome Incompleto</option>
                                <option value="Nome Incorreto">Nome Incorreto</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php
            else :?>
                <div class="form-group">
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?=$_SESSION ['user_info'] ['id_usuario'];?>">
                </div>
                <?php
            endif;
            ?>
            <div class="form-group">
                <input type="hidden" name="redirect"  value="redirect">
                <input type="hidden" name="tipo_pessoa"  id="textoTipoPessoa" value="f">  
                <input type="hidden" name="acao" value="consultaSPCSERASA"> 
                <input type="hidden" name="tipoFrm" value="<?= $tipo_consulta == 'ex' ? 'aprovar' : 'consultar'; ?>">
                <input type="submit" value="<?=$tipo_consulta == 'ex' ? 'Salvar' : 'Consultar'; ?>" class="btn btn-primary">
                    <a href="?pg=12&redirect=on&id=" class="btn btn-info ">Voltar</a>
                    <?php
                    if (isset($redirect) && $redirect == 'on') {
                        echo "<a href=\"index.php?pg=19&id={$id_captacao}\" class=\"btn btn-info \">Voltar</a>";
                    }
                    ?>
            </div>
        </form>
       <?php  } ?>
    </div>
</div>
<script type="text/javascript" language="javascript" src="modulos/captacao/public/js/frm_captacaoCliente.js"></script>