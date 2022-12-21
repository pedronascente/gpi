<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CheckList extends CI_Controller {

    private  $_tipo_checklist = "checklist_";

    public function __construct() 
    {
        parent:: __construct();
        $this->load->model('M_CRUD');
        $this->load->model('Clientes');
        $this->load->model('Veiculos');
        $this->load->helper("file");
    }

    public function baixar_checklist($id_cliente) 
    {
        $object_cliente = $this->Clientes->getCliente($id_cliente);
        $object_veiculo = $this->Veiculos->getVeiculo($id_cliente);
        if(is_dir('assets/pdf/checklist/dinamic/')){
           delete_files('assets/pdf/checklist/dinamic/'); 
           unlink('checklist.zip');
        }
        foreach($object_veiculo AS $K=>$V)
        {
            $_html = $this->GerarHtml($object_cliente,$V);
            $placa = ($V->placa) ?$V->placa :$V->chassis;    
            $this->GerarPDFDomPDF($_html, "assets/pdf/checklist/dinamic/checklist_{$placa}.pdf");
        }
        $this->zipar_arquivo();
    }

    private function GerarPDFDomPDF($_html, $destino_arquivo) 
    {
        include_once ("../../fpdf/dompdf/dompdf_config.inc.php");    
        $dompdf = new DOMPDF ();
        $dompdf->load_html($_html);
        $dompdf->set_paper("a4", "portrait");
        $dompdf->render();
        //$dompdf->stream ( "acionamento_viaturas.pdf" );//Imprimir pdf
        $output = $dompdf->output();
        file_put_contents($destino_arquivo, $output);
    }

    private function GerarHtml($object_cliente,$object_veiculo) 
    {
        if($object_cliente->tipo_cadastro == "rastreador_com_seguro"){            
             $checklist = $this->gerar_checklist_libert($object_cliente,$object_veiculo);
        }else{
            $checklist =  $this->gerar_checklist($object_cliente,$object_veiculo);
        }
        return $checklist;
    }

    private function gerar_checklist($object_cliente,$object_veiculo) 
    {
        $bloqueio = ($object_veiculo->bloqueio=='s')?"SIM":"NÃO"; 
        $html = '<img src="../../public/img/checklist/01.jpg"   width="100%">';
        $html .='<br><br>';
        $html .=' <table  cellspacing="0" cellpadding="2"  border="0" style="border: 0px solid; margin:0; padding:0; font-size:12px" width="100%">  ';  
        if(!empty($object_veiculo->placa)){
            $html.='<tr><td><b>Nome do Técnico: </b>_________________________________________________________________</td><td width="150px"><b>Placa :  </b>' . $object_veiculo->placa . '</td></tr>';
        }else{
            $html.='<tr><td><b>Nome do Técnico: </b>_________________________________________________________________</td><td width="200px"><b>Chassi :  </b>' .$object_veiculo->chassis. '</td></tr>';
        }
        $html.='<tr> <td><b>Veículo : </b> ' . $object_veiculo->marca . ' / ' . $object_veiculo->modelo . '</td><td><b>Bloqueio : </b> ' . $bloqueio . '</td></tr>';
            
        $html .='    
            <tr>
                <td colspan="2"><b>Cliente / Proprietário : </b>' . $object_cliente->nome_cliente . '</td>
            </tr>
            <tr>
                <td colspan="2"><b>CPF / CNPJ :     </b>' . $object_cliente->cnpjcpf_cliente . '</td>
            </tr>
            <tr>
                <td colspan="2"><b>Data: __/__/____</b></td>
            </tr>
        </table>
        <br>
        <table  cellspacing="0" cellpadding="2"  border="1" style="border: 1px solid; margin:0; padding:0; font-weight: bold ; font-size:11px" width="100%">
            <tr style="text-align: center">
                <td>EQUIPAMENTOS DO VEÍCULO</td>
                <td>ANTES DA INSTALAÇÃO</td>
                <td>APÓS DA INSTALAÇÃO</td>
            </tr>
            <tr>
                <td colspan="3"> <span style="color:#fff" >.</span></td>
            </tr>
            <tr>
                <td>Vidro Elétrico</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Travas Elétricas</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Retrovisor Elétrico</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Retrovisor Manual</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Ar frio / Ar quente</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Ar-condicionado</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Buzina</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Lanterna</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Farol Baixo</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Farol Alto</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Faróis Auxiliares</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Setas</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Pisca Alerta</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Luz de Freio (Break light)</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Bancos Elétricos</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Funcionamento do Câmbio</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Luz de Ré</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Luz(es) de Cortesia</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Limpador de Pára-Brisas</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Desembaçador (traseiro e espelhos)</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Relógio do Painel</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Painel de Instrumentos</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Luzes do Painel de Instrumentos</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Som Automotivo</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Alarme Original</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Freio de Mão</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Tampo do Porta-luvas</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Acendedor de Cigarros</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Antena Manual, Elétrica ou Interna</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Volante Escamotável</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Freios</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Forração do Teto, Quebra-Sol</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Teto solar</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
        </table>
        <br>
        <table style="font-size:12px">
            <tr>
                <td colspan="2"> <b>OBS “NP significa Não Possui”</b></td>
            </tr>
            <tr>
                <td colspan="2"> <b>Bateria: (    ) Boa  (    ) Regular  (    ) Fraca</b></td>
            </tr>
        </table>
        <img src="../../public/img/checklist/02.jpg" style="border:0; width: 100%  heght:275px"> 
        <img src="../../public/img/checklist/03.jpg" style="border:0; width: 100%  heght:667px">';

        return $html;
    }


    private function gerar_checklist_libert($object_cliente,$object_veiculo) 
    {
        $html =' <table  cellspacing="0" cellpadding="3"  border="0" style="border: 0px solid; margin:0; padding:2px; font-size:12px" width="100%">';  
        $html .=' 
        <tr>
            <td></td>
            <td><img src="../../public/img/checklist/libert_logo.jpg"   width="130px"></td>
        </tr>
        <tr>
            <td colspan="2"><br></td>
        </tr>';
        if(!empty($object_veiculo->placa)){
            $html.='<tr><td><b>Técnico: </b>_________________________________________________________________</td><td width="150px"><b>Placa :  </b>' . $object_veiculo->placa . '</td></tr>';
        }else{
            $html.='<tr><td><b>Nome do Técnico: </b>_________________________________________________________________</td><td width="200px"><b>Chassi :  </b>' .$object_veiculo->chassis. '</td></tr>';
        }
        $html.='<tr> <td colspan="2"><b>Veículo : </b> ' . $object_veiculo->marca . ' / ' . $object_veiculo->modelo . '</td></tr>';
        $html .='    
            <tr>
                <td colspan="2"><b>Cliente / Proprietário : </b>' . $object_cliente->nome_cliente . '</td>
            </tr>
            <tr>
                <td colspan="2"><b>CPF / CNPJ :     </b>' . $object_cliente->cnpjcpf_cliente . '</td>
            </tr>
            <tr>
                <td colspan="2"><b>Data: __/__/____</b></td>
            </tr>
            <tr>
                <td colspan="2"><b style="color:red">OBS “NP” significa não possui.</b></td>
            </tr>
        </table>
     
        <table  cellspacing="0" cellpadding="2"  border="1" style="border: 1px solid; margin:0; padding:1; font-weight: bold ; font-size:12px" width="100%">
            <tr style="text-align: center">
                <td>EQUIPAMENTOS DO VEÍCULO</td>
                <td>ANTES DA INSTALAÇÃO</td>
                <td>APÓS DA INSTALAÇÃO</td>
            </tr>
            <tr>
                <td colspan="3"> <span style="color:#fff" >.</span></td>
            </tr>
            <tr>
                <td>Vidro Elétrico</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Travas Elétricas</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Retrovisor Elétrico</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Retrovisor Manual</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Ar frio / Ar quente</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Ar-condicionado</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Buzina</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Lanterna</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Farol Baixo</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Farol Alto</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Faróis Auxiliares</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Setas</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Pisca Alerta</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Luz de Freio (Break light)</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Bancos Elétricos</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Funcionamento do Câmbio</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Luz de Ré</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Luz(es) de Cortesia</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Limpador de Pára-Brisas</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Desembaçador (traseiro e espelhos)</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Relógio do Painel</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Painel de Instrumentos</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Luzes do Painel de Instrumentos</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Som Automotivo</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Alarme Original</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Freio de Mão</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Tampo do Porta-luvas</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Acendedor de Cigarros</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Antena Manual, Elétrica ou Interna</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Volante Escamotável</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Freios</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Forração do Teto, Quebra-Sol</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Teto solar</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Luz do AirBag</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Tunado</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Rebaixado</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
            <tr>
                <td>Paralama amassado</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
                <td>(  ) OK   (  )  Defeito  (  ) NP</td>
            </tr>
        </table>
        
        <img src="../../public/img/checklist/libert_01.jpg" style="border:0; width: 100%  heght:275px" > ';

        return $html;
    }

    private function zipar_arquivo() 
    {
        $pathdir[] = 'assets/pdf/checklist/dinamic/';
        $pathdir[] = 'assets/pdf/checklist/static/';
        $nameArchive = "checklist.zip";        
        $zip = new ZipArchive();
        if ($zip->open($nameArchive, ZipArchive::CREATE) === TRUE) {
            for ($i=0; $i<count($pathdir);$i++){
                $dir = opendir($pathdir[$i]);
                while ($file = readdir($dir)) {
                    if (is_file($pathdir[$i] . $file)) {
                        $zip->addFile($pathdir[$i] . $file, $file);
                    }
                }
            }            
            $zip->close();
            echo 'Arquivo criado com sucesso!<br>';
        }
        echo '<a href="/gpi/application/ci_update/' . $nameArchive . '">eefe</a> ';
        header('Location:/gpi/application/ci_update/' . $nameArchive);
    }
    
    private function GerarPDFMpdf($_html, $destino_arquivo) 
    {
        require_once '../../vendor/autoload.php';
        $mpdf = new Mpdf\Mpdf(['utf-8',]);
        $mpdf->WriteHTML($_html);
        //$mpdf->AddPage();
        $mpdf->Output($destino_arquivo, \Mpdf\Output\Destination::FILE);
    }
}
