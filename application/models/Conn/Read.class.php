<?php

/**
 * <b>Read.class.php</b> 
 * Classe Responsavel por leituras genéricas no banco de dados! 
 * @copyright (c)2014, Pedro jardim Grupo Volpato
 */
class Read extends Conn {

    private $_Select;
    private $_Places;
    private $_Result;
    protected $filtro;
    private $limit;

    /**
     * @var PDOstatement
     */
    private $_Read;

    /**
     * @var PDO
     */
    private $_Conn;

    public function ExRead($Tabela, $Termos = NULL, $ParseString = NULL) {
        if (!empty($ParseString)) :
            $this->_Places = $ParseString;
            parse_str($ParseString, $this->_Places);

        endif;
        $this->_Select = "SELECT * FROM {$Tabela} {$Termos}";
        $this->Execute();
    }

    public function getResult() {
        return $this->_Result;
    }

    public function getRowCount() {
        return $this->_Read->rowCount();
    }

    /*
     * <b>FullRead:</b>
     * Cria um select generico!
     *
     * @param STRING $Query = Informa Query a ser procurada!
     * @param STRING $ParseString = Informa conjunto de valores concatenados por & exemplo : valor1=1&valor2=2 .
     */

    public function FullRead($Query, $ParseString = NULL) {
        $this->_Select = $Query;
        if (!empty($ParseString)) :
            $this->_Places = $ParseString;
            parse_str($ParseString, $this->_Places);

        endif;
        $this->Execute();
    }

    public function setPlaces($ParseString) {
        parse_str($ParseString, $this->_Places);
        $this->Execute();
        $this->ExecuteUpdate();
    }

    /*
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */

    private function Connect() {
        $this->_Conn = parent::getConn();
        $this->_Read = $this->_Conn->prepare($this->_Select);
        $this->_Read->setFetchMode(PDO::FETCH_ASSOC);
    }

    /* Cria a Sintax de query para Prepared Statements */

    private function getSyntax() {
        if ($this->_Places) :
            foreach ($this->_Places as $Vinculo => $Valor) :
                if ($Vinculo == 'limit' || $Vinculo == 'offset') :
                    $Valor = (int) $Valor;

                endif;
                $this->_Read->bindValue(":{$Vinculo}", $Valor, (is_int($Valor) ? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach
            ;

        endif;
    }

    /* Obtém a conexão e a Syntax , executa a query */

    private function Execute() {
        $this->Connect();
        try {
            $this->getSyntax();
            $this->_Read->execute();
            $this->_Result = $this->_Read->fetchAll();
        } catch (PDOException $e) {
            $this->_Result = null;
            WSErro("<b>Erro ao Ler:</b> {$e->getMessage()}", $e->getCode());
        }
    }

    public function FullUpdate($Query, $ParseString = NULL) {
        $this->_Select = $Query;
        if (!empty($ParseString)) :
            $this->_Places = $ParseString;
            parse_str($ParseString, $this->_Places);

        endif;
        $this->ExecuteUpdate();
    }

    private function ExecuteUpdate() {
        $this->Connect();
        try {
            $this->getSyntax();
            $this->_Read->execute();
            $this->_Result = true;
        } catch (PDOException $e) {
            $this->_Result = null;
            WSErro("<b>Erro ao Ler:</b> {$e->getMessage()}", $e->getCode());
        }
    }

    public function setFiltros(array $filtro) {
        unset($filtro ['acao']);
        foreach ($filtro as $k => $v) :
            $this->filtro [$k] = $v;
        endforeach
        ;
    }

    public function getFiltros() {
        return $this->filtro;
    }

    public function setLimit($limite) {
        $this->limit = $limite;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function setarConfiguracoesASC() {
        $this->setarConfiguracoesASC();
    }

}
