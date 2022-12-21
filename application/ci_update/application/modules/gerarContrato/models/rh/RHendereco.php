<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RHendereco extends M_CRUD {

    protected $tabela = "rh_endereco";

    public function save(array $dadosForm) {
        parent::insert($this->tabela, $dadosForm);
        return $this->ultimoId();
    }
}
