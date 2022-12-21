<?php
header('Content-Type: text/html; charset=utf-8');
include_once("../../../../Config.inc.php");
$path__MIDIAS_proposta = '../../../../../_MIDIAS_/proposta/';
$objeto_captacao = new Captacao;
$funcoes = new Funcoes;
$phpmailer = new PHPMailer;
$objeto_proposta = new Proposta;
$objeto_usuario = new Usuarios;

session_start();

    $id_proposta = filter_input(INPUT_POST, 'id_proposta', FILTER_VALIDATE_INT);
    $id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
    $id_captacao = filter_input(INPUT_POST, 'id_captacao', FILTER_VALIDATE_INT);
    $tipoFolha = "P"; // P = Retrato | L = Paisagem.
    $emails = filter_input(INPUT_POST, "email");
    $acao = isset($_POST['acao'])?$_POST['acao']:null;
if(!$acao){
    die('<b>Você não tem autorização! </b></br>Falta requisição <b>POST</b>');
}
$cliente = $objeto_captacao->selCliente($id_captacao); //busca o nome do cliente
$ddd = substr($cliente['ddd'], 0, 4);
$ddd = str_replace(')', '', str_replace('(', '', $ddd)); # Formatat o ddd :
if (empty($ddd)) {
    $ddd = 51;
}
//ASSINATURA DIGITAL DO USUARIO:
$assinaturaDigital = $objeto_usuario->selecionarAssinaturaEmail($id_usuario, $ddd);
//VALIDACOES :
if(!isset($assinaturaDigital['1']['regiao_ddd'])){
    die("Favor verifique o DDD do Cliente!");
}
if(empty($assinaturaDigital[0]['assinaturaEmail'])){
    die("Favor verifique o Assinatura  do Email! <br> Suporte : 530");
}
if (!isset($assinaturaDigital[0]['nome'])) {
    die(json_encode(array("type" => "erro")));
}
# - FUNÇÃO QUE GERA O PDF E GUARDA NA PASTA ( ../fpdf/proposta/arquivos_pdf/nomeArquivo).
function geraPDF($titulo, $html, $tipo = "P") {
    $path__MIDIAS_proposta = '../../../../../_MIDIAS_/proposta/';
   
    $dompdf = new DOMPDF();
    if ($tipo == "L") {
        $dompdf->set_paper("481x680", "landscape");
    }
 
    $html = preg_replace('/>\s+</', '><', $html);
    $html = stripslashes($html);
    $html = utf8_decode($html);
    $dompdf->load_html($html);
    $dompdf->render();
    $pdf = $dompdf->output();
    $arquivo = $path__MIDIAS_proposta . $titulo;
    if (file_put_contents($arquivo, $pdf)) {
        return true; // Salvo com sucesso.
    } else {
        return false; // Erro ao salvar o arquivo.
    }
}
$veiculos = $objeto_proposta->selVeiculos($id_proposta); //busca os veiculos cadastrados.
$total_txInstalacao = $objeto_proposta->selectTotalTInst($id_proposta); //busca o tatal taxa de habilitação.
$TotalMensal = $objeto_proposta->selectTotalMensal($id_proposta); //busca o tatal mensal.
$tipo_proposta = $objeto_proposta->selectProposta($id_proposta); 
$_tipo_proposta = "ouro";
$_body = null;

$nomeDoArquivo = "codigo_" . $cliente['id_captacao'] . ".pdf";
# - condição pra buscar o cartao de visita do usuario com permissao vendedor.
$where = array(
    'id_usuario' => $id_usuario,
    'tipo_proposta' =>  "ouro"
);
$_senha = "02p1cmunj";
# TRECHO DE CÓDIGO QUE GERA O HTML DO DOCUMENTO PDF
include_once('../../../../application/views/layouts/enviar_proposta/tabelaProposta.php');
# SE O 'PDF' FOR CRIADO UM EMAIL DEVERÁ SER ENVIADO PRO CLIENTE COM O PDF EM ANEXO.
include_once("../../../../fpdf/dompdf/dompdf_config.inc.php");


if (geraPDF($nomeDoArquivo, $html, $tipoFolha)) {
    # atribui os emaisl no fim do array de emails:
    # objeto - CaptacaoEmails.
    $objeto_captacao->insertCaptacaoEmail(
		array(
			'email' => "'$emails'",
			'emails_id_proposta' => $id_proposta,
			'email_status' => 1
		)
    );
	
	//verica se o cadastro está atualizado.
	if(
		empty($assinaturaDigital[0]['nome']) || 
		empty($assinaturaDigital[0]['usuario']) ||
		empty($assinaturaDigital[0]['assinatura']) ||
		empty($assinaturaDigital[0]['usuario_email']) ||
		empty($assinaturaDigital[0]['assinaturaEmail'])		
	){
		$arrai_list_dados = [
			'nome'=>$assinaturaDigital[0]['nome'],
			'usuario'=>$assinaturaDigital[0]['usuario'],
			'assinatura'=>$assinaturaDigital[0]['assinatura'],
			'usuario_email'=>$assinaturaDigital[0]['usuario_email'],
			'assinaturaEmail'=>$assinaturaDigital[0]['assinaturaEmail'],
		];
			
		die(
			json_encode(
				array(
					"type" => 'faill_data',
					"data" => $arrai_list_dados
				)
			)
		);
	}
	
	
	#Corpo do email:
	
    $msgCliente = ' 
    <p style="font-family:Arial; font-size:16px; margin:0;">Ol&aacute;,</p>
    <p style="font-family:Arial; font-size:16px; margin:0;">A Volpato Rastreamento &eacute; certificada pelo CESVI Brasil, &oacute;rg&atilde;o que atesta e garante servi&ccedil;os de qualidade em Rastreamento Veicular.</p>
    <p style="font-family:Arial; font-size:16px; margin:0;">Conforme falamos, segue em anexo uma breve apresenta&ccedil;&atilde;o de nossa empresa e servi&ccedil;os.</p>
    <p style="font-family:Arial; font-size:16px; margin:0;">&nbsp;</p>
    <p style="font-family:Arial; font-size:16px; margin:0;">Fa&ccedil;a um web-test em nosso sistema atrav&eacute;s de Login e Senha de demonstra&ccedil;&atilde;o:</p>
    <p style="font-family:Arial; font-size:16px; margin:0;"><strong>Site:</strong> <a href="http://www.volpato.net.br">volpato.net.br</a></p>
    <p style="font-family:Arial; font-size:16px; margin:0;"><strong>Usu&aacute;rio:</strong> ' . $_tipo_proposta . '</p>
    <p style="font-family:Arial; font-size:16px; margin:0;"><strong>Senha:</strong> ' . $_tipo_proposta . '</p>
    <p style="font-family:Arial; font-size:16px; margin:0;">&nbsp;</p>
    <p style="font-family:Arial; font-size:16px; margin:0;">Baixe nosso App:</p>
    <p>
        <a href="https://play.google.com/store/apps/details?id=br.com.volpato.rastreamento&hl=pt_BR" >
            <img src="https://seguidor.com.br/assinaturaEmail/googleplay.jpg"   alt="Verssão Adroid" />
        </a>
        <a href="https://itunes.apple.com/br/app/volpato-rastreamento/id1236834132?mt=8&ign-mpt=uo%3D4" >
            <img src="https://seguidor.com.br/assinaturaEmail/ios.jpg" alt="Verssão IOS"  />
        </a>
    </p>
    <p style="font-family:Arial; font-size:16px; margin:0;"><strong>Usu&aacute;rio:</strong> ouro</p>
    <p style="font-family:Arial; font-size:16px; margin:0;"><strong>Senha:</strong>ouro</p>
    <p style="font-family:Arial; font-size:22px; color:#F00; font-weight:bold">Promo&ccedil;&atilde;o por tempo limitado, n&atilde;o perca esta oportunidade!</p>
    <p style="font-family:Arial; font-size:16px; margin:0;">Garantimos a melhor negocia&ccedil;&atilde;o do mercado.</p>
    <p style="font-family:Arial; font-size:16px; margin:0;">Volpato. Sua seguran&ccedil;a garantida.</p>
    <p style="font-family:Arial; font-size:16px; margin:0;">&nbsp;</p>
    <p style="font-family:Arial; font-size:16px; margin:0;">&nbsp;</p>
    <table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table border="0"  cellpadding="0" cellspacing="0" style="background:#FFF; margin:0">
                    <tr>
                        <td rowspan="3">
                           <img src="https://seguidor.com.br/assinaturaEmail/' . $assinaturaDigital [0] ['assinaturaEmail'] . '" style="position:absolute; top:510px; left:40px;" />
                        </td>
                    </tr>
                    <tr>
                        <td valign="bottom">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>';
		
    $DadosEmail ['asssunto'] = "PROPOSTA COMERCIAL";
    $DadosEmail ['emailRementente'] = $assinaturaDigital [0] ['usuario_email'];
    $DadosEmail ['remetente'] = 'Grupo Volpato';
    $DadosEmail ['emailDestino'] = $emails;
    $DadosEmail ['nome'] = $assinaturaDigital [0] ['nome'];
    $DadosEmail ['emailResposta'] = $assinaturaDigital [0] ['usuario_email'];
    $DadosEmail ['nomeEmailResposta'] = "GRUPO VOLPATO";
    $DadosEmail ['Body'] = $msgCliente;
    $DadosEmail ['nomeEpastaDoArquivoEmAnexo'] = $path__MIDIAS_proposta . $nomeDoArquivo;
 
	/*
		SEMPRE QUE UMA PROPOSTA FOR ENVIADA ,
		O SISTEMA TEM QUE ATUALIZAR O STATUS DA CAPTACAO POR  :  enviado
	*/
    if (($funcoes->EnviarEmail($DadosEmail, $phpmailer))) {
        $objeto_captacao->updateCaptacao(array('captacao_id' => $cliente['id_captacao'], 'captacao_status' => 'enviado'));
		
		die(
			json_encode(
				array("type" =>1)
			)
		);
    }else{
		die(
			json_encode(
				array("type" =>'faill')
			)
		);
    }
  }