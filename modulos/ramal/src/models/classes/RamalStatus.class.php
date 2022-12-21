<?php

final class RamalStatus extends Crud {

    private $_tabela = 'ramal_status';
    private $_ramal_status_id;
    private $_ramal_status;

    public function setId($id) {
        $this->_ramal_status_id = $id;
    }

    public function getId() {
        return $this->_ramal_status_id;
    }

    public function setDados($Dados) {
        $this->setId($Dados ['ramal_status_id']);
        $this->setRamalStatus($Dados ['ramal_status']);
    }

    public function ExUpdate($Dados) {
        $this->Update()->ExUpdate($this->_tabela, $Dados, "WHERE  {$this->_ramal_status_id} = :id", "id={$this->_ramal_status_id}");
        return $this->Update()->getResult();
    }

    public function ListaRamalStatus() {
        $this->Read()->FullRead("SELECT * FROM {$this->_tabela}");
        return $this->Read()->getResult();
    }

}

/* 
 $ramalStatus = new RamalStatus;
 $ramalStatus->setDados($Dados);
 $ramalStatus->ExUpdate();
*/