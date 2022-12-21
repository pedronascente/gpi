<?php

/**
 * <b>Create.class.php</b> 
 * Classe Responsavel por cadastros genéricos no banco de dados!
 * 
 * @copyright (c)2014, Pedro jardim Grupo Volpato
 */
class Create extends Conn {

    private $_Tabela;
    private $_Dados;
    private $_Result;

    /**
     * @var PDOstatement
     */
    private $_Create;

    /**
     * @var PDO
     */
    private $_Conn;

    /*
     * <b>ExCreate:</b>
     * Executa um cadastro simplificado no banco de dados utilizando prepared statements.
     * Basta informar o nome da tabela e um array atribuitivo com o nome da coluna e valor!
     *
     * @param STRING $Tabela = Informa o nome da tabela no banco!
     * @param ARRAY $Dados = Informa um array atribuitivo. ( Nome Da Coluna => valor).
     */

    public function ExCreate($Tabela, array $Dados) {
        $this->_Tabela = (string) $Tabela;
        $this->_Dados = $Dados;
        $this->getSyntax();
        $this->Execute();
    }

    public function getResult() {
        return $this->_Result;
    }

    /*
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */

    private function Connect() {
        $this->_Conn = parent::getConn();
        $this->_Create = $this->_Conn->prepare($this->_Create);
    }

    private function getSyntax() {
        $Fileds = implode(', ', array_keys($this->_Dados));
        $Places = ':' . implode(', :', array_keys($this->_Dados));
        $this->_Create = "INSERT INTO {$this->_Tabela} ({$Fileds}) VALUES ({$Places})";
    }

    private function Execute() {
        $this->Connect();
        try {
            $this->_Create->execute($this->_Dados);
            $this->_Result = $this->_Conn->lastInsertId();
        } catch (PDOException $e) {
            $this->_Result = null;
            $e = WSErro("<b>Erro ao cadastrar:</b> {$e->getMessage()}", $e->getCode());

            die($e);
        }
    }

    public function setarConfiguracoesASC() {
        $this->setarConfiguracoesASC();
    }

}
