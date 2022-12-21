<?php
/*
 * --------------------------------------------------------------------
 * Responsavel por retornar conexão com bando de dados Mysql:
 * -------------------------------------------------------------------- 
 */
include_once "Conn/Dadabase.php";

class PagSeguro {

    protected $_db;
    protected $_db2;
    protected $_sql;
    protected $_retorno;
    protected $_url;
    protected $_idUltimoRegistroLog;
    protected $_data;
    protected $_xml;
 

    public function __construct() {
        $this->_db = Database::conexao();
        //$this->_db2 = Database::conexao2();
    }

    /*
     * --------------------------------------------------
     * Retornar ultimo status da transacao :
     * --------------------------------------------------
     */
    
    public function buscarUltimoStatusTransacao($cliente_id_cliente_contrato) {
		$xml="https://www.seguidor.com.br/integracaoPagSeguro/ws/ws.dadosTransacao.php?acao=visualizarStatusTransacao&id=".$cliente_id_cliente_contrato;
		
		if(file_exists($xml)){
			$retorno = simplexml_load_file($xml);
		}else{
			$retorno = false;
		}
		
   }

    /*
     * --------------------------------------------------------------------
     * Responsavel por persistir dados do log :
     * -------------------------------------------------------------------- 
     */

    //Regra : fazer uma consult na base de dados pra ver se o log já existe na base de dados:
    //se nao ->realizar o insert  
    //se sim ->realizar nao faz nada  

    public function insertLog($transaction) {
        try {
            $stmt = $this->_db->prepare(
                    "INSERT INTO log (
                    dataDaCriacaoDaTransacao,
                    codigoIdentificadorDaTransacao,
                    codigoDeReferenciaDaTransacao,
                    tipoDaTransacao,
                    statusDaTransacao,
                    origemDoCancelamento,
                    dataDoUltimoEvento,
                    tipoDoMeioDePagamentoType,
                    tipoDoMeioDePagamentoCode,
                    valorBrutoDaTransacao,
                    valorDoDescontoDado,
                    valorTotalDasTaxasCobradas,
                    valorLiquidoDatransacao,
                    dataDecredito,
                    valorExtra,
                    numeroDeParcelas,
                    numeroDeItensDaTransacao,
                    emailDoComprador,
                    nomecompletoDoComprador,
                    dddDoComprador,
                    numeroDeTelefoneDoComprador,
                    tipoDeFrete,
                    custoTotalDoFrete,
                    paisDoEnderecoDeEnvio,
                    estadoDoEnderecoDeEnvio,
                    cidadeDoEnderecoDeEnvio,
                    cepDoEnderecoDeEnvio,
                    bairroDoEnderecoDeEnvio,
                    nomeDaRuaDoEnderecoDeEnvio,
                    numeroDoEnderecoDeEnvio,
                    complementoDoEnderecoDeEnvio,
                    id_cliente_contrato
                ) 
                VALUES 
                (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
   
         
            $id_cliente_contrato  = explode('_',$transaction->reference);
            //var_dump($id_cliente_contrato); die;
            
            $stmt->bindParam(1, $transaction->date);
            $stmt->bindParam(2, $transaction->code);
            $stmt->bindParam(3, $transaction->reference);
            $stmt->bindParam(4, $transaction->type);
            $stmt->bindParam(5, $transaction->status);
            $stmt->bindParam(6, $transaction->cancellationSource);
            $stmt->bindParam(7, $transaction->lastEventDate);
            $stmt->bindParam(8, $transaction->paymentMethod->type);
            $stmt->bindParam(9, $transaction->paymentMethod->code);
            $stmt->bindParam(10, $transaction->grossAmount);
            $stmt->bindParam(11, $transaction->discountAmount);
            $stmt->bindParam(12, $transaction->feeAmount);
            $stmt->bindParam(13, $transaction->netAmount);
            $stmt->bindParam(14, $transaction->escrowEndDate);
            $stmt->bindParam(15, $transaction->extraAmount);
            $stmt->bindParam(16, $transaction->installmentCount);
            $stmt->bindParam(17, $transaction->itemCount);
            $stmt->bindParam(18, $transaction->sender->email);
            $stmt->bindParam(19, $transaction->sender->name);
            $stmt->bindParam(20, $transaction->sender->phone->areaCode);
            $stmt->bindParam(21, $transaction->sender->phone->number);
            $stmt->bindParam(22, $transaction->shipping->type);
            $stmt->bindParam(23, $transaction->shipping->cost);
            $stmt->bindParam(24, $transaction->shipping->address->country);
            $stmt->bindParam(25, $transaction->shipping->address->state);
            $stmt->bindParam(26, $transaction->shipping->address->city);
            $stmt->bindParam(27, $transaction->shipping->address->postalCode);
            $stmt->bindParam(28, $transaction->shipping->address->district);
            $stmt->bindParam(29, $transaction->shipping->address->street);
            $stmt->bindParam(30, $transaction->shipping->address->number);
            $stmt->bindParam(31, $transaction->shipping->address->complement);
            $stmt->bindParam(32, $id_cliente_contrato[1]);
            $stmt->execute();
            $this->_idUltimoRegistroLog = $this->_db->lastInsertId(); //retorna ultimo id
            if ($this->_idUltimoRegistroLog) {
                $this->insertItem($transaction, $this->_idUltimoRegistroLog);
                return true;
            }
        } catch (Exception $e) {
            die("ERROR:" . $e->getMessage());
        }
    }

    /*
     * --------------------------------------------------------------------
     * Responsavel por persistir os itens da compra :
     * -------------------------------------------------------------------- 
     */

    private function insertItem($transaction, $id_log) {
        try {
            if ($id_log):
                foreach ($transaction->items->item as $key => $value) :
                    $stmt = $this->_db->prepare(
                            "INSERT INTO item (
                        itemIdentificador,
                        itemDescricao,
                        itemValorUnitario,
                        itemQuantidade,
                        codigoIdentificadorDaTransacao,
                        id_log
                    )
                    VALUES 
                    (?,?,?,?,?,?)");
                    $stmt->bindParam(1, $value->id);
                    $stmt->bindParam(2, $value->description);
                    $stmt->bindParam(3, $value->amount);
                    $stmt->bindParam(4, $value->quantity);
                    $stmt->bindParam(5, $transaction->code);
                    $stmt->bindParam(6, $id_log);
                    $stmt->execute();
                endforeach;
            endif;
        } catch (Exception $e) {
            die("ERROR:" . $e->getMessage());
        }
    }

    /*
     * --------------------------------------------------------------------
     * Descrição :Responsavel por retornar os seguintes dados: 
     * @ id (log)
     * @ dataDoUltimoEvento (log)
     * @ codigoIdentificadorDaTransacao (log)
     * @ transacao_significado (transacao)
     * @ meio_pagamento_sgnificado (meio_pagamento)
     * @ valorBrutoDaTransacao (log)
     * -------------------------------------------------------------------- 
     */

    public function VisualizarLogs($id) {
       
	    $xml = "https://www.seguidor.com.br/integracaoPagSeguro/ws/ws.dadosTransacao.php?acao=visualizarLogs&id=".$id;
		
		if(file_exists($xml)){
			$retorno = simplexml_load_file($xml);
		}else{
			$retorno = false;
		}
	
	}

    /*
     * -----------------------------------------------------------------------
     *  Description : Retorna  webServer  :
     * ----------------------------------------------------------------------- 
     */

    public function getCurl($URL) {
        $this->_url = $URL;
        $curl = curl_init($this->_url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $this->_retorno = curl_exec($curl);
        curl_close($curl);
        $this->_retorno = @simplexml_load_string($this->_retorno);
        return $this->_retorno;
    }

    /*
     * -------------------------------------------------------------------------   
     * RETORNA O CODIGO E A DATA DA COMPRA :
     * -------------------------------------------------------------------------
     */

    public function getCodigoCompra($data, $url) {
        $this->_url = $url;
        $this->_data = http_build_query($data);
        $curl = curl_init($this->_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->_data);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        $this->_xml = curl_exec($curl);
        curl_close($curl);
        if (isset($this->_xml->error->code)) {
            die(json_encode(array(
                'type' => 'false'
            )));
        } else {
            $this->_xml = simplexml_load_string($this->_xml);
            return $this->_xml->code;
        }
    }

    public function getDuplicidade($code, $status) {
        $this->_sql = " SELECT COUNT(_LOG.id) FROM log  AS _LOG  WHERE _LOG.codigoIdentificadorDaTransacao = '$code' AND _LOG.statusDaTransacao = '$status' ";
        $stmt = $this->_db->query($this->_sql);
        $TOTAL_REGISTRE = $stmt->fetchColumn();
        if ($TOTAL_REGISTRE >= 1) {
            return true;
        } else {
            return false;
        }
    }
}


