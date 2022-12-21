<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RHformacao extends M_CRUD {

    protected $tabela = "rh_formacao";

    public function save(array $dadosForm) {
        parent::insert($this->tabela, $dadosForm);
        return $this->ultimoId();
    }
}
