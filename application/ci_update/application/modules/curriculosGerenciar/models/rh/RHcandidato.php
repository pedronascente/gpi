<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RHcandidato extends M_CRUD {
    protected $tabela = "rh_candidato";
    public function save(array $dadosForm) {

        parent::insert($this->tabela, $dadosForm);
        return $this->ultimoId();
    }
     public function findByCnpjCPF($cnpjcpf_cliente) {
       return parent::findById($this->tabela, 'cnpjcpf_cliente', $cnpjcpf_cliente);
    }
	
	
	public function verificaDuplicata($filtro){
		 return parent::findById($this->tabela, 'nome', $filtro);
	}
	
	
	
}
