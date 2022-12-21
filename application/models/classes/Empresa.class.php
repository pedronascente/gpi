<?php

final class Empresa extends Crud {

    private $_tabela = 'empresas';
    private $_sql;

    public function select() {
        $this->Read()->ExRead($this->_tabela, "ORDER BY nome_empresa ASC", null);
        return $this->Read()->getResult();
    }

    public function selecionarEmpresaById($id) {
         $this->Read()->ExRead($this->_tabela, "WHERE id_empresa = '{$id}'");
        return $this->limparArray($this->Read()->getResult());
    }
    
    public function getSql() {
        return $this->_sql;
    }

}
