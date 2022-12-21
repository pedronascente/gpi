<?php

class Funcoes
{

    private $enviarEmail;

    static public function moeda($get_valor)
    {
        $source = array(
            '.',
            ','
        );
        $replace = array(
            '',
            '.'
        );
        $valor = str_replace($source, $replace, $get_valor); // remove os pontos e substitui a virgula pelo ponto
        return $valor; // retorna o valor formatado para gravar no banco
    }


     static public function formataMoedaSql($get_valor)
    {
        
        $source = array(
            '.',
            ','
        );
        $replace = array(
            '',
            '.'
        );
        $valor = str_replace($source, $replace, $get_valor);

        $valor = str_replace('R$ ', '', $valor);
        
        return $valor;
    }

    static public function removerCodigoMalicioso($comSeguranca)
    {
        $comSeguranca = addslashes($comSeguranca);
        $comSeguranca = htmlspecialchars($comSeguranca);
        $comSeguranca = str_replace("SELECT", "", $comSeguranca);
        $comSeguranca = str_replace("FROM", "", $comSeguranca);
        $comSeguranca = str_replace("WHERE", "", $comSeguranca);
        $comSeguranca = str_replace("INSERT", "", $comSeguranca);
        $comSeguranca = str_replace("UPDATE", "", $comSeguranca);
        $comSeguranca = str_replace("DELETE", "", $comSeguranca);
        $comSeguranca = str_replace("DROP", "", $comSeguranca);
        $comSeguranca = str_replace("DATABASE", "", $comSeguranca);
        $comSeguranca = str_replace("'", " ", $comSeguranca);
        return $comSeguranca;
    }

    static public function limparString($string)
    {

        // Converte todos os caracteres para minusculo
        $string = strtolower($string);
        // Remove os acentos
        $string = str_replace('[aáàãâä]', 'a', $string);
        $string = str_replace('[eéèêë]', 'e', $string);
        $string = str_replace('[iíìîï]', 'i', $string);
        $string = str_replace('[oóòõôö]', 'o', $string);
        $string = str_replace('[uúùûü]', 'u', $string);
        // Remove o cedilha e o ñ
        $string = str_replace('[ç]', 'c', $string);
        $string = str_replace('[ñ]', 'n', $string);
        // Substitui os espaços em brancos por underline
        $string = str_replace('-', '', $string);
        // Remove hifens duplos
        $string = str_replace('--', '_', $string);
        $string = str_replace('/', '', $string);
        $string = str_replace('(', '', $string);
        $string = str_replace(')', '', $string);
        $string = str_replace('-', '', $string);
        $string = str_replace("'", '', $string);
        return $string;
    }

    static function printrx($variavel)
    {
        echo "<pre>";
        die(print_r($variavel));
    }

    static public function UploadImg($destino, $nome, $largura, $altura, $pasta)
    {
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

    // converter maiuscula e minuscula: 1=M 0=m
    static function convertem($term, $tp)
    {
        if ($tp == "1")
            $palavra = strtr(strtoupper($term), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
        elseif ($tp == "0")
            $palavra = strtr(strtolower($term), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß", "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
        return $palavra;
    }

    static public function UploadArquivos($caminho, $nome, $destino)
    {
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

    static public function calcHora($hora1)
    {
        date_default_timezone_set('Brazil/East');
        $entrada = $hora1;
        $saida = date('H:i:s');
        // die(print_r($entrada));
        $hora1 = explode(":", $entrada);
        $hora2 = explode(":", $saida);
        // die(print_r($hora1));
        @$acumulador1 = ($hora1 [0] * 3600) + ($hora1 [1] * 60) + $hora1 [2];
        @$acumulador2 = ($hora2 [0] * 3600) + ($hora2 [1] * 60) + $hora2 [2];
        $resultado = $acumulador2 - $acumulador1;
        $hora_ponto = floor($resultado / 3600);
        $resultado = $resultado - ($hora_ponto * 3600);
        $min_ponto = floor($resultado / 60);
        $resultado = $resultado - ($min_ponto * 60);
        $secs_ponto = $resultado;
        $hora_total = $hora_ponto . ":" . $min_ponto . ":" . $secs_ponto;
        return $hora_total;
    }

    // formata hora:
    static public function formataHora($hora)
    {
        $dataHora = explode(' ', $hora);
        return $dataHora [1];
    }

    // formata data:
    static public function formataData($data)
    {
        $dataHora = explode(' ', $data);
        $dt = \explode('-', $dataHora [0]);
        return $dt[2] . "/" . $dt[1] . "/" . $dt[0];
    }

    // formata data e a hora:
    static public function DataHora($data, $hora)
    {
        return self::formataData($data) . '-' . self::formataHora($hora);
    }

    static public function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
    {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';
        $caracteres .= $lmin;
        if ($maiusculas) {
            $caracteres .= $lmai;
        }
        if ($numeros) {
            $caracteres .= $num;
        }
        if ($simbolos) {
            $caracteres .= $simb;
        }
        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres [$rand - 1];
        }
        return $retorno;
    }

    static public function FormatadataHora($data)
    {
        date_default_timezone_set('Brazil/East');
        $array_data = explode("/", $data);
        $dh = $array_data [2] . '-' . $array_data [1] . '-' . $array_data [0];
        return $dh .= ' ' . date('H:i:s');
    }

    // FUNÇÃO FORMATA DATA PADRAO AMERICANO ATUALIZADO EM 05/11/2013 -JOAO LUCAS
    static public function FormatadataSql($data)
    {
        $dataHora = explode(' ', $data);
        $data = explode('/', $dataHora [0]);
        if (!empty($data [2])) {
            $datanew = $data [2] . '-' . $data [1] . '-' . $data [0];
        } else {
            $datanew = "";
        }
        return $datanew;
    }

    // função que identifica o navegador Atual
    static public function buscaNavegador()
    {
        $useragent = $_SERVER ['HTTP_USER_AGENT'];
        if (preg_match('|MSIE ([0-9].[0-9]{1,2})|', $useragent, $matched)) {
            $browser_version = $matched [1];
            $browser = 'IE';
        } elseif (preg_match('|Opera/([0-9].[0-9]{1,2})|', $useragent, $matched)) {
            $browser_version = $matched [1];
            $browser = 'Opera';
        } elseif (preg_match('|Firefox/([0-9\.]+)|', $useragent, $matched)) {
            $browser_version = $matched [1];
            $browser = 'Firefox';
        } elseif (preg_match('|Chrome/([0-9\.]+)|', $useragent, $matched)) {
            $browser_version = $matched [1];
            $browser = 'Chrome';
        } elseif (preg_match('|Safari/([0-9\.]+)|', $useragent, $matched)) {
            $browser_version = $matched [1];
            $browser = 'Safari';
        } else {
            // browser not recognized!
            $browser_version = 0;
            $browser = 'other';
        }
        // print "browser: $browser $browser_version";
        return $browser;
    }

    static public function utf8($lista)
    {
        return array_map('utf8_encode', $lista);
    }

    static public function formartaMoedaReal($valor)
    {
        return number_format($valor, 2, ',', '.');
    }

    // exportar excel:
    static public function exportExel($html, $nome_arquivo)
    {
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

    static public function trataTelefone($fone)
    {
        $array = array(
            '(',
            ')',
            '-',
            ' '
        );
        return str_replace($array, "", $fone);
    }

    static public function addCaracter($var, $caracter = '<br>', $lim = '30')
    {
        $tamanho = strlen($var);
        $nova = null;
        if ($tamanho > $lim) {
            $quebra = $tamanho / $lim;
            $ini = 0;
            $fim = $lim;
            for ($i = 0; $i <= intval($quebra); $i++) {
                if ($i == intval($quebra))
                    $nova .= substr($var, $ini, $lim);
                else
                    $nova .= substr($var, $ini, $lim) . $caracter;
                $ini = $fim;
                $fim = $fim + $lim;
            }
            return $nova;
        } else {
            return $var;
        }
    }

    static public function Disable($acao)
    {
        if (!empty($acao) && $acao == "visualizar")
            return "disabled";
    }

    static public function zebrarTR($k)
    {
        if ($k % 2 == 0) :
            $ret = 'style="background:#FFFFFF" ';
        else :
            $ret = 'style="background:#CED1FF" ';
        endif;
        return $ret;
    }

    /*
     * *************************************************
     * ********* RESPONSAVEL POR ENVIAR EMAIL **********
     * *************************************************
     */

    static public function EnviarEmail(array $DadosEmail, PHPMailer $PHPMailer, $charset = MAIL_CHARSET)
    {
        $email = $PHPMailer;
		$email->SMTPDebug = 1;
        $email->IsSMTP(); // define que será usado SMTP:
        // Define os dados técnicos da Mensagem:
        $email->IsHTML(true);
        $email->CharSet = $charset;
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

    /*
     * ***********************************************
     * ********* RESPONSAVEL POR ENVIAR SMS **********
     * ***********************************************
     */

    static public function EnviarSMS(array $DadosSms)
    {
        include_once 'HumanClientMain.php';
        // VERIFICAR SE TEM ALGUM TELEFONE CELULAR E ENVIAR UM SMS PRO CLIENTE:
        if (strpos($DadosSms ['celular'], '7') || strpos($DadosSms ['celular'], '8') || strpos($DadosSms ['celular'], '9')) :
            $sms_fone = '55' . Funcoes::trataTelefone($DadosSms ['celular']);
            // ENVIA UM SMS DE BOAS VINDAS PRO CLIENTE:
            $sms_msg = "Obrigado pela preferencia. Em breve um de nossos consultores entrara em contato. Grupo Volpato";
            $msg_list = $sms_fone . ";" . $sms_msg . ";4545454545454" . rand();

            // AUTENTICAÇÃO COM A API
            $humanMultipleSend = new HumanMultipleSend("volpatoapipos", "bmHvfLRFlr");
            var_dump($humanMultipleSend);
            $response = $humanMultipleSend->sendMultipleList(HumanMultipleSend::TYPE_C, $msg_list);

            var_dump($response);

            foreach ($response as $resp) {
                echo $resp->getCode() . " - " . $resp->getMessage() . "<br />";
            }


        endif;
    }

    //Exemplo: EnviarSMSAgendada(555185454598, "Teste", 515148792565, "08/11/2015 10:20:05")
    static public function EnviarSMSAgendada($to, $msg, $from)
    {
        include_once 'HumanClientMain.php';

        try {

            $msg_list = $to . ";" . $msg . ";" . date("dmYHis");

            // AUTENTICAÇÃO COM A API
            $humanMultipleSend = new HumanMultipleSend("volpatoapipos", "bmHvfLRFlr");
            var_dump($humanMultipleSend);
            $response = $humanMultipleSend->sendMultipleList(HumanMultipleSend::TYPE_C, $msg_list);

        } catch (Exception $e) {

        }

    }

    /*
     * ********************************************************************
     * ************ RESPONSAVEL POR ENVIAR UM SMS PRO CLIENTE *************
     * ********************************************************************
     */

    public static function enviaSMS($dados, Sms $Sms, HumanMultipleSend $HumanMultipleSend)
    {
        $sms = $Sms;
        $humanMultipleSend = $HumanMultipleSend;
        $telefone = (!empty($dados ['telefone'])) ? $dados ['telefone'] : null;
        $telefone = preg_replace("/[^0-9]/", "", $telefone);
        $id_captacao = (!empty($dados ['id_captacao'])) ? $dados ['id_captacao'] : null;
        $mensagem = (!empty($dados ['mensagem'])) ? $dados ['mensagem'] : null;

        $exp_regular = '/^[0-9]{2}[0-9]{4}[0-9]{4}$/';

        // VERIFICA SE O TELEFONE Ã‰ UM CELULAR:
        if (preg_match($exp_regular, $telefone)) :
            $sms_fone = '55' . Funcoes::trataTelefone($telefone);
            // REGISTRAR O SMS NO BANCO :
            if ($id_captacao > 0) :
                $sms->insert(array(
                    'sms_id_captacao' => $id_captacao
                ));
            else :
                $sms->insert(array(
                    'sms_desc' => "'outros'"
                ));
            endif;
            $id_sms = $sms->getUltimoId();
            $sms_msg = $mensagem;
            $msg_list = $sms_fone . ";" . $sms_msg . ";" . $id_sms;
            $response = $humanMultipleSend->sendMultipleList(HumanMultipleSend::TYPE_C, $msg_list);
            //AUTENTICAÃ‡ÃƒO COM A API
            //foreach ($response as $resp) {
            //echo $resp->getCode() . " - " . $resp->getMessage() . "<br />";
            //}
        endif;
    }

    static public function Nregistro()
    {
        echo '<div class="alert alert-warning"><span class="glyphicon  glyphicon-alert"></span>  Nenhum registro encontrado.</div>';
    }

    /*
     * **************************************************************
     * ********* RESPONSAVEL POR FORMATAR CAMPO OPERADORA **********
     * **************************************************************
     */

    public static function captacao_operadora($operadora_value, $operadora_name)
    {
        $html = "<select class=\"inputWidth100\" name=\"{$operadora_name}\" id=\"{$operadora_name}\"> ";
        $html .= " <option value=\"Claro\" ";
        if ($operadora_value == 'Claro')
            $html .= 'selected';
        $html .= " > Claro </option>";
        $html .= " <option value=\"Embratel\" ";
        if ($operadora_value == 'Embratel')
            $html .= 'selected';
        $html .= " > Embratel </option>";
        $html .= " <option value=\"OI\" ";
        if ($operadora_value == 'OI')
            $html .= 'selected';
        $html .= " > OI </option>";
        $html .= " <option value=\"TIM\" ";
        if ($operadora_value == 'TIM')
            $html .= 'selected';
        $html .= " > TIM </option>";
        $html .= " <option value=\"Vivo\" ";
        if ($operadora_value == 'Vivo')
            $html .= 'selected';
        $html .= " > Vivo </option>";
        $html .= " <option value=\"GVT\" ";
        if ($operadora_value == 'GVT')
            $html .= 'selected';
        $html .= " > GVT </option>";
        $html .= " <option value=\"Net\" ";
        if ($operadora_value == 'Net')
            $html .= 'selected';
        $html .= " > Net </option>";
        $html .= "</select>";
        return $html;
    }

    public static function geraPDF($nomeDoArquivo, $html, $tipo, DOMPDF $dompdf, $pastaDestino)
    {
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
        $arquivo = $_SESSION['caminho_local'] . $pastaDestino;
        if (file_put_contents($arquivo, $pdf)) :
            // Salvo com sucesso.
            return true;
        else :
            // Erro ao salvar o arquivo.
            return false;
        endif;
    }

    // função que gera um nome aleatorio
    static public function gerarNomeAleatorio($quantCaracteres)
    {
        $temp = substr(md5(uniqid(time())), 0, $quantCaracteres);
        return $temp;
    }

    /*
     * *************************************************************************
     * ********* FUNÇÃO QUE ENVIA UM ARQUIVO PARA UM SERVIDOR EXTERNO **********
     * *************************************************************************
     */

    static public function uploadArquivosServidor($ftp_server, $ftp_username, $ftp_userpass, $nomeArquivo, $caminhoArquivo)
    {
        $ftp_conn = @ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
        
        //var_dump($ftp_conn, $nomeArquivo, $caminhoArquivo); die;
        
        if (@ftp_put($ftp_conn, $nomeArquivo, $caminhoArquivo, FTP_BINARY))
            echo "Successfully uploaded file.";
        else
            echo "Error uploading file.";
        ftp_close($ftp_conn);
    }

    /*
     * ************************************************************************
     * ********* FUNÇÃO QUE DELETA UM ARQUIVO DE UM SERVIDOR EXTERNO **********
     * ************************************************************************
     */

    static public function deletarArquivoServidor($ftp_server, $ftp_username, $ftp_userpass, $caminhoArquivo)
    {
        $ftp_conn = @ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
        if (ftp_delete($conn_id, $caminhoArquivo)) {
            echo "O arquivo $file foi excluído\n";
        } else {
            echo "não foi possível excluir $file\n";
        }

        ftp_close($conn_id);

        die();
    }

    /*
     * *****************************************************************************
     * ********* FUNÇÃO QUE BUSCA UM VALOR NO ARRAY E RETORNA SUA POSIÇÃO **********
     * *****************************************************************************
     */

    static public function arraySearch($valor, array $array)
    {
        $teste = false;
        foreach ($array as $k => $a) {
            if ($valor == $a) {
                $teste = true;
                return (string)$k;
                break;
            }
        }

        if (!$teste)
            return -1;
    }

    /*
     * *************************************************************************
     * ********* MUDA A COR DA LINHA DA TABELA DE ACORDO COM O STATUS **********
     * *************************************************************************
     */

    static public function colorirLinha($status)
    {
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

        else if ($status == 8)
            $ret = 'style="background:#BC8F8F;"';

        return $ret;
    }

    /*
     * *******************************************************************
     * ********* RETORNA DATA E HORA FORMATADA DA DATA DO BANCO **********
     * *******************************************************************
     */

    static public function formataDataComHora($data)
    {
        $data = explode(" ", $data);
        $date = $data[0];
        $hora = $data[1];
        $data = Funcoes::formataData($date);
        return $data . " " . $hora;
    }

    /*
     * *********************************************************************
     * ********* RETORNA DATA E HORA FORMATADA PARA DATA DO BANCO **********
     * *********************************************************************
     */

    static public function formataDataComHoraSQL($data)
    {
        $arrayData = explode(" ", $data);
        $date = $arrayData[0];
        $hora = $arrayData[1];

        return Funcoes::FormatadataSql($date) . " " . $hora;
    }

    #TRATA A STRING DE ACORDO COM OS CAMPOS DO ASC

    static public function cortarString($string, $tamanho)
    {
        if (strlen($string) > $tamanho) {
            $arr[0] = 1;  // RETORNA 1 SE STRING FOR MAIOR QUE O TAMANHO
            $arr[1] = substr($string, 0, $tamanho);
        } else {
            $arr[0] = 0;
            $arr[1] = $string;
        }
        return $arr;
    }

    static public function limparAcento($string)
    {
        $patterns = array('/À/', '/Á/', '/Â/', '/Ã/', '/Ä/', '/Å/', '/ÆÇ/', '/È/', '/É/', '/Ê/', '/Ë/', '/Ì/', '/Í/', '/Î/', '/Ï/', '/Ñ/', '/Ò/', '/Ó/', '/Ô/', '/Õ/', '/Ö/', '/Ù/', '/Ü/', '/Ú/');
        $replacements = array('A', 'A', 'A', 'A', 'A', 'A', 'E', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U');
        $nova_string = preg_replace($patterns, $replacements, $string);

        return str_replace("'", ' ', $nova_string);
    }

    /*
     * ****************************************************
     * ********* MONTA URL COM OS PARAMETROS GET **********
     * ****************************************************
     */

    static public function getParametrosURL($Array)
    {
        $url = '';

        unset($Array['pag']);

        //DEPOIS DO PHP 7.2.X
        $pkCount = (is_array($Array) ? sizeof($Array) : 0);

        if ($pkCount >= 1) {

            foreach ($Array as $k => $a) {
                $url .= "&{$k}={$a}";
            }
        }

        return $url;
    }

    /*
     * ************************************************************************************
     * ********* RETORNA DATA INICIAL E FINAL DO PERIODO DOS PEDIDOS DE COMISSÃO **********
     * ************************************************************************************
     */

    static public function pegarDatasPeriodoPlanilha($periodo, $ano)
    {

        $json_file = file_get_contents($_SESSION['caminho_local'] . "\modulos\pedidoComissao\public\js\periodos.json");
        $periodos = json_decode($json_file, true);

        $pcfPeriodo = str_replace(" ", "", $periodo);

        $mesInicial = (int)$periodos[explode("/", $pcfPeriodo)[0]] + 1;
        $mesFinal = (int)$periodos[explode("/", $pcfPeriodo)[1]] + 1;

        $mesInicial = strlen($mesInicial) == 1 ? "0" . $mesInicial : $mesInicial;
        $mesFinal = strlen($mesFinal) == 1 ? "0" . $mesFinal : $mesFinal;

        $anoFinal = $mesInicial == 12 && $mesFinal == 01 ? $ano + 1 : $ano;

        $datas['dataInicial'] = $ano . "-" . $mesInicial . "-01";

        $datas['dataFinal'] = $anoFinal . "-" . $mesFinal . "-21";

        return $datas;
    }

    static public function tratarError(array $dados)
    {
        if (isset($dados)) {
            switch ($dados['error']) {
                case 'alert-success':
                    $classe = 'alert-success';
                    $mensagem = $dados['mensagem'];
                    break;
                case 'alert-info':
                    $classe = 'alert-info';
                    $mensagem = $dados['mensagem'];
                    break;
                case 'alert-warning':
                    $classe = 'alert-warning';
                    $mensagem = $dados['mensagem'];
                    break;
                case 'alert-danger':
                    $classe = 'alert-danger';
                    $mensagem = $dados['mensagem'];
                    break;
            }
            $html = '<div class="alert ' . $classe . '" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span>  ' . $mensagem . '</div>';
        }
        return $html;
    }

    //desconsidera o zero ao testar vazio
    static public function dadosVaziosDesconsiderandoZero($dado)
    {
        if (!is_numeric($dado) && empty($dado))
            return true;
        else
            return false;
    }

    static public function converterParaDouble($valor)
    {
        $valor = str_replace('R$ ', '', $valor);
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        return $valor;
    }

    //PEGA STRING DO NÚMERO REAL POR EXTENSO
    static public function valorPorExtensoReal($valor = 0)
    {
        $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
        $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");

        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

        $z = 0;

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);

        $rt = "";

        for ($i = 0; $i < count($inteiro); $i++)
            for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
                $inteiro[$i] = "0" . $inteiro[$i];

        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," 😉
        $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < count($inteiro); $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count($inteiro) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($valor == "000")
                $z++;
            elseif ($z > 0)
                $z--;
            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
                $r .= (($z > 1) ? " de " : "") . $plural[$t];
            if ($r)
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        return substr($rt ? $rt : "zero", 1);
    }

    //PEGA STRING DO NÚMERO POR EXTENSO
    static public function valorPorExtenso($valor = 0)
    {
        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

        $z = 0;

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);

        $rt = "";

        for ($i = 0; $i < count($inteiro); $i++)
            for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
                $inteiro[$i] = "0" . $inteiro[$i];

        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," 😉
        $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < count($inteiro); $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count($inteiro) - 1 - $i;
            if ($valor == "000")
                $z++;
            elseif ($z > 0)
                $z--;
            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
                $r .= (($z > 1) ? " de " : "");
            if ($r)
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        return substr($rt ? $rt : "zero", 1);
    }

    static public function gerarLogCadastro($logs, $acao, $Dados, $nivel, $campos = NULL, $textos = NUll)
    {
        if (!isset($_SESSION['user_info']['id_usuario']))
            @session_start();
        $id_usuario = isset($_SESSION['user_info']['id_usuario']) ? $_SESSION['user_info']['id_usuario'] : $Dados['id'];
        $log['log_identificacao'] = $Dados['id'];
        $log['log_usuario'] = $id_usuario;
        $log['log_descricao'] = ucwords($acao);
        $log['log_data'] = date("Y-m-d H:i:s");

        $texto = "";

        unset($Dados['id']);

        if (!empty($Dados)) {
            foreach ($Dados as $k => $d) {
                $valor = isset($textos[$k]) ? $textos[$k] : $d;;
                $descricao = isset($campos[$k]) ? $campos[$k] : Funcoes::limparCampoLog($k);
                $texto .= ucwords($descricao) . ": " . $valor . "\n";
            }
        }

        $log['log_texto'] = $texto;
        $log['log_nivel'] = $nivel;
        $logs->insert($log);
    }

    static public function gerarLogAlteracao($logs, $acao, $Dados, $anterior, $nivel, $status = NULL, $campos = NULL, $textos = NUll, $textoAdicional = NULL)
    {

        if (!isset($_SESSION['user_info']['id_usuario']))
            @session_start();

        $id = $Dados['id'];

        unset($Dados['id']);

        $log['log_identificacao'] = $id;
        $log['log_usuario'] = $_SESSION['user_info']['id_usuario'];
        $log['log_descricao'] = $acao;

        $data = date("Y-m-d H:i:s");

        $texto = "";

        foreach ($Dados as $k => $d) {

            $campo = isset($campos[$k]) ? $campos[$k] : Funcoes::limparCampoLog($k);
            $valor = isset($textos[$k]) ? $textos[$k] : $d;

            if ((!empty($d) && $d != $anterior[$k]) || (empty($d) && !empty($anterior[$k]))) {

                if (!empty($status) && in_array($k, $status)) {

                    $l['log_identificacao'] = $id;
                    $l['log_usuario'] = $_SESSION['user_info']['id_usuario'];
                    $l['log_descricao'] = "Alteração {$campo} da solicitação para {$valor}";
                    $l['log_data'] = $data;
                    $l['log_nivel'] = $nivel;
                    $logs->insert($l);
                } else {
                    $texto .= ucwords($campo) . ": " . $valor . "\n";
                }
            }
        }

        $log['log_texto'] = $texto;
        $log['log_data'] = $data;
        $log['log_nivel'] = $nivel;

        if (!empty($texto)) {
            $logs->insert($log);
        }
    }

    static public function limparCampoLog($str)
    {
        $tabelas = array("pcf_", "pedido_comissao_", "_cliente", "chip_", "credenciado_", "veiculos_equipamentos_", "veiculos_os_", "contato_", "captacao_");

        foreach ($tabelas as $t) {
            $str = str_replace($t, "", $str);
        }

        return str_replace("_", " ", trim($str));
    }

   

    static public function verificarCamposContratoCliente($campos, $campo)
    {

        $value = "disabled";

        if (in_array($campo, Funcoes::pegarChaveArray($campos, "campos_contrato_name")))
            $value = "";

        return $value;
    }

    static public function verificarCamposContratoVeiculo($campos, $campo, $id_veiculo)
    {

        $value = "disabled";

        if (in_array(array("campos_contrato_name" => $campo, "cr_veiculo" => $id_veiculo), $campos))
            $value = "";

        return $value;
    }

    static public function pegarChaveArray($array, $column_key, $index_key = null)
    {
        return array_reduce($array, function ($result, $item) use ($column_key, $index_key) {
            if (null === $index_key) {
                $result[] = $item[$column_key];
            } else {
                $result[$item[$index_key]] = $item[$column_key];
            }

            return $result;
        }, []);
    }

    static public function getCumprimento()
    {
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

    static public function enviarPost($url, $data)
    {
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return $result;
    }

    static public function create_zip($files = array(), $destination = '', $overwrite = false)
    {
        //if the zip file already exists and overwrite is false, return false
        if (file_exists($destination) && !$overwrite) {
            return false;
        }
        //vars
        $valid_files = array();
        //if files were passed in...
        if (is_array($files)) {
            //cycle through each file
            foreach ($files as $file) {
                //make sure the file exists
                if (file_exists($file)) {
                    $valid_files[] = $file;
                }
            }
        }
        //if we have good files...
        if (count($valid_files)) {
            //create the archive
            $zip = new ZipArchive();

            if (file_exists($destination) && $overwrite) {
                $zip->open($destination, ZIPARCHIVE::OVERWRITE);
            } else {
                $zip->open($destination, ZIPARCHIVE::CREATE);
            }

            //add the files
            foreach ($valid_files as $file) {
                $zip->addFile($file, basename($file));
            }
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

            //close the zip -- done!
            $zip->close();

            //check to make sure the file exists
            return file_exists($destination);
        } else {
            return false;
        }
    }

}
