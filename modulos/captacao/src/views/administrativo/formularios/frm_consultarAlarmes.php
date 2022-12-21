<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div class="bg_corpo">
    <div class="box">
        <form method="post" name="frmRelatorio_captacao"
              id="frmRelatorio_captacao">
            <fieldset style="width: 92%; margin: 10px 0 10px 30px">
                <legend>
                    <h1>Consultar Alarmes</h1>
                </legend>
                <table width="100%" border="0" cellpadding="5" cellspacing="10">
                    <tr>
                        <td width="53%">
                            <div class="_radio_">
                                <input type="radio" id="radio1" name="radio" checked="checked"
                                       value="f"> <label for="radio1">Fisica</label> <input
                                       type="radio" id="radio2" name="radio" value="j"><label
                                       for="radio2">Jurídica</label>
                            </div>
                        </td>
                        <td width="47%" align="right"><strong>Usuario:</strong><br /> <select
                                name="id__" id="id__" class="inputWidth3">
                                <option value="0" selected="selected">selecione um usuario</option>
                                <?php
                                $usuario = new Usuarios ();
                                $lista_usuarios = $usuario->selUser('vendas');
                                if ($lista_usuarios) :
                                    foreach ($lista_usuarios as $li) :
                                        $usuario_id = !empty($li ['usuario_id']) ? $li ['usuario_id'] : NULL;
                                        $usuario_nome = !empty($li ['usuario_nome']) ? $li ['usuario_nome'] : NULL;
                                        echo ' <option value="' . $usuario_id . '">' . $usuario_nome . '</option>';
                                    endforeach
                                    ;

                                endif;
                                ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="_radio_">
                                <input type="radio" id="radio3" name="radioApRp"
                                       class="radio_AprovaReprova" checked="checked" value="aprovado">
                                <label for="radio3">Aprovado</label> <input type="radio"
                                                                            id="radio4" name="radioApRp" class="radio_AprovaReprova"
                                                                            value="reprovado"><label for="radio4">Reprovado</label>
                            </div>
                        </td>
                        <td align="right">
                            <div class="sel_campo" id="boxMotivoReprovacao">
                                <strong>Motivo Reprovado :</strong><br /> <select
                                    name="m_reprovado" id="m_reprovado"
                                    class="inputWidth3 m_reprovarConsultaSPC">
                                    <option value="">::SELECIONE::</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><span id="title_nome"> Nome :</span> <span id="razaoSocial"
                                                                       class="sel_campo"> Razão Social </span> <br />
                            <input type="text" name="nome" id="nome" style="width: 400px"></td>
                        <td align="right">
                            <div id="cpf" class="">
                                CPF :<br />
                                <input type="text" name="txt_cpf" id="txt_cpf" maxlength="9"
                                       class="mask_cpf inputWidth3">
                            </div>
                            <div id="cnpj" class="sel_campo">
                                CNPJ:<br /> <input type="text" name="txt_cnpj" id="txt_cnpj"
                                                   maxlength="14" class="mask_cnpj inputWidth3">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="javaScript:void(0)"
                               id="btn_aprovar_cliente_do_alarmes" class="btn_ui">Salvar</a></td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>
</div>