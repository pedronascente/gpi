<form id="formBuscarRamal" method="post" action="?pg=11">
    <ui id="form-busca-ramal" class="_panel">
        <li>
            <h1>
                <a href="index.php?pg=11&acao=listarRamais"> Lista de Ramais </a>
            </h1>
        </li>
        <li><input type="text" name="usuarioRamal" placeholder="Seu nome"
                   value="" required></li>
        <li><input type="hidden" name="acao" value="buscarRamal"> <input
                type="image" class="image" id="id-busca-ramal"
                src="modulos/ramal/public/img/botao_busca.png" width="30" height="29"
                border="0" style="border: 0"></li>
        <li>
            <?php if (in_array(array('tipo_permissao' => 'admin'), $_SESSION ['user_info'] ['permissoes']) || in_array(array('tipo_permissao' => 'recepcao'), $_SESSION ['user_info'] ['permissoes'])): ?>
                <a id="490//Formulario de Ramal//1//modulos/ramal/src/views/formularios/form.php?acao=inserir" class="dialogAction"> Cadastrar ramal </a>
            <?php endif; ?>
        </li>
    </ui>
</form>