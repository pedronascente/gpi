<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RHexperienciaproficional extends M_CRUD {

    protected $tabela = "rh_experienciaproficional";

    public function save(array $dadosForm) {
        parent::insert($this->tabela, $dadosForm);
        return $this->ultimoId();
    }
}
