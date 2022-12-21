<?php

final class Empresas extends Crud {

    private $_nome_empresa;
    private $_cnpj;
    private $_tabela = "empresas";

    public function setId_colaborador($id_colaborador){
        $this->nome_empresa = $id_colaborador;
    }
    public function setId_empresa($id_empresa){
        $this->_cnpj = $id_empresa;
    }

    public function selectTodasEmpresas(){
        $this->Read()->ExRead($this->_tabela, "ORDER BY nome_empresa ASC", null);
        return $this->Read()->getResult();
    }

}
