<?php

final class Anexos extends Crud {

    private $_id_anexo;
    private $_id_contrato;
        private $_tabela = 'anexos';
    private $_sql;
    private $ComprovantePagamento;

    public function setId($id) {
        $this->_id_anexo = $id;
    }

    public function setIdContrato($id) {
        $this->_id_contrato = $id;
    }

    public function insert($dados) {
        $this->Create()->ExCreate($this->_tabela, $dados);
        $this->Create()->getResult();
    }

    public function updateAnexo($dados) {
        $this->Update()->ExUpdate($this->_tabela, $dados, "WHERE id_anexo={$dados['id_anexo']}", null);
        $this->Update()->getResult();
    }

    public function deleteAnexos($id_anexo) {
        $this->Delete()->ExDelete($this->_tabela, " WHERE id_anexo = :id", "id={$id_anexo}");
        return $this->Delete()->getResult();
    }

    public function deleteAnexosPorContrato($id_contrato) {
        $this->Delete()->ExDelete($this->_tabela, " WHERE id_contrato = :id", "id={$id_contrato}");
        return $this->Delete()->getResult();
    }

    public function select($id_anexo) {
        $this->Read()->ExRead($this->_tabela, "WHERE id_anexo = :id", "id={$id_anexo}");
        return $this->limparArray($this->Read()->getResult());
    }

    public function selectAnexos($id_contrato, $id_cliente) {
        
       // var_dump('selectAnexos',$id_cliente,$id_contrato);
        
        $this->_sql = "
			SELECT a.*,c.*  FROM  {$this->_tabela} as a
			LEFT JOIN contratos as c  
				ON a.id_contrato = c.id_contrato
			WHERE  (a.id_contrato = {$id_contrato} AND a.id_contrato<>0) OR a.id_cliente = {$id_cliente}   ORDER BY a.id_anexo DESC ";
        $this->Read()->FullRead($this->_sql, null);
        return $this->Read()->getResult();
    }
    public function selectAnexosClientes($id_cliente){
        // var_dump('selectAnexosClientes',$id_cliente);
        
    	 $this->Read()->ExRead($this->_tabela, "WHERE id_cliente = :id", "id={$id_cliente}");
    	 return $this->Read()->getResult();
    }
    public function validarArquivo($tipo_doc, $tipo_pessoa, $cliente_ra) {
        $this->Read()->ExRead($this->_tabela, "WHERE tipo_doc = '{$tipo_doc}' AND tipo_pessoa = {$tipo_pessoa}  AND cliente_ra = {$cliente_ra}", null);
        return $this->limparArray($this->Read()->getResult());
     }
    public function getSql() {
        return $this->_sql;
    }
    /*
     *  --------------------------------------------------------------------
     *  Responsavel por Gerar o comprovante de pagamento :
     *  GerarComprovantePagamento($cliente_id_cliente_contrato,$cliente_id){}
     *  dependente : createHtml(){} 
     *  dependente : createPDF($idCliente,$idContrato,$html){}
     *               dependente : saveBasedeDados($ArrayDados){}
     *  --------------------------------------------------------------------   
     */
    public function GerarComprovantePagamento($cliente_id_cliente_contrato,$cliente_id){
        $idCliente = $cliente_id_cliente_contrato ;
        $idContrato = $cliente_id ;
        //busca dados da transacao:
        $ws = simplexml_load_file ("https://www.seguidor.com.br/integracaoPagSeguro/ws/ws.dadosTransacao.php?acao=visualizarLogs&id=".$idCliente);
        //buscar dados da tranazacao
        $this->ComprovantePagamento = $ws;
        //criar HTML
        $html = $this->createHtml();
        //criar PDF 
        $this->createPDF($idCliente, $idContrato, $html);
    }
    private function createHtml(){
        $html = '<table weight="500px"   border="0"  >';
        $html .= '    <tr style="background-color:#37bd8c; font-size:28px;padding:10px">';
        $html .= '        <td colspan="2">PagSeguro</td>';
        $html .= '    </tr>';
        $html .= '    <tr>';
        $html .= '        <td>Data:</td><td>'.$this->ComprovantePagamento->dadosLog->dataDoUltimoEvento.'</td>';
        $html .= '    </tr>';
        $html .= '    <tr>';
        $html .= '        <td>Status:</td><td>'.$this->ComprovantePagamento->dadosLog->transacao_significado.'</td>';
        $html .= '    </tr>';
        $html .= '    <tr>';
        $html .= '        <td>Meio de Pagamento:</td><td>'.$this->ComprovantePagamento->dadosLog->meio_pagamento_sgnificado.'</td>';
        $html .= '    </tr>';
        $html .= '    <tr>';
        $html .= '        <td>Código:</td><td>'.$this->ComprovantePagamento->dadosLog->codigoIdentificadorDaTransacao.'</td>';
        $html .= '    </tr>';
        $html .= '    <tr style="background-color:#37bd8c; font-size:28px;padding:10px">';
        $html .= '        <td ></td> <td style="text-align:right">   Total   :  '.$this->ComprovantePagamento->dadosLog->valorBrutoDaTransacao.'</td>';
        $html .= '    </tr>';
        $html .= '</table>';
        return  $html;
    }
    private function createPDF($idCliente, $idContrato, $html){
        require("/fpdf/dompdf/dompdf_config.inc.php");
        $dompdf = new DOMPDF();
        $dompdf->load_html(utf8_decode($html));
        $dompdf->set_paper('A4','landscape');
        $dompdf->render();  
        $id_contrato = '0' ;
        $tipo_doc = 'COMPROVANTE_PAGAMENTO_1' ;
        $id_cliente = $idCliente; 
        $cliente_ra = $idContrato;//id contrato
        $tipo_pessoa = 1 ;
        $nome_arquivo_renomeado = "COMPROVANTE_PAGAMENTO_".$cliente_ra."_".date("Ymd")."_".$id_cliente.".pdf";
        //___ANEXOS
        $destino = "../../../../../_MIDIAS_/anexosContrato/clientes/" .$id_cliente."/".$tipo_doc;
        $nome_anexo = $id_cliente."/".$tipo_doc."/".$nome_arquivo_renomeado;
        $caminhoArquivo = $destino."/".$nome_arquivo_renomeado;
        //criar pasta destino
        if (!file_exists($destino)){
           mkdir($destino, 0777, true);
        }
        //deletar arquivo caso já exista
        if(file_exists($caminhoArquivo)){
           unlink($nomeArquivo);
        }
        //enviar arquivo na pasta
        file_put_contents($caminhoArquivo, $dompdf->output());
        //persistir dados na base de dados Mysql
        $this->saveBasedeDados(
            array(
                'nome_anexo'=>$nome_anexo,
                'id_contrato'=>$id_contrato,
                'tipo_doc'=>'COMPROVANTE_PAGAMENTO',
                'cliente_ra'=>$cliente_ra,
                'tipo_pessoa'=>$tipo_pessoa,
                'id_cliente'=>$id_cliente,

             )
        );
    }
    private function saveBasedeDados($ArrayDados){
        //verificar duplicidade
        $this->Read()->ExRead($this->_tabela, "WHERE id_cliente = :id", "id={$ArrayDados['id_cliente']}");
    	$result = count($this->Read()->getResult());
        //salva  na base de dados:
        if($result <1){
            $this->insert($ArrayDados);
        }
    }
}