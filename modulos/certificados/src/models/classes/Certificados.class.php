<?php
/**
 * Created by PhpStorm.
 * User: desenvolvimento02
 * Date: 06/11/2017
 * Time: 10:24
 */

class Certificados extends Crud
{
    //<editor-fold desc="PROPIEDADES">
    protected $_tabela = 'certificados';
    protected $_id;
    protected $_nomeEmpresa;
    protected $_senha;
    protected $_dataExpiracao;
    protected $_emailExpiracao;
    protected $_urlArquivo;
    protected $_diasExpiracao;
    protected $_statusCertificado;

    private $_diretorioArquivosCertificados;
    //<editor-fold desc="Configuração Email">
    private $assunto_email = 'Vencimento do Certificado:';
    private $emailRementente_email = 'revendavolpato@revendavolpato.com';
    private $remetente_email = 'Grupo Volpato';
    private $nomeEmailResposta_email = "Grupo Volpato";
    private $nome_email = "VOLPATO";
    private $emailResposta_email = "revendavolpato@revendavolpato.com";
    private $destinatarioPadrao = array('desenvolvimento02@grupovolpato.com');
    //</editor-fold>

    //</editor-fold>

    //<editor-fold desc="GETTERS AND SETTERS">

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return mixed
     */
    public function getNomeEmpresa()
    {
        return $this->_nomeEmpresa;
    }

    /**
     * @param mixed $nomeEmpresa
     */
    public function setNomeEmpresa($nomeEmpresa)
    {
        $this->_nomeEmpresa = $nomeEmpresa;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->_senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha)
    {
        $this->_senha = $senha;
    }

    /**
     * @return mixed
     */
    public function getDataExpiracao()
    {
        return $this->_dataExpiracao;
    }

    /**
     * @param mixed $dataExpiracao
     */
    public function setDataExpiracao($dataExpiracao)
    {
        if ($this->validateDate($dataExpiracao, 'Y-m-d')) {
            $date = DateTime::createFromFormat('Y-m-d', $dataExpiracao);
            $this->_dataExpiracao = $date->format('d/m/Y');
        } elseif ($this->validateDate($dataExpiracao, 'd/m/Y')) {
            $date = DateTime::createFromFormat('d/m/Y', $dataExpiracao);
            $this->_dataExpiracao = $date->format('Y-m-d');
        }

    }

    /**
     * @return mixed
     */
    public function getEmailExpiracao()
    {
        return $this->_emailExpiracao;
    }

    /**
     * @param mixed $emailExpiracao
     */
    public function setEmailExpiracao($emailExpiracao)
    {
        $this->_emailExpiracao = $emailExpiracao;
    }

    /**
     * @return mixed
     */
    public function getUrlArquivo()
    {
        return $this->_urlArquivo;
    }

    /**
     * @param mixed $urlArquivo
     */
    public function setUrlArquivo($urlArquivo)
    {
        // 1 - SETA O TIPO DO PARAMETRO PASSADO
        $varType = gettype($urlArquivo);
        // 2 - VERIFICA O TIPO DO PARAMETRO PASSADO, SE FOR ARRAY DA UPDATE OU ADICIONA O ARQUIVO, SE FOR STRING APENAS ADICIONA O OBJETO À CLASSE
        switch ($varType) {
            case 'string':
                $this->_urlArquivo = $urlArquivo;
                break;
            case 'array':
                if ($urlArquivo['name'] == '') {
                    $this->_urlArquivo = $urlArquivo['urlArquivo_old'];
                }
                if ($this->salvarArquivo($urlArquivo)) {
                    $this->_urlArquivo = BASE_URL . MEDIAS . '/certificados/' . pathinfo($urlArquivo['name'])['filename'] . '.zip';
                }
                break;
        }

    }

    /**
     * @return mixed
     */
    public function getDiasExpiracao()
    {
        return $this->_diasExpiracao;
    }

    /**
     * @param mixed $diasExpiracao
     */
    public function setDiasExpiracao()
    {
        $this->_diasExpiracao = ((strtotime(DateTime::createFromFormat('d/m/Y', $this->getDataExpiracao())->format('Y-m-d')) - strtotime(date('Y-m-d'))) / 86400);
    }

    /**
     * @return mixed
     */
    public function getStatusCertificado()
    {
        return $this->_statusCertificado;
    }

    /**
     * @param mixed $statusCertificado
     */
    public function setStatusCertificado($diasExpiracao)
    {
        if ($diasExpiracao <= 10 || is_null($diasExpiracao)) {
            $this->_statusCertificado = 'danger';
        } else {
            $this->_statusCertificado = 'default';
        }

    }

    /**
     * @return mixed
     */
    public function getDiretorioArquivosCertificados()
    {
        return $this->_diretorioArquivosCertificados;
    }

    /**
     * @param mixed $diretorioArquivosCertificados
     */
    public function setDiretorioArquivosCertificados($diretorioArquivosCertificados)
    {
        $this->_diretorioArquivosCertificados = $diretorioArquivosCertificados;
    }

    /**
     * @return string
     */
    public function getAssuntoEmail()
    {
        return $this->assunto_email;
    }

    /**
     * @param string $assunto_email
     */
    public function setAssuntoEmail($assunto_email)
    {
        $this->assunto_email = $assunto_email;
    }

    /**
     * @return string
     */
    public function getEmailRemententeEmail()
    {
        return $this->emailRementente_email;
    }

    /**
     * @param string $emailRementente_email
     */
    public function setEmailRemententeEmail($emailRementente_email)
    {
        $this->emailRementente_email = $emailRementente_email;
    }

    /**
     * @return string
     */
    public function getRemetenteEmail()
    {
        return $this->remetente_email;
    }

    /**
     * @param string $remetente_email
     */
    public function setRemetenteEmail($remetente_email)
    {
        $this->remetente_email = $remetente_email;
    }

    /**
     * @return string
     */
    public function getNomeEmailRespostaEmail()
    {
        return $this->nomeEmailResposta_email;
    }

    /**
     * @param string $nomeEmailResposta_email
     */
    public function setNomeEmailRespostaEmail($nomeEmailResposta_email)
    {
        $this->nomeEmailResposta_email = $nomeEmailResposta_email;
    }

    /**
     * @return string
     */
    public function getNomeEmail()
    {
        return $this->nome_email;
    }

    /**
     * @param string $nome_email
     */
    public function setNomeEmail($nome_email)
    {
        $this->nome_email = $nome_email;
    }

    /**
     * @return string
     */
    public function getEmailRespostaEmail()
    {
        return $this->emailResposta_email;
    }

    /**
     * @param string $emailResposta_email
     */
    public function setEmailRespostaEmail($emailResposta_email)
    {
        $this->emailResposta_email = $emailResposta_email;
    }

    /**
     * @return array
     */
    public function getDestinatarioPadrao()
    {
        return $this->destinatarioPadrao;
    }

    /**
     * @param array $destinatarioPadrao
     */
    public function setDestinatarioPadrao($destinatarioPadrao)
    {
        $this->destinatarioPadrao = $destinatarioPadrao;
    }



    //</editor-fold>

    //<editor-fold desc="METODOS PUBLICOS">

    public function __construct()
    {
        parent::__construct();
        if(!is_dir($_SERVER['DOCUMENT_ROOT'] . MEDIAS . '/certificados/')){
            mkdir($_SERVER['DOCUMENT_ROOT'] . MEDIAS . '/certificados/',0777,true);
        }
        $this->setDiretorioArquivosCertificados($_SERVER['DOCUMENT_ROOT'] . MEDIAS . '/certificados/');
    }

    /**
     * @return mixed
     */
    public function procurar($id = null)
    {
        if (!is_null($id)) {
            $id = "WHERE `id_certificado` = $id";
        }
        $this->sql = "SELECT * FROM `$this->_tabela` $id ORDER BY `id_certificado` ASC ";
        $this->Read()->FullRead($this->sql);
        return $this->Read()->getResult();
    }

    /**
     * GERA TABELA DE VISUALIZAÇÃO DOS CERTIFICADOS*****
     */
    /**
     * @param array $certificadosArray
     * @return string
     */
    public function gerarTabela(array $certificadosArray)
    {

        //<editor-fold desc="TABLE HEAD">
        $table = "
                <table class=\"table table-hover table-striped table-condensed table-bordered\"> 
                    <thead> 
                        <tr> 
                            <th style=\"font-size: 120%; text-align: center;\">Empresa</th>
                            <th style=\"font-size: 120%; text-align: center;\">Data de Expiração</th>
                            <th style=\"font-size: 120%; text-align: center;\" colspan=\"3\">Ações</th> 
                        </tr> 
                    </thead> 
                    <tbody>
                
                ";
        //</editor-fold>

        //<editor-fold desc="TABLE CONTENT">
        foreach ($certificadosArray as $certificado) {
            $this->setId($certificado['id_certificado']);
            $this->setNomeEmpresa($certificado['empresa']);
            $this->setDataExpiracao($certificado['dataExpiracao']);
            $this->setSenha($certificado['senha']);
            $this->setUrlArquivo($certificado['urlArquivo']);
            $this->setDiasExpiracao();
            $this->setStatusCertificado($this->getDiasExpiracao());

            //função callback pra trazer o button da ação
            $acao = function ($status) {
                $data = "";

                switch ($status) {
                    case 'danger':
                        $data = "
                                <td class=\"$status\" style=\"text-align: center;\">
                                    <a href=\"{$this->getUrlArquivo()}\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Fazer download do arquivo\" class=\"btn btn-primary btn-xs\" ><span class=\"glyphicon glyphicon-download\" aria-hidden=\"true\"></span></a>
                                </td>
                                <td class=\"$status\" style=\"text-align: center;\">
                                    <a href=\"index.php?pg=54&acao=formulario&id={$this->getId()}&tipo=edicao\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Renovar o certificado\" class=\"btn btn-warning btn-xs\" ><span class=\"glyphicon glyphicon-list\" aria-hidden=\"true\"></span></a>
                                </td>                                
                                <td class=\"$status\" style=\"text-align: center;\">
                                    <span data-toggle=\"modal\" data-empresa=\"{$this->getNomeEmpresa()}\" data-urlarquivo=\"{$this->getUrlArquivo()}\" data-target=\"#enviarEmail\">
                                        <a class=\"btn btn-danger btn-xs\" data-placement=\"left\" title=\"Enviar email com o Certificado\" data-toggle=\"tooltip\"><span class=\"glyphicon glyphicon-envelope\" aria-hidden=\"true\"></span></a>
                                    </span>
                                </td>
                            ";
                        break;
                    case 'default':
                        $data = "
                                <td class=\"$status\" style=\"text-align: center;\">
                                    <a href=\"{$this->getUrlArquivo()}\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Fazer download do arquivo\" class=\"btn btn-primary btn-xs\" ><span class=\"glyphicon glyphicon-download\" aria-hidden=\"true\"></span></a>
                                </td>
                                <td class=\"$status\" style=\"text-align: center;\">
                                    <a href=\"index.php?pg=54&acao=formulario&id={$this->getId()}&tipo=edicao\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Editar o certificado\"  class=\"btn btn-success btn-xs\" ><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></a>
                                </td>
                                <td class=\"$status\"style=\"text-align: center;\">
                                    <span data-toggle=\"modal\" data-empresa=\"{$this->getNomeEmpresa()}\" data-urlarquivo=\"{$this->getUrlArquivo()}\" data-target=\"#enviarEmail\">
                                        <a class=\"btn btn-danger btn-xs\" data-placement=\"left\" title=\"Enviar email com o Certificado\" data-toggle=\"tooltip\"><span class=\"glyphicon glyphicon-envelope\" aria-hidden=\"true\"></span></a>
                                    </span>
                                </td>
                            ";
                        break;
                };
                return $data;
            };

            $table .= "
                    <tr> 
                        <td class=\"col-md-9 {$this->getStatusCertificado()} \" style=\"vertical-align: middle;\">{$this->getNomeEmpresa()}</td>
                        <td class=\"col-md-2 {$this->getStatusCertificado()} \" style=\"vertical-align: middle; text-align: center;\">{$this->getDataExpiracao()}</td> 
                        {$acao($this->getStatusCertificado())} 
                        </tr> 
                    <tr> 
            ";

        }
        //</editor-fold>

        //<editor-fold desc="TABLE FOOTER">
        $table .= "</tbody></table>";
        //</editor-fold>

        return $table;
    }

    /**
     * @param array|null $certificadosArray
     * @return string
     */
    public function gerarFormulario(array $certificadosArray = null, $formType)
    {
        if (!is_null($certificadosArray)) {
            $this->setId($certificadosArray['0']['id_certificado']);
            $this->setNomeEmpresa($certificadosArray['0']['empresa']);
            $this->setDataExpiracao($certificadosArray['0']['dataExpiracao']);
            $this->setSenha($certificadosArray['0']['senha']);
            $this->setUrlArquivo($certificadosArray['0']['urlArquivo']);
            $this->setDiasExpiracao($certificadosArray['0']['diasExpiracao']);
            $this->setStatusCertificado($certificadosArray['0']['diasExpiracao']);
        }

        $arquivo = function ($url = null) {
            $data = "";
            if (is_null($url)) {
                $data = "<span class=\"input-group-addon add-on\"><span class=\"glyphicon glyphicon-folder-open\"></span></span><input type=\"file\" class=\"form-control\" name=\"arquivo\" value=\"\" required>";
            } else {
                $data = "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"20000\" required /><span class=\"input-group-addon add-on\"><span class=\"glyphicon glyphicon-folder-open\"></span></span><input type=\"file\" class=\"form-control\" name=\"arquivo\" value=\"\"><div class=\"input-group-btn\"><a href=\"{$this->getUrlArquivo()}\" class=\"btn btn-primary\">Download Original</a></div>";
            }
            return $data;
        };
        $botoes = function () use ($formType) {
            switch ($formType) {
                case 'adicao':
                    return "<button type=\"submit\" class=\"btn btn-primary\">Salvar</button>";
                    break;
                case 'edicao':
                    return "<button type=\"submit\" class=\"btn btn-primary\">Salvar</button>
                    <a class=\"btn btn-danger \" data-empresa=\"{$this->getNomeEmpresa()}\" data-idcertificado=\"{$this->getId()}\" data-urlarquivo=\"{$this->getUrlArquivo()}\" data-toggle=\"modal\" data-target=\"#confirmarExclusao\">Remover</a>";
                    break;
            }
        };
        $acao = (is_null($this->getId())) ? 'inserir' : 'editar';
        $form = "<form id=\"formulario\" action=\"modulos/certificados/src/controllers/Certificados.php\" enctype=\"multipart/form-data\" method=\"POST\">
                    <input type=\"hidden\" name=\"pg\" value=\"54\">
                    <input type=\"hidden\" name=\"acao\" value=\"$acao\">
                    <input type=\"hidden\" name=\"certificado[id_certificado]\" value=\"{$this->getId()}\">
                    <input type=\"hidden\" name=\"certificado[urlArquivo]\" value=\"{$this->getUrlArquivo()}\">
                    <div class=\"form-group\">
                        <label>Empresa:</label>
                        <input type=\"text\" class=\"form-control\" name=\"certificado[empresa]\" value=\"{$this->getNomeEmpresa()}\" aria-describedby=\"helpEmpresa\" required>
                         <span style=\"display: none;\" id=\"helpEmpresa\" class=\"help-block\">Este campo é obrigatorio.</span>
                    </div>
                    <div class=\"form-group\">
                        <label>Expiração:</label>
                        <div class=\"input-group date datepicker obrigatorio\">
                            <span class=\"input-group-addon add-on\"><span class=\"glyphicon glyphicon-calendar\"></span></span>
                            <input id=\"\" type=\"text\" class=\"form-control\" name=\"certificado[dataExpiracao]\" value=\"{$this->getDataExpiracao()}\" aria-describedby=\"helpExpiracao\" required>
                        </div>
                        <span style=\"display: none;\" id=\"helpExpiracao\" class=\"help-block\">Este campo é obrigatorio.</span>
                    </div>
                    <div class=\"form-group\" aria-describedby=\"helpSenha\">
                        <label>Senha:</label>
                        <input type=\"text\" class=\"form-control\" name=\"certificado[senha]\" value=\"{$this->getSenha()}\" maxlength=\"16\" required>
                        <span style=\"display: none;\" id=\"helpSenha\" class=\"help-block\">Este campo é obrigatorio.</span>
                    </div>
                    <div class=\"form-group\" aria-describedby=\"helpArquivo\">
                        <label>Arquivo:</label>
                        <div class=\"input-group\">
                            {$arquivo($this->getUrlArquivo())}
                        </div>
                        <span style=\"display: none;\" id=\"helpArquivo\" class=\"help-block\">Este campo é obrigatorio.</span>
                    </div>
                    {$botoes()}     
                </form>
        ";

        return $form;
    }

    /**
     * @param array|null $certificadosArray
     * @return mixed
     */
    public function inserir(array $certificadosArray = null)
    {
        // 1 - CRIA UM NOVO CERTIFICADO
        if (!is_null($certificadosArray)) {
            $this->setId($certificadosArray['id_certificado']);
            $this->setNomeEmpresa($certificadosArray['empresa']);
            $this->setSenha($certificadosArray['senha']);
            $this->setDataExpiracao($certificadosArray['dataExpiracao']);
            $this->setUrlArquivo($certificadosArray['arquivo']);
        }
        // 2 - CRIA A ARRAY DO UPDATE, PASSANDO AS COLUNAS E AS VARIAVEIAS A SEREM EDITADAS/ INSERIDAS
        $certificados = array(
            'empresa' => $this->getNomeEmpresa(),
            'senha' => $this->getSenha(),
            'dataExpiracao' => $this->getDataExpiracao(),
            'urlArquivo' => $this->getUrlArquivo()
        );
        // 3 - SE NÃO FOR PASSADO ID IRÁ ADICIONAR SE NÃO IRÁ DAR UPDATE PELO ID
        if ($certificadosArray['id_certificado'] == '') {
            // 3.1 - CRIA E EXECUTA O COMANDO UPDATE
            $this->Create()->ExCreate("certificados", $certificados);
            // 3.2 - RETORNA RESULTADO DO COMANDO UPDATE
            return $this->Create()->getResult();
        } else {
            // 3.1 - CRIA E EXECUTA O COMANDO INSERT
            $this->Update()->ExUpdate($this->_tabela, $certificados, "WHERE  `id_certificado` = {$this->getId()}", null);
            // 3.2 - RETORNA RESULTADO DO COMANDO INSERT
            return $this->Update()->getResult();

        }

    }

    /**
     * @param null $idCertificado
     * @return mixed
     */
    public function deletar($idCertificado = null, $urlArquivo = null)
    {
        if (!is_null($urlArquivo)) {
            $this->deletarArquivo($urlArquivo);
        }
        if (!is_null($idCertificado)) {
            $this->Delete()->ExDelete("certificados", "WHERE id_certificado = {$idCertificado}", null);
            return $this->Delete()->getResult();
        }
    }

    /**
     * @param array|null $certificadosArray
     */
    public function enviarEmailCertificadosExpirados(array $certificadosArray = null)
    {
        if (!is_null($certificadosArray)) {
            $certificadosExpirados = $this->verificarExpirados($certificadosArray);
            foreach ($certificadosExpirados as $certificado) {
                $this->setNomeEmpresa($certificado['empresa']);
                $this->setDataExpiracao($certificado['dataExpiracao']);
                $this->setDiasExpiracao();


                //<editor-fold desc="Mensagem">
                
				switch ($this->getDiasExpiracao()) {
                    case $this->getDiasExpiracao() <= 10 && $this->getDiasExpiracao() > 0:
                        $messageContent = "<p style=\"font-size:16px\">O certificado da empresa <strong>{$this->getNomeEmpresa()}</strong> estará vencendo em <strong>{$this->getDiasExpiracao()}</strong> dias.</strong></p>";
                        break;
                    case $this->getDiasExpiracao() == 0:
                        $messageContent = "<p style=\"font-size:16px\">O certificado da empresa <strong>{$this->getNomeEmpresa()}</strong> está <strong>expirado</strong>.</strong></p>";
                        break;
                    case $this->getDiasExpiracao() < 0:
                        $dias = abs($this->getDiasExpiracao());
                        $messageContent = "<p style=\"font-size:16px\">O certificado da empresa <strong>{$this->getNomeEmpresa()}</strong> está <strong>expirado</strong> à <strong>{$dias}</strong> dias.</p>";
                        break;
                }
                $mensagem = "
                            <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
                            <html xmlns=\"http://www.w3.org/1999/xhtml\">
                            <head>
                            <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                            <title>Certificado Expirado.</title>
                            </head>			
                            <body  style=\" color:#1D3E69; font-size:16px; font-family:Arial, Helvetica, sans-serif\">
                                <p > Olá,</p>
                                {$messageContent}
                                <p style=\"font-size:16px\">Acesse a gpi e o renove</p>
                                <p style=\"font-size:16px\">Atenciosamente,<br>
                                Grupo Volpato</p>
                                <p style=\"font-size:16px\"><img src=\"http://revendavolpato.com/assinaturaEmail/assinatura.padrao.jpg\"  width=\"850\" height=\"188\" alt=\"\" border=\"0\"></p>			
                            </body>
                            </html>
                ";
                //</editor-fold>
                $this->enviarEmail($this->destinatarioPadrao, $mensagem);
            }
        }
    }

    /**
     * @param array|null $dadosEmail
     * @return bool|void
     */
    public function enviarEmailFormulario(array $dadosEmail = null)
    {
        $this->setAssuntoEmail("Envio do certificado {$dadosEmail['nome']}");
        $destino = $dadosEmail['destino'];
        unset($dadosEmail['destino']);
        foreach (array_unique($destino) as $email) {
            $dadosEmail['destino'][] = str_replace(' ', '', $email);
        }
        unset($destino);
        if (file_exists($this->getDiretorioArquivosCertificados() . basename($dadosEmail['urlArquivo']))) {
            $arquivo =  $this->getDiretorioArquivosCertificados() . basename($dadosEmail['urlArquivo']);
        }

        //<editor-fold desc="MENSSAGEM">
        $mensagem = "                            
            <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
            <html xmlns=\"http://www.w3.org/1999/xhtml\">
            <head>
            <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
            <title>Certificado da Empresa {$dadosEmail['nome']} .</title>
            </head>		
            <body  style=\" color:#1D3E69; font-size:16px; font-family:Arial, Helvetica, sans-serif\">
                <p> Olá, </p>
                <p>Segue em anexo o certificado da empresa {$dadosEmail['nome']}</p>               
                <br>
                <p style=\"font-size:16px\">Atenciosamente,<br>
                Grupo Volpato
                </p>
                <p style=\"font-size:16px\"><img src=\"http://revendavolpato.com/assinaturaEmail/assinatura.padrao.jpg\"  width=\"850\" height=\"188\" alt=\"\" border=\"0\"></p>			
            </body>
            </html>
        ";
        //</editor-fold>

        return $this->enviarEmail($dadosEmail['destino'],$mensagem,$arquivo);
    }

    /**
     * @param array|null $certificadosArray
     * @return array
     */
    public function verificarExpirados(array $certificadosArray = null)
    {
        if (!is_null($certificadosArray)) {
            foreach ($certificadosArray as $key => $certificado) {
                $this->setDataExpiracao($certificado['dataExpiracao']);
                $this->setDiasExpiracao();
                if ($this->getDiasExpiracao() >= 10) {
                    unset($certificadosArray[$key]);
                }
            }
            return $certificadosArray;
        }
    }

    //</editor-fold>

    //<editor-fold desc="METODOS PRIVADOS">

    /**
     * @param $date
     * @param string $format
     * @return bool
     */
    private function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * @param $urlArquivo
     */
    private function deletarArquivo($urlArquivo)
    {
        // 1 - SETA O DIRETORIO DOS CERTIFICADOS
        $dir = $this->getDiretorioArquivosCertificados();
        // 2 - VERIFICA SE O ARQUIVO EXISTE E O DELETA
        if (file_exists($dir . basename($urlArquivo))) {
            // 2.1 - DELETA O ARQUIVO
            unlink($dir . basename($urlArquivo));
        }
    }

    /**
     * @param array $urlArquivo
     * @return bool
     */
    private function salvarArquivo(array $urlArquivo)
    {
        if ($urlArquivo['name'] != '' && pathinfo($urlArquivo['name'])['extension'] == 'pfx') {
            // 1 - SETA O DIRETORIO DOS CERTIFICADOS
            $dir = $this->getDiretorioArquivosCertificados();
            // 2 - SETA ONDE SERA SALVO O ARQUIVO
            $fileSaveDir = $dir . basename($urlArquivo['name']);
            // 3 - SETA O NOME DO TXT COM A SENHA
            $txtSaveDir = $dir . 'senha' . '.txt';
            // 4 - SETA O NOME DO ZIP COM OS ARQUIVOS
            $zipSaveDir = $dir . pathinfo($urlArquivo['name'])['filename'] . '.zip';
            // 5 - CRIA A ARRAY DOS ARQUIVOS
            $files = array();
            // 6 - SE FOR PASSADO POR PARAMETRO O ARQUIVO ANTIGO, O PROCURA E O DELETA
            if ($urlArquivo['urlArquivo_old'] != '') {
                // 2.4.1 - VERIFICA SE O ARQUIVO EXISTE E DELETA
                $this->deletarArquivo($urlArquivo['urlArquivo_old']);
            }
            // 7 - MOVE O ARQUIVO PASSADO POR PARAMETRO PARA O DIRETORIO SETADO
            if (move_uploaded_file($urlArquivo['tmp_name'], $fileSaveDir)) {
                $files[] = $fileSaveDir;
            }
            // 8 - CRIA O ARQUIVO TXT COM A SENHA
            $txtFile = fopen($txtSaveDir, 'a+');
            // 9 - GRAVA A SENHA NO ARQUIVO TXT
            fwrite($txtFile, $this->getSenha());
            // 10 - FECHA E SALVA O ARQUIVO NO DIRETORIO ESPECIFICADO
            fclose($txtFile);
            // 11 - INCLUI O ARQUIVO NA ARRAY PARA SER ZIPADO
            $files[] = $txtSaveDir;
            // 12 - SE CONSEGUIR INCLUIR O ARQUIVO NO ZIP, REMOVE OS ARQUIVOS INDIVIDUAIS
            if (Funcoes::create_zip($files, $zipSaveDir, true)) {
                foreach ($files as $file) {
                    unlink($file);
                }
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * @param array $destinatarios
     * @param string $mensagen
     */
    private function enviarEmail(array $destinatarios, $mensagen, $pathArquivo = null)
    {
        $DadosEmail ['asssunto'] = $this->assunto_email;
        $DadosEmail ['emailRementente'] = $this->emailRementente_email;
        $DadosEmail ['remetente'] = $this->remetente_email;
        $DadosEmail ['nomeEmailResposta'] = $this->nomeEmailResposta_email;
        $DadosEmail ['nome'] = $this->nome_email;
        $DadosEmail ['emailResposta'] = $this->emailResposta_email;
        $DadosEmail ['Body'] = $mensagen;
        if (!is_null($pathArquivo)) {
            $DadosEmail ['nomeEpastaDoArquivoEmAnexo'] = $pathArquivo;
        }
        $stats = array();
        foreach ($destinatarios as $d) {
            $DadosEmail ['emailDestino'] = $d;
            $stats[$d] = Funcoes::EnviarEmail($DadosEmail, new PHPMailer(), "utf-8");
        }
        return $stats;
    }

    //</editor-fold>
}