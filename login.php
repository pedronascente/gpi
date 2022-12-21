<?php
$protocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false) ? 'http' : 'https';
$host = $_SERVER['HTTP_HOST'];
$parametros = $_SERVER['QUERY_STRING'];
$UrlAtual = $protocolo . '://' . $host;
$caminho_site = $UrlAtual."/gpi/";
?>

<!DOCTYPE html>
<html class=google lang=pt-BR> 
<head>
        <meta charset=utf-8>
        <meta http-equiv=X-UA-Compatible content="IE=edge">
        <meta content="initial-scale=1, width=device-width" name=viewport>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="author" content="Grupo Volpato :: fone:(51)3342-5551 - site :www.grupovolpato.com">
        <link rel="shortcut icon" type="image/x-icon" href="public/img/ico/48x48xgpi.ico">
        <link type="text/css" rel="stylesheet" href="<?= $caminho_site; ?>public/css/vendor/bootstrap/min/bootstrap.min.css" style="pointer-events: none;"  />
        <title>GPI - Gestão de Processos Internos</title>
        <style type="text/css">
            .login-panel{margin-top: 25%}
        </style>
    </head>
    <body style="background: #F8F8F8">
        <div class="container">
            <div class="row">
                <div class="col-xs-12  col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-primary">
                        <div class="panel-heading">						   
                            <h3 style="font-size:3.3rem">GPI - Gestão de Processos Internos</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form">
                                <fieldset>
                                    <div class="logar">
                                        <div class="form-group" style="margin-bottom:3.6rem">
                                            <input type="text" name="txt_usuario" id="txt_usuario"  placeholder="Usuario" class="form-control" autofocus />
                                        </div>
                                        <div class="form-group"style="margin-bottom:3.6rem">
                                            <input type="password" name="txt_senha" id="txt_senha" size="15" value="" class="form-control" placeholder="Password" >
                                        </div>
                                        <div class="form-group"style="margin-bottom:3.6rem">
                                            <a  role="button" data-toggle="collapse" href="#panelEsqueceu" aria-controls="panelEsqueceu" id="esqueceu">
                                                Recuperação / Criação usuário
                                            </a>
                                        </div>
                                    </div>
                                    <div class="collapse" id="panelEsqueceu">
                                        <div class="form-group">
                                            <input type="text" name="usuario" id="usuario"  placeholder="Usuario" class="form-control"/>
                                        </div>
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label><input type="checkbox" id="esqueceuUsuario">Não lembro / possuo usuário</label>
                                            </div>
                                        </div>
                                        <div class="form-group emailEsqueceu" style="display:none;"> 
                                            <input type="text" name="nome" id="nome" placeholder="Nome" class="form-control"/>
                                        </div>
                                        <div class="form-group emailEsqueceu" style="display:none;"> 
                                            <input type="text" name="setor" id="setor" placeholder="Setor" class="form-control"/>
                                        </div>
                                        <div class="form-group emailEsqueceu" style="display:none;"> 
                                            <input type="email" name="email" id="email" placeholder="E-mail" class="form-control"/>
                                        </div>
                                        <a href="javaScript:void(0);" id="btn_esqueceu" alt="botao Logar" class="btn btn-lg btn-primary btn-block">Enviar</a>
                                    </div>
                                    <a href="javaScript:void(0);" id="btn_logar" alt="botao Logar" class="btn btn-lg btn-primary btn-block logar">Logar </a>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script language="JavaScript" type="text/javascript" src="<?= $caminho_site; ?>public/js/vendor/jquery/jquery.v1.11.3.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?= $caminho_site; ?>public/js/vendor/bootstrap/min/bootstrap.min.js"></script>
        <script language="javascript" type="text/javascript" src="<?= $caminho_site; ?>public/js/login.min.js"></script>
    </body>
</html>
