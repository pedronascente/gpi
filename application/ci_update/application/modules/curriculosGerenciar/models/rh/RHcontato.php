<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RHcontato extends M_CRUD {

    protected $tabela = "rh_contato";

    public function save(array $dadosForm) {
	    parent::insert($this->tabela, $dadosForm);
        return $this->ultimoId();
    }
}
