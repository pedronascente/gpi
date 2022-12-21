<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RHdocumentacao extends M_CRUD {

    protected $tabela = "rh_documentacao";

    public function save(array $dadosForm) {
        parent::insert($this->tabela, $dadosForm);
        return $this->ultimoId();
    }
     public function findByCPF($cpf) {
       return parent::findById($this->tabela, 'cpf', $cpf);
    }
}
