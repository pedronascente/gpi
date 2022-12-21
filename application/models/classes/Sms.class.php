<?php

class Sms extends Crud {

    private $_id;
    private $_tabela = 'sms';

    public function insert($dados) {
        $this->Create()->ExCreate($this->_tabela, $dados);
    }

    public function getUltimoId() {
        return $this->Create()->getResult();
    }

}
