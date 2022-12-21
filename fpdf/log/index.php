<?php

include_once '../../Config.inc.php';

$log = new Log();

$id_log = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

$log->select($id_log);


$html = '
					<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
					<title>CONTRATO VOLPATO</title>
					<style type="text/css">
						ul{text-align:left;}
						ul li{list-style:none;}
						#aa{text-align:left;}
					</style>
					<body  style="  font-size:11px;">
					<div style=" margin:0 auto ;width:700px ; font-size:11px; " align="center">
					   <table border="0" cellspacing="0" cellpadding="0" width="100%">
						<tr>
						  <td align="right">
								<img src="../img/logo-contrato.jpg" width="207" height="67"  alt="" border="0"/>
						  </td>
						</tr>
						<tr>
						  <td align="center">
								<strong>
									<h2>REGISTRO DO SISTEMA</h2>
								</strong>
						  </td>
						</tr>
					  </table>
					  <table border="1" cellspacing="0" cellpadding="0" width="100%">
						<tr>
						  <td  colspan="4"><strong>DATA:</strong><br />' . $log->get("log_data") . '</td>
						</tr>
						<tr>
						  <td  colspan="4"><strong>USUÁRIO:</strong><br />' . $log->get("log_nome_usuario") . '</td>
						</tr>
						<tr>
						  <td  colspan="4"><strong>AÇÃO:</strong><br />' . $log->get("log_descricao") . '</td>
						</tr>
						<tr>
						  <td colspan="4"><strong>DESCRIÇÃO:</strong><br />' . str_replace("\n", "<br>", $log->get("log_texto")) . '</td>
						</tr>
					  </table>';

// objeto que cria o arquivo PDF.
include_once ("../dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF ();
$dompdf->load_html($html, 'UTF-8');
$dompdf->set_paper("a4", "portrait");
$dompdf->render();
$dompdf->stream("log.pdf");
