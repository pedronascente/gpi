<?php

/**
 * <b>Delete.class.php</b> 
 * Classe Responsavel por Delete dados  genéricas no banco de dados!
 * 
 * @copyright (c)2014, Pedro jardim Grupo Volpato
 */
class Delete extends Conn {

    private $_Tabela;
    private $_Termos;
    private $_Places;
    private $_Result;

    /**
     * @var PDOstatement
     */
    private $_Delete;

    /**
     * @var PDO
     */
    private $_Conn;

    public function ExDelete($Tabela, $Termos, $ParseString) {
        $this->_Tabela = (string) $Tabela;
        $this->_Termos = (string) $Termos;

        parse_str($ParseString, $this->_Places);
        $this->getSyntax();
        $this->Execute();
    }

    public function getResult() {
        return $this->_Result;
    }

    public function getRowCount() {
        return $this->_Delete->rowCount();
    }

    public function setPlaces($ParseString) {
        parse_str($ParseString, $this->_Places);
        $this->getSyntax();
        $this->Execute();
    }

    /*
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */

    // Obtém o PDO e Prepara a query
    private function Connect() {
        $this->_Conn = parent::getConn();
        $this->_Delete = $this->_Conn->prepare($this->_Delete);
    }

    /* Cria a Sintax de query para Prepared Statements */

    private function getSyntax() {
        $this->_Delete = "DELETE FROM {$this->_Tabela} {$this->_Termos}";
    }

    /* Obtém a conexão e a Syntax , executa a query */

    private function Execute() {
        $this->Connect();
        try {
            $this->_Delete->execute($this->_Places);
            $this->_Result = true;
        } catch (PDOException $e) {
            $this->_Result = null;
            WSErro("<b>Erro ao Deletar:</b> {$e->getMessage()}", $e->getCode());
        }
    }

    public function setarConfiguracoesASC() {
        $this->setarConfiguracoesASC();
    }

}
