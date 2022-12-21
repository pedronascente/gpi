<?php
$Dados = filter_input_array(INPUT_POST);

if (!empty($_POST["nome_anexo_fipe"])) {
    $_POST ["nome_anexo"] = $_POST["nome_anexo_fipe"];
    $nome_arquivo = $_POST ["nome_anexo"];
}
if (!empty($_POST["nome_anexo_crlv"])) {
    $_POST ["nome_anexo"] = $_POST["nome_anexo_crlv"];
    exit('teste' . $_POST ["nome_anexo"]);
}
if (!empty($_POST["nome_anexo_dut"])) {
    $_POST ["nome_anexo"] = $_POST["nome_anexo_dut"];
    $nome_arquivo = $_POST ["nome_anexo"];
}
if (!empty($_POST["nome_anexo"])) {
    $nome_arquivo = $_POST["nome_anexo"];
}
if (!empty($Dados) && isset($Dados)) :
    $acao = $Dados ['acao'];
    $id = !empty($Dados ['cliente_ra']) ? $Dados ['cliente_ra'] : '';
    $id_cliente_contrato = !empty($Dados ['id']) ? $Dados ['id'] : '';
    unset($Dados ['acao'], $Dados ['id']);
endif;

$Dados['tipo_pessoa'] = isset($Dados['tipo_pessoa']) ? $Dados['tipo_pessoa'] : 1;

$captacao = new Captacao ();
$contrato = new contratos ();
$anexos = new Anexos ();
include_once __DIR__ . '/../../../controllers/controllerCadastraClienteRastreador.php';
switch ($error) :
    case 1 :
        $msgError = '<p class="alert  alert-warning" > <span class="glyphicon glyphicon-exclamation-sign"> </span>  Por favor, envie arquivos com a extensão: ( .jpg |.pdf |.doc|.docx )</p> ';
        break;
    case 2 :
        $msgError = '<p class="alert  alert-danger" > <span class="glyphicon glyphicon-exclamation-sign"> </span>   O arquivo no upload é maior do que o limite do PHP</p>';
        break;
    case 3 :
        $msgError = '<p class="alert  alert-danger"> <span class="glyphicon glyphicon-exclamation-sign"> </span>   O arquivo ultrapassa o limite de tamanho especifiado -> MAX 6Mb </p>';
        break;
    case 4 :
        $msgError = '<p class="alert  alert-warning"> <span class="glyphicon glyphicon-exclamation-sign"> </span>   O upload do arquivo foi feito parcialmente</p>';
        break;
    case 5 :
        $msgError = '<p class="alert  alert-danger"> <span class="glyphicon glyphicon-exclamation-sign"> </span>   Não foi feito o upload do arquivo</p>';
        break;
    case 6 :
        $msgError = '<p class="alert  alert-success"> <span class="glyphicon glyphicon-exclamation-sign"> </span>   Arquivo anexado com sucesso!</p>';
        break;
endswitch;
?>
<script type="text/javascript">
    function optionCheck() {
        var option = document.getElementById("tipo_doc").value;
        if (option == "alteracao_contratual") {
            document.getElementById("alteracao_contratual").style.visibility = "visible";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "carta_cancelamento") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "visible";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "certidao_casamento") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "visible";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "certificado_uniao_estavel") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "visible";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "cnh") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "visible";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "cnpj") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "visible";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "comprovante_endereco") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "visible";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "comprovante_pagamento") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "visible";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "contrato_social") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "visible";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "correio") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "visible";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "cpf") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "visible";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "crlv_documento_provisorio") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "visible";
            document.getElementById("crlv_documento_provisorio").style.visibility = "visible";
            document.getElementById("crlv_documento_provisorio").disabled = false;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "crlv") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "visible";
            document.getElementById("crlv").style.visibility = "visible";
            document.getElementById("crlv").disabled = false;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "declaracao_endereco") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "visible";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "detran") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "visible";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "email") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "visible";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "endereco_entrega") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "visible";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "nota_fiscal") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "visible";
            document.getElementById("nota_fiscal").style.visibility = "visible";
            document.getElementById("nota_fiscal").disabled = false;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "outros") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "visible";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "procuracao") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "visible";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "requerimento_empresario") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "visible";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "rg_frente") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "visible";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "rg_verso") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "visible";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "tabela_fipe") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "visible";
            document.getElementById("tabela_fipe").style.visibility = "visible";
            document.getElementById("tabela_fipe").disabled = false;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "termo_ciencia") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "visible";
            document.getElementById("validacao_cartao").style.visibility = "hidden";
        } else if (option == "validacao_cartao") {
            document.getElementById("alteracao_contratual").style.visibility = "hidden";
            document.getElementById("carta_cancelamento").style.visibility = "hidden";
            document.getElementById("certidao_casamento").style.visibility = "hidden";
            document.getElementById("certificado_uniao_estavel").style.visibility = "hidden";
            document.getElementById("cnh").style.visibility = "hidden";
            document.getElementById("cnpj").style.visibility = "hidden";
            document.getElementById("comprovante_endereco").style.visibility = "hidden";
            document.getElementById("comprovante_pagamento").style.visibility = "hidden";
            document.getElementById("contrato_social").style.visibility = "hidden";
            document.getElementById("correio").style.visibility = "hidden";
            document.getElementById("cotacao").style.visibility = "hidden";
            document.getElementById("cpf").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio1").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").style.visibility = "hidden";
            document.getElementById("crlv_documento_provisorio").disabled = true;
            document.getElementById("crlv1").style.visibility = "hidden";
            document.getElementById("crlv").style.visibility = "hidden";
            document.getElementById("crlv").disabled = true;
            document.getElementById("declaracao_endereco").style.visibility = "hidden";
            document.getElementById("detran").style.visibility = "hidden";
            document.getElementById("dispensa_vistoria").style.visibility = "hidden";
            document.getElementById("email").style.visibility = "hidden";
            document.getElementById("endereco_entrega").style.visibility = "hidden";
            document.getElementById("nota_fiscal1").style.visibility = "hidden";
            document.getElementById("nota_fiscal").style.visibility = "hidden";
            document.getElementById("nota_fiscal").disabled = true;
            document.getElementById("outros").style.visibility = "hidden";
            document.getElementById("procuracao").style.visibility = "hidden";
            document.getElementById("proposta").style.visibility = "hidden";
            document.getElementById("requerimento_empresario").style.visibility = "hidden";
            document.getElementById("rg_frente").style.visibility = "hidden";
            document.getElementById("rg_verso").style.visibility = "hidden";
            document.getElementById("tabela_fipe1").style.visibility = "hidden";
            document.getElementById("tabela_fipe").style.visibility = "hidden";
            document.getElementById("tabela_fipe").disabled = true;
            document.getElementById("termo_ciencia").style.visibility = "hidden";
            document.getElementById("validacao_cartao").style.visibility = "visible";
        }
    }
</script>
<div class="panel panel-primary   ">
    <div class="panel-default panel-body">
        <div class="row ">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <?= (!empty($error)) ? $msgError : '<p class="alert  alert-warning" > <span class="glyphicon glyphicon-exclamation-sign"> </span>    É válido somente Arquivos com as extensões  : .jpg |.pdf |.doc|.docx </p>'; ?></p>
            </div>
        </div>
        <form enctype="multipart/form-data" name="form-anexa-arquivos"
              action="modulos/captacao/src/controllers/captacao_anexos.php" method="post" id="formAnexos">
            <div class="row">
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" <?= $tipoPessoa == 'f' || $tipoPessoa == 'F' ? "style='display:none;'" : ""; ?>>
                    <div class="form-group">
                        <label>Tipo de Pessoa .:</label>
                        <select name="tipo_pessoa"
                                required <?= $tipoPessoa == 'f' || $tipoPessoa == 'F' ? "disabled" : ""; ?>
                                class="form-control">
                            <option value="">Selecione ...</option>
                            <option value="2">1° Sócio</option>
                            <option value="3">2° Sócio</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group" style="margin-bottom:25px;">
                        <label>Tipo de Doc .:</label>
                        <select name="tipo_doc" id="tipo_doc" class="form-control" onchange="optionCheck()" required>
                            <option value="">Selecione ...</option>
                            <option value="consulta">Consulta</option>
                            <option value="contrato_assinado">Contrato Assinado</option>
                            <?php
                            if ($veiculo > '0') {
                                echo '
		<option value="alteracao_contratual">Alteração Contratual</option>
		<option value="carta_cancelamento">Carta de Cancelamento</option>
		<option value="certidao_casamento">Certidão de Casamento</option>
		<option value="certificado_uniao_estavel">Certificado de União Estável</option>
		<option value="cnh">CNH</option>
		<option value="cnpj">CNPJ</option>
		<option value="comprovante_endereco">Comprovante de Endereço</option>
		<option value="comprovante_pagamento">Comprovante de Pagamento</option>
		<option value="contrato_social">Contrato Social</option>
		<option value="correio">Correio</option>
        <option value="cotacao">Cotação</option>   
		<option value="cpf">CPF</option>
		<option value="crlv_documento_provisorio">CRLV - Documento Provisório</option>
		<option value="crlv">CRLV</option>
		<option value="declaracao_endereco">Declaração de Endereço</option>
		<option value="detran">Detran</option>
        <option value="dispensa_vistoria">Dispensa de vistoria</option>
		<option value="email">Email</option>
		<option value="endereco_entrega">Endereço de Entrega</option>
		<option value="nota_fiscal">Nota Fiscal</option>
		<option value="procuracao">Procuração</option>
        <option value="proposta">Proposta</option>  
		<option value="requerimento_empresario">Requerimento de Empresário</option>
		<option value="rg_frente">RG Frente</option>
		<option value="rg_verso">RG Verso</option>
		<option value="tabela_fipe">Tabela FIPE</option>
		<option value="termo_ciencia">Termo de Ciência</option>
		<option value="validacao_cartao">Validação do Cartão</option>		

	';
                            } else {
                                echo '
		<option value="alteracao_contratual">Alteração Contratual</option>
		<option value="carta_cancelamento">Carta de Cancelamento</option>
		<option value="certidao_casamento">Certidão de Casamento</option>
		<option value="certificado_uniao_estavel">Certificado de União Estável</option>
		<option value="cnh">CNH</option>
		<option value="cnpj">CNPJ</option>
		<option value="comprovante_endereco">Comprovante de Endereço</option>
		<option value="comprovante_pagamento">Comprovante de Pagamento</option>
		<option value="contrato_social">Contrato Social</option>
		<option value="correio">Correio</option>
        <option value="cotacao">Cotação</option>   
		<option value="cpf">CPF</option>
		<option value="declaracao_endereco">Declaração de Endereço</option>
		<option value="detran">Detran</option>
        <option value="dispensa_vistoria">Dispensa de vistoria</option>
		<option value="email">Email</option>
		<option value="endereco_entrega">Endereço de Entrega</option>
		<option value="procuracao">Procuração</option>
        <option value="proposta">Proposta</option>  
		<option value="requerimento_empresario">Requerimento de Empresário</option>
		<option value="rg_frente">RG Frente</option>
		<option value="rg_verso">RG Verso</option>
		<option value="termo_ciencia">Termo de Ciência</option>
		<option value="validacao_cartao">Validação do Cartão</option>
	';
                            }
                            ?>
                        </select>
                        <div class="input-group">
                            <input type="hidden" name="nome_anexo" id="alteracao_contratual"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="ALTERAÇÃO CONTRATUAL"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="carta_cancelamento"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="CARTA DE CANCELAMENTO"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="certidao_casamento"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="CERTIDAO DE CASAMENTO"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="certificado_uniao_estavel"
                                   style="margin-top: -34px; visibility:hidden;"
                                   placeholder="CERTIFICADO DE UNIÂO ESTAVEL"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="cnh" style="visibility:hidden;" placeholder="CNH"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>" class="form-control"
                                   disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="cnpj"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="CNPJ"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption " disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="comprovante_endereco"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="COMPROVANTE DE ENDEREÇO"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="comprovante_pagamento"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="COMPROVANTE DE PAGAMENTO"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="contrato_social"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="CONTRATO SOCIAL"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="correio"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="CORREIOS"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="cotacao"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="COTAÇÃO"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="cpf"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="CPF"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="crlv_documento_provisorio"
                                   style="margin-top: -34px 250px; visibility:hidden;"
                                   class="form-control file-caption kv-fileinput-caption "/>
                            <select class="form-control" id="crlv_documento_provisorio1"
                                    onchange="documentacaoCrlvProvisorio(this)"
                                    style="margin: -34px 250px; visibility:hidden;">
                                <option value="">Selecione ...</option>
                                <?PHP
                                foreach ($list_veiculos as $k => $veiculo) :
                                    $veiculo_id = (!empty ($veiculo ['id_veiculo']) ? $veiculo ['id_veiculo'] : NULL);
                                    echo '<option value=' . (!empty($veiculo['placa']) ? $veiculo['placa'] : NULL) . ' name=' . (!empty($veiculo['placa']) ? $veiculo['placa'] : NULL) . '>' . (!empty($veiculo['placa']) ? $veiculo['placa'] : NULL) . '</option>';
                                endforeach;
                                ?>
                            </select>
                            <script>
                                function documentacaoCrlvProvisorio(e) {
                                    var selectedOption = e.options[e.selectedIndex];
                                    document.getElementById('crlv_documento_provisorio').value = selectedOption.getAttribute('name');
                                }
                            </script>
                            <input type="hidden" name="nome_anexo" id="crlv"
                                   style="margin-top: -34px 250px; visibility:hidden;"
                                   class="form-control file-caption kv-fileinput-caption"/>
                            <select class="form-control" id="crlv1" onchange="documentacaoCrlv(this)"
                                    style="margin: -34px 250px; visibility:hidden;">
                                <option value="">Selecione ...</option>
                                <?PHP
                                foreach ($list_veiculos as $k => $veiculo) :
                                    $veiculo_id = (!empty ($veiculo ['id_veiculo']) ? $veiculo ['id_veiculo'] : NULL);
									//echo '<option value='.(!empty($veiculo['chassis'])?$veiculo['chassis']:NULL).'>'.(!empty($veiculo['placa'])?$veiculo['placa']:NULL).'</option>';
                                    echo '<option value=' . (!empty($veiculo['placa']) ? $veiculo['placa'] : NULL) . ' name=' . (!empty($veiculo['placa']) ? $veiculo['placa'] : NULL) . '>' . (!empty($veiculo['placa']) ? $veiculo['placa'] : NULL) . '</option>';
                                endforeach;
                                ?>
                            </select>
                            <script>
                                function documentacaoCrlv(e) {
                                    var selectedOption = e.options[e.selectedIndex];
                                    document.getElementById('crlv').value = selectedOption.getAttribute('name');
                                }
                            </script>
                            <input type="hidden" name="nome_anexo" id="declaracao_endereco"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="DECLARAÇÃO DE ENDEREÇO"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="detran"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="DISPENSA DE VISTORIA"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                            <input type="hidden" name="nome_anexo" id="dispensa_vistoria"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="DETRAN"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"       
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="email"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="EMAIL"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="endereco_entrega"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="ENDEREÇO DE ENTREGA"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="nota_fiscal"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="NOTA FISCAL"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <select class="form-control" id="nota_fiscal1" onchange="documentacaoNota(this)"
                                    style="margin: -34px 250px; visibility:hidden;">
                                <option value="">Selecione ...</option>
                                <?PHP
                                foreach ($list_veiculos as $k => $veiculo) :
                                    $veiculo_id = (!empty ($veiculo ['id_veiculo']) ? $veiculo ['id_veiculo'] : NULL);
//												echo '<option value='.(!empty($veiculo['chassis'])?$veiculo['chassis']:NULL).'>'.(!empty($veiculo['placa'])?$veiculo['placa']:NULL).'</option>';
                                    echo '<option value=' . (!empty($veiculo['placa']) ? $veiculo['placa'] : NULL) . ' name=' . (!empty($veiculo['placa']) ? $veiculo['placa'] : NULL) . '>' . (!empty($veiculo['placa']) ? $veiculo['placa'] : NULL) . '</option>';
                                endforeach;
                                ?>
                            </select>
                            <script>
                                function documentacaoNota(e) {
                                    var selectedOption = e.options[e.selectedIndex];
                                    document.getElementById('nota_fiscal').value = selectedOption.getAttribute('name');
                                }
                            </script>
                            <input type="hidden" name="nome_anexo" id="procuracao"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="PROCURAÇÃO"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="proposta"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="PROPOSTA"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="requerimento_empresario"
                                   style="margin-top: -34px; visibility:hidden;"
                                   placeholder="REQUERIMENTO DE EMPRESÁRIO"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="rg_frente" style="visibility:hidden;"
                                   placeholder="RG FRENTE" value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="rg_verso"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="RG VERSO"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption " disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="tabela_fipe"
                                   style="margin-top: -34px 250px; visibility:hidden;"
                                   class="form-control file-caption kv-fileinput-caption "/>
                            <select class="form-control" id="tabela_fipe1" onchange="documentacaoFipe(this)"
                                    style="margin: -34px 250px; visibility:hidden;">
                                <option value="">Selecione ...</option>
                                <?PHP
                                foreach ($list_veiculos as $k => $veiculo) :
                                    $veiculo_id = (!empty ($veiculo ['id_veiculo']) ? $veiculo ['id_veiculo'] : NULL);
                                    echo '<option value=' . (!empty($veiculo['placa']) ? $veiculo['placa'] : NULL) . ' name=' . (!empty($veiculo['placa']) ? $veiculo['placa'] : NULL) . '>' . (!empty($veiculo['placa']) ? $veiculo['placa'] : NULL) . '</option>';
                                endforeach;
                                ?>
                            </select>
                            <script>
                                function documentacaoFipe(e) {
                                    var selectedOption = e.options[e.selectedIndex];
                                    document.getElementById('tabela_fipe').value = selectedOption.getAttribute('name');
                                }
                            </script>
                            <input type="hidden" name="nome_anexo" id="termo_ciencia"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="TERMO DE CIÊNCIA"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="validacao_cartao"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="VALIDAÇÃO DO CARTÃO"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                            <input type="hidden" name="nome_anexo" id="outros"
                                   style="margin-top: -34px; visibility:hidden;" placeholder="OUTROS"
                                   value="<?PHP echo $_GET['id_cliente_contrato'] ?>"
                                   class="form-control file-caption kv-fileinput-caption" disabled="disabled"/>
                        </div>
                    </div>
                </div>
            </div>
            <!--	fim do select para nome do tipo do arquivo	-->
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="assinatura" id="assinatura"
                                   class="form-control file-caption  kv-fileinput-caption fileBar" disabled="disabled"/>
                            <span class="input-group-btn">
                                <button class="btn btn-default selectFile" type="button"><span
                                            class="glyphicon glyphicon-open"></span></button>
                            </span>
                        </div>
                        <input type="file" name="anexos" class="imagemAssinatura"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                    <div class="form-group">
                        <input type="hidden" name="cliente_ra" id="cliente_ra" value="<?= $id_cliente ?>"/>
                        <input type="hidden" name="id" id="id" value="<?= $id_cli; ?>"/>
                        <input type="hidden" name="acao" value="InsertArquivos"/>
                        <input type="submit" value="Anexar" class="btn btn-primary"/>
                        <a href="?pg=33&id=<?= $id_cliente ?>&id_cliente_contrato=<?= $id_cli; ?>#anexos"
                           class="btn btn-info">ListarAnexos</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>