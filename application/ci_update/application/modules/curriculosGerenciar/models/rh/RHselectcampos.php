<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RHselectcampos extends M_CRUD {

    protected $tabela = "rh_selectcampos";

    public function save(array $dadosForm) {
        parent::insert($this->tabela, $dadosForm);
        return $this->ultimoId();
    }
}
