<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

define('MAIL_CHARSET', "iso-8859-1");
define('MAIL_SMTPAUTH', true);
define('MAIL_SMTPSECURE', 'ssl');
define('MAIL_HOST', 'smtp.seguidor.com.br');
define('MAIL_PORT', 587);
define('MAIL_USER_NAME', "seguidor@seguidor.com.br");
define('MAIL_PASSWORD', '33ftp666');





/**
 * Verifica se o dado esta vazio desconsiderando se for 0
 * @param string $dado
 * @return boolean
 */
function dadosVaziosDesconsiderandoZero($dado) {
    if (!is_numeric($dado) && empty($dado))
        return true;
    else
        return false;
}

/**
 * Formata data no padrão dd/mm/yyyy HH:MM:SS
 * @param unknown $data
 * @return string
 */
function formataDataComHora($data) {
    if ($data != "") {
        $data = explode(" ", $data);
        $date = $data [0];
        $hora = $data [1];
        $data = formataData($date);
        return $data . " " . $hora;
    } else
        return "";
}

/**
 * Formata data no padrão 
 * @param string $data
 * @return string
 */
function formataData($data) {
    if (!empty($data)) {
        $dataHora = explode(' ', $data);
        $dt = \explode('-', $dataHora [0]);
        return $dt [2] . "/" . $dt [1] . "/" . $dt [0];
    } else
        return "";
}

/**
 * Envia um email
 * @param array $DadosEmail
 * @param PHPMailer $PHPMailer
 * @return void|boolean
 */
function EnviarEmail(array $DadosEmail, PHPMailer $PHPMailer) {

    // die(var_dump($DadosEmail));
    $email = $PHPMailer;
    $email->IsSMTP(); // define que será usado SMTP:
    // Define os dados técnicos da Mensagem:
    $email->IsHTML(true);
    $email->CharSet = MAIL_CHARSET;
    $email->SMTPAuth = MAIL_SMTPAUTH; // Configurações do SMTP:
    // $email->SMTPSecure = MAIL_SMTPSECURE;
    $email->Host = MAIL_HOST;
    $email->Port = MAIL_PORT;
    $email->Username = MAIL_USER_NAME; // Usuário do servidor SMTP.
    $email->Password = MAIL_PASSWORD; // Senha do servidor SMTPmente
    $email->Subject = $DadosEmail ['asssunto']; // Define a mensagem (Assunto).
    // Define remetente:
    $email->From = $DadosEmail ['emailRementente'];
    $email->FromName = $DadosEmail ['remetente'];
    $email->AddReplyTo($DadosEmail ['emailResposta'], $DadosEmail ['nomeEmailResposta']); // Para quando responder, não vá para o email de autenticação.
    $email->AddAddress($DadosEmail ['emailDestino'], $DadosEmail ['nome']); // Define 0(s) destinatarios:
    $email->Body = $DadosEmail ['Body']; // corpo da mensagem:
    // corpo da mensagem em modo texto:
    $email->AltBody = $DadosEmail ['Body'];
    // anexa arquivo no corpo do email:
    if (!empty($DadosEmail ['nomeEpastaDoArquivoEmAnexo'])) {
        $email->AddAttachment($DadosEmail ['nomeEpastaDoArquivoEmAnexo']); // attachment
    }
    // Envia o e-mail:

    try {
        if (!$email->send())
            return var_dump($email->ErrorInfo);
        else
            return true;
    } catch (Exception $e) {
        
    }
}

/**
 * Pega o cumprimento adequado (Bom Dia, Boa Tarde, Boa Noite) de acordo com a hora do dia
 * @return Ambigous <NULL, string>
 */
function getCumprimento() {
    $periodo = null;
    $hora = date("H");

    if ($hora < 12 && $hora >= 6)
        $periodo = "Bom Dia";
    else if ($hora > 12 && $hora < 18)
        $periodo = "Boa Tarde";
    else
        $periodo = "Boa Noite";

    return $periodo;
}

/**
 * Retorna somente uma chave específica de um array
 * @param array $array
 * @param string $column_key
 * @param string $index_key
 * @return mixed|unknown
 */
function pegarChaveArray($array, $column_key, $index_key = null) {
    return array_reduce($array, function ($result, $item) use($column_key, $index_key) {
        if (null === $index_key) {
            $result [] = $item [$column_key];
        } else {
            $result [$item [$index_key]] = $item [$column_key];
        }

        return $result;
    }, []);
}

/**
 * Gera um log de cadastro
 * @param unknown $logs objeto que insere o log
 * @param unknown $acao acao do log
 * @param unknown $Dados os dados a serem salvos na descricao
 * @param unknown $nivel a tabela que da origem ao log
 * @param string $campos campos de descricao a serem alterados
 * @param string $textos textos de values a serem alterados
 */
function gerarLogCadastro($sessao, $logs, $acao, $Dados, $nivel, $campos = NULL, $textos = NUll) {

    date_default_timezone_set('America/Sao_Paulo');

    $id_usuario = $sessao->userdata("id_usuario") != null ? $sessao->userdata("id_usuario") : $Dados ['id'];

    $log ['log_identificacao'] = $Dados ['id'];
    $log ['log_usuario'] = $id_usuario;
    $log ['log_descricao'] = ucwords($acao);
    $log ['log_data'] = date("Y-m-d H:i:s");

    $texto = "";

    unset($Dados ['id']);

    if (!empty($Dados)) {
        foreach ($Dados as $k => $d) {
            $valor = isset($textos [$k]) ? $textos [$k] : $d;
            $descricao = isset($campos [$k]) ? $campos [$k] : limparCampoLog($k);
            $texto .= ucwords($descricao) . ": " . $valor . "\n";
        }
    }

    $log ['log_texto'] = $texto;
    $log ['log_nivel'] = $nivel;
    $logs->insert("log", $log);
}

/**
 * Gera log de alteracao
 * @param unknown $logs objeto que insere o log
 * @param unknown $acao acao do log
 * @param unknown $Dados os dados alterados a serem salvos na descricao
 * @param unknown $anterior os dados como eram antigamente
 * @param unknown $nivel a tabela que da origem ao log
 * @param string $status array que define quais campos são status
 * @param string $campos campos de descricao a serem alterados
 * @param string $textos textos de values a serem alterados
 * @param string $textoAdicional texto adicional a ser adicionado na descricao
 */
function gerarLogAlteracao($sessao, $logs, $acao, $Dados, $anterior, $nivel, $status = NULL, $campos = NULL, $textos = NUll, $textoAdicional = NULL) {

    date_default_timezone_set('America/Sao_Paulo');

    $id = $Dados ['id'];

    unset($Dados ['id']);

    $log ['log_identificacao'] = $id;
    $log ['log_usuario'] = $sessao->userdata("id_usuario");
    $log ['log_descricao'] = $acao;

    $data = date("Y-m-d H:i:s");

    $texto = "";

    foreach ($Dados as $k => $d) {

        $campo = isset($campos [$k]) ? $campos [$k] : limparCampoLog($k);
        $valor = isset($textos [$k]) ? $textos [$k] : $d;

        if ((!empty($d) && $d != $anterior [$k]) || (empty($d) && !empty($anterior [$k]))) {

            if (!empty($status) && in_array($k, $status)) {

                $l ['log_identificacao'] = $id;
                $l ['log_usuario'] = $sessao->userdata("id_usuario");
                $l ['log_descricao'] = "Alteração {$campo} da solicitação para {$valor}";
                $l ['log_data'] = $data;
                $l ['log_nivel'] = $nivel;
                $logs->insert($l);
            } else {
                $texto .= ucwords($campo) . ": " . $valor . "\n";
            }
        }
    }

    $log ['log_texto'] = $texto;
    $log ['log_data'] = $data;
    $log ['log_nivel'] = $nivel;

    if (!empty($texto)) {
        $logs->insert("log", $log);
    }
}

/**
 * Faz upload da imagem e redimensiona
 * @param string $destino
 * @param string $nome
 * @param int/string $largura
 * @param int/string $altura
 * @param string $pasta
 */
function UploadImg($destino, $nome, $largura, $altura, $pasta) {
    $img = imagecreatefromjpeg($destino);
    $x = imagesx($img);
    $y = imagesy($img);
    if (empty($altura))
        $altura = ($largura * $y) / $x;
    $novaImagem = imagecreatetruecolor($largura, $altura);
    imagecopyresampled($novaImagem, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
    imagejpeg($novaImagem, "$pasta/$nome");
    imagedestroy($img);
    imagedestroy($novaImagem);
}

/**
 * Faz upload do arquivo no servidor
 * @param unknown $ftp_server
 * @param unknown $ftp_username
 * @param unknown $ftp_userpass
 * @param unknown $nomeArquivo
 * @param unknown $caminhoArquivo
 */
function uploadArquivosServidor($ftp_server, $ftp_username, $ftp_userpass, $nomeArquivo, $caminhoArquivo) {
    $ftp_conn = @ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
    $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
    if (@ftp_put($ftp_conn, $nomeArquivo, $caminhoArquivo, FTP_BINARY))
        echo "Successfully uploaded file.";
    else
        echo "Error uploading file.";
    ftp_close($ftp_conn);
}

/**
 * FUNÇÃO QUE BUSCA UM VALOR NO ARRAY E RETORNA SUA POSIÇÃO
 * @param string $valor
 * @param array $array
 * @return posicao
 */
function arraySearch($valor, array $array) {
    $teste = false;
    foreach ($array as $k => $a) {
        if ($valor == $a) {
            $teste = true;
            return (string) $k;
            break;
        }
    }

    if (!$teste)
        return - 1;
}

/**
 * Função que gera um nome aleatorio
 * @param unknown $quantCaracteres
 * @return string
 */
function gerarNomeAleatorio($quantCaracteres) {
    $temp = substr(md5(uniqid(time())), 0, $quantCaracteres);
    return $temp;
}

/**
 * Método que carrega a configuração da paginação
 * @param unknown $url
 * @param unknown $total
 * @param unknown $porPagina
 * @param unknown $uri
 * @param array $variaveis variaveis get
 * @return string
 */
function configurarPaginacao($url, $total, $porPagina, $uri, $variaveis = null, $tab = null) {
    $config['base_url'] = base_url($url);
    $config['total_rows'] = $total;
    $config['per_page'] = $porPagina;
    $config["uri_segment"] = $uri;
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_link'] = '<<';
    $config['last_link'] = '>>';
    $config['next_link'] = '>';
    $config['prev_link'] = '<';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['prev_link'] = '&laquo';
    $config['prev_tag_open'] = '<li class="prev">';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = '&raquo';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $variaveis = !empty($variaveis) ? "?" . http_build_query($variaveis, '', "&") : "";
    $config['suffix'] = "/" . $variaveis . $tab;
    return $config;
}

/**
 * Mostra mensagem de nenhum registro encontrado
 */
function Nregistro() {
    echo '<div class="alert alert-warning"><span class="glyphicon  glyphicon-alert"></span>  Nenhum registro encontrado.</div>';
}

/**
 * Exporta html para excel
 * @param unknown $html
 * @param unknown $nome_arquivo
 */
function exportExel($html, $nome_arquivo) {
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment;filename=" . $nome_arquivo);
    header("Content-Transfer-Encoding: binary ");

    echo utf8_decode($html);
    exit();
}

/**
 * Desabilita campo se a acao for visualizar
 * @param unknown $acao
 * @return string
 */
function Disable($acao) {
    if (!empty($acao) && $acao == "visualizar")
        return "disabled";
}

/**
 * Converte um real para double
 * @param unknown $valor
 * @return mixed
 */
function converterParaDouble($valor) {
    $valor = str_replace('R$ ', '', $valor);
    $valor = str_replace('.', '', $valor);
    $valor = str_replace(',', '.', $valor);
    return $valor;
}

/**
 * Converte um double para numeros
 * @param unknown $valor
 */
function converterDouble($valor) {
    return str_replace(".", ",", $valor);
}

/**
 * Formata para o padrão SQL datas com hora
 * @param unknown $data
 * @return string
 */
function formataDataComHoraSQL($data) {
    $arrayData = explode(" ", $data);
    $date = $arrayData[0];
    $hora = $arrayData[1];

    return FormatadataSql($date) . " " . $hora;
}

/**
 * Formata a data para o padrão SQL
 * @param unknown $data
 * @return string
 */
function FormatadataSql($data) {
    $dataHora = explode(' ', $data);
    $data = explode('/', $dataHora [0]);
    if (!empty($data [2])) {
        $datanew = $data [2] . '-' . $data [1] . '-' . $data [0];
    } else {
        $datanew = "";
    }
    return $datanew;
}

/**
 * Muda cor da linha conforme status
 * @param unknown $status
 * @return string
 */
function colorirLinha($status) {
    $ret = '';

    if ($status == 0)
        $ret = 'style="background:#FFFFFF" text-align:center;';

    else if ($status == 1)
        $ret = 'style="background: rgb(174, 184, 255);" ';

    else if ($status == 2)
        $ret = 'style="background: rgb(218, 233, 255);" ';

    else if ($status == 3)
        $ret = 'style="background: rgb(255, 179, 126);"';

    else if ($status == 4)
        $ret = 'style="background:rgb(255, 242, 181);" ';

    else if ($status == 5)
        $ret = 'style="background: rgb(167, 204, 166);"';

    else if ($status == 6)
        $ret = 'style="background:#D3D3D3;"';

    else if ($status == 7)
        $ret = 'style="background:rgb(204, 126, 129);"';

    return $ret;
}

/**
 * Exibe mensagem de alerta
 * @param array $dados
 * @return string
 */
function tratarMensagem(array $dados) {
    if (isset($dados)) {
        switch ($dados['tipo']) {
            case 'alert-success': $classe = 'alert-success';
                $mensagem = $dados['mensagem'];
                break;
            case 'alert-info': $classe = 'alert-info';
                $mensagem = $dados['mensagem'];
                break;
            case 'alert-warning': $classe = 'alert-warning';
                $mensagem = $dados['mensagem'];
                break;
            case 'alert-danger': $classe = 'alert-danger';
                $mensagem = $dados['mensagem'];
                break;
        }
        $html = '<div class="alert ' . $classe . '" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span>  ' . $mensagem . '</div>';
    }
    return $html;
}

/**
 * Gera um pdf para anexar
 * @param unknown $nomeDoArquivo
 * @param unknown $html
 * @param unknown $tipo
 * @param DOMPDF $dompdf
 * @param unknown $pastaDestino
 * @return boolean
 */
function geraPDF($nomeDoArquivo, $html, $tipo, DOMPDF $dompdf, $pastaDestino) {
    $dompdf = $dompdf; // objeto - DOMPDF.
    // Altera o papel para modo paisagem.
    if ($tipo == "L") :
        $dompdf->set_paper("481x680", "landscape");


    endif;
    // Carrega o HTML para a classe.
    $dompdf->load_html(utf8_decode($html));
    $dompdf->render();
    $pdf = $dompdf->output(); // Cria o pdf.
    // Tenta salvar o pdf gerado.
    $arquivo = $pastaDestino;
    if (file_put_contents($arquivo, $pdf)) :
        // Salvo com sucesso.
        return true;
    else :
        // Erro ao salvar o arquivo.
        return false;
    endif;
}

/**
 * Faz upload de um arquivo
 * @param unknown $caminho
 * @param unknown $nome
 * @param unknown $destino
 * @return boolean
 */
function UploadArquivos($caminho, $nome, $destino) {
    $tempFile = $caminho;
    $targetFile = $destino . $nome;

    if (!file_exists($destino)) :
        mkdir($destino, 0744, true);
    endif;

    if (move_uploaded_file($tempFile, $targetFile)) :
        return true;
    else :
        return false;
    endif;
}

/**
 * Retorna string com todas as variaveis get
 * @param unknown $Array
 * @return string
 */
function getParametrosURL($Array) {
    $url = '';

    unset($Array['pag']);

    if (sizeof($Array) >= 1) {

        foreach ($Array as $k => $a) {
            $url .= "&{$k}={$a}";
        }
    }

    return $url;
}

/**
 * Limpar nomes tabelas do log
 * @param unknown $str
 * @return mixed
 */
function limparCampoLog($str) {
    $tabelas = array("pcf_", "pedido_comissao_", "_cliente", "chip_", "credenciado_", "veiculos_equipamentos_", "veiculos_os_", "contato_", "captacao_");

    foreach ($tabelas as $t) {
        $str = str_replace($t, "", $str);
    }

    return str_replace("_", " ", trim($str));
}

/**
 * Pegar datas do período da planilha
 * @param unknown $periodo
 * @param unknown $ano
 * @return string
 */
function pegarDatasPeriodoPlanilha($periodo, $ano) {

    $json_file = file_get_contents(base_url("assets/pedidoComissao/periodos.json"));
    $periodos = json_decode($json_file, true);

    $pcfPeriodo = str_replace(" ", "", $periodo);

    $mesInicial = (int) $periodos[explode("/", $pcfPeriodo)[0]] + 1;
    $mesFinal = (int) $periodos[explode("/", $pcfPeriodo)[1]] + 1;

    $mesInicial = strlen($mesInicial) == 1 ? "0" . $mesInicial : $mesInicial;
    $mesFinal = strlen($mesFinal) == 1 ? "0" . $mesFinal : $mesFinal;

    $anoFinal = $mesInicial == 12 && $mesFinal == 01 ? $ano + 1 : $ano;

    $datas['dataInicial'] = $ano . "-" . $mesInicial . "-01";

    $datas['dataFinal'] = $anoFinal . "-" . $mesFinal . "-21";

    return $datas;
}

/**
 * Formata um telefone
 * @param unknown $fone
 * @return mixed
 */
function trataTelefone($fone) {
    $array = array(
        '(',
        ')',
        '-',
        ' '
    );
    return str_replace($array, "", $fone);
}

/**
 * Envia um SMS
 * @param unknown $dados
 * @param unknown $sms
 * @param HumanMultipleSend $humanMultipleSend
 */
function enviaSMS($dados, $sms, HumanMultipleSend $humanMultipleSend) {
    $telefone = (!empty($dados ['telefone'])) ? $dados ['telefone'] : null;
    $telefone = preg_replace("/[^0-9]/", "", $telefone);
    $id_captacao = (!empty($dados ['id_captacao'])) ? $dados ['id_captacao'] : null;
    $mensagem = (!empty($dados ['mensagem'])) ? $dados ['mensagem'] : null;

    $exp_regular = '/^[0-9]{2}[0-9]{4}[0-9]{4}$/';

    // VERIFICA SE O TELEFONE Ã‰ UM CELULAR:
    if (preg_match($exp_regular, $telefone)) {
        $sms_fone = '55' . trataTelefone($telefone);
        // REGISTRAR O SMS NO BANCO :
        if ($id_captacao > 0)
            $sms->insert("sms", array('sms_id_captacao' => $id_captacao));
        else
            $sms->insert("sms", array('sms_desc' => "'outros'"));

        $id_sms = $sms->ultimoId();
        $sms_msg = $mensagem;
        $msg_list = $sms_fone . ";" . $sms_msg . ";" . $id_sms;
        $response = $humanMultipleSend->sendMultipleList(HumanMultipleSend::TYPE_C, $msg_list);
        //AUTENTICAÃ‡ÃƒO COM A API
        //foreach ($response as $resp) {
        //echo $resp->getCode() . " - " . $resp->getMessage() . "<br />";
        //}
    }
}

/**
 * Verifica se os campos do contrato estão liberados para edição
 * @param unknown $campos
 * @param unknown $campo
 * @return string
 */
function verificarCamposContratoCliente($campos, $campo) {

    $value = "disabled";

    if (in_array($campo, pegarChaveArray($campos, "campos_contrato_name")))
        $value = "";

    return $value;
}

/**
 * Salva a a imagem com um nome aleatório em uma pasta
 */
function subirImagem($imagem, $pasta) {

    // var_dump($imagem, $pasta); DIE;

    $nome = isset($imagem ['name']) ? $imagem ['name'] : '';
    $caminho = isset($imagem ['tmp_name']) ? $imagem ['tmp_name'] : ''; // onde fica armazenado temporario
    preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $nome, $ext); // Pega extensão da imagem
    $nome_imagem = gerarNomeAleatorio(10) . "." . $ext [1]; // Gera um nome único para a imagem
    UploadArquivos($caminho, $nome_imagem, $pasta);
    return $nome_imagem;
}

/**
 * Prepara os dados necessários para montar o menu
 * @param unknown $obj
 * @param unknown $usuario
 * @return NULL
 */
function selectControllerAcaoUrl($obj, $usuario) {
    $url = $obj->router->fetch_class() . "/" . $obj->router->fetch_method();
    $result = $usuario->verificarAcessoArea($obj->session->userdata("grupo"), $url);

    if (!$obj->session->userdata('id_usuario') != null)
        redirect(base_url('Login'));

    if (empty($result) && $obj->router->fetch_method() != "index" && !strpos($obj->router->fetch_method(), "modal") === false)
        redirect(base_url('CL_view_Usuario'));

    $data_array['permissoes'] = null;

    if (!empty($result)) {
        $usuario->selectPermissoesArea($result->aux_mag_id);
        $data_array['permissoes'] = $usuario->getResultArray();
    }

    $usuario->selectDescricaoModulosGrupo($obj->session->userdata("grupo"));
    $data_array['modulos'] = $usuario->getResult();
    $data_array['usuario'] = $usuario;

    return $data_array;
}
