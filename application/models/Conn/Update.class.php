<?php

/**
 * <b>Updade.class.php</b> 
 * Classe Responsavel por Atualizar dados  genéricas no banco de dados!
 * 
 * @copyright (c)2014, Pedro jardim Grupo Volpato
 */
class Update extends Conn {

    private $_Tabela;
    private $_Dados = [];
    private $_Termos;
    private $_Places;
    private $_Result;

    /**
     * @var PDOstatement
     */
    private $_Updade;

    /**
     * @var PDO
     */
    private $_Conn;

    public function ExUpdate($Tabela, $Dados, $Termos, $ParseString) {


        $this->_Tabela = (string) $Tabela;
        $this->_Dados = $Dados;
        $this->_Termos = (string) $Termos;
        parse_str($ParseString, $this->_Places);
        $this->getSyntax();
        $this->Execute();
    }

    public function getResult() {
        return $this->_Result;
    }

    public function getRowCount() {
        return $this->_Updade->rowCount();
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

    private function Connect() {
        $this->_Conn = parent::getConn();
        $this->_Updade = $this->_Conn->prepare($this->_Updade);
    }

    /* Cria a Sintax de query para Prepared Statements */

    private function getSyntax() {
           
        if(  $this->_Dados  !==null){
            foreach ($this->_Dados as $key => $value) {
                $Places [] = $key . ' = :' . $key;
            }    
        }else{
            $Places = [];
        }

        
        $Places = implode(', ', $Places);
        $this->_Updade = "UPDATE {$this->_Tabela} SET {$Places} {$this->_Termos}";
    }

    /* Obtém a conexão e a Syntax , executa a query */

    private function Execute() {
        $this->Connect();
        try {

            if($this->_Dados !==null){                
                $this->_Updade->execute(array_merge($this->_Dados, $this->_Places));
                $this->_Result = true;
            }
        } catch (PDOException $e) {
            $this->_Result = null;
            WSErro("<b>Erro ao Atualizar:</b> {$e->getMessage()}", $e->getCode());
        }
    }

    public function setarConfiguracoesASC() {
        $this->setarConfiguracoesASC();
    }

}
