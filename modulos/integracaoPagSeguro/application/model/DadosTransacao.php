<?php
require "classXML.php";
require "Conn/Dadabase.php";

class DadosTransacao{
    
    private $_xml ;
    private $_db ;
    private $_result ;
    private $_erro =0;
    private $_msgerro ;
    private $_stmt ;
    private $_sql ;
    private $_filtro ;
    private $_qtd_registros;
    
    public function __construct() {
        $this->_xml = new classXML();
        $this->_db = Database::conexao();
    }
    
    public function visualizarStatusTransacao($FILTRO){
        $this->_filtro = $FILTRO ;
        $this->_xml->openTag("response");
        if($this->_filtro ==''){
            $this->_erro = 1;
            $this->_msgerro = 'Código inválido!';
        }else{
            $this->_sql ="
            SELECT   _t.transacao_significado FROM log AS _log 
            INNER JOIN transacao AS _t 
            ON _log.statusDaTransacao = _t.transacao_codigo
            WHERE _log.id_cliente_contrato = {$this->_filtro}
            ORDER BY   _log.id DESC  LIMIT 0,1" ;          
            $this->_stmt = $this->_db->query($this->_sql);
            $this->_qtd_registros = $this->_stmt->rowCount(); 
            if($this->_qtd_registros >0){
                $this->_result =  $this->_stmt->fetch(PDO::FETCH_OBJ);
                $this->_xml->addTag("statusTransacao", $this->_result->transacao_significado);
            }else{
                $this->_erro =2;
                $this->_msgerro ="Produto não encontrado!";
            }
        }
        $this->_xml->addTag("erro", $this->_erro);
        $this->_xml->addTag("msgerro", $this->_msgerro);
        $this->_xml->closeTag("response");
        return $this->_xml;
    }
    
    public function VisualizarLogs($FILTRO){
        $this->_filtro = $FILTRO ;
        $this->_xml->openTag("response");
        if($this->_filtro ==''){
            $this->_erro = 1;
            $this->_msgerro = 'Código inválido!';
        }else{
            $this->_sql ="SELECT 
            _log.id, 
            _log.dataDoUltimoEvento, 
            _log.codigoIdentificadorDaTransacao , 
            _t.transacao_significado, 
            _mp.meio_pagamento_sgnificado, 
            _log.valorBrutoDaTransacao 
            FROM log  AS _log
            INNER JOIN transacao AS _t
            ON _log.statusDaTransacao = _t.transacao_codigo
            INNER JOIN  meio_pagamento AS _mp
            ON _log.tipoDoMeioDePagamentoCode = _mp.meio_pagamento_codigo
            WHERE _log.id_cliente_contrato = {$this->_filtro}
            ORDER BY _log.id DESC";
            $this->_stmt = $this->_db->query($this->_sql);
            $this->_qtd_registros = $this->_stmt->rowCount(); 
            if($this->_qtd_registros >0){
                foreach ($this->_stmt->fetchAll(PDO::FETCH_ASSOC) as $k => $v){
                    //FORMATA DATA
                    $dataDoUltimoEvento = explode('T', $v["dataDoUltimoEvento"]);
                    $dataDoUltimoEvento = date('d/m/Y', strtotime($dataDoUltimoEvento[0]));
                    //FORMATA VALOR
                    $valorBrutoDaTransacao = "R$" . number_format($v["valorBrutoDaTransacao"], 2, ",", ".");
                    $this->_xml->openTag("dadosLog");
                    $this->_xml->addTag("id", $v["id"]);
                    $this->_xml->addTag("dataDoUltimoEvento", $dataDoUltimoEvento);
                    $this->_xml->addTag("codigoIdentificadorDaTransacao", $v["codigoIdentificadorDaTransacao"]);
                    $this->_xml->addTag("transacao_significado", $v["transacao_significado"]);
                    $this->_xml->addTag("meio_pagamento_sgnificado", $v["meio_pagamento_sgnificado"]);
                    $this->_xml->addTag("valorBrutoDaTransacao", $valorBrutoDaTransacao);                        
                    $this->_xml->closeTag("dadosLog");
                }
            }else{
                $this->_erro =2;
                $this->_msgerro ="Produto não encontrado!";
            }
        }
        $this->_xml->addTag("erro", $this->_erro);
        $this->_xml->addTag("msgerro", $this->_msgerro);
        $this->_xml->closeTag("response");
        return $this->_xml;
    }
}