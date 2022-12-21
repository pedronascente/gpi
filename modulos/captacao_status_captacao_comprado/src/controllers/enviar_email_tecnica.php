<?php
include_once("../../../../Config.inc.php");

$dados = $_POST;
if($dados['acao']!='enviar_email'){
    header('Location:/');
    exit;
}
$tipoFolha = "P"; // P = Retrato | L = Paisagem.

//demo
//$dados =   array (
//        'email' =>  'CLIENTE@BOL.COM',
//        'acao' => 'enviar_email' ,
//        'id_captacao' =>  '113570',
//        
//   );

$email = strtolower($dados['email']);
$destinatario = ucfirst($dados['destinatario']);

$objeto_captacao = new Captacao;
$funcoes = new Funcoes();
$phpmailer = new PHPMailer;
$objeto_usuario = new Usuarios();

$array_list_captacao = $objeto_captacao->selCaptacao($dados['id_captacao']);

$_json = json_encode($array_list_captacao);
$json_list_captacao = json_decode($_json);

$nomeDoArquivo = $json_list_captacao->captacao_id . ".pdf";

# - GERAR HTML :
$html = getHtml($json_list_captacao);

# - GERAR PDF :
if (geraPDF($nomeDoArquivo, $html, $tipoFolha)) {
    $msgCliente ='<p style="font-family:Arial; font-size:16px; margin:0;">Olá  , '.$destinatario.'<br><br> Segue em anexo os dados da Captação. </p>';
    $msgCliente .='<p style="font-family:Arial; font-size:16px; margin:0;">Código :'.$json_list_captacao->captacao_id .'.</p>';
    $msgCliente .='<br><br><br>';
    $msgCliente .='<p style="font-family:Arial; font-size:16px; margin:0;"><b>Atenciosamente, </b> Agendamento</p>';
    $DadosEmail['asssunto'] = 'Captação';
    $DadosEmail['emailRementente'] = "agendamento@grupovolpato.com";
    $DadosEmail['remetente'] = 'GPI - Agendamento';
    $DadosEmail['emailDestino'] = $email;
    $DadosEmail['nome'] = "Agendamento";
    $DadosEmail['emailResposta'] =  "agendamento@grupovolpato.com";
    $DadosEmail['nomeEmailResposta'] = "Agendamento";
    $DadosEmail['Body'] = $msgCliente;
    $DadosEmail['nomeEpastaDoArquivoEmAnexo'] = "../../../../../_MIDIAS_/captacao_agendamento/" . $nomeDoArquivo;
    $RESPOSTA = ($funcoes->EnviarEmail($DadosEmail, $phpmailer)) ? 1 : 0;
    die(json_encode(array("type" => $RESPOSTA)));
}
# - FUNCAO QUE GERA O PDF :
function geraPDF($titulo, $html, $tipo = "P") {
    include_once("../../../../fpdf/dompdf/dompdf_config.inc.php");
    $dompdf = new DOMPDF();
    if ($tipo == "L") {
        $dompdf->set_paper("481x680", "landscape");
    }
    $dompdf->load_html(utf8_encode($html));
    $dompdf->render();
    $pdf = $dompdf->output();
    $arquivo = "../../../../../_MIDIAS_/captacao_agendamento/" . $titulo;

    if (file_put_contents($arquivo, $pdf)) {
        return true; // Salvo com sucesso.
    } else {
        return false; // Erro ao salvar o arquivo.
    }
}

function getHtml($json_list_captacao){
    if($json_list_captacao->captacao_data_criacao){
         $formatar_data = explode(' ', $json_list_captacao->captacao_data_criacao );
         $data_cadastro = date('d/m/Y',  strtotime($formatar_data[0]));
         $horario = $formatar_data[1];
     }
    $html ='<table class="table table-striped table-bordered table-hover"  border="1" cellpadding="2"  cellspacing="0"   >     
                <tbody>
                    <tr>
                        <td colspan="4"><b>Interesse:</b><br>'.$json_list_captacao->interesse.'</td>
                    </tr>
                    <tr>
                        <td><b>Data:</b>'.$data_cadastro.'<br></td>
                        <td><b>Horário:</b><br>'.$horario.'</td>
                        <td colspan="2"><b>Responsavel:</b><br>'.$json_list_captacao->captacao_responsavel.'</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Cliente:</b><br>'.$json_list_captacao->captacao_cliente.'</td>
                        <td><b>Data Nascimento:</b><br>'.$json_list_captacao->captacao_data_nascimento.'</td>
                    </tr>
                    <tr>
                        <td colspan="4"><b>Email:</b><br>'.$json_list_captacao->captacao_email.'</td>
                    </tr>
                    <tr>
                        <td><b>Telefone1:</b><br>'.$json_list_captacao->captacao_telefone1.'</td>
                        <td><b>Operadora1:</b><br>'.$json_list_captacao->captacao_operadora1.'</td>
                        <td><b>Telefone2:</b><br>'.$json_list_captacao->captacao_telefone2.'</td>
                        <td><b>Operadora2:</b><br>'.$json_list_captacao->captacao_operadora2.'</td>
                    </tr>
                    <tr>
                        <td colspan="4"><b>Já é cliente VOLPATO ?:</b><br>'.$json_list_captacao->captacao_ja_e_cliente.'</td>
                    </tr>
                    <tr>
                        <td><b>Tipo de Serviços:</b><br>'.$json_list_captacao->captacao_tipo_servico.'</td>
                        <td colspan="2"><b>Descrição:</b><br>'.$json_list_captacao->captacao_tipo_servico_desc_outros.'</td>
                        <td><b>Localização dos serviços atuais (Cidade):</b><br>'.$json_list_captacao->captacao_localizacao_do_servico_atual.'</td>
                    </tr>
                    <tr>
                        <td><b>Cliente desde:</b><br>'.$json_list_captacao->captacao_cliente_desde.'</td>
                        <td colspan="2"><b>Pendencias financeiras:</b><br>'.$json_list_captacao->captacao_pendencias_financeiras.'</td>
                        <td><b>Ações:</b><br>'.$json_list_captacao->captacao_acoes.'</td>
                    </tr>
                    <tr>
                        <td  colspan="2"><b>Conceito:</b><br>'.$json_list_captacao->captacao_conceito.'</td>
                        <td  colspan="2"><b>Tipo de Cliente:</b><br>'.$json_list_captacao->captacao_tipo_de_cliente.'</td>
                    </tr>       
                    <tr>
                        <td colspan="4"><b>Observações sobre o cliente:</b><br>'.$json_list_captacao->captacao_obs.'</td>
                    </tr>       
                    <tr>
                        <td colspan="2"><b>CEP:</b><br>'.$json_list_captacao->captacao_cep.'</td>
                        <td colspan="2"><b>UF:</b><br>'.$json_list_captacao->captacao_uf.'</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Logradouro:</b><br>'.$json_list_captacao->captacao_endereco.'</td>
                        <td><b>Numero:</b><br>'.$json_list_captacao->captacao_numero.'</td>
                    </tr>
                    <tr>
                        <td><b>Cidade:</b><br>'.$json_list_captacao->captacao_cidade.'</td>
                        <td><b>Bairro:</b><br>'.$json_list_captacao->captacao_bairro.'</td>
                        <td colspan="2"><b>Complemento:</b><br>'.$json_list_captacao->captacao_complemento.'</td>
                    </tr>
                    <tr>
                        <td colspan="4"><b>O imóvel no qual o Cliente pretende instalar nossos produtos e contratar nossos serviços é:</b><br>'.$json_list_captacao->captacao_imovel_tipo_imovel.'</td>
                    </tr>
                    <tr>
                        <td colspan="4"><b>Atividade Principal do local:</b><br>'.$json_list_captacao->captacao_imovel_atividade_principal.'</td>
                    </tr>
                    <tr>
                        <td><b>Referencia: </b><br>'.$json_list_captacao->captacao_imovel_ao_lado_de.'</td>
                        <td><b>Metragem do Terreno ex (200m2) :</b><br>'.$json_list_captacao->captacao_imovel_metragem.'</td>
                        <td><b>Área construida ex (200m2):</b><br>'.$json_list_captacao->captacao_imovel_area.'</td>
                        <td><b>Pisos:</b><br>'.$json_list_captacao->captacao_imovel_pisos.'</td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Descrição da área construida:</b><br>'.$json_list_captacao->captacao_imovel_descricao_da_ares.'</td>
                        <td colspan="2"><b>Estado do Imovel:</b><br>'.$json_list_captacao->captacao_imovel_estado.'</td>
                    </tr>
                    <tr>
                        <td colspan="4"><b>Possui acesso vigiado ?:</b><br>'.$json_list_captacao->captacao_imovel_acesso_vigiado.'</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Tipo de serviço vigiado:</b><br>'.$json_list_captacao->captacao_imovel_tipo_servico_vigiado.'</td>
                        <td><b>Horário:</b><br>'.$json_list_captacao->captacao_imovel_tipo_servico_vigiado_horario.'</td>
                    </tr>
                    <tr>
                        <td  colspan="3"><b>Possui registro de ocorrências recentes no Local ?:</b><br>'.$json_list_captacao->captacao_imovel_registro_ocorrencia_local.'</td>
                        <td><b>Descrição da  dinâmica:</b><br>'.$json_list_captacao->captacao_imovel_descricao_ocorrencia_local.'</td>
                    </tr>                                
                    <tr>
                        <td  colspan="3"><b>Possui registro de ocorrências recentes na Vizinhança ?:</b><br>'.$json_list_captacao->captacao_imovel_registro_ocorrencia_vizinhanca.'</td>
                        <td><b>Descrição da  dinâmica:</b><br>'.$json_list_captacao->captacao_imovel_descricao_ocorrencia_vizinhanca.'</td>
                    </tr>

                <tr>
                    <td colspan="3"><b>Possui aderência ?:</b><br>'.$json_list_captacao->captacao_aderencia_possui.'</td>
                    <td><b> Motivo:</b><br>'.$json_list_captacao->captacao_aderencia_motivo.'</td>
                </tr>
                <tr>
                    <td colspan="4"><b>Como foi que o cliente nos encontrou?</b><br>'.$json_list_captacao->captacao_indicador.'</td>
                </tr>
                <tr>
                    <td colspan="2"><b>Data Agendada para : </b><br>'.$json_list_captacao->captacao_data_agenda.'</td>
                    <td colspan="2"><b>Consultor :</b><br>'.$json_list_captacao->captacao_consultor.'</td>
                </tr>
            </tbody>
        </table>';   
    return utf8_decode($html);
}