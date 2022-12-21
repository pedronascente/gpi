<?php
# namespace C:\wamp\www\gpi\modulos\captacao\src\controllers\fichaAdesao.php
include_once ("../../../../Config.inc.php");

$Dados = $_GET;

$cliente = new Clientes();	
$contrato = new Contratos();
$veiculos = new Veiculos();

$arrayListCliente = $contrato->getContratoPdf($Dados['id']);
$JsonListCliente  = json_decode(json_encode($arrayListCliente));
$arrayListVeiculo = $veiculos->selectIDCliente($JsonListCliente->id_cliente);
$JsonListVeiculo  = json_decode(json_encode($arrayListVeiculo));
$arrayListContato = $cliente->getContatoByRaContato(['tabela'=>'contato_cliente','id_cliente_contato'=>$JsonListCliente->id_cliente,'ra_contato'=>1]);
$JsonListContato  = json_decode(json_encode($arrayListContato));
$arrayListCombustivel = [
    2=>'Alcool',
    3=>'Bicombustivel',
    4=>'Dissel',
    5=>'GNV',
    6=>'Gazolina'
];  
$arrayListTipoServico = [
    'Rastreamento'=>'plano1',
    'Rastreamento + Proteção veicular'=>'plano22',
    'Rastreamento + Proteção + veicular'=>'plano2',
    'Rastreamento + Proteção + veicular + Assistência Veicular'=>'plano3',
    'Rastreamento + Proteção veicular + Assistência Veicular'=>'plano33'
];  

$IMAGEM_03 = $_SERVER['DOCUMENT_ROOT']."/gpi/public/img/FICHA_ADESAO/3.jpg";
$IMAGEM_04 = $_SERVER['DOCUMENT_ROOT']."/gpi/public/img/FICHA_ADESAO/4.jpg";
$IMAGEM_05 = $_SERVER['DOCUMENT_ROOT']."/gpi/public/img/FICHA_ADESAO/5.jpg";
$IMAGEM_07 = $_SERVER['DOCUMENT_ROOT']."/gpi/public/img/FICHA_ADESAO/7.jpg";

$html='<style>  
    th,td,p,div,b,table{margin:0;padding:0}
    html{margin:20px 20px;font-size:11px }
    ._border_top{border-top:0}
    ._border_bottom{border-bottom:0}
    ._border_left{border-left:0}
    ._border_right{border-right:0}
</style>';

for($i=0;$i< count($JsonListVeiculo);$i++){
    
$explode_ano = $pieces = explode("/", $JsonListVeiculo[$i]->ano);
$ano_fabricacao = $explode_ano[0];                
$ano_modelo = $explode_ano[1];                
    
$html.='
<div style="page-break-after:always;"> 
    <table width="100%" cellpadding="0" cellspacing="0" border="1" >
        <tr>
            <td colspan="5"><img src="'.$IMAGEM_03.'" width="750"> </td>
        </tr>
    </table>  
    <table width="100%" cellpadding="8" cellspacing="0" border="1" style="margin-top:-2px;">
        <tr>  
            <td colspan="3">
                <table width="100%" cellpadding="5" cellspacing="0">
                    <tr>
                        <td>Tipo Pessoa:</td>';
                            if($JsonListCliente->tipo_pessoa=='f'){
                                $html.='<td>( X ) FÍSICA</td><td>(  ) JURÍDICA</td>';
                            }else{
                                $html.='<td>(  ) FÍSICA</td><td>( X ) JURÍDICA</td>';
                            }
                  $html.='</tr>
                </table>
            </td>
            <td colspan="2">CPF/CNPJ:  ' .$JsonListCliente->cnpjcpf_cliente.'</td>
        </tr>
        <tr>
            <td colspan="3">Nome:  ' .$JsonListCliente->nome_cliente.' </td>
            <td colspan="2">Data de Nascimento:  ' .$JsonListCliente->data_nascimento.'</td>
        </tr>
        <tr>
            <td colspan="3">Endereço:  '.$JsonListCliente->logradouro_cliente.'</td>
            <td colspan="2">CEP:  '.$JsonListCliente->cep_cliente.'</td>
        </tr>
        <tr>
            <td>Nº:  '.$JsonListCliente->numero_cliente.'</td>
            <td>Complemento:  '.$JsonListCliente->complemento_cliente.'</td>
            <td>Bairro:  '.$JsonListCliente->bairro_cliente.'</td>
            <td>Cidade:  '.$JsonListCliente->cidade_cliente.'</td>
            <td>Estado:  '.$JsonListCliente->uf_cliente.'</td>
        </tr>
        <tr>
            <td colspan="2">E-mail:  ' . $JsonListContato->email_contato . '</td>
            <td>Telefone Fixo:  ' . $JsonListContato->telefone2_contato . '</td>
            <td colspan="2">Telefone Celular:  ' . $JsonListContato->telefone1_contato . '</td>
        </tr>';
        if(!empty($JsonListCliente->socio_1)){
            $html.='<tr><td colspan="3">Nome representante legal pessoa jurídica:  '.$JsonListCliente->socio_1.'</td><td colspan="2">Telefone Celular:</td></tr>';
        }
        if(!empty($JsonListCliente->socio_2)){
            $html.='<tr><td colspan="3">Nome representante legal pessoa jurídica:  '.$JsonListCliente->socio_2.'</td><td colspan="2">Telefone Celular:</td></tr>';
        } 
    $html.='</table> 
    <table width="100%" cellpadding="0" cellspacing="0" border="1" style="margin-top:-2px;">  
        <tr>
            <td colspan="5" style="background: #D9D9D9"><img src="'.$IMAGEM_04.'" width="750"> </td>
        </tr>
    </table>
    <table width="100%" cellpadding="8" cellspacing="0" border="1"  style="margin-top:-2px;"> 
        <tr>';
                switch ($arrayListTipoServico[$JsonListVeiculo[$i]->tipo_seguro]){
                    case'plano1':  $html.=' <td>( X ) Rastreamento</td><td>(  ) Proteção Veicular</td><td>(  ) Assistência Veicular</td>';break;
                    case'plano2':  
                    case'plano22':  
                        $html.=' <td>( X ) Rastreamento</td><td>( X ) Proteção Veicular</td><td>(  ) Assistência Veicular</td>';break;
                    case'plano3':  
                    case'plano33':  
                        $html.=' <td>( X ) Rastreamento</td><td>( X ) Proteção Veicular</td><td>( X ) Assistência Veicular</td>';break;
                } 
            $html.='
            <td colspan="2">___________Outros (Especificar)</td>            
        </tr>
    </table>    
    <table width="100%" cellpadding="0" cellspacing="0" border="1" style="margin-top:-2px;">
        <tr>
            <td colspan="5"><img src="'.$IMAGEM_05.'" width="750"> </td>
        </tr> 
     </table>   
     <table width="100%" cellpadding="8" cellspacing="0" border="1" style="margin-top:-2px;">
        <tr>
            <td>Marca: '.$JsonListVeiculo[$i]->marca.'</td>
            <td>Modelo (conforme DUT): '.$JsonListVeiculo[$i]->modelo.'</td>
            <td>Renavam: '.$JsonListVeiculo[$i]->renavam.'</td>
            <td colspan="2">Chassi: '.$JsonListVeiculo[$i]->chassis.'</td>
        </tr> 
        <tr>
            <td>Placa:  '.$JsonListVeiculo[$i]->placa.'</td>
            <td colspan="2">Combustível:  '. $arrayListCombustivel[$JsonListVeiculo[$i]->combustivel].'</td>
            <td>Ano Fabricação: '.$ano_fabricacao.'</td>
            <td>Ano Modelo:  '.$ano_modelo.'</td>
        </tr> 
        <tr>
            <td colspan="5">
                Possui Kit Gás:
                <table width="100%" cellpadding="2" cellspacing="3" border="0">
                    <tr>
                        <td width="100px">  </td>
                        <td>(   )SIM</td>
                        <td>(   )NÃO</td>
                        <td colspan="3" style="text-align:center">O não preenchimento será considerado como NÃO):</td>
                    </tr>
                </table>
           </td>     
        </tr> 
        <tr>
            <td colspan="5">
                Categoria:<br>
                <table width="100%" cellpadding="2" cellspacing="3" border="0">
                    <tr>
                        <td>      </td>
                        <td>(   )Veículo Leve</td>
                        <td>(   )Van</td>
                        <td>(   )Táxi</td>
                        <td>(   )Motocicleta</td>
                        <td>(   )Veículo Leve Com Carroceria</td>                    
                        <td>(   )Auto Escola </td>
                        <td>(   )Locação</td>
                        <td>(   )Veículo de App</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table width="100%" cellpadding="1" cellspacing="0" border="1" style="margin-top:-2px;">
        <tr>
            <td colspan="5">A critério da ASSOCIAÇÃO é obrigatória instalação de rastreador e/ou outro tipo de equipamento/dispositivo de segurança em automóveis e motocicletas. O associado declara estar ciente, e de acordo com as normas e regras previstas no regulamento da proteção automotiva.</td>
        </tr>   
        <tr style="background:#d9d9d9;">
            <td colspan="5"> Por meio da presente Ficha de Adesão, venho requerer a minha  Filiação como associado na Associação de Proteção Patrimonial Brasil - APPBR autorizando a Empresa Volpato a realizar os tramites de minha filiação </td>
        </tr>   
        <tr>
             <td colspan="5" style="height:200px"><img src="'.$IMAGEM_07.'" width="740"> </td>
        </tr>   
    </table>
</div>';
}

//RESONSAVEL POR GERAR PDF:
include_once ($_SERVER['DOCUMENT_ROOT']."/gpi/fpdf/dompdf/dompdf_config.inc.php");

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4", "portrait");
$dompdf->render();
$dompdf->stream('ficha_adesao.pdf');