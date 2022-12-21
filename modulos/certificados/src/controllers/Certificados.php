<?php
/**
 * Created by PhpStorm.
 * User: desenvolvimento02
 * Date: 06/11/2017
 * Time: 10:28
 */

// FORÇA A INCLUSÃO DO ARQUIVO Config.inc.php PARA FAZER AUTOLOAD DE CLASSES E ETC, FUNCINAL......
if (file_exists('../../../../Config.inc.php')) {
    include_once '../../../../Config.inc.php';
}
$certificados = new Certificados;

$viewsPath = 'modulos/certificados/src/views/';
$acao = $_REQUEST['acao'];


switch ($acao) {
    case 'listar':
        // 1 - BUSCAR TODOS OS CERTIFICADOS E OS PORCESSA PARA TRANSFORMAR EM TABELA
        $certificadosTabela = $certificados->gerarTabela($certificados->procurar());
        // 2 - CRIA UM ALERT VAZIO E DEPENDENDO DO GET STATUS QUE ELE TRAZER RETORNA UM ALERT DIFERENTE
		
		$alert = "";
        if (isset($_REQUEST['status'])) {
		
		//var_dump($_REQUEST['status']); die;
		
            switch ($_REQUEST['status']) {
                case 'succesUpdate':
                    $alert = "
                        <div class=\"alert alert-success\" role=\"alert\">
                            <strong>Tudo certo!</strong> Certificado alterado com sucesso. 
                        </div>
                    ";
                    break;
                case 'successDelete':
                    $alert = "
                        <div class=\"alert alert-success\" role=\"alert\">
                            <strong>Tudo certo!</strong> Certificado deletado com sucesso. 
                        </div>
                    ";
                    break;
                case 'successInsert':
                    $alert = "
                        <div class=\"alert alert-success\" role=\"alert\">
                            <strong>Tudo certo!</strong> Certificado Inserido. 
                        </div>
                    ";
                    break;
                case 'successSendEmail':
                    $alert = "
                        <div class=\"alert alert-success\" role=\"alert\">
                            <strong>Tudo certo!</strong> Email enviado com sucesso. 
                        </div>
                    ";
                    break;
            }
        }
        // 3 - INCLUI O FORMULARIO COM SEUS DADOS JÁ PROCESSADOS
        include_once $viewsPath . 'listas/listar.php';
        // 4 - INCLUI O MODAL DE ENVIAR EMAIL
        include_once $viewsPath . 'modals/enviarEmail.php';
        break;
    case 'formulario':
        // 1 - SETA VALOR PADRAO DO ID
        $certificado = null;
        // 2 - VERIFICA SE O $_GET['id'] É NULO, SE NÃO FOR, BUSCA O CERTIFICADO CORRESPONDENTE AO ID
        if (isset($_GET['id'])) {
            $certificado = $certificados->procurar($_GET['id']);
        }
        // 3 - RETORNA O FORMULARIO
        $certificadosFormulario = $certificados->gerarFormulario($certificado, $_REQUEST['tipo']);
        // 5 - ADICIONA UM CERTIFICADO NOVO
        include_once $viewsPath . 'formularios/formulario.php';
        // 6 - ADICIONA MODAL DE EXCLUSAO
        include_once $viewsPath . 'modals/confirmarExclusao.php';
        break;
    case 'inserir':
        // 1 - CRIA ARRAY DO NOVO CERTIFICADO COM OS PAREMETROS NECESSARIOS
        $certificadosArray = $_REQUEST['certificado'];
        $certificadosArray['arquivo'] = $_FILES['arquivo'];
        $certificadosArray['arquivo']['urlArquivo_old'] = $_REQUEST['certificado']['urlArquivo'];
        // 2 - FAZ O UPDATE DO CERTIFICADO
        if ($certificados->inserir($certificadosArray)) {
            header("location:" . BASE_URL . "/gpi/index.php?pg=54&acao=listar&status=successInsert");
        }
        break;
    case 'editar':
        // 1 - CRIA ARRAY DO NOVO CERTIFICADO COM OS PAREMETROS NECESSARIOS
        $certificadosArray = $_REQUEST['certificado'];
        $certificadosArray['arquivo'] = $_FILES['arquivo'];
        $certificadosArray['arquivo']['urlArquivo_old'] = $_REQUEST['certificado']['urlArquivo'];
        // 2 - FAZ O UPDATE DO CERTIFICADO
        if ($certificados->inserir($certificadosArray)) {
            header("location:" . BASE_URL . "/gpi/index.php?pg=54&acao=listar&status=succesUpdate");
        }
        break;
    case 'remove':
        if ($certificados->deletar($_REQUEST['id_certificado'], $_REQUEST['urlArquivo'])) {
            header("location:" . BASE_URL . "/gpi/index.php?pg=54&acao=listar&status=successDelete");
        }
        break;
    case 'verificarExpiracao':
        // 1 - ENVIA EMAIL PARA O ADMINISTRADOR INFORMANDO OS CERTIFICADOS EXPIRADOS
        $certificadosArray = $certificados->enviarEmailCertificadosExpirados($certificados->procurar());
        break;
    case 'enviarEmailArquivo':
            if ($certificados->enviarEmailFormulario($_POST['email'])) {
            header("location:" . BASE_URL . "/gpi/index.php?pg=54&acao=listar&status=successSendEmail");
        }
        break;
}

